<?php
/**
 * --- GR4PHP (GoodRelations FOR PHP) ---
 * This class has all error messages.
 * 
 * @author	Martin Anding, Stefan Dietrich, Alex Stolz (University of German Armed Forces Munich)
 * 			API is a result of a study project in "GoodRelations" in the year of 2010.
 * 			This work is based on the GoodRelations ontology, developed by Martin Hepp.
 * @link    http://purl.org/goodrelations/
 * @license GNU LESSER GENERAL PUBLIC LICENSE
 * @version 1.0
 */

include_once 'gr4php_template.php';
include_once 'gr4php_configuration.php';


class GR4PHP_Exception extends Exception{
	
	/**
	 *
	 * Is input array empty? 
	 * @param 		array		$inputArray Input Array with search elements
	 * @return ErrorException
	 */
	public static function isNotEmptyInputArray($inputArray){
		try {
			foreach ((array)$inputArray as $element) {
					if (empty($element) && $element!="0"){
						throw new GR4PHP_Exception("Please use at least one input value!");}
			}
		} catch (GR4PHP_Exception $e) {
			echo "<b>Error: ".$e->getMessage()."<b>";
  			exit;
		}
	}
	
	/**
	 *
	 * Check the allowed using of input elements in a function  
	 * @param 		array		$inputArray	Input Array with search elements
	 * @param 		string		$function Currently function 
	 * @return ErrorException
	 */
	public static function isPossibleInputElementOfFunction($inputArray,$function){
		$possibleElements=GR4PHP_Template::possibleInputValuesByFunction($function);
		try {
			foreach ((array)$inputArray as $element=>$value) {
					if (!in_array($element, $possibleElements)){
						throw new GR4PHP_Exception("The element -".$element."- is not allowed in function: ".$function.". Please check the manual!");}
			}
		} catch (GR4PHP_Exception $e) {
			echo "<b>Error: ".$e->getMessage()."<b>";
  			exit;
		}
	}
	
	/**
	 *
	 * Check the amount of elements and associated values  
	 * @param 		array		$inputArray Input Array with search elements
	 * @return ErrorException
	 */
	public static function isEqualElementAndValueAmount($inputArray){
		$amountOfElements= count(array_keys($inputArray));
		$amountOfValues= count(array_values($inputArray));
		try {
					if ($amountOfElements!=$amountOfValues){
						throw new GR4PHP_Exception("There are ".$amountOfElements." but only ".$amountOfValues." values: The amount of elements and values have to be equal!");}
			
		} catch (GR4PHP_Exception $e) {
			echo "<b>Error: ".$e->getMessage()."<b>";
  			exit;
		}
	}
	
	/**
	 *
	 * Check the value format of every element in array
	 * @param 		array		$inputArray Input Array with search elements
	 * @return ErrorException
	 */
	public static function isCorrectValueForInputElement($inputArray){
			try {
				foreach ((array)$inputArray as $element=>$value) {
				$format=GR4PHP_Template::checkFormatOfInputValue($element);
				switch ($format) {
    				case "integer":
       	 				if (!is_numeric($value)){
       	 					throw new GR4PHP_Exception("Please check the format of the input value of the element <i>".$element."</i>. It must be <b>".$format."</b>");
       	 				}
        				break;
    				case "string":
       	 				if (!is_string($value)){
       	 					throw new GR4PHP_Exception("Please check the format of the input value of the element <i>".$element."</i>. It must be <b>".$format."</b>");
       	 				}
        				break;
        			case NULL:
        				break;
				}
				}
			}
			catch (GR4PHP_Exception $e) {
				echo "<b>Error: ".$e->getMessage()."<b>";
  				exit;
			}
		
	}
	
	/**
	 *
	 * Check length of all input values in lax-Mode, because bif:contains and Wildcard have a problem by value length less than 4
	 * @param 		array		$inputArray Input Array with search elements
	 * @return ErrorException
	 */
	public static function isCorrectLengthOfValueCausedByWildcardRule($inputArray){
				try {
					$lesserThanFour=array("geo","maxPrice","currency");
					foreach ((array)$inputArray as $element=>$value) {
					if (!in_array($element,$lesserThanFour)){	
						if (strlen((string)$value)<4){
							throw new GR4PHP_Exception("Check the input value! Some values have a length lesser than 4. It doesn't work!");}
						}
					}
				} catch (GR4PHP_Exception $e) {
					echo "<b>Error: ".$e->getMessage()."<b>";
  					exit;
				}
		
	}
	
	/**
	 *
	 * Check length of some input values only in strict mode
	 * @param 		array		$inputArray Input Array with search elements
	 * @return ErrorException
	 */
	public static function correctLengthOfValueInSrictMode($inputArray){
				$values=GR4PHP_Template::checkLengthOfElements();
				try {
					$lesserThanFour=array("geo","maxPrice","currency");
					foreach ((array)$inputArray as $element=>$value) {
					if (array_key_exists($element,$values)){	
						if (strlen((string)$value)!=$values[$element]){
							throw new GR4PHP_Exception("Check the length of the input element <i>".$element."</i>. In strict mode the value of the element has to have a length of <i>".$values[$element]."</i>. See also the gr-manual!");}
						}
					}
				} catch (GR4PHP_Exception $e) {
					echo "<b>Error: ".$e->getMessage()."<b>";
  					exit;
				}
		
	}
	
	/**
	 *
	 * Check the allowed using of SELECT elements in a function  
	 * @param 		array		$selectArray SELECT Array with search elements
	 * @param 		string		$function Currently function 
	 * @return ErrorException
	 */
	public static function isPossibleSelectElementOfFunction($selectArray,$function){
		$elements=GR4PHP_Template::getSelectPartsByFunction($function);
		// get SELECT-part (here:general-part)
		$selectPartDefault=GR4PHP_Template::getSelectPartsByFunction("general");
		$possibleElements=array_merge($selectPartDefault,$elements);
		try {
			foreach ((array)$selectArray as $element) {
					if (!in_array("?".$element, $possibleElements)){
						throw new GR4PHP_Exception("The SELECT-element -".$element."- is not allowed in function: ".$function.". Please check the manual!");}
			}
		} catch (GR4PHP_Exception $e) {
			echo "<b>Error: ".$e->getMessage()."<b>";
  			exit;
		}
	}
	
	/**
 	 *
	 * Check the mode
     * @param 		string		$mode Mode
     * @return 		string		$mode Allowed Mode
 	 */
	public static function checkMode($mode){
		$mode_array=array(Configuration::MODE_LAX,Configuration::MODE_STRICT);
	
		if (in_array($mode,$mode_array)) {
			return $mode;
		}
	
		return Configuration::MODE_LAX;
	}

	/**
 	 *
 	 * Check the limit
 	 * @param 		integer		$limit Limit
 	 * @return 		integer		$limit Allowed Limit
 	 */
	public static function checkLimit($limit){
	
		if (is_int($limit)) {
			return $limit;
		}
		return Configuration::LIMIT;
	}
}