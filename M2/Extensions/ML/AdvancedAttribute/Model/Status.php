<?php
/**
 * User: ML
 * Date: 6/24/2016
 * Time: 1:24 PM
 */

namespace ML\AdvancedAttribute\Model;

/**
 * Status
 * @category ML
 * @package  ML_AdvancedAttribute
 * @module   Bannerslider
 * @author   ML Developer
 */
class Status
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    /**
     * get available statuses.
     *
     * @return []
     */
    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_ENABLED => __('Enabled')
            , self::STATUS_DISABLED => __('Disabled'),
        ];
    }

    /**
     * @return array
     */
    public static function getTextAlign() {
        return [
            'align_none' => '--',
            'align_left' => __('Left'),
            'align_right' => __('Right'),
            'align_center' => __('Center')
        ];
    }
}
