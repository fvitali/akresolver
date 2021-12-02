<?PHP 
$code = "0AsRDcuEU3KlqdE1TTWVvdnpESEpGSlN0WUlveFpTVlE";
$arr = array() ; 
$outPath = array('config.json','explanations.json') ;
$gids = array(0,2) ;
$dir = "./data/" ;

function cmp($a, $b) { return $a['ordine'] - $b['ordine']; }

// Function to convert CSV into associative array
function csvToArray($file, $delimiter) { 
	if (($handle = fopen($file, 'r')) !== FALSE) { 
		$throwaway = fgetcsv($handle, 4000, $delimiter, '"') ;
		$headers = fgetcsv($handle, 4000, $delimiter, '"') ;
		while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
			$line = array() ;
			for ($j = 0; $j < count($lineArray); $j++) { 
				$line[$headers[$j]] = $lineArray[$j]; 
			} 
			if($lineArray[0] != "") {
				$arr[] = $line ;
			}
			$i++; 
		} 
		fclose($handle); 
	} 
	usort($arr, "cmp");
	return $arr; 
}

function indent($json) {
	$result = '';
	$pos = 0;
	$strLen = strlen($json);
	$indentStr = "\t";
	$newLine = "\n";

	for ($i = 0; $i < $strLen; $i++) {
		// Grab the next character in the string.
		$char = $json[$i];

		// Are we inside a quoted string?
		if ($char == '"') {
			// search for the end of the string (keeping in mind of the escape sequences)
			if (!preg_match('`"(\\\\\\\\|\\\\"|.)*?"`s', $json, $m, null, $i))
				return $json;

			// add extracted string to the result and move ahead
			$result .= $m[0];
			$i += strLen($m[0]) - 1;
			continue;
		} else if ($char == '}' || $char == ']') {
			$result .= $newLine;
			$pos --;
			$result .= str_repeat($indentStr, $pos);
		}

	// Add the character to the result string.
	$result .= $char;

	// If the last character was the beginning of an element,
	// output a new line and indent the next line.
	if ($char == ',' || $char == '{' || $char == '[') {
		$result .= $newLine;
		if ($char == '{' || $char == '[') {
			$pos ++;
		}

		$result .= str_repeat($indentStr, $pos);
		}
	}
	return $result;
}

try { 
	echo "<h1>Creazione mappa per AKN Resolver</h1>" ;
	for ($page=0; $page<count($gids); $page++) {
		$gid = $gids[$page] ;
		$feed = "https://docs.google.com/spreadsheet/pub?key=$code&gid=$gid&output=csv";
		$file = $outPath[$page] ;
		$arr = csvToArray($feed, ',') ;
		$data = stripslashes(json_encode($arr)) ;
		file_put_contents($dir.$file, indent($data)) ; 
		echo "<h2>contenuto del file $file</h2>" ;
		p($arr) ;
		echo "<h1>Creazione andata a buon fine</h1>" ;
	}
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

function p($s) {
	echo "<xmp>".print_r($s,true)."</xmp>" ;
}
?>