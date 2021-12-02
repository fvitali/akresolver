<?PHP

require "./util.php" ;
require "../admin/tpl2.php" ;
// $exampleFile = '../examples/nir/list.txt' ; 
// $examples = explode("\n",trim(file_get_contents( $exampleFile ))) ;

$config_file = './config.json' ;

function getVal($s) { return $s[0]; }

$as = 'json' ;	
$response = array() ;
$debug_msg = array() ;
$debug = false ;

try {
	$config = json_decode(file_get_contents( $config_file ),true) ;

//	require $config['fix'] ;
															debug("Read file $config[fix]") ;

//	$doctypes = $config['doctypes'] ;
	
															debug($_GET, '$_GET') ;
	if (isset($_GET['debug']))   $debug = true ;
	if (isset($_GET['as'   ]))   $as = $_GET['as'] ;
	if (isset($_GET['uri'  ]))   $uri = $_GET['uri']  ; 

	if      (preg_match("^/akn/^", $uri))  { $syntax = 'akn' ; }
	else if (preg_match("^/eli/^", $uri))  { $syntax = 'eli' ; }
	else if (preg_match("^/ecli/^", $uri)) { $syntax = 'ecli1' ; }
	else if (preg_match("^ECLI:^", $uri))  { $syntax = 'ecli2' ; }
	else if (preg_match("^URN^", $uri))    { $syntax = 'urn' ; } 
	else                                   { $syntax = 'none'; }
															debug("Syntax chosen is $syntax") ;
	
	switch ($syntax) {
	case 'akn':
		$intermediate = parseAKN($uri) ;
		break; 
	case 'eli':
		$intermediate = match($config['patterns'], $uri) ;
															debug($intermediate, 'ELI $intermediate') ;
		$result = fixParse($intermediate) ;
															debug($result, 'ELI $result') ;
		break; 
	case 'ecli1':
	case 'ecli2':
		$intermediate = parseECLI($uri) ;
		break; 
	case 'urn':
		$intermediate = parseURN($uri) ;
		break; 	 
	}
	
	$response['lcm'] = buildLCM($uri, $intermediate) ;
	buildUris($response) ; 
	if ($debug) {
		$response['debug'] = $debug_msg ;
	}
	
} catch (Exception $e) {
	$response['error'] = $e->getMessage() ;
}

switch ($as) {
case 'json': 
	header('Content-type: application/json; charset=utf-8');	
	echo stripslashes(json_encode($response));
	break; 
case 'xml': 
	header('Content-type: text/xml');
	echo xml_encode(array('response'=>$response));
	break; 
case 'text': 
	header('Content-type: text/plain; charset=utf-8');	
	echo print_r($response,true) ;
	break; 	
}

function parseAKN($uri) {
	return "pippo" ;
}

function parseECLI($uri) {
	return "paperino" ;
}

function parseURN($uri) {
	return "nonna papera" ;
}

function buildLCM($uri, $data) {
	$flist =array() ;
	foreach ($data as $key => $value) {
		array_push($flist, array(
			'name'=> $key, 
			'frame' => 'source',
			'frbr' => 'work',
			'levels' => array( array('values' => $value ) )
		)) ;		
	}
	return array(
		'context'=> array(
			'http://www.fabiovitali.it/legalcitem/lcm-context7.json', 
			'http://www.fabiovitali.it/legalcitem/lcm-local.json'
		),
		'citation' => array(
			'details'=> array(
				'text'=>$uri 
			)
		), 
		'references' => array( 
			array(
				'features' => $flist 
			) 
		)
	);
}
function buildUris(&$response) {
	global $response; 
	$response['akn'] = 'ciccio'; 
} 


function match($patterns, $uri) {
	$defPatterns = array(
		'd44'     => '\d{4}-\d{4}',
		'd8'     => '\d{8}', 
		'd4'     => '\d{4}', 
		'd2'     => '\d{2}',
		'd\+'     => '\d+',
		'Rd'     => 'R\d',
		'd1or2'     => '\d{1,2}',
		'w2'     => '\w{2}',
		'w3'     => '\w{3}',
		'w12'     => '\w{12}',
		'w\+'     => '\w+',
		'date'   => '\d{4}-\d{2}-\d{2}',
		'subEU'    => '(/\w{3}_\d+)*',
		'subIE'    => '(\w+(/\d+)?)'
	) ;

// p($patterns) ;
	foreach ($patterns as $name => $tpl) {
// p($tpl) ;
		$real_tpl = $tpl['value'] ;
		$real_tpl = preg_replace('=\{([a-zA-Z0-9_\-]+):([^\}]+)\}(\??)=',"(?'$1'$2)$3",$real_tpl) ;
		$real_tpl = preg_replace('=\{([a-zA-Z0-9_\-]+)\}(\??)=','(?\'$1\'[^/]+)$2',$real_tpl) ;
//		$real_tpl = preg_replace('=\/([a-zA-Z0-9_]+)(\??)=','/(?\'$1\'$1)$2',$real_tpl) ;
		$real_tpl = str_replace('-','_',$real_tpl) ;
		foreach ($defPatterns as $name => $pt) {
			$real_tpl = preg_replace('=\$'.$name.'=',$pt,$real_tpl) ;		
		}
		$real_tpl = '=^'.str_replace('/','\/',$real_tpl).'$=' ;
// p($real_tpl) ;
		$ok= preg_match($real_tpl, $uri, $match) ;
		if ($ok) {
			$match['pattern'] = $tpl['name']; 
			return clean_match($match) ;
		}
	}
	return array(
		'error'=> 'no suitable pattern found for this uri',
		'extra'=> $uri
	) ;
}

