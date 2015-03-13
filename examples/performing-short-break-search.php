<?php

/**
 * This file documents how to search for properties that have short break
 * availability for a given period and that allow a short break for that
 * period.
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

$properties = new \tabs\api\property\PropertySearch();
$properties->setFilters(
    array(
        'fromDate' => '2015-03-27',
        'plusMinus' => 0,
        'nights' => 3
    )
);
$properties->setAdditionalParam('shortBreakCheck', 'true');
$properties->setAdditionalParam('shortBreakOnly', 'true');
$properties->find();

echo $properties->getTotal();