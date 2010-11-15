<?php
/**
 * --- GEFSA (GoodRelations Extractor For SPARQL API) ---
 * This class creates the SPARQL-Query to search for gr-data
 * 
 */
include_once 'gr4php_template.php';
include_once 'gr4php_configuration.php';
include_once 'gr4php_general.php';
include_once 'gr4php_exception.php';

class GR4PHP{
	
	private $endpoint;
	private $timeout;
	
	// Constructor of Class
	public function __construct($endpoint=GR4PHP_Configuration::Endpoint_URIBURNER,$timeout=10000){
			$this->endpoint=$endpoint;
			$this->timeout=$timeout;	
	} 
	/**
	 *
	 * Return SPARQL Query for gr:getStoreInfo
	 * @param Input Array with search elements
	 * @param Mode (strict || lax)
	 * @param Result-Limit (Default: 0 --> see configuration.php)
	 * @return SPARQL Query
	 */
	function getStore($inputArray,$mode=GR4PHP_Configuration::Mode_LAX, $limit=0 ){
		// At first check all possible errors
		// 1) not empty input array?
		GR4PHP_Exception::isNotEmptyInputArray($inputArray); 
		
		// 2) all input elments are allowed?
		GR4PHP_Exception::isPossibleInputElementOfFunction($inputArray,"getStore");
		
		// 3) Control amount of elements and values (equal)
		GR4PHP_Exception::isEqualElementAndValueAmount($inputArray);
		
		// 4) Control format of input values
		GR4PHP_Exception::isCorrectValueForInputElement($inputArray);
		
		// 5) Control length of values in input Array 
		GR4PHP_Exception::isCorrectLengthOfValueCausedByWildcardRule($inputArray);
		
		// 6) Correct length of some gr-values (only in strict mode.)
		if ($mode==GR4PHP_Configuration::Mode_STRICT){
			GR4PHP_Exception::correctLengthOfValueInSrictMode($inputArray);
		}
		// No error! The query building begins
		// get Ontologies for getStoreInfo
		$ontologies=GR4PHP_Template::getPrefixByFunction("getStore");
		
		//add Ontologies to query
		if(!empty($ontologies)){
		foreach($ontologies as $ontologie => $prefix){
			$sparql.=$prefix." ";
		}
		}
		// get SELECT-parts of getStoreInfo
		$selectPartspec=GR4PHP_Template::getSelectPartsByFunction("getStore");
		
		
		// get SELECT-part (here:general-part)
		$selectPartDefault=GR4PHP_Template::getSelectPartsByFunction("general");
		
		$selectPartComplete=array_merge($selectPartDefault,$selectPartspec);
		
		$sparql.= "SELECT DISTINCT ".getArray2String($selectPartComplete)." WHERE { ";
		
		$deleteOptionalInput=array();

			// set WHERE-part of query
			//cut the length of certain elements (here: gln)
			$inputArray=isLengthOfElementRight($inputArray);
			foreach ($inputArray as $column => $value){
				$sparql.=GR4PHP_Template::getInputValues($mode,$column,$value);
				if ($mode==GR4PHP_Configuration::Mode_LAX){
					$deleteOptionalInput[]=$column;
				}
			}
		
		$sparql.=" ?x a gr:LocationOfSalesOrServiceProvisioning. ";
		
		// get OPTIONAL-part of getStoreInfo (depend on input array)
		$outputValues=GR4PHP_Template::getOutputValuesByFunction("getStore");
		
		foreach($outputValues as $aloneOutput => $output){
		
		// set OPTIONAL-part
		if (!in_array($aloneOutput , $deleteOptionalInput)){
			if ($aloneOutput=="openTime"){
			$sparql.=GR4PHP_Template::getSpecialOutputValues($aloneOutput);}
			$sparql.=$output;
			}
		}
		
		//set LIMIT of query
		$sparql.="} LIMIT ";
		
		if ($limit==0){
			$limit=GR4PHP_Configuration::Limit;	
		}
		$sparql.=$limit;
		return self::connectGR4PHP($sparql,"getStore");	
	}
	
