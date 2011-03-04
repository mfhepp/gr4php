<?php
/**
 * --- GR4PHP (GoodRelations FOR PHP) ---
 * This class has all configuration attributes of the API
 * 
 * @author	Martin Anding, Stefan Dietrich (University of German Armed Forces Munich)
 * 			API is a result of a study project in "GoodRelations" in the year of 2010.
 * 			This work is based on the GoodRelations ontology, developed by Martin Hepp.
 * @link    http://purl.org/goodrelations/
 * @license GNU LESSER GENERAL PUBLIC LICENSE
 * @version 1.0
 */
 class Configuration{
	
 	// query limit
	const LIMIT = 20;
	
	// some endpoints to get the SPARQL information
	const ENDPOINT_URIBURNER="http://www.uriburner.com/sparql";
	const ENDPOINT_LDURIBURNER="http://linkeddata.uriburner.com/sparql";
	const ENDPOINT_LOC="http://linkedopencommerce.com/sparql";
	const ENDPOINT_LOD="http://lod.openlinksw.com/sparql";

	//variants of mode
	const MODE_LAX=":lax";
	const MODE_STRICT=":strict";
	
	// list of available standard namespace prefixes
	static $prefixes = array(
		"gr"=>"http://purl.org/goodrelations/v1#",
		"rdfs"=>"http://www.w3.org/2000/01/rdf-schema#",
		"dc"=>"http://purl.org/dc/elements/1.1/",
		"vc"=>"http://www.w3.org/2001/vcard-rdf/3.0#",
		"vcard"=>"http://www.w3.org/2006/vcard/ns#",
		"rdf"=>"http://www.w3.org/1999/02/22-rdf-syntax-ns#",
		"foaf"=>"http://xmlns.com/foaf/0.1/",
		"geo"=>"http://www.w3.org/2003/01/geo/wgs84_pos#"
	);
	
	// bind your custom namespace prefix
	static function bindPrefix($ns="foo", $uri) {
		self::$prefixes[$ns] = $uri;
	}
}