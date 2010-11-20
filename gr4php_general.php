<?php
/**
 * --- GEFSA (GoodRelations Extractor For SPARQL API) ---
 * This class contains all general functions of GEFSA 
 * 
 */
include_once 'gr4php_template.php';
include_once 'gr4php_configuration.php';

/**
 *
 * Convert a String in Array by split the String
 * @param String, that want to be convert
 * @param Char, that shows the cut-off point (Default: ",")
 * @return Array
 */
function getString2Array($string,$zeichen=","){
	
	$arrayOfStrings=explode($zeichen, $string);
	
	return $arrayOfStrings; 
}

/**
 *
 * Convert Array in String
 * @param Array
 * @return String
 */
function getArray2String($array){
	
		foreach ($array as $content){
    		$str.=$content.",";
		}
		
	$string=substr ( $str, 0, - 1 );
	
	return $string; 
}

/**
 *
 * Return a specific time-format by using the assign value
 * @param value (day or time)
 * @return time format
 */
function getDateByValue($value){
	$date=array("day"=>"l","time"=>"H:i");
	return date($date[$value]);
}

/**
 *
 * Check the length of certain input elements 
 * @param Input Array with search elements
 * @return Input Aray with elements of right length
 */
 function isLengthOfElementRight($inputArray){
		$elementLength=GR4PHP_Template::checkLengthOfElements();
		$resultArray=$inputArray;
			foreach ($inputArray as $element=>$value) {
					if (array_key_exists($element, $elementLength)){
						if (strlen($value)>$elementLength[$element]){
							$resultArray[$element]=substr($value,0,$elementLength[$element]);
						}
						}
			}
		return $resultArray;
	}

/**
 *
 * An array of elements, which should be shown 
 * @param Array with wanted elements
 * @param Array of all possible elements which are given by function
 * @return Array of all wanted elements
 */
function getWantedElements($wantedElements,$possibleElements){
	$resultArray=array();
	foreach ($wantedElements as $ownElement){
		if (in_array("?".$ownElement,$possibleElements)){
			$resultArray[]="?".$ownElement;
		}
	}
	
	return $resultArray;
}
	
	