<?php
/**
 * --- GR4PHP (GoodRelations FOR PHP) ---
 * This class has all configuration infos of the API
 * 
 * @author	Martin Anding, Stefan Dietrich (Students at Universität der Bundeswehr München)
 * 			API is a result of a study project in "GoodRelations" in the year of 2010.
 * 			This work is based on the GoodRelations ontology, developed by Martin Hepp.
 * @link    http://purl.org/goodrelations/
 * @license GNU LESSER GENERAL PUBLIC LICENSE
 * @version 1.0
 */
 class GR4PHP_Configuration{
	
 	// query Limit
	const Limit =20;
	
	// some Endpoints to get the SPARQL information
	const Endpoint_URIBURNER="http://www.uriburner.com/sparql";
	const Endpoint_LDURIBURNER="http://linkeddata.uriburner.com/sparql";
	const Endpoint_LOC="http://linkedopencommerce.com/sparql";
	const Endpoint_LOD="http://lod.openlinksw.com/sparql";

	//variants of mode
	const Mode_LAX=":lax";
	const Mode_STRICT=":strict";
}