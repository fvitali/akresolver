<?PHP 
require_once('./tpl.php') ;
$config_file = "./data/config.json" ;

$negs = <<<EOD
{
		"lang": [
			{"lang3":"eng","lang2":"en","eng":"English","fra":"anglais","native":"English"},
			{"lang3":"wel","lang2":"cy","eng":"Welsh","fra":"gallois","native":"Cymraeg"}
		],
		"format": [
			{ "prefix": "htm",   "mime":  "text/html"},
			{ "prefix": "html",  "mime":  "text/html"},
			{ "prefix": "xht",   "mime":  "application/xhtml+xml"},
			{ "prefix": "xhtml", "mime":  "application/xhtml+xml"},
			{ "prefix": "pdf",   "mime":  "application/pdf"}
		]
}
EOD;

$forces = <<<EOD
{
	"manifSource": "hmso", 
	"mapper": "uk"
}
EOD;

$return = array() ;
$negotiates = json_decode($negs,true) ;
$forced = json_decode($forces,true) ;

if (isset($_GET['q'] ) ) { 
	$query = $_GET['q'] ;
	$package = json_decode(base64_decode($query),true) ;
	$features = $package['features']; 
	$sources = $package['sources'] ;
} else {
	$features = array() ;	
	$sources = array() ;	
}
$features['debug'] = array(); 

debug("test" ); 
adjustFeatures() ;
fixErrors() ;
getAllVersions() ;
decideVersion() ; 

$return = resolveFeatures($features) ;
$return["features"]  = $features ;
$return["sources"]   = $sources ;

// p($return) ;
echo stripslashes(json_encode($return)) ; 
die() ; 

/* ----- */

function adjustFeatures() {
	global $forced, $negotiates, $features, $sources; 

	foreach ($forced as $f => $v) {
		$features[$f] = $v ;
		$sources[$f] = "forced" ;	
	}
	foreach ($negotiates as $f => $v) {
		if (array_key_exists($f, $features)) {
			$value = negotiate($features[$f], $v) ;
			if ($value === false) {
				$features[$f] = $v[0];
				$sources[$f] = "non-negotiated" ;	
			} else {
				$features[$f] = $value;
				if (isset($sources[$f]) ) {
					$sources[$f] = "negotiated with $sources[$f]" ;
				} else {
					$sources[$f] = "negotiated" ;	
				}
			}
		} else {
			$features[$f] = $v[0] ;
			$sources[$f] = "provided" ;	
		}
	}
}

function negotiate($primary, $secondary) {	
	global $features ;	
	foreach ($primary as $main) {
		foreach ($secondary as $match) {
			foreach ($match as $f => $v) {
				if (array_key_exists($f, $main) && $main[$f] == $v) {
					return $main ;
				}
			}
		}
	}
	return false ;
}

function explain($v) {
	if (is_array($v) ) {
		$keys = array_keys($v) ;
		$k0 = $keys[0] ;
		return $v[$k0] ;
	} else {
		return $v ;
	}
}

function fixErrors() {
	global $features ;
	if ($features['worksubtype']=='gpa') {
		$features['worksubtype'] = 'pga' ;
	}
	$n = $features['workNumber'][0] ; 
	$features['number4'] = substr("0000$n",-4) ;
}	

function getAllVersions() {
	global $features ;
	$avt = "http://www.legislation.gov.uk/{jurisdiction[0]}{worksubtype[0]}/{workDate[year]}/{workNumber[0]}?timeline=true" ;
	$ptt = new tpl($avt) ; 
	$ptt->addMany($features) ;
	$allversions = $ptt->apply() ;

	if (strpos($allversions,"{") === false) {
		$b = simplexml_load_file($allversions) ;
//		$b = fetch($allversions) ;
		$b->registerXPathNamespace('x', 'http://www.w3.org/1999/xhtml') ;
		$vs = $b->xpath('//x:div[@id="timelineData"]//x:a[x:span[@class="pointer"]]');
		$t = $b->xpath('//x:title');
		$features['title'] = "$t[0]" ;
		foreach ($vs as $version) {
			preg_match("/.+(\d{4}-\d{2}-\d{2})/",(string) $version->attributes()->href,$m) ;
			if (count($m) > 0) {
				$n1 = $m[1] ;
				$features['versions'][] = array('year' => substr($n1,0,4), 'month'=> substr($n1,5,2), 'day' => substr($n1,8,2), 'string'=> $m[1]) ;
			}
		}
	}
//	array_pop($features['versions']) ;
}

