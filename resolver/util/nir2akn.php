<?PHP

require "../admin/util.php" ;
require "../admin/tpl2.php" ;
// $exampleFile = '../examples/nir/list.txt' ; 
// $examples = explode("\n",trim(file_get_contents( $exampleFile ))) ;

$doctypes= array('accordo'=>'act',
'atto'=>'act',
'autorizzazione'=>'act',
'avviso'=>'act',
'bando'=>'doc',
'bando.concorso'=>'doc',
'bando.duce'=>'doc',
'bollettino'=>'act',
'circolare'=>'act',
'comunicato'=>'act',
'comunicazione'=>'act',
'decisione'=>'judgment',
'decreto'=>'act',
'decreto.capo.governo'=>'act',
'decreto.duce'=>'act',
'decreto.legge'=>'act',
'decreto.legge.luogotenziale'=>'act',
'decreto.legislativo'=>'act',
'decreto.legislativo.duce'=>'act',
'decreto.legislativo.luogotenziale'=>'act',
'decreto.luogotenziale'=>'act',
'delibera'=>'act',
'deliberazione'=>'act',
'determina'=>'act',
'determinazione'=>'act',
'dichiarazione'=>'act',
'direttiva'=>'act',
'disegno.legge'=>'bill',
'disposizione'=>'act',
'documento'=>'doc',
'intesa'=>'act',
'istruzioni'=>'act',
'legge'=>'act',
'legge.costituzionale'=>'act',
'linee.guida'=>'act',
'ordinanza'=>'act',
'ordine.giorno'=>'doc',
'parere'=>'act',
'progetto.legge'=>'bill',
'provvedimento'=>'act',
'regio.decreto'=>'act',
'regio.decreto.legge'=>'act',
'regio.decreto.legislativo'=>'act',
'regolamento'=>'act',
'resoconto'=>'debate',
'risoluzione'=>'act',
'seduta'=>'doc',
'testo'=>'doc',
'avviso.rettifica'=>'doc',
'entrata.vigore'=>'doc',
'errata.corrige'=>'doc',
'mancata.conversione' => 'doc' );

$nir2akn = array(
	'schema' => 'akn',
	'jurisdiction-0' => 'it',
	'worktype' => array('getDoc','>documento-provvedimento-tipo'),
	'worksubtype-0' => '>documento-provvedimento-tipo',
	'workactor' => array('getActor', '>documento-autorita-soggetto'),
	'workDate-string' => array('getPeriod','>documento-estremi-date'),
	'workNumber-dash' => array('getNumber', '>documento-estremi-periodo','>documento-estremi-numeri'),
	'lang-lang3' => 'ita',
	'versDate-string' => '>versione-data',
	'exprSource' => null,
	'exprDate-string' => '>versione-vigenza',
	'manifSource' => '>manifestazione-editore-nome',
	'manifDate-string' => null,
	'format-prefix' => '>manifestazione-formato-formato',
	'component' => array('joinComps','>documento-annesso','>manifestazione-componente-nome'),
	'fragment' => '>partizione-id'

) ;

$response = array() ;
	$debug = isset($_GET['debug']) ;
	if (isset($_GET['as'])) {
		$as = $_GET['as'] ;
	} else {
		$as = 'json' ;
	}


