<?php
/**
 * --- GR4PHP (GoodRelations FOR PHP) ---
 * An easy example to include GR4PHP-API in your website
 * 
 * @author	Martin Anding, Stefan Dietrich (University of German Armed Forces Munich)
 * 			API is a result of a study project in "GoodRelations" in the year of 2010.
 * 			This work is based on the GoodRelations ontology, developed by Martin Hepp.
 * @link    http://purl.org/goodrelations/
 * @license GNU LESSER GENERAL PUBLIC LICENSE
 * @version 1.0
 * 
 */

// Requirements: the following two include tags
include_once 'gr4php.php';
include_once 'gr4php_configuration.php';

// first instruction: Instantiation of GR4PHP-Class
$gr4php=new GR4PHP(GR4PHP_Configuration::Endpoint_URIBURNER);

// second instruction: Select function, input array, wanted elements, mode and limt
print_r($gr4php->getStore(array("gln"=>"1234567890123"),FALSE,":lax",30));
