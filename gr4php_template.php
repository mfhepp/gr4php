<?php
/**
* --- GR4PHP (GoodRelations FOR PHP) ---
* All function directions, that are used to create the SPARQL-Query can you find in this class.
* To add new values for a function you have to upgrade the private attributes in this class.
* 
* @author	Martin Anding, Stefan Dietrich, Alex Stolz (University of German Armed Forces Munich)
* 			API is a result of a study project in "GoodRelations" in the year of 2010.
* 			This work is based on the GoodRelations ontology, developed by Martin Hepp.
* @link    http://purl.org/goodrelations/
* @license GNU LESSER GENERAL PUBLIC LICENSE
* @version 1.0
*/
include_once 'gr4php_general.php';

class GR4PHP_Template{
	
	// Assoc. array shows all possible input values
	private static $possibleInputValues=array(
		":lax"=>array(
				"gln"=>array("?uri gr:hasGlobalLocationNumber ?gln. ?gln bif:contains '\"","value","\"' ."),
				"title"=>array("{{?uri rdfs:label ?title. ?title bif:contains '\"","value","\"' .} UNION
					{?uri gr:name ?title. ?title bif:contains '\"","value","\"' .} UNION
					{?uri gr:description ?title. ?title bif:contains '\"","value","\"' .} UNION
					{?uri rdfs:comment ?title. ?title bif:contains '\"","value","\"' .} UNION
					{?uri dc:title ?title. ?title bif:contains '\"","value","\"' .}}"),
				"country"=>array("{{?uri vc:ADR ?adr} UNION {?uri vcard:adr ?adr}}
					{{?adr vc:Country ?country. ?country bif:contains '\"","value","\"' .} UNION 
					{?adr vcard:country-name ?country. ?country bif:contains '\"","value","\"' .}}"),
				"street"=>array("{{?uri vc:ADR ?adr} UNION {?uri vcard:adr ?adr}}
					{{?adr vc:Street ?street. ?street bif:contains '\"","value","\"' .} UNION 
					{?adr vcard:street-address ?street. ?street bif:contains '\"","value","\"' .}}"),
				"post"=>array("{{?uri vc:ADR ?adr} UNION {?uri vcard:adr ?adr}}
					{{?adr vc:Pcode ?post. ?post bif:contains '\"","value","\"' .} UNION
					{?adr vcard:postal-code ?post. ?post bif:contains '\"","value","\"' .}}"),
				"city"=>array("{{?uri vc:ADR ?adr} UNION {?uri vcard:adr ?adr}}
					{{?adr vc:City ?city. ?city bif:contains '\"","value","\"' .} UNION
					{?adr vcard:locality ?city. ?city bif:contains '\"","value","\"' .}}"),
				"legalName"=>array("?uri gr:legalName ?legalName. ?legalName bif:contains '\"","value","\"' ."),
				"duns"=>array("?uri gr:hasDUNS ?duns. ?duns bif:contains '\"","value","\"' ."),
				"isicv4"=>array("?uri gr:hasISICv4 ?isicv4. ?isicv4 bif:contains '\"","value","\"' ."),
				"naics"=>array("?uri gr:hasNAICS ?naics. ?naics bif:contains '\"","value","\"' ."),
				"openNow"=>array("?uri gr:hasOpeningHoursSpecification ?time.
					?time gr:hasOpeningHoursDayOfWeek gr:","day",".
					?time gr:closes ?closeTime.FILTER (?closeTime >"," \"","time","\" ","^^xsd:time).
					?time gr:opens ?openTime.FILTER (?openTime < "," \"","time","\" "," ^^xsd:time)."),
				"sku"=>array("?uri gr:hasStockKeepingUnit ?sku . ?sku bif:contains '\"","value","\"' ."),
				"ean13"=>array("?uri gr:hasEAN_UCC-13 ?ean13. ?ean13 bif:contains '\"","value","\"' ."),
				"gtin14"=>array("?uri gr:hasGTIN-14 ?gtin14. ?gtin14 bif:contains '\"","value","\"' ."),
				"manufacturer"=>array("?uri gr:hasManufacturer ?manufacturer. ?manufacturer bif:contains '\"","value","\"' ."),
				// because of the minimal using..some elements of GR don't be in use (at the moment!)
				//"variantOf"=>array("?x gr:isVariantOf ?variantOf. Filter regex(str(?variantOf),\"","value","\",\"i\")."),
				//"predecessorOf"=>array("?x gr:predecessorOf ?predecessorOf. Filter regex(str(?predecessorOf),\"","value","\",\"i\")."),
				//"successorOf"=>array("?x gr:successorOf ?successorOf. Filter regex(str(?successorOf),\"","value","\",\"i\")."),
				"validThrough"=>array("?uri gr:validThrough ?validThrough. ?validThrough bif:contains '\"","value","\"'^^xsd:time ."),
				"validFrom"=>array("?uri gr:validFrom ?validFrom. ?validFrom bif:contains '\"","value","\"'^^xsd:time ."),
				"price"=>array("?uri gr:hasPriceSpecification ?pricespec.
					?pricespec gr:hasCurrencyValue ?price. FILTER (?price < ","price",")."),
				"currency"=>array("?uri gr:hasPriceSpecification ?pricespec.
					?pricespec gr:hasCurrency ?currency. ?currency bif:contains '\"","value","\"' ."),
				"acceptedPaymentMethod"=>array("?uri gr:acceptedPaymentMethods ?acceptedPaymentMethod. ?acceptedPaymentMethod bif:contains '\"","value","\"' ."),
				"businessFunction"=>array("?uri gr:hasBusinessFunction ?businessFunction. ?businessFunction bif:contains '\"","value","\"' ."),
				"minWarrantyInMonths"=>array("?uri gr:hasWarrantyPromise ?hasWarrantyPromise.
					?hasWarrantyPromise gr:durationOfWarrantyInMonths ?minWarrantyInMonths.
					FILTER (?minWarrantyInMonths < "," \"","value","\" ",")."),
				"eligibleCustomerTypes"=>array("?uri gr:eligibleCustomerTypes ?eligibleCustomerTypes. ?eligibleCustomerTypes bif:contains '\"","value","\"' ."),
				"eligibleRegions"=>array("?uri gr:eligibleRegions ?eligibleRegions ?eligibleRegions bif:contains '\"","value","\"' ."),
				"availabilityStarts"=>array("?uri gr:availabilityStarts ?availabilityStarts. ?availabilityStarts bif:contains '\"","value","\"' ."),
				"availabilityEnds"=>array("?uri gr:availabilityEnds ?availabilityEnds. ?availabilityEnds bif:contains '\"","value","\"' ."),
				"availableDeliveryMethods"=>array("?uri gr:availableDeliveryMethods ?availabledeliveryMethods. ?availabledeliveryMethods bif:contains '\"","value","\"' ."),
				"geo"=>array("?uri geo:geometry ?geo. FILTER(bif:round ( bif:st_distance ( ?geo,bif:st_point(","lat",", ","long",") ) ) < ","distance",")")
		),
		":strict"=>array(
				"gln"=>array("?uri gr:hasGlobalLocationNumber \"","value","\"^^xsd:string."),
				"title"=>array("{{?uri rdfs:label \"","value","\"@en.} UNION
					{?uri gr:name \"","value","\"@en.} UNION
					{?uri gr:description \"","value","\"@en.} UNION
					{?uri rdfs:comment \"","value","\"@en.} UNION
					{?uri dc:title \"","value","\"@en.}}"),
				"country"=>array("{{?uri vc:ADR ?adr} UNION {?uri vcard:adr ?adr}}
					{{?y vc:Country \"","value","\"@en.} UNION 
					{?y vcard:country-name \"","value","\"@en.}}"),
				"street"=>array("{{?uri vc:ADR ?adr} UNION {?uri vcard:adr ?adr}}
					{{?y vc:Street \"","value","\"@en.} UNION 
					{?y vcard:street-address \"","value","\"@en.}}"),
				"post"=>array("{{?uri vc:ADR ?adr} UNION {?uri vcard:adr ?adr}}
					{{?y vc:Pcode \"","value","\".} UNION 
					{?y vcard:postal-code \"","value","\".}}"),
				"city"=>array("{{?uri vc:ADR ?adr} UNION {?uri vcard:adr ?adr}}
					{{?adr vc:City \"","value","\"@en.} UNION 
					{?adr vcard:locality \"","value","\"@en.}}"),
				"legalName"=>array("?uri gr:legalName \"","value","\"^^xsd:Literal."),
				"duns"=>array("?uri gr:hasDUNS \"","value","\"^^xsd:string."),
				"isicv4"=>array("?uri gr:hasISICv4 \"","value","\"^^xsd:int."),
				"naics"=>array("?uri gr:hasNAICS \"","value","\"^^xsd:int."),
				"openNow"=>array("?uri gr:hasOpeningHoursSpecification ?time.
					?time gr:hasOpeningHoursDayOfWeek gr:","day",".
					?time gr:closes ?closeTime.FILTER (?closeTime >"," \"","time","\" ","^^xsd:time).
					?time gr:opens ?openTime.FILTER (?openTime < "," \"","time","\" "," ^^xsd:time)."),
				"sku"=>array("?uri gr:hasStockKeepingUnit \"","value","\"^^xsd:string."),
				"ean13"=>array("?uri gr:hasEAN_UCC-13  \"","value","\"^^xsd:string."),
				"gtin14"=>array("?uri gr:hasGTIN-14 ?gtin14 \"","value","\"^^xsd:string."),
				"manufacturer"=>array("?uri gr:hasManufacturer \"","value","\"."),
				// because of the minimal using..some elements of GR don't be in use (at the moment!)
				//"variantOf"=>array("?x gr:isVariantOf ?variantOf. Filter regex(str(?variantOf),\"","value","\",\"i\")."),
				//"predecessorOf"=>array("?x gr:predecessorOf  ?predecessorOf. Filter regex(str(?predecessorOf),\"","value","\",\"i\")."),
				//"successorOf"=>array("?x gr:successorOf  ?successorOf. Filter regex(str(?successorOf),\"","value","\",\"i\")."),
				"validThrough"=>array("?uri gr:validThrough \"","value","\"^^xsd:dateTime."),
				"validFrom"=>array("?uri gr:validFrom \"","value","\"^^xsd:dateTime."),
				"price"=>array("?uri gr:hasPriceSpecification ?pricespec.
					?pricespec gr:hasCurrencyValue ?price. FILTER (?price <","price",")."),
				"currency"=>array("?uri gr:hasPriceSpecification ?pricespec.
					?pricespec gr:hasCurrency \"","value","\"^^xsd:string."),
				"acceptedPaymentMethod"=>array("?uri gr:acceptedPaymentMethods \"","value","\"."),
				"businessFunction"=>array("?uri gr:hasBusinessFunction \"","value","\"."),
				"minWarrantyInMonths"=>array("?uri gr:hasWarrantyPromise ?hasWarrantyPromise.
					?hasWarrantyPromise gr:durationOfWarrantyInMonths ?minWarrantyInMonths.
					FILTER (?minWarrantyInMonths < "," \"","value","\" ",")."),
				"eligibleCustomerTypes"=>array("?uri gr:eligibleCustomerTypes \"","value","\"."),
				"eligibleRegions"=>array("?uri gr:eligibleRegions \"","value","\"^^xsd:string."),
				"availabilityStarts"=>array("?uri gr:availabilityStarts \"","value","\"^^xsd:dateTime."),
				"availabilityEnds"=>array("?uri gr:availabilityEnds \"","value","\"^^xsd:dateTime."),
				"availableDeliveryMethods"=>array("?uri gr:availableDeliveryMethods \"","value","\"."),
				"geo"=>array("?uri geo:geometry ?geo. Filter(bif:round ( bif:st_distance ( ?geo,bif:st_point(","lat",", ","long",") ) ) < ","distance",")")
		)
				
	);
	
	// Assoc. array shows all possible optional output values. 
	// A second-dimension array, that shows in the first dimension the memebership of the function 
	// and the second dimension all possible ouput values of it.
	private static $possibleOutputValues=array(
		"getStore"=>array(
				"gln"=>"OPTIONAL {?uri gr:hasGlobalLocationNumber ?gln.} ",
				"title"=> "OPTIONAL {{?urirdfs:label ?title.} UNION
					{?uri gr:name ?title.} UNION {?uri gr:description ?title.} UNION
					{?uri rdfs:comment ?title.} UNION {?uri dc:title ?title.}} ",
				"street"=>"OPTIONAL {{{?adr vcard:street-address ?street.} UNION {?adr vc:Street ?street.}}} ",
				"post"=>"OPTIONAL {{{?adr vcard:postal-code ?post.} UNION {?adr vc:Pcode ?post.}}} ",
				"city"=>"OPTIONAL {{{?adr vcard:locality ?city.} UNION {?adr vc:City ?city.}}} ",
				"country"=>"OPTIONAL {{{?adr vcard:country-name ?country.} UNION {?adr vc:Country ?country.}}} ",
				"phone"=>"OPTIONAL {{{?adr vc:TEL ?phone.} UNION {?adr vcard:tel ?phone.}}} ",
				"email"=>"OPTIONAL {{{?adr vc:EMAIL ?email.} UNION {?adr vcard:email ?email.}}}
					OPTIONAL {{{?mail rdf:value ?email.} UNION {?mail rdfs:comment ?email.}}} ",
				"lat"=>"OPTIONAL{{{?uri vcard:geo ?zlat.?zlat vcard:latitude ?lat.} UNION
					{?uri vcard:latitude ?lat.} UNION
					{?uri geo:location ?zlat.?zlat geo:lat ?lat.} UNION
					{?uri vc:GEO ?zlat.?zlat vc:latitude ?lat.} UNION
					{?uri geo:lat ?lat.}}} ",
				"long"=>"OPTIONAL{{{?uri vcard:geo ?zlong.?zlong vcard:longitude ?long.} UNION
					{?uri vcard:longitude ?long.} UNION
					{?uri geo:location ?zlong.?zlong geo:long ?long.} UNION
					{?uri vc:GEO ?zlong.?zlong vc:longitude ?long.} UNION
					{?uri geo:long ?long.}}} ",
				"openTime"=>array("OPTIONAL {?uri gr:hasOpeningHoursSpecification ?time.
					?time gr:hasOpeningHoursDayOfWeek gr:","day",".
					?time gr:opens ?openTime.}"),
				"closeTime"=>array("OPTIONAL {?x gr:hasOpeningHoursSpecification ?time.
					?time gr:hasOpeningHoursDayOfWeek gr:","day",".
					?time gr:closes ?closeTime.}")),
		"getCompany"=>array(
				"legalName"=>"OPTIONAL {?uri gr:legalName ?legalName.} ",
				"duns"=>"OPTIONAL {?uri gr:hasDUNS ?duns.} ",
				"isicv4"=>"OPTIONAL {?uri gr:hasISICv4 ?isicv4.} ",
				"naics"=>"OPTIONAL {?uri gr:hasNAICS ?naics.} ",
				"gln"=>"OPTIONAL {?uri gr:hasGlobalLocationNumber ?gln.} ",
				"title"=> "OPTIONAL {{?uri rdfs:label ?title.} UNION
					{?uri gr:name ?title.} UNION {?uri gr:description ?title.} UNION
					{?uri rdfs:comment ?title.} UNION {?uri dc:title ?title.}} ",
				"street"=>"OPTIONAL {{{?adr vcard:street-address ?street.} UNION {?adr vc:Street ?street.}}} ",
				"post"=>"OPTIONAL {{{?adr vcard:postal-code ?post.} UNION {?adr vc:Pcode ?post.}}} ",
				"city"=>"OPTIONAL {{{?adr vcard:locality ?city.} UNION {?adr vc:City ?city.}}} ",
				"country"=>"OPTIONAL {{{?adr vcard:country-name ?country.} UNION {?adr vc:Country ?country.}}} ",
				"phone"=>"OPTIONAL {{{?adr vc:TEL ?phone.} UNION {?uri vcard:tel ?phone.}}} ",
				"email"=>"OPTIONAL {{{?adr vc:EMAIL ?mail.} UNION {?uri vcard:email ?mail.}}}
					 OPTIONAL {{{?mail rdf:value ?email.} UNION {?mail rdfs:comment ?email.}}} ",
				"lat"=>"OPTIONAL{{{?uri vcard:geo ?zlat.?zlat vcard:latitude ?lat.} UNION
					{?uri vcard:latitude ?lat.} UNION
					{?uri geo:location ?zlat.?zlat geo:lat ?lat.} UNION
					{?uri vc:GEO ?zlat.?zlat vc:latitude ?lat.} UNION
					{?uri geo:lat ?lat.}}} ",
				"long"=>"OPTIONAL{{{?uri vcard:geo ?zlong.?zlong vcard:longitude ?long.} UNION
				 	{?uri vcard:longitude ?long.} UNION
					{?uri geo:location ?zlong.?zlong geo:long ?long.} UNION
					{?uri vc:GEO ?zlong.?zlong vc:longitude ?long.} UNION
					{?uri geo:long ?long.}}} ",
),
		"getProductModel"=>array(
				"title"=> "OPTIONAL {{?uri rdfs:label ?title.} UNION
					{?uri gr:name ?title.} UNION {?uri gr:description ?title.} UNION
					{?uri rdfs:comment ?title.} UNION {?uri dc:title ?title.}}",
				"sku"=>"OPTIONAL {?uri gr:hasStockKeepingUnit ?sku .}",
				"ean13"=>"OPTIONAL {?uri gr:hasEAN_UCC-13  ?ean13.}",
				"gtin14"=>"OPTIONAL {?uri gr:hasGTIN-14  ?gtin14.}",
				"description"=>"OPTIONAL {{?uri gr:description ?description.} UNION {?uri rdfs:comment ?description.}}",
				"website"=>"OPTIONAL {{?uri foaf:page ?website.} UNION {?uri rdfs:seeAlso ?website.}}",
				"manufacturer"=>"OPTIONAL {?uri gr:hasManufacturer ?manufacturer.}",
				// because of the minimal using..some elements of GR don't be in use (at the moment!)
				//"variantOf"=>"OPTIONAL {?x gr:isVariantOf ?variantOf.}",
				//"consumableFor"=>"OPTIONAL {?x gr:isConsumableFor ?consumablefor.}",
				//"similiarTo"=>"OPTIONAL {?x gr:isSimilarTo  ?similiarTo.}",
				//"predecessorOf"=>"OPTIONAL {?x gr:predecessorOf  ?predecessorOf.}",
				//"succesorOf"=>"OPTIONAL {?x gr:successorOf  ?successorOf.}",
				//"accessory"=>"OPTIONAL {?x gr:isAccessoryOrSparePartFor ?accessory.}"
				),
		"getOffers"=>array(
				""=>"?offering gr:includesObject ?taqn. ?taqn gr:typeOfGood ?uri.",
				"title"=> "OPTIONAL {{?uri rdfs:label ?title.} UNION
					{?uri gr:name ?title.} UNION {?uri gr:description ?title.} UNION
					{?uri rdfs:comment ?title.} UNION {?uri dc:title ?title.}}",
				"sku"=>"OPTIONAL {?uri gr:hasStockKeepingUnit ?sku.}",
				"ean13"=>"OPTIONAL {?uri gr:hasEAN_UCC-13  ?ean13.}",
				"gtin14"=>"OPTIONAL {?uri gr:hasGTIN-14  ?gtin14.}",
				"description"=>"OPTIONAL {{?uri gr:description ?description.} UNION {?uri rdfs:comment ?description.}}",
				"manufacturer"=>"OPTIONAL {?uri gr:hasManufacturer ?manufacturer.}",
				"description"=>"OPTIONAL {{?uri gr:description ?description.} UNION {?uri rdfs:comment ?description.}}",
				"minValue"=>"OPTIONAL {?uri gr:hasInventoryLevel ?inventoryLevel.?inventoryLevel gr:hasMinValue ?minValue.}",
				"validThrough"=>"OPTIONAL {?uri gr:validThrough ?validThrough.}",
				"validFrom"=>"OPTIONAL {?uri gr:validFrom ?validFrom.}",
				"businessFunction"=>"OPTIONAL {?uri gr:hasBusinessFunction ?businessFunction.}",
				"price"=>"OPTIONAL {?uri gr:hasPriceSpecification ?pricespec. ?pricespec gr:hasCurrencyValue ?price.}",
				"currency"=>"OPTIONAL {?pricespec gr:hasCurrency ?currency.}",
				"acceptedPaymentMethod"=>"OPTIONAL {?uri gr:acceptedPaymentMethods ?acceptedPaymentMethod.}",
				"minWarrantyInMonths"=>"OPTIONAL {?uri gr:hasWarrantyPromise ?hasWarrantyPromise.
					?hasWarrantyPromise gr:durationOfWarrantyInMonths ?minWarrantyInMonths.}",
				"eligibleCustomerTypes"=>"OPTIONAL {?uri gr:eligibleCustomerTypes ?eligibleCustomerTypes.}",
				"eligibleRegions"=>"OPTIONAL {?uri gr:eligibleRegions ?eligibleRegions.}",
				"availabilityStarts"=>"OPTIONAL {?uri gr:availabilityStarts ?availabilityStarts.}",
				"availabilityEnds"=>"OPTIONAL {?uri gr:availabilityEnds ?availabilityEnds.}",
				"availableDeliveryMethods"=>"OPTIONAL {?uri gr:availableDeliveryMethods ?availableDeliveryMethods.}",
				"availableAtOrFrom"=>"OPTIONAL {?uri gr:availableAtOrFrom ?availableAtOrFrom.}",
				"paymentCurrency"=>"",
				"paymentCurrencyValue"=>"",
				"paymentTaxIncluded"=>"OPTIONAL {?pricespec gr:hasCurrency ?paymentCurrency. ?pricespec gr:hasCurrencyValue ?paymentCurrencyValue. ?pricespec gr:valueAddedTaxIncluded ?paymentTaxIncluded.}",
				"deliveryRegion"=>"",
				"deliveryCurrency"=>"",
				"deliveryCurrencyValue"=>"",
				"deliveryTaxIncluded"=>"OPTIONAL {?pricespec gr:eligibleRegions ?deliveryRegion. ?pricespec gr:hasCurrency ?deliveryCurrency. ?pricespec gr:hasCurrencyValue ?deliveryCurrencyValue. ?pricespec gr:valueAddedTaxIncluded ?deliveryTaxIncluded.}"
				),
		"getOpeningHours"=>array(
				"title"=> "OPTIONAL {{?uri rdfs:label ?title.} UNION
					{?uri gr:name ?title.} UNION {?uri gr:description ?title.} UNION
					{?uri rdfs:comment ?title.} UNION {?uri dc:title ?title.}} ",
				"openMonday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Monday. ?time gr:opens ?openMonday. ?time gr:closes ?closeMonday.}",
				"openTuesday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Tuesday. ?time gr:opens ?openTuesday. ?time gr:closes ?closeTuesday.}",
				"openWednesday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Wednesday. ?time gr:opens ?openWednesday. ?time gr:closes ?closeWednesday.}",
				"openThursday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Thursday. ?time gr:opens ?openThursday. ?time gr:closes ?closeThursday.}",
				"openFriday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Friday. ?time gr:opens ?openFriday. ?time gr:closes ?closeFriday.}",
				"openSaturday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Saturday. ?time gr:opens ?openSaturday. ?time gr:closes ?closeSaturday.}",
				"openSunday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Sunday. ?time gr:opens ?openSunday. ?time gr:closes ?closeSunday.}",
				"closeMonday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Monday. ?time gr:opens ?openMonday. ?time gr:closes ?closeMonday.}",
				"closeTuesday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Tuesday. ?time gr:opens ?openTuesday. ?time gr:closes ?closeTuesday.}",
				"closeWednesday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Wednesday. ?time gr:opens ?openWednesday. ?time gr:closes ?closeWednesday.}",
				"closeThursday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Thursday. ?time gr:opens ?openThursday. ?time gr:closes ?closeThursday.}",
				"closeFriday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Friday. ?time gr:opens ?openFriday. ?time gr:closes ?closeFriday.}",
				"closeSaturday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Saturday. ?time gr:opens ?openSaturday. ?time gr:closes ?closeSaturday.}",
				"closeSunday"=>"OPTIONAL{?time gr:hasOpeningHoursDayOfWeek gr:Sunday. ?time gr:opens ?openSunday. ?time gr:closes ?closeSunday.}",
				),
		"getLocation"=>array(
				"gln"=>"OPTIONAL {?uri gr:hasGlobalLocationNumber ?gln.} ",
				"title"=> "OPTIONAL {{?uri rdfs:label ?title.} UNION
					{?uri gr:name ?title.} UNION {?uri gr:description ?title.} UNION
					{?uri rdfs:comment ?title.} UNION {?uri dc:title ?title.}} "
				)
	);
	
	//Possible SELECT-values of all functions.
	// "general"=> all functions use it!
	private static $possibleSelectParts=array(
		"general"=>array(
			"?uri",
			"?title"
			),
		"getStore"=>array(
			"?gln",
			"?street",
			"?post",
			"?city",
			"?country",
			"?phone",
			"?email",
			"?long", 
			"?lat", 
			"?openTime",
			"?closeTime"
			),
		"getCompany"=>array(
			"?gln",
			"?legalName",
			"?duns",
			"?isicv4",
			"?naics",
			"?street",
			"?post",
			"?city",
			"?country",
			"?phone",
			"?email",
			"?long", 
			"?lat"
			),
		"getProductModel"=>array(
			"?sku",
			"?ean13",
			"?gtin14",
			"?description",
			"?website",
			"?manufacturer",
			// because of the minimal using..some elements of GR don't be in use (at the moment!)
			//"?variantOf",
			//"?consumablefor",
			//"?similiarTo",
			//"?predecessorOf",
			//"?successorOf",
			//"?accessory"
			),
		"getOffers"=>array(
			"?ean13",
			"?gtin14",
			"?sku",
			"?manufacturer",
			"?businessFunction",
			"?acceptedPaymentMethod",
			"?price",
			"?currency",
			"?eligibleRegions",
			"?eligibleCustomerTypes",
			"?minValue",
			"?validFrom",
			"?validThrough",
			"?description",
			"?availableAtOrFrom",
			"?availabilityStarts",
			"?availabilityEnds",
			"?availableDeliveryMethods",
			"?minWarrantyInMonths",
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
			"title",
			"country",
			"street",
			"post",
			"city",
			"openNow"
			),
		"getCompany"=>array(
			"legalName",
			"title",
			"duns",
			"gln",
			"isicv4",
			"naics"
			),
		"getProductModel"=>array(
			"ean13",
			"gtin14",
			"title",
			"manufacturer",
			// because of the minimal using..some elements of GR don't be in use (at the moment!)
			//"variantOf",
			//"predecessorOf",
			//"successorOf"
			),
		"getOffers"=>array(
			"ean13",
			"gtin14",
			"title",
			"sku",
			"manufacturer",
			"validThrough",
			"validFrom",
			"price",
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
			"title"
			),
		"getLocation"=>array(
			"gln",
			"title"
			)
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
			"price",
			"lat",
			"long",
			"distance"
			),
		"string"=>array(
			"title",
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
			"eligibleRegions"
			)
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
	 * Add prefixes at beginning of query string.. no return value, call-by-reference
	 * @param 		string		$sparql SPARQL query string
	 */

	public static function appendPrefixes(&$sparql) {
		foreach (Configuration::$prefixes as $ns=>$uri) {
			if(preg_match("/$ns:/i", $sparql))
				$sparql = "PREFIX $ns: <$uri>\n".$sparql;
		}
	}
	
	/**
	 *
	 * Return SELECT-part of a query depend on function
	 * @param 		string		$part Function
	 * @return 		array		$possibleSelectParts Possible SELECT elements  
	 */
	public static function getSelectPartsByFunction($part){
		return self::$possibleSelectParts[$part];
	}
	
	/**
	 *
	 * Return the input part and assign values  depend on function 
	 * @param 		string		$mode Mode of Sparql (lax or strict)
	 * @param 		string		$column Input part
	 * @param 		string		$value Assign value to the input part
	 * @return 		string		$sparql	Finished input order
	 */ 
	public static function getInputValues($mode,$column,$value){

		foreach ((array)self::$possibleInputValues[$mode][$column] as $part){
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
	 * @param 		string		$functionName Function calling it
	 * @param 		string		$part Function
	 * @return 		string		$sparql Finished specific output values of the query 
	 */
	public static function getSpecialOutputValues($functionName, $part){
		$sparql="";
		foreach ((array)self::$possibleOutputValues[$functionName][$part] as $part){
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
	 * @param 		string		$part Function
	 * @return 		array		$possibleOutputValues Finished optional output-part of the query 
	 */
	public static function getOutputValuesByFunction($part){
		return self::$possibleOutputValues[$part];
	}
	
	/**
	 *
	 * Return an array of all possible input values of the given function
	 * @param 		string		$part Function
	 * @return 		array		$possibleInputValuesByFunction Array of possible input values 
	 */
	public static function possibleInputValuesByFunction($function){
		return self::$possibleInputValuesByFunction[$function];
	}
	
	/**
	 *
	 * Return the real format of an element to prove the datatype of the input
	 * @param 		string		$element Element in input array
	 * @return 		string		$type Format of the element
	 */
	public static function checkFormatOfInputValue($element){
		$type=NULL;
		foreach ((array)self::$inputValueFormat as $formatGroup => $possibleArray){
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
	 * @return 		array		$correctLengthOfElements Array of lengths 
	 */
	public static function checkLengthOfElements(){
		return self::$correctLengthOfElements;
	}
	
	/**
	 *
	 * Return an array of special select parts (e.g. for getLocation())
	 * @param		string		$functionName Function that uses these prepared special parts
	 * @param 		array		$inputArray Input array
	 * @return 		array		$statement	Special select statement 
	 */
	public static function getSpecialSelectPartsByFunction($functionName, $inputArray){
		$statement = array();
		if($functionName == "getLocation") {
			$prepare="( bif:round ( bif:st_distance ( ?geo,bif:st_point(".$inputArray['geo']['lat'].", ".$inputArray['geo']['long'].") ) ) ) AS ?distance";
			$statement[]=$prepare;
		}
		return $statement;
	}
/////End function section
}