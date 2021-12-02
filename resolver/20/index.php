<?PHP 

require_once('admin/tpl.php'); 
date_default_timezone_set('Europe/Rome') ;

$serverCollection = 'http://akn.web.cs.unibo.it/resolvers/servers.json' ;
$wURI = '/{prefix}[/{country}][-{jurisdiction}][/{type}][/{subtype}][/{creator}][/{creationDate}][/{number}]' ;
$eURI = $wURI . '[/{language}]@{versionDate}[:{viewDate}][/{endViewDate}][/{exprAuthority}][/{contentDate}]' ;
$mURI = $eURI . '[;{manifAuthority}][/{manifDate}][.{format}]' ;
$clean = true ;
$cleanPrefs = false ;
$defaultUse =' wrap'; 

/* ------------------------------ */
/*          COLLECT INPUT         */
/* ------------------------------ */

$script = explode('/',$_SERVER["SCRIPT_NAME"]) ;
array_pop($script) ;
$pathBase = implode('/',$script) ;

if (!$cleanPrefs && $_COOKIE['AKRprefs']) {
	$prefs = json_decode(base64_decode($_COOKIE['AKRprefs']),true) ;
	$prefs['source'] = 'cookie' ;
} else {
	$prefs = json_decode(file_get_contents("admin/data/default.json"),true);
	$prefs['source'] = 'default file' ;
}
$cookie = base64_encode(json_encode($prefs)) ;

if(!isset($_GET['path']) || $_GET['path'] == '') {
	require "admin/help.html" ;
	die(); 
}
$URIref = "/".$_GET['path'] ;

/* ------------------------------ */
/*          MAIN                  */
/* ------------------------------ */

$features = parseURI($URIref) ;
$servers = findServer($features) ;
$response = resolve($servers,$features,$cookie) ;
fixFeatures($response,$features,$prefs) ;
doResponse($response,$cookie) ;
die() ;

/* ------------------------------ */
/*          FUNCTIONS             */
/* ------------------------------ */

function parseURI($path,$clean=true) {
	$features = array() ;
	$start = "/^".implode("",array(
		"(\/?(?'use'wrap|redirect|resolve|dereference))?",
		"(?'path'\/.*)?"
	)).'/' ;

	$work = "/^".implode("",array(
		"\/?(?'prefix'akn)",
		"\/(?'country'[a-zA-Z0-9]+)", 
		"(\-(?'jurisdiction'\w+))?\/", 
		"(?'type'\w+)\/",
		"((?'subtype'\w+)\/)?",
		"((?'creator'\w+)\/)?",
		"(?'creationDate'(?'creationYear'\d{4})(-(?'creationMonth'\d{2})-(?'creationDay'\d{2}))?)\/",
		"(?'number'\w+)(\/)?",
		"(?'remaining'.*)?"
	)).'/' ;

	$expression = "/^".implode("",array(
		"(?'language'\w{3})?", 
		"((?'expr'@)(?'versionDate'(?'versionYear'\d{4})(-(?'versionMonth'\d{2})-(?'versionDay'\d{2}))?)?)?",
		"(:(?'viewDate'(?'viewYear'\d{4})(-(?'viewMonth'\d{2})-(?'viewDay'\d{2}))?))?",
		"(-(?'endViewDate'(?'endViewYear'\d{4})(-(?'endViewMonth'\d{2})-(?'endViewDay'\d{2}))?))?",
		"(\/(?'exprAuthority'\w+))?", 
		"(\/(?'contentDate'(?'contentYear'\d{4})(-(?'contentMonth'\d{2})-(?'contentDay'\d{2}))?))?",
		"(?'remaining'.*)?"
	)).'/' ;

	$manifestation = "/^".implode("",array(
		"(;(?'manifAuthority'\w+))?", 
		"(\/(?'manifDate'(?'manifYear'\d{4})(-(?'manifMonth'\d{2})-(?'manifDay'\d{2}))?))?",
		"\.(?'format'\w{3})",
		"(?'remaining'.*)?"
	)).'/' ;

	$start_matches = array() ;
	$work_matches = array() ;
	$expr_matches = array() ;
	$manif_matches = array() ;
	$Sok = preg_match($start,$path,$start_matches) ;

	if ($start_matches['path'] !== '') {
		$Wok = preg_match($work,$start_matches['path'],$work_matches) ;
		if ($work_matches['remaining'] !== '') {
			$Eok = preg_match($expression,$work_matches['remaining'],$expr_matches) ;
			if ($expr_matches['remaining'] !== '') {
				$Mok = preg_match($manifestation,$expr_matches['remaining'],$manif_matches) ;
			}
		}
	}
	$features = array_merge($start_matches,$work_matches,$expr_matches,$manif_matches) ;
	if ($clean) {
		foreach ($features as $k => $i) {
			if (is_int($k) || ($i=='')) {
				unset($features[$k]) ;
			} 
		}
	}

	return $features; 

}

