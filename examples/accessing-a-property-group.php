<?php

/**
 * This file documents how to create a property group object from a  
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
    
    $propertyGroup = new \tabs\api\property\PropertyGroup();
    
    $property1 = \tabs\api\property\Property::getProperty('709', 'NO');
    $propertyGroup->addProperty($property1);
    
    $property2 = \tabs\api\property\Property::getProperty('710', 'NO');
    $propertyGroup->addProperty($property2);
    
    echo $propertyGroup->getCalendar(mktime(0, 0, 0, 9, 1, 2014));
    
} catch(Exception $e) {
    echo $e->getMessage();
}