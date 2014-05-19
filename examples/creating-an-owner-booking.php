<?php

/**
 * This file documents how to create a owner booking for a specific owner
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
    
    if (\tabs\api\core\Owner::authenticate('JBLOG', 'password')) {
        
        // Request owner details
        $owner = \tabs\api\core\Owner::create('JBLOG');
        
        $property = array_pop($owner->getProperties());
        
        $booking = $owner->setOwnerBooking(
            $property->getPropref(),
            strtotime('2012-07-01'),
            strtotime('2012-07-08'),
            'Staying there ourselves'
        );
        
        if ($booking) {
            echo 'Booking added!';
        }
        
        
    } else {
        // Could not authenticate
    }
    
} catch(Exception $e) {
    echo $e->getMessage();
}