	/**
	 *
	 * Return SPARQL Query for gr:getBusinessEntity
	 * @param Input Array with search elements
	 * @param Mode (strict || lax)
	 * @param Result-Limit (Default: 0 --> see configuration.php)
	 * @return SPARQL Query
	 */
	function getCompany($inputArray,$mode=GR4PHP_Configuration::Mode_LAX, $limit=0 ){
		// At first check all possible errors
		// 1) not empty input array?
		GR4PHP_Exception::isNotEmptyInputArray($inputArray); 
		
		// 2) all input elments are allowed?
		GR4PHP_Exception::isPossibleInputElementOfFunction($inputArray,"getCompany");
		
		// 3) Control amount of elements and values (equal)
		GR4PHP_Exception::isEqualElementAndValueAmount($inputArray);
		
		// 4) Control format of input values
		GR4PHP_Exception::isCorrectValueForInputElement($inputArray);
		
		// 5) Control length of values in input Array 
		GR4PHP_Exception::isCorrectLengthOfValueCausedByWildcardRule($inputArray);
		
		// 6) Correct length of some gr-values (only in strict mode.)
		if ($mode==GR4PHP_Configuration::Mode_STRICT){
			GR4PHP_Exception::correctLengthOfValueInSrictMode($inputArray);
		}

		// No error! The query building begins
		// get Ontologies for getBusinessEntity
		$ontologies=GR4PHP_Template::getPrefixByFunction("getCompany");
		
		//add Ontologies to query
		if(!empty($ontologies)){
		foreach($ontologies as $ontologie => $prefix){
			$sparql.=$prefix;
		}
		}
		
		// get SELECT-part of getBusinessEntity
		$selectPartspec=GR4PHP_Template::getSelectPartsByFunction("getCompany");
		
		// get SELECT-part (here:general-part)
		$selectPartDefault=GR4PHP_Template::getSelectPartsByFunction("general");
		$selctPartComplete=array_merge($selectPartDefault,$selectPartspec);
		
		$sparql.= "SELECT DISTINCT ".getArray2String($selctPartComplete)." WHERE { ";
		
		$deleteOptionalInput=array();
 		
		// set WHERE-part of query
		//cut the length of certain elements (here: gln)
		$inputArray=isLengthOfElementRight($inputArray);
		foreach ($inputArray as $column => $value){
			$sparql.=GR4PHP_Template::getInputValues($mode,$column,$value);
			if ($mode==GR4PHP_Configuration::Mode_LAX){
					$deleteOptionalInput[]=$column;
				}
		}
		
		$sparql.=" ?x a gr:BusinessEntity. ";

		
		//Optional-Values
		$outputValues=GR4PHP_Template::getOutputValuesByFunction("getCompany");
		
		foreach($outputValues as $aloneOutput => $output){

		if (!in_array($aloneOutput , $deleteOptionalInput)){
			if ($aloneOutput=="openTime"){
			$sparql.=GR4PHP_Template::getSpecialOutputValues($aloneOutput);}
			$sparql.=$output;
			}
		}
		
		//set LIMIT of query
		$sparql.="} LIMIT ";
		
		if ($limit==0){
			$limit=GR4PHP_Configuration::Limit;	
		}
		$sparql.=$limit;
		
		return self::connectGR4PHP($sparql,"getCompany");
	}
	
