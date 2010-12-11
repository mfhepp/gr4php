<!-- Define HTML-Header -->
<html xmlns="http://www.w3.org/1999/xhtml" > 
<head> 
<title>GR4PHP Test-GUI</title>
</head> 
<body>
<?php
/**
 * --- GR4PHP (GoodRelations FOR PHP) ---
 * A GUI to test GR4PHP API. 
 * 
 * @author	Martin Anding, Stefan Dietrich (University of German Armed Forces Munich)
 * 			API is a result of a study project in "GoodRelations" in the year of 2010.
 * 			This work is based on the GoodRelations ontology, developed by Martin Hepp.
 * @link    http://purl.org/goodrelations/
 * @license GNU LESSER GENERAL PUBLIC LICENSE
 * @version 1.0
 */
include_once '../gr4php.php';
include_once '../gr4php_configuration.php';
include_once '../gr4php_general.php';
include_once '../gr4php_template.php';

set_time_limit(60);
?>
<form method="post" action="gr4php_test_tool.php?endpoint=<?php echo $_POST["endpoint"]?>&amp;mode=<?php echo $_POST["mode"];?>&amp;function=<?php echo $_POST["function"];?>&amp;array1=<?php echo $_POST["array1"];?>&amp;array2=<?php echo $_POST["array2"];?>&amp;array3=<?php echo trim($_POST["array3"]);?>">
<?php 
if (empty($_GET["array1"])){$default1="title";} else {$default1=trim($_POST["array1"]);}
if (empty($_GET["array2"])){ $default2="Team EWS Ingenieure";} else {$default2=$_POST["array2"];}
if (empty($_GET["array3"])){ $default3="x,title";} else {$default3=trim($_POST["array3"]);}
if (empty($_GET["limit"]) || !is_int($_GET["limit"])){ $limit="20";} else {$limit=$_POST["limit"];}
if (empty($_GET["mode"])){ $mode=GR4PHP_Configuration::Mode_LAX;} else {$mode=$_POST["mode"];}
if (empty($_POST["array3"])){$wantedElements=NULL;} else{$wantedElements=getString2Array(trim(stripslashes($_POST["array3"])));}
$endpoint=$_POST["endpoint"];
if (empty($endpoint)){$endpoint=GR4PHP_Configuration::Endpoint_URIBURNER;}
$function=$_POST["function"];
if (empty($function)){$function="getStore";}

$arrayfunktion=array("getStore","getCompany","getProductModel","getOffers","getOpeningHours","getLocation");
$arrayEndpoint=array(GR4PHP_Configuration::Endpoint_URIBURNER,GR4PHP_Configuration::Endpoint_LDURIBURNER,GR4PHP_Configuration::Endpoint_LOC,GR4PHP_Configuration::Endpoint_LOD);
$arrayMode=array(GR4PHP_Configuration::Mode_LAX,GR4PHP_Configuration::Mode_STRICT);

//First DropDown -Enpoint-
echo "Select an endpoint:&nbsp;";
echo '<select style="width:169px;" name="endpoint">'."\n";
$str="";
foreach($arrayEndpoint as $part){
$str.='<option value="'.$part.'" ';
if ($part==$endpoint){
	$str.='selected';
}
$str.='>'.$part.'</option>'."\n";
 }
$str.="</select>"."\n";
echo $str;
echo "<br /><br />";

//Second DropDown -Function-
echo "Select a function:&nbsp;";
echo '<select style="width:169px;" name="function">'."\n";
$str="";
foreach($arrayfunktion as $part){
$str.='<option value="'.$part.'" ';
if ($part==$function){
	$str.='selected';
}
$str.='>'.$part.'</option>'."\n";
 }
$str.="</select>"."\n";
echo $str;
echo "<br /><br />";

//Third DropDown -Mode-
echo "Select Mode:&nbsp;";
echo '<select style="width:169px;" name="mode">'."\n";
$str="";
foreach($arrayMode as $part){
$str.='<option value="'.$part.'" ';
if ($part==$mode){
	$str.='selected';
}
$str.='>'.$part.'</option>'."\n";
 }
