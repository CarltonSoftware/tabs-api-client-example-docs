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
    
    $payment = $booking->processSagepayResponse($_POST);

    // Echo sagepay response.  Note, this should be the only output
    // on the callback page.  Callback pages can either display a simple message
    // or could be a rendered page (which would then subsequently pop out of the
    // iframe.
    $output = str_replace(
        '\r\n', 
        "\r\n", 
        $payment->sagePayOutput(
            'https://2034db8e.ngrok.io/tabs-api-client/tabs-api-client-example-docs/examples/confirming-a-booking.php?bookref=' . $booking->getBookingId()
        )
    );
    error_log(
        $output
    );
    echo $output;
    die();
} catch(Exception $e) {
    // Calls magic method __toString
    // Any invalid booking will throw an exception.  The exception will return a
    // code and a user friendly message
    echo $e;
}