	/**
	 *
	 * Return SPARQL Query for gr:getProductModelInfo
	 * @param Input Array with search elements
	 * @param Mode (strict || lax)
	 * @param Result-Limit (Default: 0 --> see configuration.php)
	 * @return SPARQL Query
	 */
	function getProductModel($inputArray,$mode=GR4PHP_Configuration::Mode_LAX, $limit=0 ){
		// At first check all possible errors
		// 1) not empty input array?
		GR4PHP_Exception::isNotEmptyInputArray($inputArray); 
		
		// 2) all input elments are allowed?
		GR4PHP_Exception::isPossibleInputElementOfFunction($inputArray,"getProductModel");
		
		// 3) Control amount of elements and values (equal)
		GR4PHP_Exception::isEqualElementAndValueAmount($inputArray);
		
		// 4) Control format of input values
		GR4PHP_Exception::isCorrectValueForInputElement($inputArray);
		
		// 5) Control length of values in input Array 
		GR4PHP_Exception::isCorrectLengthOfValueCausedByWildcardRule($inputArray);
		
		// 6) Correct length of some gr-values (only in strict mode.)
		if ($mode==GR4PHP_Configuration::Mode_STRICT){
			GR4PHP_Exception::correctLengthOfValueInSrictMode($inputArray);
		}
		
		// No error! The query building begins
		// get Ontologies for getProductModelInfo
		$ontologies=GR4PHP_Template::getPrefixByFunction("getProductModel");
		
		//add Ontologies to query
		if(!empty($ontologies)){
		foreach($ontologies as $ontologie => $prefix){
			$sparql.=$prefix." ";
		}
		}
		
		// get SELECT-part of getProductModelInfo
		$selectPartspec=GR4PHP_Template::getSelectPartsByFunction("getProductModel");
		
		// get SELECT-part (here:general-part)
		$selectPartDefault=GR4PHP_Template::getSelectPartsByFunction("general");
		$selectPartComplete=array_merge($selectPartDefault,$selectPartspec);
		
		$sparql.= "SELECT DISTINCT ".getArray2String($selectPartComplete)." WHERE { ";
		
		$deleteOptionalInput=array(); 

		// set WHERE-part of query
		//cut the length of certain elements (here: gln)
		$inputArray=isLengthOfElementRight($inputArray);
		foreach ($inputArray as $column => $value){
			$sparql.=GR4PHP_Template::getInputValues($mode,$column,$value);
			if ($mode==GR4PHP_Configuration::Mode_LAX){
					$deleteOptionalInput[]=$column;
				}
		}
		
		$sparql.=" ?x a gr:ProductOrServiceModel. ";

		//Optional-Values
		$outputValues=GR4PHP_Template::getOutputValuesByFunction("getProductModel");
		
		foreach($outputValues as $aloneOutput => $output){

		if (!in_array($aloneOutput , $deleteOptionalInput)){
			if ($aloneOutput=="openTime"){
			$sparql.=GR4PHP_Template::getSpecialOutputValues($aloneOutput);}
			$sparql.=$output;
			}
		}
		
		//set LIMIT of query
		$sparql.="} LIMIT ";
		
		if ($limit==0){
			$limit=GR4PHP_Configuration::Limit;	
		}
		$sparql.=$limit;

		return self::connectGR4PHP($sparql,"getProductModel");
	}
	
