<?php

/**
 * This file documents how to creating a new booking and submit a new booking 
 * request to a tabs api instance
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
    $fromdate = filter_input(INPUT_GET, 'fromdate');
    $todate = null;
    $adults = 2;
    $children = 3;
    $infants = 0;
    $pets = 2;
    if (!$fromdate) {
        $fromdate = strtotime('01-07-2012');
        $todate = strtotime('08-07-2012');
    } else {
        $fromdate = strtotime($fromdate);
        $todate = strtotime('+7 days', $fromdate);
        $adults = 1;
        $children = 0;
        $infants = 0;
        $pets = 0;
    }
    
    
    // Retrieve an booking from the api
    $booking = \tabs\api\booking\Booking::create(
        (filter_input(INPUT_GET, 'propref') ? filter_input(INPUT_GET, 'propref') : 'mousecott'), 
        (filter_input(INPUT_GET, 'brandcode') ? filter_input(INPUT_GET, 'brandcode') : 'SS'), 
        $fromdate, 
        $todate, 
        $adults, 
        $children,
        $infants,
        $pets
    );
    
    $booking->addNewExtra('COT', 1, 10);
    
    // Return formatted booking data
    echo sprintf(
        '<p>Booking ok</p>
        <ul>
            <li>From: %s</li>
            <li>Till: %s</li>
            <li>Basic Price: &pound;%s</li>
            <li>Extras: &pound;%s</li>
            %s
            <li>Total Price: &pound;%s</li>
            <li>To Pay: &pound;%s</li>
        </ul>',
        $booking->getFromDateString(),
        $booking->getToDateString(),
        $booking->getBasicPrice(),
        $booking->getExtrasTotal(),
        ($booking->getSecurityDeposit() > 0) ? sprintf('<li>Security Deposit: &pound;%s</li>', number_format($booking->getSecurityDeposit(), 2)) : '',
        $booking->getFullPrice(),
        $booking->getPayableAmount()
    );
    
    // Below is the immediate public methods available for the booking class.
    // This does not include all of the methods for the coupled classes like
    // Extras and Pricing.
    var_dump(get_class_methods($booking)); 
    
} catch(Exception $e) {
    // Calls magic method __toString
    // Any invalid booking will throw an exception.  The exception will return a
    // code and a user friendly message
    echo $e;
}