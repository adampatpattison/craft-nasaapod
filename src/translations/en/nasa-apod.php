<?php
/**
 * NASA APOD plugin for Craft CMS 3.x
 *
 * Adds a simple widget which pulls the NASA Astronomy Picture of the Day in
 *
 * @link      https://www.adampatpattison.co.uk
 * @copyright Copyright (c) 2018 Adam Pat Pattison
 */

/**
 * @author    Adam Pat Pattison
 * @package   NasaApod
 * @since     1.0.0
 */
return [
    'API Key' => 'NASA API Key',
    'API Key Instructions' => 'Add a NASA APOD API Key here. To get an API Key, see <a href="https://api.nasa.gov/index.html#apply-for-an-api-key">https://api.nasa.gov/index.html#apply-for-an-api-key</a>',
    'Cache Duration' => 'API Response Cache Duration',
    'Cache Duration Instructions' => 'The widget uses a data cache of the result from the NASA API so we\'re not spamming the API, the length this is cached for can be disabled or customised here',
];