	/**
	 *
	 * Return SPARQL Query for gr:getOffers
	 * @param Input Array with search elements
	 * @param Mode (strict || lax)
	 * @param Result-Limit (Default: 0 --> see configuration.php)
	 * @return SPARQL Query
	 */
	function getOffers($inputArray,$mode=GR4PHP_Configuration::Mode_LAX, $limit=0 ){
		// At first check all possible errors
		// 1) not empty input array?
		GR4PHP_Exception::isNotEmptyInputArray($inputArray); 
		
		// 2) all input elments are allowed?
		GR4PHP_Exception::isPossibleInputElementOfFunction($inputArray,"getOffers");
		
		// 3) Control amount of elements and values (equal)
		GR4PHP_Exception::isEqualElementAndValueAmount($inputArray);
		
		// 4) Control format of input values
		GR4PHP_Exception::isCorrectValueForInputElement($inputArray);
		
		// 5) Control length of values in input Array 
		GR4PHP_Exception::isCorrectLengthOfValueCausedByWildcardRule($inputArray);
		
		// 6) Correct length of some gr-values (only in strict mode.)
		if ($mode==GR4PHP_Configuration::Mode_STRICT){
			GR4PHP_Exception::correctLengthOfValueInSrictMode($inputArray);
		}
		
		// No error! The query building begins
		// get Ontologies for getOffers
		$ontologies=GR4PHP_Template::getPrefixByFunction("getOffers");
		
		//add Ontologies to query
		if(!empty($ontologies)){
		foreach($ontologies as $ontologie => $prefix){
			$sparql.=$prefix." ";
		}
		}
		
		// get SELECT-part of getOffers
		$selectPartspec=GR4PHP_Template::getSelectPartsByFunction("getOffers");
		
		// get SELECT-part (here:general-part)
		$selectPartDefault=GR4PHP_Template::getSelectPartsByFunction("general");
		$selectPartComplete=array_merge($selectPartDefault,$selectPartspec);
		
		$sparql.= "SELECT DISTINCT ".getArray2String($selectPartComplete)." WHERE { ";
		
		$deleteOptionalInput=array();

		// set WHERE-part of query
		//cut the length of certain elements (here: gln)
		$inputArray=isLengthOfElementRight($inputArray);
		foreach ($inputArray as $column => $value){
			$sparql.=GR4PHP_Template::getInputValues($mode,$column,$value);
			if ($mode==GR4PHP_Configuration::Mode_LAX){
					$deleteOptionalInput[]=$column;
				}
		}
		$sparql.=" ?offering a gr:Offering. ";
		
		//Optional-Values
		$outputValues=GR4PHP_Template::getOutputValuesByFunction("getOffers");
		
		foreach($outputValues as $aloneOutput => $output){
		
		if (!in_array($aloneOutput , $deleteOptionalInput)){
			if ($aloneOutput=="openTime"){
			$sparql.=GR4PHP_Template::getSpecialOutputValues($aloneOutput);}
			$sparql.=$output;
			}
		}
		
		//set LIMIT of query
		$sparql.="} LIMIT ";
		
		if ($limit==0){
			$limit=GR4PHP_Configuration::Limit;	
		}
		$sparql.=$limit;

		return self::connectGR4PHP($sparql,"getOffers");
	}
	
