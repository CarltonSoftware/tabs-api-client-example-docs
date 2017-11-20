<?php

/**
 * This file documents how to add a payment to an existing booking object
 * which has been requested from a tabs api instance.
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
    // Create an booking from the api with a given id
    $booking = \tabs\api\booking\Booking::createBookingFromId(
        (filter_input(INPUT_GET, 'bookingId') ? filter_input(INPUT_GET, 'bookingId') : 'c70175835bda68846e')
    );


    $sagePay = new \tabs\api\utility\SagepayServer(
        'theoriginalcot1',    // Sagepay vendor name
        'Test',                   // This should be either Live/Test or Simulator
        'https://2034db8e.ngrok.io/tabs-api-client/tabs-api-client-example-docs/examples/sagepaycallback.php?bookingId=' . $booking->getBookingId()
        // your callback url
    );

    // Optional, set credit card fee
    $sagePay->setCcCharge(1.79);

    // Sagepay object should now be created

    // Your next step is to create a transaction
    $response = $sagePay->buyDeferred(
        $booking->getDepositAmount(), // Amount of transaction.  
        'My transaction',             // Detail of your transaction.  This will 
        // display on the sagepay system so you'll probably want to use some sort
        // of identifer
        $booking->getCustomer(), // Customer object containing name, address details etc.
        time() // Vendor Transaction Code.  Unique transaction ID.  Can be anything, 
        // as long as its unique.  This transaction reference
        // should only be used once so its common to either use a random digit 
        // or a timestamp, adding booking information may also be useful.Note, this
        // has a limit of 40 characters.
    );



    // Sagepay will return an array
    try {
        switch ($response['Status']) {
        case 'OK':
            echo sprintf(
                '<iframe src="%s" width="%s" height="600" id="sagePayFrame"></iframe>',
                $response['NextURL'],
                '100%'
            );
            break;
        default:
            throw new Exception($response['StatusDetail']);
            break;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
} catch(Exception $e) {
    // Calls magic method __toString
    // Any invalid booking will throw an exception.  The exception will return a
    // code and a user friendly message
    echo $e;
}