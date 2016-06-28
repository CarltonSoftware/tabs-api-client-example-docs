<?php

/**
 * This file documents how to create a property object and how to 
 * out put a calendar widget.
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
    
    // Retrieve property data from api
    $property = tabs\api\property\Property::getProperty(
        (filter_input(INPUT_GET, 'propref') ? filter_input(INPUT_GET, 'propref') : 'mousecott'),
        (filter_input(INPUT_GET, 'brandcode') ? filter_input(INPUT_GET, 'brandcode') : 'SS')
    );
    
    // Echoing the property object will call the magic method __toString();
    echo sprintf('<p>%s - Availability</p>', $property);    
    
    
    // Simply printing the calendar widget function outputs a single calendar
    // to the screen.  This has 4 arguments:
    // 
    // $targetMonth    Timestamp of the target month e.g. mktime or time()
    // $options        Calendar options array.  The options are defaulted to:
    //      
    //                 array(
    //                      'start_day' => 'monday',
    //                      'month_type' => 'long',
    //                      'day_type' => 'short'
    //                 );
    //  
    // $highLightStart Start of highlighted period
    // $highLightEnd   End of highlighted period
    
    echo $property->getCalendarWidget();    
    
    // Manipulating a few simple dates gets use a reusable date widget.
    $calDate = mktime(0, 0, 0, date("m"), 1, date("Y"));
    if (filter_input(INPUT_GET, 'date')) {
        $date = strtotime(filter_input(INPUT_GET, 'date'));
        if ($date > $calDate) {
            $calDate = mktime(0, 0, 0, date("m", $date), 1, date("Y", $date));
        }
    }

    // Set dates
    if ($calDate > mktime(0, 0, 0, date("m"), 1, date("Y"))) {
        $prevDate = strtotime("-1 month", $calDate);
    } else {
        $prevDate = $calDate;
    }
    
    echo sprintf(
        '<a href="?propref=%s&brandcode=%s&date=%s">Previous</a>',
        $property->getPropref(),
        $property->getBrandcode(),
        date('d-m-Y', $prevDate)
    );

    // Next date
    $nextDate = strtotime("+1 month", $calDate);
    echo sprintf(
        ' | <a href="?propref=%s&brandcode=%s&date=%s">Next</a>',
        $property->getPropref(),
        $property->getBrandcode(),
        date('d-m-Y', $nextDate)
    );
    
    $cellContent = sprintf(
        '<a href="creating-a-new-enquiry.php?propref=%s&brandcode=%s&fromdate={id}">{content}</a>',
        $property->getPropref(),
        $property->getBrandcode()
    );
    
    echo $property->getCalendarWidget(
        $calDate, 
        array(
            'start_day' => strtolower($property->getChangeOverDay()),
            'sevenRows' => true,
            'attributes' => sprintf(
                'class="calendar" data-month="%s"',
                date('Y-m', $calDate)
            ),
            'cal_cell_content' => $cellContent,
            'cal_cell_content_today' => $cellContent,
            'sevenRows' => true
        )
    );
    
} catch(Exception $e) {
    echo $e->getMessage();
}