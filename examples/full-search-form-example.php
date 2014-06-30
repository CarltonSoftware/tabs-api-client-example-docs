<?php

/**
 * This file documents how to use the SearchHelper library. It also uses the
 * aw-form-fields library which provides shortcuts when creating html forms.
 * In order for this to work, you will need to have the aw-form-fields library
 * included at the top of this script.
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

// Include the aw-form-fields library here.  You can clone it from
// https://github,com/alexwyett/aw-form-fields
require_once dirname(__FILE__) . '/../../../aw-form-fields/autoload.php';
require_once dirname(__FILE__) . '/../../../aw-form-fields/examples/ToccAdvancedSearch.php';

try {
    
    // Create a new search helper object
    $searchHelper = new \tabs\api\property\SearchHelper(
        filter_input_array(INPUT_GET), // Search parameters array
        array(),                       // Any search parameters that need to be persisted
        basename(__FILE__)             // Base url of the search page (this is for pagination)
    );
    
    // Create new search form
    $form = new \aw\formfields\forms\ToccAdvancedSearch(
        array(), 
        filter_input_array(INPUT_GET)
    );
    
    $tabsAreas = \tabs\api\utility\Utility::getAreasAndLocations();
    $areas = array('Please choose an Area' => '');
    $locations = array('Town/Village' => '');
    foreach ($tabsAreas as $area) {
        $areas[$area->getName()] = $area->getCode();
        foreach ($area->getLocations() as $location) {
            $locations[$location->getName()] = array(
                'value' => $location->getCode(),
                'class' => $area->getCode()
            );
        }
    }
    
    // Add in areas
    $form->setAreaSelect(
        $form->createBasicSelect(
            'Please choose an Area',
            $areas,
            'area', 
            'areaAdv'
        )
    );

    $form->setLocationSelect(
        $form->createBasicSelect(
            'Town/Village', 
            $locations,
            'location', 
            'locationAdv'
        )
    );

    $form->setSearchAttribute('Special Offers', 'specialOffer')
        ->setSearchAttribute('Featured Properties', 'promote');
    
    $form->build();
    
    // Just going to remove some TOCC specific things...
    $form->getElementBy('getId', 'dogs')->getParent()->remove();
    $form->getElementBy('getId', 'distance')->getParent()->remove();
    $form->getElementBy('getId', 'bathrooms')->getParent()->remove();
    
    // Change the type of the arrival date just to get a browser control
    $form->getElementBy('getId', 'fromDate')->setTemplate('<input type="date"{implodeAttributes}>')->popAttribute('readonly');
    
    // Perform search and Display properties
    $propertySearch = $searchHelper->search(1);
    $facets = $propertySearch->getFacets();
    $properties = $searchHelper->getProperties();
    
    // Loop through all of the elements of the facet and try to find an applicable
    // form element
    foreach ($facets as $facetName => $facet) {
        $ele = $form->getElementBy('getName', $facetName);
        if ($ele) {
            // If its a select box, loop through children and append amount
            // onto the options display value
            if ($ele->getType() == 'select') {
                foreach ($ele->getChildren() as $child) {
                    $property = $child->getValue();
                    if (property_exists($facet, $property)) {
                        $child->setDisplayValue($child->getDisplayValue() . ' (' . $facet->$property . ')');
                    } else if($child->getValue() != '') {
                        $child->setDisplayValue($child->getDisplayValue() . ' (0)');
                    }
                }
                
            // If its a checkbox, append amount onto the label (its parent)
            } else if ($ele->getType() == 'checkbox') {
                $ele->getParent()->setLabel(
                    $ele->getParent()->getLabel() . ' (' . $facet->true . ')'
                );
            }
        }
    }
    
    
    // Output form (using __toString() method)
    echo $form->mapValues();
    
    if ($properties) {
        echo sprintf(
            '<h2>Found: %s %s</h2>',
            $searchHelper->getSearch()->getTotal(),
            $searchHelper->getSearch()->getLabel()
        );
        
        // Output pagination
        echo $searchHelper->getPaginationLinks(5, ' | ');
        
        foreach ($properties as $property) {
            echo sprintf(
                '<p><a href="accessing-a-single-property.php?propref=%s&brandcode=%s">%s (%s)</a></p>',
                $property->getPropRef(),
                $property->getBrandcode(),
                $property->getName(),
                $property->getPropRef()
            );
        }
        
        
    } else {
        echo 'No Properties found';
    }
    
} catch(Exception $e) {
    echo $e->getMessage();
}