try {
	if (isset($_GET['nir'])) {
		$nir = $_GET['nir'] ;
	} else if (isset($_GET['urn'])) {
		$nir = $_GET['nir'] ;
	} else if (isset($_GET['uri'])) {
		$nir = $_GET['nir'] ;
	} else if (isset($_GET['url'])) {
		$nir = $_GET['nir'] ;
	} else {
		throw new Exception('No urn:nir provided. Specify one with parameter "nir"');
	}

	$response['nir'] = $nir;
	$parse = parse('test',$nir,'..',false) ; 
	if (isset($parse['extra'])) {
		throw new Exception('parse failed starting with: '.$parse['extra']);
	}
	$useParse = fixParse($parse) ;
	$features = map($useParse,$nir2akn) ;
	$response['akn'] = getIRI($useParse,$features) ;

	if ($debug) {
		$response['parse'] = $parse ;
		$response['features'] = $features ;
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

	function getValue($s, $sep='-') {
		$ret = '' ;
		if (is_array($s) ) {
			foreach ($s as $i) {
				$v = getValue($i, $sep) ;
				if ($v !== '') {
					$ret .= $v . $sep ;
				}
			}
		} else {
			$ret = $s ;
		}
		return $ret ;
	}
	function getVal($s) { return getValue($s[0]) ; }

	function getDoc($s) { 
		global $doctypes ; 
		if (array_key_exists($s[0], $doctypes)) { 
			return $doctypes[$s[0]] ;
		} else {
			return 'doc' ;
		}
	}

	function getActor($d) { 
		$ret = '' ;
		if (array_key_exists(0,$d)) {
			foreach ($d as $i) {
				$ret .= getActor($i) . '+' ;
			}
			$ret = trim($ret,'+') ; 
		} else if (array_key_exists('carica',$d)) {
			return $d['carica'] ;
		} else {
			$ret .= $d['istituzione'] . '-' ;
			if (array_key_exists('organo',$d)) {
				if (!is_array($d['organo']))
					$d['organo'] = array($d['organo']) ;
				$ret .= implode($d['organo'],'-') . '-' ;
			}
			if (array_key_exists('funzione',$d)) {
				$ret .= $d['funzione'] ;
			}
		}
		return $ret ;
	}

	function getPeriod($d) { 
		$ret = '' ;
		$d = $d[0] ;
		if (is_array($d)) {
			foreach ($d as $i) {
				$ret .= $i . '-' ;
			}
			$ret = trim($ret,'-') ; 
		} else {
			$ret .= $d ;
		}
		return $ret ;
	}

	function getNumber($s) {
		$ret = trim(implode($s,'-'),'-') ;
		if ($ret==='') $ret = 'nn' ;
		return $ret ;
	}
	
	function joinComps($s) { 
		$ret = '' ;
		if ($s[0]!== '') {
			$annessi = $s[0] ;
			if (array_key_exists(0,$annessi)) {
				foreach ($annessi as $annesso) {
					$ret .= $annesso['id'].'/' ;
				}
			} else {
				$ret .= $annessi['id'] . '/' ;
			}
		}
		if ($s[1]!=='') {
			$ret .= $s[1] . '/' ;		
		}
		return trim($ret,'/');
	}

function fixParse($old) {
	$parse = $old ;
	$altro = '' ;
	if (array_key_exists('comunicato',$parse)) {
		$comunicato = $parse['comunicato'] ;
		if (array_key_exists('data', $comunicato)) {
			$data = $comunicato['data'] ;
			$tipo = $comunicato['tipo'] ;
		} else {
			$n = count($comunicato)-1 ;
			$data = $comunicato[$n]['data'] ;
			$tipo = $comunicato[$n]['tipo'] ;
			for ($i=0; $i<$n; $i++) {
				$altro .= $comunicato[$i]['tipo'] . '_' . $comunicato[$i]['data'] . '-' ;
			}
		}			
		$altro .= $parse['documento']['provvedimento']['tipo'] . '_'  ;
		$altro .= getPeriod(array($parse['documento']['estremi']['date'])) . '_'  ;
		$altro .= $parse['documento']['estremi']['numeri'] ;
		$parse['documento']['provvedimento']['tipo'] = $tipo ;
		$parse['documento']['estremi']['date'] = $data ;
		$parse['documento']['estremi']['numeri'] = $altro ;
	}
// p($parse) ;
	return $parse ; 
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
		}
	}
	return $ret ;
}

function getIRI($parse,$features) {
	if (array_key_exists('manifestazione', $parse))
		return manifestationIRI(array('features'=> $features) ) ;
	else if (array_key_exists('versione', $parse))
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