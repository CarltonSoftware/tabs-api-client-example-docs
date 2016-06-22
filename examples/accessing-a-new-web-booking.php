<?php

/**
 * This file documents how to create a web booking object from a  
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
    
    $bookref = filter_input(INPUT_GET, 'bookref') ? filter_input(INPUT_GET, 'bookref') : false;
    if ($bookref) {
        $booking = \tabs\api\booking\Booking::createBookingFromId($bookref);
        include 'includes/bookingOutput.php';
    }
    
} catch(Exception $e) {
    echo $e->getMessage();
}