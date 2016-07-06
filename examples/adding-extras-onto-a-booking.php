<?php

/**
 * This file documents how to add extras to an existing booking object
 * which has been requested from a tabs api instance.
 *
 * PHP Version 5.3
 * 
 * @category  API_Client
 * @package   Tabs
 * @author    Carlton Software <support@carltonsoftware.co.uk>
 * @copyright 2012 Carlton Software
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.carltonsoftware.co.uk
 */

// Include the connection
require_once 'creating-a-new-connection.php';

try {
    // Create an booking from the api with a given id
    $booking = \tabs\api\booking\Booking::createBookingFromId(
        (filter_input(INPUT_GET, 'bookref') ? filter_input(INPUT_GET, 'bookref') : 'c70175835bda68846e')
    );
    
    // Example booking already has a pet, need to remove it for this example
    $booking->removeExtra('PET');
    $booking->removeExtra('ZZZ');
    $booking->removeExtra('ZERO');
    $booking->removeExtra('AFFIL');
    
    // Return available extras for booking
    $extras = $booking->getAvailableExtras();
//    foreach ($extras as $extra) {
//        echo sprintf(
//            '<p>%s</p>',
//            $extra->getDescription()
//        );
//    }
    
    // Add a new extra to the booking factory.
    // The list of extra codes can be retrieved with the UtilityFactory.
    
    foreach ($booking->getPricing()->getExtras() as $extra) {
        echo sprintf(
            '<p>%s %s</p>',
            $extra->getDescription(),
            $extra->getTotalPrice()
        );
    }
    echo sprintf(
        '<p>%s - %s</p>',
        $booking->getTotalPrice(),
        $booking->getDepositAmount()
    );
    
    //$booking->addNewExtra('PET', 1);
    //$booking->addNewExtra('ZZZ', 1);
    //$booking->addNewExtra('ZERO', 2, 5);
    $booking->addNewExtra('AFFIL', 1, 50);
    
    foreach ($booking->getPricing()->getExtras() as $extra) {
        echo sprintf(
            '<p>Added %s costing &pound;%s</p>',
            $extra->getDescription(),
            $extra->getTotalPrice()
        );
    }
    echo sprintf(
        '<p>%s - %s</p>',
        $booking->getTotalPrice(),
        $booking->getDepositAmount()
    );
    
    //$booking->removeExtra('PET');
    
    echo sprintf(
        '<p>%s - %s</p>',
        $booking->getTotalPrice(),
        $booking->getDepositAmount()
    );
    
    include 'includes/bookingOutput.php';
    
} catch(Exception $e) {
    // Calls magic method __toString
    // Any invalid booking will throw an exception.  The exception will return a
    // code and a user friendly message
    echo $e;
}
