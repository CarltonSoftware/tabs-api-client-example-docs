<?php

/**
 * This file documents how to access areas and locations from a tabs api instance.
 *
 * PHP Version 5.3
 * 
 * @category  API_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2013 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.carltonsoftware.co.uk
 */

// Include the connection
require_once 'creating-a-new-connection.php';

$areas = tabs\api\utility\Utility::getAreasAndLocations();

foreach ($areas as $area) {
    echo '<p>' . $area->getName() . '</p>';
    
    echo '<p>Locations</p>';
    echo '<ul>';
    foreach ($area->getLocations() as $location) {
        echo '<li>' . $location->getName() . '(' . $location->getRadius() . ')</li>';
    }
    echo '</ul>';
}