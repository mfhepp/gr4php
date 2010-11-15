<?php
/**
 * --- GEFSA (GoodRelations Extractor For SPARQL API) ---
 * This class has all configuration infos of the API
 * 
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