	/**
	 *
	 * Return SPARQL Query for all opening hours of the store
	 * @param Input Array with search elements
	 * @param Mode (strict || lax)
	 * @param Result-Limit (Default: 0 --> see configuration.php)
	 * @return SPARQL Query
	 */
	function getOpeningHours($inputArray,$mode=GR4PHP_Configuration::Mode_LAX, $limit=0 ){

		// At first check all possible errors
		// 1) not empty input array?
		GR4PHP_Exception::isNotEmptyInputArray($inputArray); 
		
		// 2) all input elments are allowed?
		GR4PHP_Exception::isPossibleInputElementOfFunction($inputArray,"getOpeningHours");
		
		// 3) Control amount of elements and values (equal)
		GR4PHP_Exception::isEqualElementAndValueAmount($inputArray);
		
		// 4) Control format of input values
		GR4PHP_Exception::isCorrectValueForInputElement($inputArray);
		
		// 5) Control length of values in input Array 
		GR4PHP_Exception::isCorrectLengthOfValueCausedByWildcardRule($inputArray);
		
		// 6) Correct length of some gr-values (only in strict mode.)
		if ($mode==GR4PHP_Configuration::Mode_STRICT){
			GR4PHP_Exception::correctLengthOfValueInSrictMode($inputArray);
		}
		
		// No error! The query building begins
		$dayArray=array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
		
		// get SELECT-part of getOffers
		$selectPartspec=GR4PHP_Template::getSelectPartsByFunction("getOpeningHours");
		
		// get SELECT-part (here:general-part)
		$selectPartDefault=GR4PHP_Template::getSelectPartsByFunction("general");
		$selectPartComplete=array_merge($selectPartDefault,$selectPartspec);
		
		$sparql.= "SELECT DISTINCT ".getArray2String($selectPartComplete)." WHERE { ";
			
		$deleteOptionalInput=array();
		// set WHERE-part of query
		//cut the length of certain elements (here: gln)
		$inputArray=isLengthOfElementRight($inputArray);
		foreach ($inputArray as $column => $value){
			$sparql.=GR4PHP_Template::getInputValues($mode,$column,$value);
			if ($mode==GR4PHP_Configuration::Mode_LAX){
					$deleteOptionalInput[]=$column;
				}

		}
			
		$sparql.= "?x a gr:LocationOfSalesOrServiceProvisioning. ?x gr:hasOpeningHoursSpecification ?spec. ";

		//Optional-Values
		$outputValues=GR4PHP_Template::getOutputValuesByFunction("getOpeningHours");
		
		foreach($outputValues as $aloneOutput => $output){
		
		if (!in_array($aloneOutput , $deleteOptionalInput)){
			if ($aloneOutput=="openTime"){
			$sparql.=GR4PHP_Template::getSpecialOutputValues($aloneOutput);}
			$sparql.=$output;
			}
		}
		
		//set LIMIT of query
		$sparql.="} LIMIT ";
		
		if ($limit==0){
			$limit=GR4PHP_Configuration::Limit;	
		}
		$sparql.=$limit;

		return self::connectGR4PHP($sparql,"getOpeningHours");	
	}
	
/**
	 *
	 * Return SPARQL Query for all stores close to the given distance
	 * @param Input Array that contains gln, long, lat and distance
	 * @param Mode (strict || lax)
	 * @param Result-Limit (Default: 0 --> see configuration.php)
	 * @return SPARQL Query
	 */
	function getLocation($inputArray,$mode=GR4PHP_Configuration::Mode_LAX, $limit=0 ){
		// At first check all possible errors
		// 1) not empty input array?
		GR4PHP_Exception::isNotEmptyInputArray($inputArray); 
		
		// 2) all input elments are allowed?
		GR4PHP_Exception::isPossibleInputElementOfFunction($inputArray,"getLocation");
		
		// 3) Control amount of elements and values (equal)
		GR4PHP_Exception::isEqualElementAndValueAmount($inputArray);
		
		// 4) Control format of input values
		GR4PHP_Exception::isCorrectValueForInputElement($inputArray);
		
		//5 ) Control length of values in input Array 
		GR4PHP_Exception::isCorrectLengthOfValueCausedByWildcardRule($inputArray);
		
		// 6) Correct length of some gr-values (only in strict mode.)
		if ($mode==GR4PHP_Configuration::Mode_STRICT){
			GR4PHP_Exception::correctLengthOfValueInSrictMode($inputArray);
		}
		
		// No error! The query building begins; 
		if (empty($inputArray['geo']['distance'])){
			$inputArray['geo']['distance']=100;
		}
		if (empty($inputArray['geo']['lat'])){
			$inputArray['geo']['lat']=0;
		}
		if (empty($inputArray['geo']['long'])){
			$inputArray['geo']['long']=70;
		}
		
		// get SELECT-part of getOffers
		$selectPartspec=GR4PHP_Template::getSelectPartsByFunction("getLocation");
		$selectPartspec2=GR4PHP_Template::getSpecialSelectPartsByFunction($inputArray);
		// get SELECT-part (here:general-part)
		$selectPartDefault=GR4PHP_Template::getSelectPartsByFunction("general");
		$selectPartComplete=array_merge($selectPartDefault,$selectPartspec,$selectPartspec2);
		
		$sparql.= "SELECT DISTINCT ".getArray2String($selectPartComplete)." WHERE { ";
		
		$deleteOptionalInput=array();

		// set WHERE-part of query
		//cut the length of certain elements (here: gln)
		$inputArray=isLengthOfElementRight($inputArray);

		foreach ($inputArray as $column => $value){
			$sparql.=GR4PHP_Template::getInputValues($mode,$column,$value);
			if ($mode==GR4PHP_Configuration::Mode_LAX){
					$deleteOptionalInput[]=$column;
				}
		}
		//TO-DO
		$sparql.= " ?x a gr:LocationOfSalesOrServiceProvisioning.";
		
	//Optional-Values
		$outputValues=GR4PHP_Template::getOutputValuesByFunction("getLocation");
		
		foreach($outputValues as $aloneOutput => $output){
		
		if (!in_array($aloneOutput , $deleteOptionalInput)){
			if ($aloneOutput=="openTime"){
			$sparql.=GR4PHP_Template::getSpecialOutputValues($aloneOutput);}
			$sparql.=$output;
			}
		}
		
		//set LIMIT of query
		$sparql.="} LIMIT ";
		
		if ($limit==0){
			$limit=GR4PHP_Configuration::Limit;	
		}
		$sparql.=$limit;

		return self::connectGR4PHP($sparql,"getLocation");
	}
	
