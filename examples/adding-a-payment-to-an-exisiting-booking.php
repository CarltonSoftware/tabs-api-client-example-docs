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

        // Format of sagepay response
        $sagePayResponse = array(
            "TxType" => "PAYMENT",
            "VendorTxCode" => "8b39c0e7",
            "VPSTxId" => "85249E3D-9C7C-A6A7-6BDE-364B020D2AFC",
            "Status" => "OK",
            "StatusDetail" => "",
            "TxAuthNo" => 1707344162,
            "AVSCV2" => "ALL MATCH",
            "AddressResult" => "MATCHED",
            "PostCodeResult" => "MATCHED",
            "CV2Result" => "NOTMATCHED",
            "GiftAid" => 0,
            "3DSecureStatus" => "OK",
            "CAVV" => "",
            "CardType" => "VISA",
            "Last4Digits" => 3521,
            "VPSSignature" => ""
        );
    
        // Tabs only supports sagepay at this present time so the following factory
        // interprets the sagepay callback and creates a new payment object
        // ready to be added to the booking.
        
        // NOTE: Payment amount should include the credit card amount.
        $payment = \tabs\api\booking\Payment::createPaymentFromSagePayResponse(
            $booking->getTotalPrice() + $booking->getSecurityDepositAmount(),           // Amount of payment
            $sagePayResponse,   // Sagepay response
            'balance'           // Type of payment either 'deposit', 'balance' to
                                // specify whether its a deposit (part) payment
                                // for a booking or the full amount.
                                // IF a CC charge is included append -ccc onto the end of the 
                                // payment type string
        );
        
        $booking->addPayment($payment);
    }
    
} catch(Exception $e) {
    echo $e->getMessage();
}