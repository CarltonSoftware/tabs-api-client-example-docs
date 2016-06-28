<?php

/**
 * This file documents how to create a property object from a  
 * tabs api instance.
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

try {
    
    // Retrieve property data from api
    $property = tabs\api\property\Property::getProperty(
        (filter_input(INPUT_GET, 'propref') ? filter_input(INPUT_GET, 'propref') : 'mousecott'),
        (filter_input(INPUT_GET, 'brandcode') ? filter_input(INPUT_GET, 'brandcode') : 'SS')
    );
    
    // Echoing the property object will call the magic method __toString();
    echo sprintf('<h1>%s</h1>', $property);
    
    // You can also call the objects methods to access information
    echo sprintf(
        '<p>Sleeps: %s (%s)</p>',
        $property->getAccommodates(),
        $property->getAccommodationDescription()
    );
    
    echo sprintf(
        '<p><a href="using-the-calendar-widget.php?propref=%s&brandcode=%s">View Availability</a></p>',
        $property->getPropref(),
        $property->getBrandcode()
    );
    
    // You can also call the objects methods to access information
    echo sprintf(
        '<p>Bedrooms: %s</p>',
        $property->getBedrooms()
    );
    
    // Each property has its own descriptions, full, short and availability
    // (providing they are in use).
    echo sprintf(
        '<h3>Full Description</h3>%s', 
        $property->getFullDescription()
    );
    echo sprintf(
        '<h3>Short Description</h3>%s', 
        $property->getShortDescription()
    );
    echo sprintf(
        '<h3>Availability Description</h3>%s', 
        $property->getAvailabilityDescription()
    );
    
    // Get list of descriptions
    foreach ($property->getAllDescriptions('NO') as $desc) {
        var_dump($desc);
    }
    
    // Get a date range price object array
    $drps = $property->getDateRangePrices(date('Y'));
    if (count($drps) > 0) {
        $trs = '';
        foreach ($drps as $drp) {
            $trs .= sprintf(
                '<tr><td>%s</td><td>&pound;%s</td></tr>',
                call_user_func($drp->getDateRangeString, 'jS M Y'),
                $drp->price
            );
        }
        echo sprintf(
            '<table>
                <thead>
                    <th>Date</th>
                    <th>Price</th>
                </thead>
                <tbody>
                    %s
                </tbody>
            </table>',
            $trs
        );
    }
    
    // Get a list of attributes
    foreach ($property->getAttributes() as $attribute) {
        echo sprintf(
            '<p>%s - (%s)</p>',
            $attribute,
            $attribute->getType()
        );
    }
    
    // View images of different sizes
    if ($property->getMainImage()) {
        echo '<h4>View property images</h4>';
        echo '<p>Please note, in order to reduce the amount of hits on the api (and thus reduce the cost of usage), we recommend caching images locally.</p>';
        echo '<p>Default image type (Square, 100px x 100px)<br>';
        echo $property->getMainImage()->createImageTag();
        echo '</p>';
        
        echo '<p>Smart scalling (400px x 200px)<br>';
        echo $property->getMainImage()->createImageTag('width', 400, 200);
        echo '</p>';
    }
    
    var_dump(tabs\api\client\ApiClient::getApi()->getRoutes());
    
    if ($property->isOnSpecialOffer()) {
        echo $property->getSpecialOffersDescriptions('<p>', '</p>');
    }
    
    // Available properties of the property object that are available via
    // property::get{Property}
    
    // Available functions on property object
    var_dump(get_class_methods($property));
    
} catch(Exception $e) {
    echo $e->getMessage();
}