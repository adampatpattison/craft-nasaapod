<?php
/**
 * NASA APOD plugin for Craft CMS 3.x
 *
 * Adds a simple widget which pulls the NASA Astronomy Picture of the Day in
 *
 * @link      https://www.adampatpattison.co.uk
 * @copyright Copyright (c) 2018 Adam Pat Pattison
 */

namespace adampatpattison\nasaapod\widgets;

use adampatpattison\nasaapod\NasaApod;

use Craft;
use craft\base\Widget;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;

/**
 * NASA APOD Widget
 *
 * @author    Adam Pat Pattison
 * @package   NasaApod
 * @since     1.0.0
 */
class Apod extends Widget
{

    // Public Properties
    // =========================================================================

    /**
     * @var string The message to display
     */
    public $apiKey;
    public $cacheDuration;
    public $cacheDurationOptions;

    // Static Methods
    // =========================================================================
    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('nasa-apod', 'NASA Astronomy Picture of the Day');
    }

    /**
     * Returns the path to the widget’s SVG icon.
     *
     * @return string|null The path to the widget’s SVG icon
     */
    public static function iconPath()
    {
        return Craft::getAlias('@adampatpattison/nasaapod/icon.svg');
    }

    /**
     * Returns the widget’s maximum colspan.
     *
     * @return int|null The widget’s maximum colspan, if it has one
     */
    public static function maxColspan()
    {
        return null;
    }

    // Public Methods
    // =========================================================================

    /**
     * Apod constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->_setCacheDurationOptions();
        $this->cacheDuration = 3;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge(
            $rules,
            [
                ['apiKey', 'string'],
                ['cacheDuration', 'number', 'min' => 0, 'max' => 24],
                ['cacheDuration', 'default', 'value'=> 3],
            ]
        );
        return $rules;
    }

    /**
     * Returns the component’s settings HTML.
     * @return string|null
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'nasa-apod/_components/widgets/Apod_settings',
            [
                'widget' => $this
            ]
        );
    }

    /**
     * Returns the widget's body HTML.
     *
     * @return string|false The widget’s body HTML, or `false` if the widget
     *                      should not be visible. (If you don’t want the widget
     *                      to be selectable in the first place, use {@link isSelectable()}.)
     */
    public function getBodyHtml()
    {

        $cacheKey = 'ak:' . $this->apiKey . 'cd:'.$this->cacheDuration;
        $result = $this->cacheDuration > 0 ? Craft::$app->getCache()->get($cacheKey) : false;
        if(!$result) {
            $url = 'https://api.nasa.gov/planetary/apod?api_key='.$this->apiKey;
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
//            $result = json_decode(curl_exec($ch));
//            curl_close($ch);
            try {
                //make Guzzle request to Nasa api
                $guzzleClient = new GuzzleClient;
                $response = $guzzleClient->get($url);
                $responseBody = $response->getBody();
                $result = json_decode($responseBody->getContents());
            } catch (GuzzleRequestException $e){
                $result = json_decode($e->getResponse()->getBody()->getContents());
            }

            if(!isset($result->error) && $this->cacheDuration > 0) {
                //cache so not spamming the API but leaves enough time to get a relatively recent
                Craft::$app->getCache()->set($cacheKey, $result, (60*60)*$this->cacheDuration); //(60 seconds * 60 minutes) * X = X hours
            }
        }
        return Craft::$app->getView()->renderTemplate(
            'nasa-apod/_components/widgets/Apod_body',
            [
                'apiKey' => $this->apiKey,
                'result' => $result
            ]
        );
    }

    /**
     *
     */
    private function _setCacheDurationOptions()
    {
        $this->cacheDurationOptions = [0 => Craft::t('nasa-apod', 'Disable Cache')];
        for($hourInt = 1; $hourInt <= 24; $hourInt++){
            $this->cacheDurationOptions[$hourInt] = Craft::t('nasa-apod', '{hourInt} Hours', ['hourInt' => $hourInt]);
        }
        return $this->cacheDurationOptions;
    }

}
