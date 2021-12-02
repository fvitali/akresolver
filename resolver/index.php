<?PHP 
require "admin/util.php" ;
require "admin/tpl2.php" ;

/* ------------------------------ */
/*     APPLICATION DEFAULTS       */
/* ------------------------------ */

$versionNumber = "3.0 beta 2 - September 2020" ;
$default_file = "admin/data/default.json" ;
$languages_file = "admin/data/languages.json" ;
$mimetypes_file = "admin/data/mimetypes.json" ;
$default_cookie_name = 'AKRprefs' ;
$default_scheme = 'akn' ;
$default_path_parameter = 'path' ; 
$default_user_agent = 'AKResolver/2.0' ;
$default_server_collection = 'http://akn.web.cs.unibo.it/resolvers/servers.json' ;
// $default_server_collection = '../resolvers/servers.json' ;

/* ------------------------------ */
/*             GLOBALS            */
/* ------------------------------ */
$data = array() ;
$default_server_info = '' ;
$error = false; 
  
/* ------------------------------ */
/*          COLLECT INPUT         */
/* ------------------------------ */

/* If we're here, it is because the request uses the Akoma Ntoso Naming Convention */
addToFeatures('request', 'schema','akn') ;

/* get pathBase */
$script = explode('/',$_SERVER["SCRIPT_NAME"]) ;
array_pop($script) ;
$pathBase = implode('/',$script) ;

addToFeatures('request', 'realpathBase', $_SERVER["SCRIPT_NAME"]) ;
addToFeatures('request', 'pathBase', "") ;
//addToFeatures('request', 'pathBase', $pathBase) ;  // 09/2020 - Makes it work with the new server

/* ------------------------------ */
/*  IF NO PATH, SHOW HELP PAGE    */
/* ------------------------------ */
if (!isset($_GET[$default_path_parameter])) {
	require_once('admin/help.html'); 
	die() ; 
}

/* ------------------------------ */
/*          LOAD DEFAULTS         */
/* ------------------------------ */
$data['defaults'] = json_decode(file_get_contents($default_file),true) ;
addToFeatures('default', $data['defaults']) ;

/* ------------------------------ */
/*      CHECK HTTP HEADERS        */
/* ------------------------------ */
$data['headers'] = getallheaders() ;
addToFeatures('user-agent', 'lang',parseHeaders('Accept-Language')) ;
addToFeatures('user-agent', 'format',parseHeaders('Accept')) ;

/* ------------------------------ */
/*      CHECK HTTP COOKIES        */
/* ------------------------------ */
if (isset($_COOKIE[$default_cookie_name])) {
	$data['cookies'] = json_decode(base64_decode($_COOKIE[$default_cookie_name]),true) ;
	addToFeatures('preferences', $data['cookies']) ;
}

/* ------------------------------ */
/*      CHECK REQUEST DATA        */
/* ------------------------------ */
$path = $_GET[$default_path_parameter] ;

/* add query parts (if any) */
$data['query'] = $_GET ;
addToFeatures('request',$data['query']) ;

/* ------------------------------ */
/*           PARSE URI            */
/* ------------------------------ */
$data['parse'] = parse($data['features']['schema'],$path) ;
if (isset($data['parse']['extra'])) {
	$extra = $data['parse']['extra'] ;
	$data['error'] ="s address. Excess fragment = $extra"; 
	$error = true ;
} else { 
	addToFeatures('request',$data['parse']['uri']['parts']) ;
}

/* ------------------------------ */
/*       FIX WRONG VALUES         */
/* ------------------------------ */
if (!$error) {
	fixLanguages($data['features'],$languages_file) ;
	fixMimeTypes($data['features'],$mimetypes_file) ;
}

if (!$error) {
	/* ------------------------------ */
	/*   FIND THE CORRECT MAPPER      */
	/* ------------------------------ */
	$data['servers'] = findServer($default_server_collection,$data['features']) ;
	if (count($data['servers']) > 0) {
		/* ------------------------------ */
		/*          RESOLVE URI           */
		/* ------------------------------ */
		$data['response'] = resolve() ;
		/* ------------------------------ */
		/*    FIX MAPPER'S RESPONSE       */
		/* ------------------------------ */
		$data['response']['manifestation'] = manifestationIRI($data['response']) ;
	} else {
		$data['error'] ="Could not find a server to map this IRI"; 
		$error = true; 
	}
}
/* ------------------------------ */
/*        OUTPUT RESPONSE         */
/* ------------------------------ */
// p($data) ; 
doResponse() ;
die() ;

/* --- */ 

function addToFeatures($source, $name, $value=null) {
	global $data ;
	if (is_array($name) ) {
		foreach ($name as $k => $v) {
			$data['features'][$k] = $v;
			$data['sources'][$k] = $source ;
		}
	} else {
		$data['features'][$name] = $value;
		$data['sources'][$name] = $source;
	}
}

function pf($val) {
	global $data ; 
	addToFeatures('AAA','status',$val) ;
	p($data['features']) ;
}



?>