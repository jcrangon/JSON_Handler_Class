<?php
class jsonHandler {

	protected static $_messages = array(
	    JSON_ERROR_NONE => 'No error has occurred',
	    JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
	    JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
	    JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
	    JSON_ERROR_SYNTAX => 'Syntax error',
	    JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
	);
	
	
	// Protected methods
	protected static function encode($phpstdclass, $options = 0) {
		$encodedjson = json_encode($phpstdclass, $options);

		if($encodedjson)  {
			return $encodedjson;
		}

		throw new RuntimeException(SELF::$_messages[json_last_error()]);
	}
	
	protected static function createRecord($encoded_json,$dataname){
		$jsonobj="{\"".$dataname."\":[".$encoded_json."]}";
		return $jsonobj;
	}
	
	
	
	// Public methods
	public static function decode($json, $assoc = false) {
		$result = json_decode($json, $assoc);

		if($result) {
			return $result;
		}

		throw new RuntimeException(SELF::$_messages[json_last_error()]);
	}

	public static function addRecord($jsonobj,$newencodedjson,$newdataname){
		$jsonobj=rtrim($jsonobj,"}");
		$jsonobj.=",\"".$newdataname."\":[".$newencodedjson."]}";
		return $jsonobj;
	}

	public static function transmit($jsonobj){
		header('content-type: application/json');
		echo $jsonobj;
	}
	
	public static function encodeFromVar($key,$value){
		$jsonphp=new stdClass();
		$jsonphp->$key=$value;
		$encodedjson=SELF::encode($jsonphp);
		return $encodedjson;
	}
	
	public static function encodeFromTab($tab){
		$jsonphp=new stdClass();
		foreach($tab as $key=>$val){
			$jsonphp->$key=$val;
		}
		$encodedjson=SELF::encode($jsonphp);
		return $encodedjson;
	}

	public static function encodeFromTab2D($tab){
		for($i=0;$i<sizeof($tab);$i++){
			$jsonphp=new stdClass();
			foreach($tab[$i] as $key=>$val){
				$jsonphp->$key=$val;
			}
			if($i>0){
				$encodedjson.=",".SELF::encode($jsonphp);
			}
			else{
				$encodedjson=SELF::encode($jsonphp);
			}
			unset($jsonphp);
		}
		return $encodedjson;
	}
	
	public static function mkRecordFromVar($key,$value,$recordname){
		$jsonphp=new stdClass();
		$jsonphp->$key=$value;
		$encodedjson=SELF::encode($jsonphp);
		$jsonobj="{\"".$recordname."\":[".$encodedjson."]}";
		return $jsonobj;
	}
	
	public static function mkRecordFromTab($tab,$recordname){
		$jsonphp=new stdClass();
		foreach($tab as $key=>$val){
			$jsonphp->$key=$val;
		}
		$encodedjson=SELF::encode($jsonphp);
		$jsonobj="{\"".$recordname."\":[".$encodedjson."]}";
		return $jsonobj;
	}
	
	public static function mkRecordFromTab2D($tab,$recordname){
		for($i=0;$i<sizeof($tab);$i++){
			$jsonphp=new stdClass();
			foreach($tab[$i] as $key=>$val){
				$jsonphp->$key=$val;
			}
			if($i>0){
				$encodedjson.=",".SELF::encode($jsonphp);
			}
			else{
				$encodedjson=SELF::encode($jsonphp);
			}
			unset($jsonphp);
		}
		$jsonobj=SELF::createRecord($encodedjson,$recordname);
		return $jsonobj;
	}
}

?>