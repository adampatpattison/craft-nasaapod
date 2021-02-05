<?php
/**
 * NASA APOD plugin for Craft CMS 3.x
 *
 * Adds a simple widget which pulls the NASA Astronomy Picture of the Day in
 *
 * @link      https://www.adampatpattison.co.uk
 * @copyright Copyright (c) 2018 Adam Pat Pattison
 */

namespace adampatpattison\nasaapod;

use adampatpattison\nasaapod\widgets\Apod as ApodWidget;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Dashboard;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

/**
 * Class NasaApod
 *
 * @author    Adam Pat Pattison
 * @package   NasaApod
 * @since     1.0.0
 *
 */
class NasaApod extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var NasaApod
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

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
    }

}
