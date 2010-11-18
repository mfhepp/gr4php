<?php
/**
* --- GEFSA (GoodRelations Extractor For SPARQL API) ---
* All function directions, that are used to create the SPARQL-Query can you find in this class.
* To add new values for a function you have to upgrade the private attributes in this class.
*/ 
include_once 'gr4php_general.php';

class GR4PHP_Template{
	
	// Assoc. array shows all possible input values
	private static $possibleInputValues=array(
				":lax"=>array(
						"gln"=>array("?x gr:hasGlobalLocationNumber ?gln. ?gln bif:contains '\"","value","*\"' ."),
						"keyword"=>array("{{?x rdfs:label ?titel. ?titel bif:contains '\"","value","*\"' .} UNION
										  {?x rdfs:comment ?titel. ?titel bif:contains '\"","value","*\"' .} UNION
										  {?x dc:title ?titel. ?titel bif:contains '\"","value","*\"' .}}"),
						"country"=>array("{{?x vc:ADR ?y} UNION {?x vcard:adr ?y}}. {{?y vc:Country ?country. ?country bif:contains '\"","value","*\"' .} UNION 
										   {?y vcard:country-name ?country. ?country bif:contains '\"","value","*\"' .}}"),
						"city"=>array("{{?x vc:ADR ?y} UNION {?x vcard:adr ?y}}. {{?y vc:locality ?city. ?city bif:contains '\"","value","*\"' .} UNION 
										   {?y vcard:locality ?city. ?ity bif:contains '\"","value","*\"' .}}"),
						"legalName"=>array("?x gr:legalName ?name. ?name bif:contains '\"","value","*\"' ."),
						"duns"=>array("?x gr:hasDUNS ?duns. ?duns bif:contains '\"","value","*\"' ."),
						"isicv4"=>array("?x gr:hasISICv4 ?isicv4. ?isicv4 bif:contains '\"","value","*\"' ."),
						"naics"=>array("?x gr:hasNAICS ?naics. ?naics bif:contains '\"","value","*\"' ."),
						"openNow"=>array("?x gr:hasOpeningHoursSpecification ?spec.
									?spec gr:hasOpeningHoursDayOfWeek gr:","day",".
									?spec gr:closes ?closeTime.FILTER (?closeTime >"," \"","time","\" ","^^xsd:time).
									?spec gr:opens ?openTime.FILTER (?openTime < "," \"","time","\" "," ^^xsd:time)."),
						"sku"=>array("?x gr:hasStockKeepingUnit ?sku . ?sku bif:contains '\"","value","*\"' ."),
						"ean13"=>array("?x gr:hasEAN_UCC-13  ?ean. ?ean bif:contains '\"","value","*\"' ."),
						"gtin14"=>array("?x gr:hasGTIN-14 ?gtin. ?gtin bif:contains '\"","value","*\"' ."),
						"manufacturer"=>array("?x gr:hasManufacturer ?manufacturer. ?manufacturer bif:contains '\"","value","*\"' ."),
						// because of the minimal using..some elements of GR arent in use (at the moment!)
						//"variantOf"=>array("?x gr:isVariantOf ?variantOf. Filter regex(str(?variantOf),\"","value","\",\"i\")."),
						//"predecessorOf"=>array("?x gr:predecessorOf  ?predecessorOf. Filter regex(str(?predecessorOf),\"","value","\",\"i\")."),
						//"successorOf"=>array("?x gr:successorOf  ?successorOf. Filter regex(str(?successorOf),\"","value","\",\"i\")."),
						"validThrough"=>array("?offering gr:validThrough ?validThrough. ?validThrough bif:contains '\"","value","*\"'^^xsd:time ."),
						"validFrom"=>array("?offering gr:validFrom ?validFrom. ?validFrom bif:contains '\"","value","*\"'^^xsd:time ."),
						"maxPrice"=>array("?offering gr:hasPriceSpecification ?pricespec.
										   ?pricespec gr:hasCurrencyValue ?price. FILTER (?price <","price",")."),
						"currency"=>array("?offering gr:hasPriceSpecification ?pricespec.
										   ?pricespec gr:hasCurrency ?currency. ?currency bif:contains '\"","value","*\"' ."),
						"acceptedPaymentMethod"=>array("?offering gr:acceptedPaymentMethods ?acceptedPaymentMethod. ?acceptedPaymentMethod bif:contains '\"","value","*\"' ."),
						"businessFunction"=>array("?offering gr:hasBusinessFunction ?businessFunction. ?businessFunction bif:contains '\"","value","*\"' ."),
						"minWarrantyInMonths"=>array("?offering gr:hasWarrantyPromise ?hasWarrantyPromise.
													  ?hasWarrantyPromise gr:durationOfWarrantyInMonths ?min_warrantyInMonths
													  (?min_warrantyInMonths < "," \"","value","\" ",")."),
						"eligibleCustomerTypes"=>array("?offering gr:eligibleCustomerTypes ?customerTypes. ?customerTypes bif:contains '\"","value","*\"' ."),
						"eligibleRegions"=>array("?offering gr:eligibleRegions ?region. ?region bif:contains '\"","value","*\"' ."),
						"availabilityStarts"=>array("?offering gr:availabilityStarts ?availabilityStarts. ?availabilityStarts bif:contains '\"","value","*\"' ."),
						"availabilityEnds"=>array("?offering gr:availabilityEnds ?availabilityEnds. ?availabilityEnds bif:contains '\"","value","*\"' ."),
						"availableDeliveryMethods"=>array("?offering gr:availableDeliveryMethods ?availabledeliveryMethods. ?availabledeliveryMethods bif:contains '\"","value","*\"' ."),
						"geo"=>array("?x geo:geometry ?geo. Filter(( bif:round ( bif:st_distance ( ?geo,bif:st_point(","lat",", ","long",") ) ) ) < ","distance",")")
				),
				":strict"=>array(
						"gln"=>array("?x gr:hasGlobalLocationNumber \"","value","\"^^<xsd:string>."),
						"keyword"=>array("{{?x rdfs:label \"","value","\"@en.} UNION
										  {?x rdfs:comment \"","value","\"@en.} UNION
										  {?x dc:title \"","value","\"@en.}}"),
						"country"=>array("{{?x vc:ADR ?y} UNION {?x vcard:adr ?y}}. {{?y vc:Country \"","value","\"@en.} UNION 
										   {?y vcard:country-name \"","value","\"@en.}}"),
						"city"=>array("{{?x vc:ADR ?y} UNION {?x vcard:adr ?y}}. {{?y vc:locality \"","value","\"@en.} UNION 
										   {?y vcard:locality \"","value","\"@en.}}"),
						"legalName"=>array("?x gr:legalName \"","value","\"^^<xsd:Literal>."),
						"duns"=>array("?x gr:hasDUNS \"","value","\"^^<xsd:string>."),
						"isicv4"=>array("?x gr:hasISICv4 \"","value","\"^^<xsd:int>."),
						"naics"=>array("?x gr:hasNAICS \"","value","\"^^<xsd:int>."),
						"openNow"=>array("?x gr:hasOpeningHoursSpecification ?spec.
									?spec gr:hasOpeningHoursDayOfWeek gr:","day",".
									?spec gr:closes ?closeTime.FILTER (?closeTime >"," \"","time","\" ","^^xsd:time).
									?spec gr:opens ?openTime.FILTER (?openTime < "," \"","time","\" "," ^^xsd:time)."),
						"sku"=>array("?x gr:hasStockKeepingUnit \"","value","\"^^<xsd:string>."),
						"ean13"=>array("?x gr:hasEAN_UCC-13  \"","value","\"^^<xsd:string>."),
						"gtin14"=>array("?x gr:hasGTIN-14 ?gtin. ?gtin bif:contains '\"","value","*\"' ."),
						"manufacturer"=>array("?x gr:hasManufacturer \"","value","\"."),
						// because of the minimal using..some elements of GR arent in use (at the moment!)
						//"variantOf"=>array("?x gr:isVariantOf ?variantOf. Filter regex(str(?variantOf),\"","value","\",\"i\")."),
						//"predecessorOf"=>array("?x gr:predecessorOf  ?predecessorOf. Filter regex(str(?predecessorOf),\"","value","\",\"i\")."),
						//"successorOf"=>array("?x gr:successorOf  ?successorOf. Filter regex(str(?successorOf),\"","value","\",\"i\")."),
						"validThrough"=>array("?offering gr:validThrough \"","value","\"^^<xsd:dateTime>."),
						"validFrom"=>array("?offering gr:validFrom \"","value","\"^^<xsd:dateTime>."),
						"maxPrice"=>array("?offering gr:hasPriceSpecification ?pricespec.
										   ?pricespec gr:hasCurrencyValue ?price. FILTER (?price <","price",")."),
						"currency"=>array("?offering gr:hasPriceSpecification ?pricespec.
										   ?pricespec gr:hasCurrency \"","value","\"^^<xsd:string>."),
						"acceptedPaymentMethod"=>array("?offering gr:acceptedPaymentMethods \"","value","\"."),
						"businessFunction"=>array("?offering gr:hasBusinessFunction \"","value","\"."),
						"minWarrantyInMonths"=>array("?offering gr:hasWarrantyPromise ?hasWarrantyPromise.
													  ?hasWarrantyPromise gr:durationOfWarrantyInMonths ?min_warrantyInMonths
													  (?min_warrantyInMonths < "," \"","value","\" ",")."),
						"eligibleCustomerTypes"=>array("?offering gr:eligibleCustomerTypes \"","value","\"."),
						"eligibleRegions"=>array("?offering gr:eligibleRegions \"","value","\"^^<xsd:string>."),
						"availabilityStarts"=>array("?offering gr:availabilityStarts \"","value","\"^^<xsd:dateTime>."),
						"availabilityEnds"=>array("?offering gr:availabilityEnds \"","value","\"^^<xsd:dateTime>."),
						"availableDeliveryMethods"=>array("?offering gr:availableDeliveryMethods \"","value","\"."),
						"geo"=>array("?x geo:geometry ?geo. Filter(( bif:round ( bif:st_distance ( ?geo,bif:st_point(","lat",", ","long",") ) ) ) < ","distance",")")
				)
				
	);
	
	// Assoc. array shows all possible optional output values. 
	// A second-dimension array, that shows in the first dimension the memebership of the function 
	// and the second dimesnion all possible ouput values of it.
	private static $possibleOutputValues=array(
						"getStore"=>array(
								"gln"=>"OPTIONAL {?x gr:hasGlobalLocationNumber ?gln.} ",
								"keyword"=> "OPTIONAL {{?x rdfs:label ?titel.} UNION
											{?x rdfs:comment ?titel.} UNION {?x dc:title ?titel.}} ",
								"street"=>"OPTIONAL {{{?x vc:ADR ?y} UNION {?x vcard:adr ?y}}} 
										   OPTIONAL {{{?y vcard:street-address ?street.} UNION {?y vc:Street ?street.}}} ",
								"post"=>"OPTIONAL {{{?y vcard:postal-code ?postalcode.} UNION {?y vc:Pobox ?postalcode.}}} ",
								"city"=>"OPTIONAL {{{?y vcard:locality ?city.} UNION {?y vc:locality ?city.}}} ",
								"country"=>"OPTIONAL {{{?y vcard:country-name ?country.} UNION {?y vc:country ?country.}}} ",
								"phone"=>"OPTIONAL {{{?y vc:TEL ?phone.} UNION {?y vcard:tel ?phone.}}} ",
								"email"=>"OPTIONAL {{{?y vc:EMAIL ?b.} UNION {?x vcard:email ?b.}}}
									   			OPTIONAL {{{?b rdf:value ?email.} UNION {?b rdfs:comment ?email.}}} ",
								"geoposition"=>"OPTIONAL{{{?y vcard:geo ?z.?z vcard:latitude ?lat.?z vcard:longitude ?long.}
   														UNION {?y geo:location ?z.?z geo:lat ?lat.?z geo:long ?long.}
   														UNION {?y vc:GEO ?z.?z vc:latitude ?lat.?z vc:longitude ?long.}}} ",
								"openTime"=>""),
						"getCompany"=>array(
								"name"=>"OPTIONAL {?x gr:legalName ?name.} ",
								"duns"=>"OPTIONAL {?x gr:hasDUNS ?duns.} ",
								"isicv4"=>"OPTIONAL {?x gr:hasISICv4 ?isicv4.} ",
								"naics"=>"OPTIONAL {?x gr:hasNAICS ?naics.} ",
								"gln"=>"OPTIONAL {?x gr:hasGlobalLocationNumber ?gln.} ",
								"keyword"=> "OPTIONAL {{?x rdfs:label ?titel.} UNION
											{?x rdfs:comment ?titel.} UNION {?x dc:title ?titel.}} ",
								"street"=>"OPTIONAL {{{?x vc:ADR ?y} UNION {?x vcard:adr ?y}}} 
										   OPTIONAL {{{?y vcard:street-address ?street.} UNION {?y vc:Street ?street.}}} ",
								"post"=>"OPTIONAL {{{?y vcard:postal-code ?postalcode.} UNION {?y vc:Pobox ?postalcode.}}} ",
								"city"=>"OPTIONAL {{{?y vcard:locality ?city.} UNION {?y vc:locality ?city.}}} ",
								"country"=>"OPTIONAL {{{?y vcard:country-name ?country.} UNION {?y vc:country ?country.}}} ",
								"phone"=>"OPTIONAL {{{?y vc:TEL ?phone.} UNION {?y vcard:tel ?phone.}}} ",
								"email"=>"OPTIONAL {{{?y vc:EMAIL ?b.} UNION {?x vcard:email ?b.}}}
									   	  OPTIONAL {{{?b rdf:value ?email.} UNION {?b rdfs:comment ?email.}}} ",
								"geoposition"=>"OPTIONAL{{{?y vcard:geo ?z.?z vcard:latitude ?lat.?z vcard:longitude ?long.}
   														UNION {?y geo:location ?z. ?z geo:lat ?lat. ?z geo:long ?long.}
   														UNION {?y vc:GEO ?z.?z vc:latitude ?lat.?z vc:longitude ?long.}}} "),
						"getProductModel"=>array(
								"keyword"=> "OPTIONAL {{?x rdfs:label ?titel.} UNION
											{?x rdfs:comment ?titel.} UNION {?x dc:title ?titel.}}",
								"sku"=>"OPTIONAL {?x gr:hasStockKeepingUnit ?sku .}",
								"ean13"=>"OPTIONAL {?x gr:hasEAN_UCC-13  ?ean.}",
								"gtin14"=>"OPTIONAL {?x gr:hasGTIN-14  ?gtin.}",
								"description"=>"OPTIONAL {{?x gr:description   ?description.} UNION {?x rdfs:comment ?description.}}",
								"website"=>"OPTIONAL {{?x foaf:page   ?website.} UNION {?x rdfs:seeAlso ?website.}}",
								"manufacturer"=>"OPTIONAL {?x gr:hasManufacturer ?manufacturer.}",
								// because of the minimal using..some elements of GR arent in use (at the moment!)
								//"variantOf"=>"OPTIONAL {?x gr:isVariantOf ?variantOf.}",
								//"consumableFor"=>"OPTIONAL {?x gr:isConsumableFor ?consumablefor.}",
								//"similiarTo"=>"OPTIONAL {?x gr:isSimilarTo  ?similiarTo.}",
								//"predecessorOf"=>"OPTIONAL {?x gr:predecessorOf  ?predecessorOf.}",
								//"succesorOf"=>"OPTIONAL {?x gr:successorOf  ?successorOf.}",
								//"accessory"=>"OPTIONAL {?x gr:isAccessoryOrSparePartFor ?accessory.}"
								),
						"getOffers"=>array(
								""=>"?offering gr:includesObject ?taqn. ?taqn gr:typeOfGood ?x.",
								"keyword"=> "OPTIONAL {{?x rdfs:label ?titel.} UNION
											{?x rdfs:comment ?titel.} UNION {?x dc:title ?titel.}}",
								"sku"=>"OPTIONAL {?x gr:hasStockKeepingUnit ?sku.}",
								"ean13"=>"OPTIONAL {?x gr:hasEAN_UCC-13  ?ean.}",
								"gtin14"=>"OPTIONAL {?x gr:hasGTIN-14  ?gtin.}",
								"description"=>"OPTIONAL {{?x gr:description   ?description.} UNION {?x rdfs:comment ?description.}}",
								"manufacturer"=>"OPTIONAL {?x gr:hasManufacturer ?manufacturer.}",
								"description"=>"OPTIONAL {{?x gr:description   ?description.} UNION {?x rdfs:comment ?description.}}",
								"minValue"=>"Optional{?x gr:hasInventoryLevel ?inventoryLevel.?inventoryLevel gr:hasMinValue ?minValue.}",
								"validThrough"=>"Optional{?offering gr:validThrough ?validThrough.}",
								"validFrom"=>"Optional{?offering gr:validFrom ?validFrom.}",
								"businessFunction"=>"Optional{?offering gr:hasBusinessFunction ?businessFunction.}",
								"price"=>"Optional{?offering gr:hasPriceSpecification ?pricespec.?pricespec gr:hasCurrencyValue ?price.}",
								"currency"=>"Optional{?pricespec gr:hasCurrency ?currency.}",
								"acceptedPaymentMethod"=>"Optional{?offering gr:acceptedPaymentMethods ?acceptedPaymentMethod.}",
								"minWarrantyInMonths"=>"Optional{?offering gr:hasWarrantyPromise ?hasWarrantyPromise.
														?hasWarrantyPromise gr:durationOfWarrantyInMonths ?min_warrantyInMonths.}",
								"eligibleCustomerTypes"=>"Optional{?offering gr:eligibleCustomerTypes ?customerTypes.}",
								"eligibleRegions"=>"Optional{?offering gr:eligibleRegions ?region.}",
								"availabilityStarts"=>"Optional{?offering gr:availabilityStarts ?availabilityStarts.}",
								"availabilityEnds"=>"Optional{?offering gr:availabilityEnds ?availabilityEnds.}",
								"availableDeliveryMethods"=>"Optional{?offering gr:availableDeliveryMethods ?availableDeliveryMethods.}",
								"availableAtOrFrom"=>"Optional{?offering gr:availableAtOrFrom ?availableAtOrFrom.}",
								"paymentChargeSpec"=>"Optional{?pricespec gr:hasCurrency ?paymentCurrency.?pricespec gr:hasCurrencyValue ?paymentCurrencyValue.
													   ?pricespec gr:valueAddedTaxIncluded ?paymentTaxIncluded.}",
								"deliverySpec"=>"Optional{?pricespec gr:eligibleRegions ?deliveryRegion.?pricespec gr:hasCurrency ?deliveryCurrency.
														  ?pricespec gr:hasCurrencyValue ?deliveryCurrencyValue.?pricespec gr:valueAddedTaxIncluded ?deliveryTaxIncluded.}"),
						"getOpeningHours"=>array(
								"keyword"=> "OPTIONAL {{?x rdfs:label ?titel.} UNION
											{?x rdfs:comment ?titel.} UNION {?x dc:title ?titel.}} ",
								"monday"=>"OPTIONAL{?spec gr:hasOpeningHoursDayOfWeek gr:Monday .?spec gr:opens ?openMonday. ?spec gr:closes ?closeMonday.}",
								"tuesday"=>"OPTIONAL{?spec gr:hasOpeningHoursDayOfWeek gr:Tuesday .?spec gr:opens ?openTuesday. ?spec gr:closes ?closeTuesday.}",
								"wednesday"=>"OPTIONAL{?spec gr:hasOpeningHoursDayOfWeek gr:Wednesday .?spec gr:opens ?openWednesday. ?spec gr:closes ?closeWednesday.}",
								"thursday"=>"OPTIONAL{?spec gr:hasOpeningHoursDayOfWeek gr:Thursday .?spec gr:opens ?openThursday. ?spec gr:closes ?closeThursday.}",
								"friday"=>"OPTIONAL{?spec gr:hasOpeningHoursDayOfWeek gr:Friday .?spec gr:opens ?openFriday. ?spec gr:closes ?closeFriday.}",
								"saturday"=>"OPTIONAL{?spec gr:hasOpeningHoursDayOfWeek gr:Saturday .?spec gr:opens ?openSaturday. ?spec gr:closes ?closeSaturday.}",
								"sunday"=>"OPTIONAL{?spec gr:hasOpeningHoursDayOfWeek gr:Sunday .?spec gr:opens ?openSunday. ?spec gr:closes ?closeSunday.}",
								),
						"getLocation"=>array(
								"gln"=>"OPTIONAL {?x gr:hasGlobalLocationNumber ?gln.} ",
								"keyword"=> "OPTIONAL {{?x rdfs:label ?titel.} UNION
											{?x rdfs:comment ?titel.} UNION {?x dc:title ?titel.}} "
								)
	);
	
	//Specific output values for some functions.
	private static $specialOutputValues=array(
								"openTime"=>array("OPTIONAL {?x gr:hasOpeningHoursSpecification ?spec.
														?spec gr:hasOpeningHoursDayOfWeek gr:","day",".
														?spec gr:opens ?openTime. ?spec gr:closes ?closeTime.}"));
	
	//Possible SELECT-values of all functions.
	// "general"=> all functions use it!
	private static $possibleSelectParts=array(
						"general"=>array(
									"?titel"
									),
						"getStore"=>array(
									"?x",
									"?gln",
									"?street",
									"?postalcode",
									"?city","?country",
									"?phone",
									"?email",
									"?long", 
									"?lat", 
									"?openTime",
									"?closeTime"
									),
						"getCompany"=>array(
									"?gln",
									"?name", 
									"?duns",
									"?isicv4",
									"?naics",
									"?street",
									"?postalcode",
									"?city",
									"?country",
									"?phone",
									"?email",
									"?long", 
									"?lat"
									),
						"getProductModel"=>array(
										"?sku",
										"?ean",
										"?gtin",
										"?description",
										"?website",
										"?manufacturer",
									// because of the minimal using..some elements of GR arent in use (at the moment!)
										//"?variantOf",
										//"?consumablefor",
										//"?similiarTo",
										//"?predecessorOf",
										//"?successorOf",
										//"?accessory"
									),
						"getOffers"=>array(
									"?ean",
									"?gtin",
									"?sku",
									"?manufacturer",
									"?businessFunction",
									"?acceptedPaymentMethod",
									"?price",
									"?currency",
	 								"?region",
	 								"?customerTypes",
	 								"?minValue",
	 								"?validFrom",
	 								"?validThrough",
	 								"?description",
	 								"?availableAtOrFrom",
				 					"?availabilityStarts",
				 					"?availabilityEnds",
									"?availableDeliveryMethods",
				 					"?min_warrantyInMonths",
				 					"?paymentCurrency",
				 					"?paymentCurrencyValue",
								 	"?paymentTaxIncluded",
								 	"?deliveryRegion",
								 	"?deliveryCurrency",
								 	"?deliveryCurrencyValue",
								 	"?deliveryTaxIncluded"
									),
						"getOpeningHours"=>array(
									"?openMonday",
									"?closeMonday",
									"?openTuesday",
									"?closeTuesday",
									"?openWednesday",
									"?closeWednesday",
									"?openThursday",
									"?closeThursday",
									"?openFriday",
									"?closeFriday",
									"?openSaturday",
									"?closeSaturday",
									"?openSunday",
									"?closeSunday"
									),
						"getLocation"=>array(
									"?gln",
									"?geo"
									)
	);
	
	//Possible Input values
	private static $possibleInputValuesByFunction=array(
						"getStore"=>array(
									"gln",
									"keyword",
									"country",
									"city"
									),
						"getCompany"=>array(
									"legalName",
									"keyword",
									"duns",
									"gln",
									"isicv4",
									"naics"
									),
						"getProductModel"=>array(
									"ean13",
									"gtin14",
									"keyword",
									"manufacturer",
									// because of the minimal using..some elements of GR arent in use (at the moment!)
									//"variantOf",
									//"predecessorOf",
									//"successorOf"
									),
						"getOffers"=>array(
									"ean13",
									"gtin14",
									"keyword",
									"sku",
									"manufacturer",
									"validThrough",
									"validFrom",
									"maxPrice",
									"currency",
									"acceptedPaymentMethod",
									"businessFunction",
									"minWarrantyInMonths",
									"eligibleCustomerTypes",
									"eligibleRegions",
									"availabilityStarts",
									"availabilityAtOrFrom"
									),
						"getOpeningHours"=>array(
									"gln",
									"keyword"
									),
						"getLocation"=>array(
									"gln",
									"keyword"
									)
	);
	
	//Some functions neeed at the beginning of the query a ontology memebership. 
	//Without the memebership the query result can be wrong or incorrect! 
	private static $prefix=array(
						"getStore"=>array(
							"vc"=>"PREFIX vc:<http://www.w3.org/2001/vcard-rdf/3.0#>",
							"vcard"=>"PREFIX vcard:<http://www.w3.org/2006/vcard/ns#> ",
							"xsd"=>"PREFIX xsd:<http://www.w3.org/2001/XMLSchema#>"),
						"getCompany"=>array(
							"vc"=>"PREFIX vc:<http://www.w3.org/2001/vcard-rdf/3.0#>",
							"vcard"=>"PREFIX vcard:<http://www.w3.org/2006/vcard/ns#> ",
							"xsd"=>"PREFIX xsd:<http://www.w3.org/2001/XMLSchema#>")
	);
	
	// array of elements to check the datatype of an input value
	private static $inputValueFormat=array(
						"integer"=>array(
									"gln",
									"duns",
									"isicv4",
									"naics",
									"ean13",
									"gtin14",
									"sku",
									"minWarrantyInMonths",
									"maxPrice",
									"lat",
									"long",
									"distance"
									),
						"string"=>array(
									"keyword",
									"country",
									"city",
									"legalName",
									"manufacturer",
									// because of the minimal using..some elements of GR arent in use (at the moment!)
									//"variantOf",
									//"predecessorOf",
									//"successorOf",
									"currency",
									"acceptedPaymentMethod",
									"businessFunction",
									"eligibleCustomerTypes",
									"eligibleRegions")
	);
	
	// array of elements to check length of certain input elements
	private static $correctLengthOfElements=array(
						"gln"=>13,
						"ean13"=>13,
						"gtin14"=>14,
						"duns"=>9
	);
	
/////Start function section
	/**
	 *
	 * Return path to specifice ontologie libs depend on function 
	 * @param function
	 * @return finished ontologie information of the whole query 
	 */
	static function getPrefixByFunction($part){
		return self::$prefix[$part];
	}
	
	/**
	 *
	 * Return SELECT-part of a query depend on function
	 * @param function
	 * @return finished SELECT-part of the query 
	 */
	static function getSelectPartsByFunction($part){
		return self::$possibleSelectParts[$part];
	}
	
	/**
	 *
	 * Return the input part and assign values  depend on function 
	 * @param mode of Sparql (lax or strict)
	 * @param input part
	 * @param assign value to the input part
	 * @return finished input order
	 */ 
	static function getInputValues($mode,$column,$value){

		foreach (self::$possibleInputValues[$mode][$column] as $part){
			
			if ($part=="value"){
				$sparql.=$value;
			}
			// if day or time-value then get the currently date/time-value 
			elseif($part=="day" || $part=="time"){$sparql.=getDateByValue($part);}
			
			// if price and lax-mode..than add to input price 1%
			elseif($part=="price"){$sparql.=(float)$value*(1.01);}
			
			elseif($column=="geo" && ($part=="lat" || $part=="long" || $part=="distance")){
				$sparql.=$value[$part];	
			}
			
			
			else {$sparql.=$part;}
		}
		
		return $sparql;
	}
	
	/**
	 *
	 * Return part of specific output values of a query
	 * @param function
	 * @return finished specific output values of the query 
	 */
	static function getSpecialOutputValues($part){
		$sparql="";
				foreach (self::$specialOutputValues[$part] as $part){
			if ($part=="day"){
				$sparql.=getDateByValue($part);
			}
			else {$sparql.=$part;}
		}
		return $sparql;
	}
	
	/**
	 *
	 * Return optional output-part of a query depend on function
	 * @param function
	 * @return finished optional output-part of the query 
	 */
	static function getOutputValuesByFunction($part){
		return self::$possibleOutputValues[$part];
	}
	
	/**
	 *
	 * Return an array of all possible input values of the given function
	 * @param function
	 * @return array of possible input values 
	 */
	static function possibleInputValuesByFunction($function){
		return self::$possibleInputValuesByFunction[$function];
	}
	
	/**
	 *
	 * Return the real format of an element to prove the datatype of the input
	 * @param element in input array
	 * @return format of the element
	 */
	static function checkFormatOfInputValue($element){
		$type=NULL;
		foreach (self::$inputValueFormat as $formatGroup => $possibleArray){
			if (in_array($element,$possibleArray)){
				$type=$formatGroup;
				break;
			}
		}
		return $type;
	}
	
	/**
	 *
	 * Return an array with information of certain elements and length
	 * @return array of lengths 
	 */
	static function checkLengthOfElements(){
		return self::$correctLengthOfElements;
	}
	
	/**
	 *
	 * Return an array of special select parts (e.g. for getLocation())
	 * @param input Array
	 * @return special select statement 
	 */
	static function getSpecialSelectPartsByFunction($inputArray){
	$prepare="( bif:round ( bif:st_distance ( ?geo,bif:st_point(".$inputArray['geo']['lat'].", ".$inputArray['geo']['long'].") ) ) ) AS ?distance";
	$statement[]=$prepare;
	return $statement;
	}
/////End function section
}