<?php

/**
 * This file documents how to create a tabs booking object from a  
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
    
    if ($bookref = filter_input(INPUT_GET, 'bookref')) {
        $booking = \tabs\api\booking\TabsBooking::getBooking($bookref);
        if ($booking->isOwnerBooking() === false) {
            echo sprintf('<p>Customer: %s</p>', $booking->getCustomer());
        } else {
            echo '<p>' . $booking->getOwnerBookingType()->getDescription() . '</p>';
        }
        
        echo sprintf('<p>Property: %s</p>', $booking->getProperty());
        echo sprintf('<p>Bookref: %s</p>', $booking->getBookingRef());
        echo sprintf('<p>From: %s</p>', date('d F Y', $booking->getFromDate()));
        echo sprintf('<p>Till: %s</p>', date('d F Y', $booking->getToDate()));
        echo sprintf(
            '<p>Price: &pound;%s</p>', 
            number_format($booking->getTotalPrice(), 2)
        );
        echo sprintf(
            '<p>Pets: %s</p>', 
            $booking->getPets()
        );
        echo sprintf(
            '<p>Repeat property booker: %s</p>', 
            $booking->getRepeatPropertyBooker()
        );
        echo sprintf(
            '<p>Repeat owner booker: %s</p>', 
            $booking->getRepeatOwnerBooker()
        );
    }
    
} catch(Exception $e) {
    echo $e->getMessage();
}