function decideVersion() {
	global $features, $sources ;

	$viewDate = isset($features['viewDate'])?$features['viewDate']['string']:"NONE" ;
	$versionDate = isset($features['versDate'])?$features['versDate']['string']:'' ;

	if ($versionDate == '') {
		$sources['versDate'] = "computed" ;	
		if ($viewDate == 'TODAY' || $viewDate == 'NONE' ) {
			$versionDate = end($features['versions']) ;
//			debug("TODAY viewDate") ; 		
		} else {
//			debug("Use generated version date") ; 
			$vd = new DateTime($viewDate) ;
			$vd = $vd->format('Y-m-d') ;
			$versionDate = end($features['versions']) ;
			for ($i = 0; $i< count($features['versions']); $i++) {
				if ($features['versions'][$i]['string'] < $vd) {
					$versionDate = $features['versions'][$i] ;			
				} 
			}
		}
		$features['versDate'] = $versionDate ;
	} else {
//		debug("Using versDate") ; 
	}
}

function resolveFeatures() {
	global $features, $return ; 
	$k = file_get_contents("./data/config.json");
	$j = json_decode($k, true) ;	
	
	$template = array() ;
	$suggest = array() ;
	$uri = array() ;
	$suggestions = array() ;
	
	foreach ($j as $item) {
		$p = $item['if'] ;
		$pattern = "/^".implode("",array(
			"\s*(?'feature'\w+)",
			"(\[(?'index'\w+)\])?",
			"\s*(?'operator'==|=|<=|>=|<|>|!=|in|not in|contains|not contains)",
			"\s*[\'|\"]?(?'value'\w+)[\'|\"]?",
		)).'$/' ;
		if (preg_match($pattern,$p,$m)) {
			if (value_compare($features[$m['feature']],$m['index'],$m['operator'],$m['value'] )) {
				$features[$item['feature']] = $item['value'] ;
			}
		}
	}
	
	$template = array($features['template']) ;
	for ($i=0; $i<count($template); $i++) {
		$ptt = new tpl($template[$i]) ; 
		$ptt->addMany($features) ;
		$pattern = $ptt->apply() ;
		if (strpos($pattern,"{") === false) {
			$uri[] = $pattern ;
		}
	}

//http://www.legislation.gov.uk/ukpga/2014/2?timeline=true
//http://www.legislation.gov.uk/ukgpa/2014/5?timeline=true

	foreach ($features['versions'] as $r) {
		$ptt = new tpl($features['suggestion']) ; 
		$ptt->addMany($features) ;
		$ptt->add('versDate',$r) ;
		$suggestions[] = $ptt->apply() ;
	}

	$return['preferred'] = array_shift($uri); 
	$return['suggestions'] = array_merge($uri, $suggestions) ;

	
	return $return ; 
}

function value_compare($f,$i,$o,$v) {
	if ($i!='') {
		$f = $f[$i] ; 
	}
	switch ($o) {
	case '=' :
	case '==' :
		return $f == $v ;
		break; 
	case '!=' :
		return $f != $v ;
		break; 
	case '<=' :
		return $f <= $v ;
		break; 
	case '>=' :
		return $f >= $v ;
		break; 
	}
}
function addDetails(&$array,$features,$expl) {
	$k = file_get_contents("./data/explanations.json");
	$details = json_decode($k, true) ;
	if ($details!='') {
		foreach ($features as $key => $value) {
			$k = search('term',$key,$details) ;
			$v = search('term',$value,$details) ;
			if ($k) {
				$expl[$key] = $k[0]['explanation'] ;
			}
			if ($v) {
				$expl[$value] = $v[0]['explanation'] ;
			}
		}
	}
	$array['explanations'] = $expl; 
	$array['features'] = $features; 		
}

function addIf(&$array,$name,$value) {
	if (!isset($array[$name]) || $array[$name]=='') {
		$array[$name]=$value;
	}
}

function p($s) {
	echo ('<xmp>') ;
	print_r($s) ;
	echo ('</xmp>') ;
}

function search($key, $value, $array) {
    $results = array();
	foreach ($array as $a) {
		if (isset($a[$key]) && $a[$key] == $value) {
			$results[] = $a ; 
        }
    }
    return $results ;
}

function debug($string) {
	global $features; 
	if ($string !=='') {
		$features['debug'][] = print_r($string,true); 
	}
}

function fetch($url,$cookie=NULL) {
	$ch=curl_init();
	if (isset($cookie)) {
		curl_setopt($ch, CURLOPT_COOKIE, "AKRprefs=$cookie");
	}
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1); 
	$data = curl_exec($ch);
	
	$return['error'] = curl_error($ch) ;
	$return['info']= curl_getinfo($ch) ;
	$header_size = curl_getinfo($ch,CURLINFO_HEADER_SIZE);
	$return['headers'] = explode("\r\n",substr($data, 0, $header_size));
	$return['data'] = substr( $data, $header_size );
	$return['httpcode'] = curl_getinfo($ch,CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	return $return ;
	
}

?>