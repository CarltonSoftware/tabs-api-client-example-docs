<?php

/**
 * This file documents how to use the SearchHelper library.
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
    
    // Create a new search helper object
    $searchHelper = new \tabs\api\property\SearchHelper(
        // Search parameters array
        (filter_input_array(INPUT_GET) ? filter_input_array(INPUT_GET) : array()),
        // Any search parameters that need to be persisted
        array(),
        // Base url of the search page (this is for pagination)
        basename(__FILE__)
    );
    
    // Perform Search
    $searchHelper->search('1');
    
    var_dump($searchHelper->getFacets(array('ATTR14')));
    
    var_dump(\tabs\api\client\ApiClient::getApi()->getRoutes());
    
} catch(Exception $e) {
    echo $e->getMessage();
}