$str.="</select>"."\n";
echo $str;
echo "<br /><br />";
?>
Keys of array:&nbsp;
<input  name="array1" size="50" type="text" value="<?php echo $default1;?>"/>
Values of array:&nbsp;
<input  name="array2" size="50" type="text" value="<?php echo $default2;?>"/>
<br />
<i>Possible keys:&nbsp; <?php echo getArray2String(GR4PHP_Template::possibleInputValuesByFunction($function));?></i>
<br />
<br />
Which elements would you like to see?:&nbsp;
<input  name="array3" size="50" type="text" value="<?php echo $default3;?>"/>
<br />
<i>Possible SELECT-elements are:&nbsp; <?php echo str_replace("?","",getArray2String(array_merge((array)GR4PHP_Template::getSelectPartsByFunction("general"),(array)GR4PHP_Template::getSelectPartsByFunction($function))));?></i>
<br />
<br />
Result limit:&nbsp;
<input  name="limit" size="5" type="text" value="<?php echo $limit;?>"/>
<input type="submit" id="S10" name="functionChance" value="Start"/>
<br />


<hr></hr>
<?php 
if (isset($_GET["array1"]) && isset($_GET["array2"])&& isset($_GET["array3"])){

if (isset($_POST["functionChance"])){
	if (count(getString2Array(stripslashes($_POST["array1"])))!= count(getString2Array(stripslashes($_POST["array2"])))){
		echo "Amount of elements and values have to be equal!";
		exit;
	}
	$inputArray=array_combine(getString2Array(stripslashes($_POST["array1"])),getString2Array(stripslashes($_POST["array2"])));
?>
<b>Selected Endpoint: </b><i><?php echo $endpoint;?></i>
<br /><br />
<b>Selected Function: </b><i><?php echo $function;?></i>
<br /><br />
<b>Selected Array:&nbsp; </b><i><?php print_r($inputArray)?></i>
<br /><br />
<b>Selected Elements:&nbsp; </b><i><?php print_r($wantedElements)?></i>
<br /><br />
<?php 
}


$resultArray=(array)getFunction($endpoint,$function,$inputArray,$wantedElements,$mode,$limit);

echo "<center><b>---- Query ----- </b></center> <br />"."\n";

echo $resultArray[1];

echo "<br /><br />"."\n";

echo "<center><b>---- Result ----- </b></center> <br />"."\n";

$selectPartspec=(array)GR4PHP_Template::getSelectPartsByFunction($_POST["function"]);
$selectPartDefault=(array)GR4PHP_Template::getSelectPartsByFunction("general");
$selectPartComplete=array_merge($selectPartDefault,$selectPartspec);


echo "<center><table border='1'>"."\n";
echo "<tr>"."\n";
if ($wantedElements!=NULL){
	
$selectPartComplete=getWantedElements($wantedElements,$selectPartComplete);
}
foreach($selectPartComplete as $spc){
				echo "<th>". str_replace("?", "", $spc)."</th>"."\n";
			}	
echo "</tr>"."\n";
foreach((array)$resultArray[0] as $ar){
	echo "<tr>"."\n";
	foreach($ar as $item){
		echo "<td>". $item . "</td> "."\n";
	}
	echo "</tr>"."\n";
}
echo "</table></center>"."\n";

}
?>
</form>
</body>
</html>
<?php 

// function to find the wright gr-function 
function getFunction($endpoint,$function,$inputArray,$wantedElements=NULL,$mode=NULL,$limit=20){
	$gr4php=new GR4PHP($endpoint);
	switch ($function){
		case "getStore":
	           $result=$gr4php->getStore($inputArray,$wantedElements,$mode,$limit);
	           $query=$gr4php->getSparqlQuery();
               break;
        case "getCompany":
	           $result=$gr4php->getCompany($inputArray,$wantedElements,$mode,$limit);
	           $query=$gr4php->getSparqlQuery();
               break;
        case "getProductModel":
	           $result=$gr4php->getProductModel($inputArray,$wantedElements,$mode,$limit);
	           $query=$gr4php->getSparqlQuery();
               break;
        case "getOffers":
	           $result=$gr4php->getOffers($inputArray,$wantedElements,$mode,$limit);
	           $query=$gr4php->getSparqlQuery();
               break;
        case "getOpeningHours":
	           $result=$gr4php->getOpeningHours($inputArray,$wantedElements,$mode,$limit);
	           $query=$gr4php->getSparqlQuery();
               break;
        case "getLocation":
	           $result=$gr4php->getLocation($inputArray,$wantedElements,$mode,$limit);
	           $query=$gr4php->getSparqlQuery();
               break;
	}
	
	return array($result,$query); 
	
}

 
