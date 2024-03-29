<?php
namespace ML\CustomBlock\Controller\Adminhtml\Block;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Model\Block;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

class Save extends \Magento\Cms\Controller\Adminhtml\Block\Save
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;


    protected $imageUploader;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param BlockFactory|null $blockFactory
     * @param BlockRepositoryInterface|null $blockRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        BlockFactory $blockFactory = null,
        BlockRepositoryInterface $blockRepository = null,
        \ML\CustomBlock\Model\ImageUploader $imageUploader
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        $this->blockFactory = $blockFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(BlockFactory::class);
        $this->blockRepository = $blockRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(BlockRepositoryInterface::class);
        parent::__construct($context, $coreRegistry, $dataPersistor, $blockFactory, $blockRepository);
    }
    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Block::STATUS_ENABLED;
            }
            if (empty($data['block_id'])) {
                $data['block_id'] = null;
            }

            /** @var \Magento\Cms\Model\Block $model */
            $model = $this->blockFactory->create();

            $id = $this->getRequest()->getParam('block_id');
            if ($id) {
                try {
                    $model = $this->blockRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This block no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            // Add custom image field to data
            if (isset($data['base_image'][0]['name']) && isset($data['base_image'][0]['tmp_name'])) {
                $data['base_image'] = $data['base_image'][0]['name'];
                $this->imageUploader->moveFileFromTmp($data['base_image']);
            } elseif (isset($data['base_image'][0]['name']) && !isset($data['base_image'][0]['tmp_name'])) {
                $data['base_image'] = $data['base_image'][0]['name'];
            } else {
                $data['base_image'] = '';
            }


            $model->setData($data);

            try {
                $this->blockRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the block.'));
                $this->dataPersistor->clear('cms_block');
                return $this->processBlockReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the block.'));
            }

            $this->dataPersistor->set('cms_block', $data);
            return $resultRedirect->setPath('*/*/edit', ['block_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the block return
     *
     * @param \Magento\Cms\Model\Block $model
     * @param array $data
     * @param \Magento\Framework\Controller\ResultInterface $resultRedirect
     * @return \Magento\Framework\Controller\ResultInterface
     */
    private function processBlockReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect ==='continue') {
            $resultRedirect->setPath('*/*/edit', ['block_id' => $model->getId()]);
        } else if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } else if ($redirect === 'duplicate') {
            $duplicateModel = $this->blockFactory->create(['data' => $data]);
            $duplicateModel->setData($data);
            $duplicateModel->setId(null);
            $duplicateModel->setIdentifier($data['identifier'] . '-' . uniqid());
            $duplicateModel->setIsActive(Block::STATUS_DISABLED);
            $this->blockRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the block.'));
            $this->dataPersistor->set('cms_block', $data);
            $resultRedirect->setPath('*/*/edit', ['block_id' => $id]);
        }
        return $resultRedirect;
    }
}
?>