	/**
	 *
	 * Return result array of query
	 * @param SPARQL Query
	 * @param Function
	 * @return result array
	 */
	function connectGR4PHP($query,$function){
		
		$url = self::buildURL($query, "json");
		$result = self::httpGet($url);
		$resultArray = self::getResultArray($result, $function);
		echo htmlentities($query)."<br />";
		echo $url."<br />";
		return $resultArray;
	}
	
	/**
	 *
	 * Return URL with SPARQL Query (converted for HTTP GET)
	 * @param SPARQL Query
	 * @param result format(here: json)
	 * @return URL
	 */
	function buildURL($query, $result_format){
    	$url = $this->endpoint."?default-graph-uri=&should-sponge=&query=".str_replace("%26", "&", str_replace("%29", ")", str_replace("%28", "(", str_replace("%7D", "}",str_replace("%7B", "{", str_replace("%3B", ";", str_replace("%26amp%3B", "&", urlencode($query))))))));; // \" to "
    	$url = $url."&format=".$result_format;
    	$url = $url."&timeout=".$this->timeout;
    	return $url;
	}
	
	/**
	 *
	 * Response of HTTP GET
	 * @param URL
	 * @return HTTP GET Response 
	 */
	function httpGet($url)
	{
    	if (ini_get('allow_url_fopen') == '1') {
    		
    		$result=@file_get_contents($url);
				if (false==$result)
				{
   					echo "<br /><b>Error: Time Out</b><br />";
				} else {
					return file_get_contents($url);
				} 
     	}
     	else {
     		echo "else-teil <br>";
        	$url = parse_url($url);
           	$port = isset($url['port']) ? $url['port'] : 80;
           	$fp = fsockopen($url['host'], $port);
           	if(!$fp) {
               echo "Cannot retrieve $url";
           }
           else {
               // send the necessary headers to get the file
               fwrite($fp, "GET ".$url['path']."?".$url['query']."HTTP/1.0\r\n".
                    "Host:". $url['host']."\r\n".
                    "Accept: application/sparql-results+xml,application/rdf+xml\r\n".
                    "Connection: close\r\n\r\n");

               // retrieve response from server
               $buffer = "";
               while($line = fread($fp, 4096))
               {
                    $buffer .= $line;
               }
               fclose($fp);
                 
               $pos = strpos($buffer,"\r\n\r\n");
               return substr($buffer,$pos);
          }
    	}
	}
	
	/**
	 *
	 * Return Result query as Array
	 * @param HTTP GET Result
	 * @param GR function
	 * @return Result array
	 */
	function getResultArray($httpResult, $sparqlQueryFunction){
		$httpResultArray = json_decode($httpResult, true);
		$ra = (array) $httpResultArray["results"]["bindings"];
		
		$selectPartspec=GR4PHP_Template::getSelectPartsByFunction($sparqlQueryFunction);
		$selectPartDefault=GR4PHP_Template::getSelectPartsByFunction("general");
		$selctPartComplete=array_merge($selectPartDefault,$selectPartspec);
		
		$elemArray = array();
		$resultArray = array();
		foreach($ra as $elem) {
			foreach($selctPartComplete as $spc){
				$ergItem = $elem[str_replace("?", "", $spc)]["value"];
				$elemArray[str_replace("?", "", $spc)] = $ergItem;
			}	
		$resultArray[] = $elemArray;
		}
		return $resultArray;

	}
}