function findServer($features) {
	global $serverCollection; 
	$opts = array('http'=>array('header' => "User-Agent: AKResolver/1.0\r\n"));
	$context = stream_context_create($opts);
	$path = $features['path'] ;
	$servers = array() ;
	$x = file_get_contents($serverCollection,false,$context) ;
	$serverList = json_decode($x,true);
	foreach ($serverList as $s) {
		$p = "+".$s['IRIregexp']."+" ;
		if (preg_match($p,$path)) {
			$servers[] = $s['Resolver'] ;
		}
	}
	return $servers ;
}

function resolve($servers,$features,$cookie) {
	$query = base64_encode(json_encode($features)) ;
	$result = "" ;
	for ($i=0; $i < count($servers) && !isset($result['url']); $i++) {
		$server = $servers[$i] ;
		$out = fetch("$server?q=$query",$cookie) ;
// echo "<!-- $server?q=$query -->\r\r " ;
		if ($out['error']!='') {
			$result = $out ;
		} else {
			$result = $out['data'] ;
		}
	} 
	$response = json_decode($result, true) ;
	return $response ;
}

function fixFeatures(&$response, $features, $prefs) {
	global $mURI,$defaultUse ;
	if (isset($features['use'])) {
			$response['using'] = 'feature' ;	
			$response['use'] = $features['use'] ;
	} else {	
		if (isset($prefs['use'])) {
			$response['using'] = 'preference' ;	
			$response['use'] = $prefs['use'] ;
		} else {
			$response['using'] = 'default' ;	
			$response['use'] = $defaultUse ;
		}
	}
	$mtpl = new tpl($mURI) ;
	$mtpl->addMany($response['features']) ;
	$response['manifURI'] = $mtpl->apply(true) ;
	$response['prefs'] = $prefs; 
}



function doResponse($features,$cookie) {
	global $pathBase ;
	$features['pathBase'] = $pathBase ;

	$use = $features['use'] ;
	$out = $features['preferred'] ;
	setCookie('AKRprefs',$cookie,strtotime( '+30 days' ),'/') ;
	switch ($use) {
	case 'resolve' :
		header('Content-Type: application/json');
		echo json_encode($features);
		break; 
	case 'dereference' :
		$r = fetch($out) ;
		if ($r['error'] == '') {
			foreach ($r['headers'] as $h) {
				header($h) ;
			}
			$uri = $_SERVER["SERVER_NAME"] ;
			header("Via: 1.1 Akoma Ntoso Resolver ($uri)") ;
			header("Content-Location: $out") ;
			echo $r['data'] ;
		} else {
			p($r['error']) ;
		}
		break; 
	case 'redirect' :
		header("Location: $out", true, 302);
		die() ;
		break; 
	case 'wrap' :
		require_once('admin/toolbar.php'); 
		break; 
	default: 
		p($features) ;
		echo "<a target='_new' href='$out'>Unknown request. to $out/a>" ;
		break; 
	}
}


/* ------------------------------ */
/*          UTILITIES             */
/* ------------------------------ */

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

function p($s) {
	echo ('<xmp>') ;
	print_r($s) ;
	echo ('</xmp>') ;
}

?>
