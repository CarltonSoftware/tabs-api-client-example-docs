<?php

/**
 * This file documents how to access customer information.
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
    
    $customer = \tabs\api\core\Customer::create('BROO263');
    echo sprintf('<p>%s</p>', (string) $customer);    
    
    foreach ($customer->getBookings() as $booking) {
        /* @var \tabs\api\booking\TabsBooking $booking */
        echo sprintf('<p>%s</p>', $booking->getBookingRef());
    }
    
} catch(Exception $e) {
    echo $e->getMessage();
}