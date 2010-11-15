<?php
/**
 * --- GEFSA (GoodRelations Extractor For SPARQL API) ---
 * This class has all error messages.
 * 
 */

include_once 'gr4php_template.php';
include_once 'gr4php_configuration.php';


class GR4PHP_Exception extends Exception{
	
	/**
	 *
	 * Is input array empty? 
	 * @param Input Array with search elements
	 * @return ErrorException
	 */
	public static function isNotEmptyInputArray($inputArray){
		try {
			foreach ($inputArray as $element) {
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
	 * @param Input Array with search elements
	 * @param currently function 
	 * @return ErrorException
	 */
	public static function isPossibleInputElementOfFunction($inputArray,$function){
		$possibleElements=GR4PHP_Template::possibleInputValuesByFunction($function);
		try {
			foreach ($inputArray as $element=>$value) {
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
	 * @param Input Array with search elements
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
	 * @param Input Array with search elements
	 * @return ErrorException
	 */
	public static function isCorrectValueForInputElement($inputArray){
			try {
				foreach ($inputArray as $element=>$value) {
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
	 * @param Input Array with search elements
	 * @return ErrorException
	 */
	public static function isCorrectLengthOfValueCausedByWildcardRule($inputArray){
				try {
					$lesserThanFour=array("geo","maxPrice","currency");
					foreach ($inputArray as $element=>$value) {
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
	 * @param Input Array with search elements
	 * @return ErrorException
	 */
	public static function correctLengthOfValueInSrictMode($inputArray){
				$values=GR4PHP_Template::checkLengthOfElements();
				try {
					$lesserThanFour=array("geo","maxPrice","currency");
					foreach ($inputArray as $element=>$value) {
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
}