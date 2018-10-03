<?php
/**
 * craftcms3-nasa-apod plugin for Craft CMS 3.x
 *
 * Adds a widget with NASA's astrology picture of the day
 *
 * @link      https://www.adampatpattison.co.uk
 * @copyright Copyright (c) 2018 Adam Pat Pattison
 */

namespace adampatpattison\craftcms3nasaapod\assetbundles\apodwidget;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Adam Pat Pattison
 * @package   Craftcms3nasaapod
 * @since     1
 */
class ApodWidgetAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@adampatpattison/craftcms3nasaapod/assetbundles/apodwidget/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/Apod.js',
        ];

        $this->css = [
            'css/Apod.css',
        ];

        parent::init();
    }
}