function clean_match($arr) {
	foreach ($arr as $key => $value) {
		if (is_int($key)) {
			unset($arr[$key]);
		}
		if ($value=='') {
			unset($arr[$key]);		
		}
	}
	return $arr ;
}

function fixParse($parse) {
	$expression = array('language', 'origin', 'pointintime') ;
	$manifestation = array('format') ;
// p($parse) ; 
	
	$intermediate = array() ; 		
	foreach ($parse as $key => $value) {
		$intermediate[$key] = array('name' => $key, 'value' => $value, 'frame' => 'source') ;
		if (in_array($key,$expression) ){
			$intermediate[$key]['frbr'] = 'expression' ;
		} else if (in_array($key,$manifestation) ) {
			$intermediate[$key]['frbr'] = 'manifestation' ;
		} else {
			$intermediate[$key]['frbr'] = 'work' ;
		}		
	}
	$country = $parse['country'] ;
	switch ($country) {
	case 'eu':
		if (strpos($parse['pattern'],'corrigendum')!==false) {
			$intermediate['type'] = array(
				'name' => 'type', 
				'value' => 'corrigendum', 
				'frame' => 'interpretation',
				'frbr'=>'work'
			) ;
		}
		break; 
	case 'fr': 
		if (contains($parse,'rectificatif') || (contains($parse,'natural_identifier') && substr($parse['natural_identifier'], -1) === 'Z')) {
			$intermediate['type'] = array(
				'name' => 'type', 
				'value' => 'rectificatif', 
				'frame' => 'interpretation',
				'frbr'=>'work'
			) ;
		}
		break; 
	case'http://www.irishstatutebook.ie/': 
		break; 
	case 'http://www.gazzettaufficiale.it/': 
		break; 
	default: 
		break; 
	}
	return $intermediate ; 
}



// BOH
function map($features,$map) {
	$return = array() ;
	foreach ($map as $left => $right) {
		$current = &$ret ;

		if ($right != null) {
			$all_left = explode('-',$left) ;
			$left_count = count($all_left)-1 ;		
			for ($i = 0; $i < $left_count ; $i++) {
				if (!isset($current[$all_left[$i]])) {
					$current[$all_left[$i]] = array() ;
					$current = &$current[$all_left[$i]] ;
				}
			}
			
			if (is_array($right)) {
				$fn = array_shift($right) ;
				$right = $right ;
			} else {
				$fn = 'getVal' ;
				$right = array($right) ;
			}
			for ($i=0; $i < count($right); $i++ ) {
				if ($right[$i]!=='' && $right[$i][0] === '>') {
					$feat = &$features ;
					$right[$i]= substr($right[$i], 1) ;
					$all_right = explode('-',$right[$i]) ;
					$right_count = count($all_right)-1 ;
					$ok = true ; 
					for ($j = 0; $j < $right_count ; $j++) {
						if (isset($feat[$all_right[$j]])) {
							$feat = &$feat[$all_right[$j]] ;					
						} else {
							$ok = false ;
						}
					}

// p($right[$i]); 				
					if ($ok && isset($feat[$all_right[$right_count]])) {
						$right[$i] = $feat[$all_right[$right_count]] ;
					} else {
						$right[$i] = '' ;
					}
				}
			}
			$val = str_replace('.','_',$fn($right)) ;	
			if ($val !== '') {
				$current[$all_left[$left_count]] = $val ;	
			}
// p($all_left[$left_count].': '.$val) ;
		}
	}
	return $ret ;
}

function getIRI($parse,$features) {
	if ($parse['frbr']=='manifestation')
		return manifestationIRI(array('features'=> $features) ) ;
	else if ($parse['frbr']=='expression')
		return expressionIRI(array('features'=> $features) ) ;
	else
		return workIRI(array('features'=> $features) ) ;
}
function multi_implode($array, $glue) {
    $ret = '';
	foreach ($array as $item) {
		if (is_array($item)) {
			$ret .= multi_implode($item, $glue) . $glue;
		} else {
			$ret .= $item . $glue;
		}
	}
	$ret = substr($ret, 0, strlen($ret) - strlen($glue));
    return $ret;
}

	function realContains($haystack,$needle) {
		if (is_string($haystack) ) {
			return strpos($haystack, $needle) !== FALSE ; 
		} else if (is_array($haystack) ) {
			return array_key_exists($needle, $haystack) ;
		}	
	}

function contains($haystack,$needle,$mode='OR') {
	if (is_array($needle) ) {
		$res = $mode !== 'OR' ;
		foreach ($needle as $item) {
			if ($mode == 'OR') {
				$res |= realContains($haystack,$item) ;
			} else {
				$res &= realContains($haystack,$item) ;
			}
		}
		return $res ;
	} else {
		return realContains($haystack, $needle) ; 
	}
}

function debug($value, $name=null) {
	global $debug_msg; 
	if (isset($name)) {
		array_push($debug_msg, array($name=> $value)) ;
	} else {
		array_push($debug_msg, $value) ;
	}
}
function q($s) {
	return print_r($s,true) ;
}

?>