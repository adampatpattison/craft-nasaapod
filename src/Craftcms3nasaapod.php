<?php
/**
 * craftcms3-nasa-apod plugin for Craft CMS 3.x
 *
 * Adds a widget with NASA's astrology picture of the day
 *
 * @link      https://www.adampatpattison.co.uk
 * @copyright Copyright (c) 2018 Adam Pat Pattison
 */

namespace adampatpattison\craftcms3nasaapod;

use adampatpattison\craftcms3nasaapod\widgets\Apod as ApodWidget;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Dashboard;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

/**
 * Class Craftcms3nasaapod
 *
 * @author    Adam Pat Pattison
 * @package   Craftcms3nasaapod
 * @since     1
 *
 */
class Craftcms3nasaapod extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Craftcms3nasaapod
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = ApodWidget::class;
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'craftcms3-nasa-apod',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
