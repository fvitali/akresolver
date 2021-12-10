<?PHP 
require_once('./tpl.php') ;
$config_file = "./data/config.json" ;

$negs = <<<EOD
{
		"lang": [
			{"lang3":"deu","lang2":"de","eng":"German","fra":"allemand","native":"Deutsch"},
			{"lang3":"ger","lang2":"de","eng":"German","fra":"allemand","native":"Deutsch"},
			{"lang3":"fra","lang2":"fr","eng":"French","fra":"français","native":"Français"},
			{"lang3":"ita","lang2":"it","eng":"Italian","fra":"italien","native":"Italiano"}
		], 
		"format": [
			{"mime": "application/pdf", "prefix": "pdf"}
		]
}
EOD;

$forces = <<<EOD
{
		"manifSource": "opc",
		"mapper": "swiss"
}
EOD;

$ignes = <<<EOD
[ "view", "version" ]
EOD;

$return = array() ;
$negotiates = json_decode($negs,true) ;
$forced = json_decode($forces,true) ;
$ignores = json_decode($ignes,true) ;

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
adjustFeatures() ; 
// p($features) ;
// die() ; 

$return = resolveFeatures($features) ;
$return["features"]  = $features ;
$return["sources"]   = $sources ;

echo json_encode($return) ; 

function adjustFeatures() {
	global $forced, $ignores, $negotiates, $features, $sources; 

	foreach ($forced as $f => $v) {
		$features[$f] = $v ;
		$v0 = explain($v) ;
		$sources[$f] = "forced" ;	
	}

	foreach ($ignores as $f) {
		if (array_key_exists($f, $features)) {
			$sources[$f] = "ignored" ;	
		}
	}

	foreach ($negotiates as $f => $v) {
		if (array_key_exists($f, $features)) {
			$value = negotiate($features[$f], $v) ;
// array_push($features['debug'],"Sto negoziando $f sperando che valga $v")  ;
			if ($value === false) {
				$features[$f] = $v[0];
				$v0 = explain($features[$f]) ;
				$sources[$f] = "non-negotiated" ;	
			} else {
				$features[$f] = $value;
				$v0 = explain($features[$f]) ;
				if (isset($sources[$f]) ) {
					$sources[$f] = "negotiated with $sources[$f]" ;
				} else {
					$sources[$f] = "negotiated" ;	
				}
			}
		} else {
			$features[$f] = $v[0] ;
			$v0 = explain($features[$f]) ;
			$sources[$f] = "provided" ;	
		}
	}
}

function resolveFeatures($features) {
	global $config_file ; 
	$pattern = array() ;
	$suggest = array() ;
	$uri = array() ;
	$suggestions = array() ;
	$return = array() ; 

	$file = file_get_contents($config_file);
	$config = json_decode($file, true) ;	
	foreach ($config as $item) {
		$ok = false;
		$p = "+".$item['IRI']."+" ;
		if (preg_match($p,$features['path'])) {
			$ok = true; 
			$pattern[] = $item['URL'] ;
			$suggest = array_merge($suggest, explode(', ',$item['Suggest'])) ;
			break ;
		}
	}
	
	for ($i=0; $i<count($pattern); $i++) {
		$ptt = new tpl($pattern[$i]) ; 
		$ptt->addMany($features) ;
		$uri[] = $ptt->apply() ;
	}
	
	for ($i=0; $i<count($suggest); $i++) {
		$ptt = new tpl($suggest[$i]) ; 
		$ptt->addMany($features) ;
		$suggestions[] = $ptt->apply() ;
	}

//	$return['myconfig'] = $config;  
	$return['preferred'] = array_shift($uri); 
	$return['suggestions'] = array_merge($uri, $suggestions) ;
	return $return ; 
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

function p($s) {
	echo ('<xmp>') ;
	print_r($s) ;
	echo ('</xmp>') ;
}

?>