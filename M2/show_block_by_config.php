/**
 * Edit in file: catalog_product_view.xml
 */


<block class="Forix\reCaptcha\Block\Holder" ifconfig="recaptcha/setting/is_active" name="recaptcha_review_product" template="Forix_reCaptcha::holder.phtml">
					<action method="setFormId">
						<argument name="formId" xsi:type="string">review_product</argument>
					</action>
				</block>