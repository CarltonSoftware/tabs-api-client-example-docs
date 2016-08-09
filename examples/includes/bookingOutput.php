<?php

/* @var $booking \tabs\api\booking\Booking */
if ($booking) {
    // Return formatted booking data
    echo sprintf(
        '<h3>Booking details</h3>
        <ul>
            <li>id: %s</li>
            <li>From: %s</li>
            <li>Till: %s</li>
            <li>Basic Price: &pound;%s</li>
            <li>Extras: &pound;%s</li>
            %s
            <li>Total Price: &pound;%s</li>
            <li>To Pay: &pound;%s</li>
        </ul>',
        $booking->getBookingId(),
        $booking->getFromDateString(),
        $booking->getToDateString(),
        $booking->getBasicPrice(),
        $booking->getExtrasTotal(),
        ($booking->getSecurityDeposit() > 0) ? sprintf('<li>Security Deposit: &pound;%s</li>', number_format($booking->getSecurityDeposit(), 2)) : '',
        $booking->getFullPrice(),
        $booking->getPayableAmount()
    );
    
    if (count($booking->getNotes()) > 0) {
        echo '<h3>Notes</h3><ul>';
        foreach ($booking->getNotes() as $note) {
            echo '<li>' . $note['message'] . '</li>';
        }
        echo '</ul>';
    }
    
    echo '<p><a href="accessing-a-new-web-booking.php?bookref=' . $booking->getBookingId() . '">View booking</a></p>';
    
    if ($booking->getCustomer()) {
        echo '<h3>Customer</h3>';
        echo '<p>' . (string) $booking->getCustomer() . '</p>';
        echo '<p>' . (string) $booking->getCustomer()->getAddress() . '</p>';
    } else {
        echo '<p><a href="adding-a-customer-to-a-booking.php?bookref=' . $booking->getBookingId() . '">Add customer details</a></p>';
    }
    
    if (count($booking->getPartyDetails()) > 0) {
        echo '<h3>Party members</h3>';
        foreach ($booking->getPartyDetails() as $partyMember) {
            echo '<p>' . (string) $partyMember . '</p>';
        }
    } else {
        echo '<p><a href="adding-party-details-to-a-booking.php?bookref=' . $booking->getBookingId() . '">Add party details</a></p>';
    }

    echo '<p><a href="adding-extras-onto-a-booking.php?bookref=' . $booking->getBookingId() . '">Add extras</a></p>';
    echo '<p><a href="adding-booking-notes.php?bookref=' . $booking->getBookingId() . '">Add notes</a></p>';
    
    if ($booking->getCustomer() 
        && count($booking->getPartyDetails()) > 0 
        && !$booking->isConfirmed()
    ) {
        echo '<p><a href="confirming-a-booking.php?bookref=' . $booking->getBookingId() . '">Confirm booking</a></p>';
    } else if ($booking->isConfirmed()) {
        echo sprintf(
            '<p>Booking is confirmed! Your new booking reference is %s.</p>',
            $booking->getWNumber()
        );
    }
    
    var_dump(\tabs\api\client\ApiClient::getApi()->getRoutes());
}