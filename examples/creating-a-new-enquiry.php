<?php

/**
 * This file documents how to request property availability and prices in a 
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
    
    
    // Retrieve an enquiry from the api
    $enquiry = \tabs\api\booking\Enquiry::create(
        (filter_input(INPUT_GET, 'propref') ? filter_input(INPUT_GET, 'propref') : 'mousecott'), 
        (filter_input(INPUT_GET, 'brandcode') ? filter_input(INPUT_GET, 'brandcode') : 'SS'), 
        $fromdate, 
        $todate, 
        $adults, 
        $children,
        $infants,
        $pets
    );
    
    // Return formatted enquiry data
    echo sprintf(
        '<p>Enquiry ok</p>
        <ul>
            <li>From: %s</li>
            <li>Till: %s</li>
            <li>Basic Price: &pound;%s</li>
            <li>Extras: &pound;%s (Including Booking fee of &pound;%s)</li>
            <li>Total Price: &pound;%s</li>
        </ul>',
        $enquiry->getFromDateString(),
        $enquiry->getToDateString(),
        $enquiry->getBasicPrice(),
        $enquiry->getExtrasTotal(),
        $enquiry->getPricing()->getExtraDetail('BKFE')->getTotalPrice(),
        $enquiry->getTotalPrice()
    );
    
    // Below is the immediate public methods available for the enquiry class.
    // This does not include all of the methods for the coupled classes like
    // Extras and Pricing.
    var_dump(get_class_methods($enquiry)); 
    
} catch(Exception $e) {
    // Calls magic method __toString
    // Any invalid enquiry will throw an exception.  The exception will return a
    // code and a user friendly message
    echo $e;
}