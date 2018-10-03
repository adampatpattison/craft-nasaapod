<?php
/**
 * craftcms3-nasa-apod plugin for Craft CMS 3.x
 *
 * Adds a widget with NASA's astrology picture of the day
 *
 * @link      https://www.adampatpattison.co.uk
 * @copyright Copyright (c) 2018 Adam Pat Pattison
 */

namespace adampatpattison\craftcms3nasaapod\widgets;

use adampatpattison\craftcms3nasaapod\Craftcms3nasaapod;
use adampatpattison\craftcms3nasaapod\assetbundles\apodwidget\ApodWidgetAsset;

use Craft;
use craft\base\Widget;

/**
 * craftcms3-nasa-apod Widget
 *
 * @author    Adam Pat Pattison
 * @package   Craftcms3nasaapod
 * @since     1
 */
class Apod extends Widget
{

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $message = 'Hello, world.';

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('craftcms3-nasa-apod', 'Apod');
    }

    /**
     * @inheritdoc
     */
    public static function iconPath()
    {
        return Craft::getAlias("@adampatpattison/craftcms3nasaapod/assetbundles/apodwidget/dist/img/Apod-icon.svg");
    }

    /**
     * @inheritdoc
     */
    public static function maxColspan()
    {
        return null;
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge(
            $rules,
            [
                ['message', 'string'],
                ['message', 'default', 'value' => 'Hello, world.'],
            ]
        );
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'craftcms3-nasa-apod/_components/widgets/Apod_settings',
            [
                'widget' => $this
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getBodyHtml()
    {
        Craft::$app->getView()->registerAssetBundle(ApodWidgetAsset::class);

        return Craft::$app->getView()->renderTemplate(
            'craftcms3-nasa-apod/_components/widgets/Apod_body',
            [
                'message' => $this->message
            ]
        );
    }
}
