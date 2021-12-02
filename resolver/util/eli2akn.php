<?PHP

require "./util.php" ;
require "../admin/tpl2.php" ;
// $exampleFile = '../examples/nir/list.txt' ; 
// $examples = explode("\n",trim(file_get_contents( $exampleFile ))) ;

$config_file = './config.json' ;

	function getVal($s) { return $s[0]; }

	$response = array() ;
	$as = 'json' ;	

try {
	$config = json_decode(file_get_contents( $config_file ),true) ;
	
	require $config['fix'] ;
	$doctypes = $config['doctypes'] ;
	
	$debug = isset($_GET['debug']) ;

	if (isset($_GET['as'])) $as = $_GET['as'] ;

	if (isset($_GET['patterns'])) {
		$local_patterns = json_decode($_GET['patterns'],true)  ;
	} else {
		$local_patterns = array() ; 
	}

	if (isset($_GET['eli'])) {
		$source = $_GET['eli'] ;
	} else if (isset($_GET['urn'])) {
		$source = $_GET['eli'] ;
	} else if (isset($_GET['uri'])) {
		$source = $_GET['eli'] ;
	} else if (isset($_GET['url'])) {
		$source = $_GET['eli'] ;
	} else {
		throw new Exception('No eli provided. Specify one with parameter "eli"');
	}
	$parse['eli'] = $source;

	$patterns = array_merge($config['patterns'], $local_patterns)  ;
	$parse = match($patterns,$source) ; 
	if (isset($parse['extra'])) {
		throw new Exception('parse failed starting with: '.$parse['extra']);
	}

	$intermediate = fixParse($parse,$config['localMaps']) ;
	$output = map($intermediate,$config['map']) ;
	$response['akn'] = getIRI($intermediate,$output) ;

	if ($debug) {
		$response['parse'] = $parse ;
		$response['intermediate'] = $intermediate ; 
		$response['output'] = $output ;
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

function q($s) {
	return print_r($s,true) ;
}

?>