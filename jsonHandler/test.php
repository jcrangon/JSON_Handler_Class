<?php
session_start();
// Afficher les erreurs à l'écran
ini_set('display_errors', 'On');
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', "On");
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__FILE__).'/log.txt');
// Afficher les erreurs et les avertissements
error_reporting(E_ALL);
	
require("./jsonHandler.php");

$json=new jsonHandler;

$var="sunny afternoon";

$car=array(
	"Make"=>"BMW",
	"Model"=>"4.18",
	"Year"=>"2015"
	);

$car_catalog=array(
		array(
		"Make"=>"BMW",
		"Model"=>"4.18",
		"Year"=>"2015"
		),
		array(
		"Make"=>"Renault",
		"Model"=>"Meagn",
		"Year"=>"2005"
		),
		array(
		"Make"=>"VW",
		"Model"=>"Passat",
		"Year"=>"2017"
		),
		array(
		"Make"=>"Citroen",
		"Model"=>"DS",
		"Year"=>"1975"
		)
	);

// Method encodeFromVar($key,$value)
$result=$json::encodeFromVar("weather",$var);
echo "<PRE>".print_r($result,true)."</PRE><br/>";
/* 
Output :

	{"weather":"sunny afternoon"}
*/


// Method encodeFromTab($tab)
$result=$json::encodeFromTab($car);
echo "<PRE>".print_r($result,true)."</PRE><br/>";
/* 
Output :

	{"Make":"BMW","Model":"4.18","Year":"2015"}
*/


// Method encodeFromTab2D($tab)
$result=$json::encodeFromTab2D($car_catalog);
echo "<PRE>".print_r($result,true)."</PRE><br/>";
/* 
Output :

	{"Make":"BMW","Model":"4.18","Year":"2015"},
	{"Make":"Renault","Model":"Meagn","Year":"2005"},
	{"Make":"VW","Model":"Passat","Year":"2017"},
	{"Make":"Citroen","Model":"DS","Year":"1975"}
*/


// Method mkRecordFromVar($key,$value,$recordname)
$result=$json::mkRecordFromVar("Weather",$var,"Forecast");
echo "<PRE>".print_r($result,true)."</PRE><br/>";
/* 
Output :

	{"Forecast":[{"Weather":"sunny afternoon"}]}
*/


// Method mkRecordFromTab($tab,$recordname)
$result=$json::mkRecordFromTab($car,"Car Specs");
echo "<PRE>".print_r($result,true)."</PRE><br/>";
/* 
Output :

	{"Car Specs":[{"Make":"BMW","Model":"4.18","Year":"2015"}]}
*/


// Method mkRecordFromTab2D($tab,$recordname)
$result=$json::mkRecordFromTab2D($car_catalog,"Car Catalog");
echo "<PRE>".print_r($result,true)."</PRE><br/>";
/* 
Output :

	{"Car Catalog":
		[{"Make":"BMW","Model":"4.18","Year":"2015"},
		{"Make":"Renault","Model":"Meagn","Year":"2005"},
		{"Make":"VW","Model":"Passat","Year":"2017"},
		{"Make":"Citroen","Model":"DS","Year":"1975"}]
	}
*/


// Method addRecord($jsonobj,$newencodedjson,$newdataname)
$encodedjson=$json::encodeFromTab($car);
$record=$json::mkRecordFromTab2D($car_catalog,"Car Catalog");

$result=$json::addRecord($record,$encodedjson,"Special Car of the Month");
echo "<PRE>".print_r($result,true)."</PRE><br/>";
/* 
Output :

	{"Car Catalog":[{"Make":"BMW","Model":"4.18","Year":"2015"},
					{"Make":"Renault","Model":"Meagn","Year":"2005"},
					{"Make":"VW","Model":"Passat","Year":"2017"},
					{"Make":"Citroen","Model":"DS","Year":"1975"}],
	 "Special Car of the Month":[{"Make":"BMW","Model":"4.18","Year":"2015"}]}
*/
?>





