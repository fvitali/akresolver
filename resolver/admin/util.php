<?PHP
use hafriedlander\Peg\Compiler;

function parse($scheme,$uri,$base='.',$force=false) {
	if (!class_exists('parsingMachine') ) {
		prepare($scheme,$base,$force) ;
	}
	$x = new parsingMachine($uri) ;
	$res = $x->match_expr() ;
	if ($res === false) {
		p('invalido') ;
	} else {
//		p($res) ;
		return cleanUp($res) ;
	}
}

function prepare($name, $base, $force=false) {
	$input = realpath($base.'/grammar/'.$name.'.grammar') ;
	$output = realpath($base.'/compiled').'/'.$name.'.php' ;

	if (file_exists($input)) {
		if ($force || (!file_exists($output) || filemtime($output) < filemtime($input) )) {
			touch($output) ;
			$string = file_get_contents( $input ) ;
			$grammar = <<<EOD
<?PHP
require_once '$base/peg/autoloader.php';
use hafriedlander\Peg\Parser;
class parsingMachine extends Parser\Basic {
/*!* parsingMachine
$string
*/
}
?>
EOD;
			require $base.'/peg/autoloader.php';
			$out = trim(Compiler::compile($grammar)) ;
			$a = file_put_contents( $output, $out ) ;
		}
	}
require $output ;
}


function cleanUp($arr) {
	$dont = array('_matchrule','name','text') ;
	$val = ''; 
    $newArray = array();
    foreach($arr as $key => $value) {
		if(!in_array($key,$dont) || $key===0) {
			if(is_array($value)) $newArray[$key] = cleanUp($value);
			else $newArray[$key] = $value;
		}
		if ($key=='text') $val = $value ;
    }
//    p($newArray) ; 
	if (array_key_exists ( 'item' , $newArray )) {
		return $newArray['item'] ;
 	} else if (count($newArray) === 0) {
		return $val;
	} else {
		return $newArray;
	}
}

function findServer($collection,$features) {
	global $default_user_agent ;
	global $default_server_info ;
	$path = $features['schema'] ;
	if (array_key_exists('path', $features)) {
		$path .= $features['path'] ;
	} else {
		$path .= $default_server_info ;
	}
	$opts = array('http'=>array('header' => "User-Agent: $default_user_agent\r\n"));
	$context = stream_context_create($opts);
	$servers = array() ;
	$x = file_get_contents($collection,false,$context) ;
	$serverList = json_decode($x,true);
	foreach ($serverList as $s) {
		$p = "+".$s['IRIregexp']."+" ;
		if (preg_match($p,$path)) {
			$servers[] = $s['Resolver'] ;
		} else {
		
		}
	}
	return $servers ;
}

function fixMimeTypes(&$features, $mimetypes_file) {
	function checkMime($item) { return strpos($item,'/')===false;  } ;
	$mimetypes = json_decode(file_get_contents($mimetypes_file),true) ;
	fixMe(&$features, $mimetypes, 'checkMime', 'format', 'prefix', 'mime') ;
}
function fixLanguages(&$features,$languages_file) {
	function checkLang($item) { return strlen($item)==3;  } ;
	$languages = json_decode(file_get_contents($languages_file),true) ;
	fixMe(&$features, $languages, 'checkLang', 'lang', 'lang3', 'lang2') ;
}

function fixMe(&$features, $array, $f, $var1, $var2, $var3) {
	if (array_key_exists($var1, $features)) {
		$result = array() ;
		for ($i=0; $i< count($features[$var1]) ; $i++) {
			if (call_user_func_array($f,array($features[$var1][$i]))) {
				$result = array_merge($result, search($array, $var2, $features[$var1][$i] )) ; 
			} else {
				$result = array_merge($result, search($array, $var3, $features[$var1][$i] )) ; 			
			}
		}
		$features[$var1] = $result; 
	}

}


function search($array, $key, $value) {
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }
    return $results;
}

function resolve() {
	global $data; 
	$package = array('features' => $data['features'], 'sources' => $data['sources']) ;
	$query = base64_encode(json_encode($package)) ;
	$servers = $data['servers'] ; 
	$result = "" ;
	$data['queries'] = array() ; 
	for ($i=0; $i < count($servers) && !isset($result['url']); $i++) {
		$server = $servers[$i] ;
		$q = preg_replace('/\$query/', $query, $server) ; 
//		$q = "$server?q=$query" ;
		$data['queries'][] = $q; 
		$out = fetch($q) ;
		if ($out['error']!='') {
			$result = $out ;
		} else {
			$result = $out['data'] ;
		}
	} 
	$response = json_decode($result, true) ;
// 	p($response) ;
	return $response ;
}

function parseHeaders($name) {
	$f = function($v) {
		$t = explode(';',$v) ;
		return $t[0]; 
	} ;
	$headers = getallheaders() ;
	$h = $headers[$name] ;
	$list = explode(',',$h) ;
	return array_map($f,$list) ;
}

function workIRI($features) {
	if (isset($features['features']) ) {
		$wURI = '[[/{schema}]][[/{jurisdiction[0]}]][[/{worktype}]][[/{worksubtype[0]}]][[/{workactor|+}]][[/{workDate[string]}]][[/{workNumber[dash]}]]' ;
		$compURI = $wURI . '[[!{component}]]' ;
		$fragURI = $compURI . '[[~{fragment|__}]]' ;
		$mtpl = new tpl($fragURI) ;
		$mtpl->addMany($features['features']) ;
		return $mtpl->apply(true) ;
	} else {
		return '';
	}
}

function expressionIRI($features) {
	if (isset($features['features']) ) {
		$wURI = '[[/{schema}]][[/{jurisdiction[0]}]][[/{worktype}]][[/{worksubtype[0]}]][[/{workactor|+}]][[/{workDate[string]}]][[/{workNumber[dash]}]]' ;
		$eURI = $wURI . '[[/{lang[lang3]}]]@[[{versDate[string]}]][[{versString}]][[/{exprSource}]][[;{exprDate[string]}]]' ;
		$compURI = $eURI . '[[!{component}]]' ;
		$fragURI = $compURI . '[[~{fragment|__}]]' ;
		$mtpl = new tpl($fragURI) ;
		$mtpl->addMany($features['features']) ;
		return $mtpl->apply(true) ;
	} else {
		return '';
	}
}

function manifestationIRI($features) {
	if (isset($features['features']) ) {
		$wURI = '[[/{schema}]][[/{jurisdiction[0]}]][[/{worktype}]][[/{worksubtype[0]}]][[/{workactor|+}]][[/{workDate[string]}]][[/{workNumber[0]}]]' ;
		$eURI = $wURI . '[[/{lang[lang3]}]]@[[{versDate[string]}]][[{versString}]][[/{exprSource}]][[;{exprDate[string]}]]' ;
		$mURI = $eURI . '[[/{manifSource}]][[/{manifDate[string]}]]' ;
		$compURI = $mURI . '[[!{component}]]' ;
		$fragURI = $compURI . '[[~{fragment|__}]]' ;
		$fmtURI = $fragURI . '[[.{format[prefix]}]]' ;
		$mtpl = new tpl($fmtURI) ;
		$mtpl->addMany($features['features']) ;
		return $mtpl->apply(true) ;
	} else {
		return '';
	}
}

function doResponse() {
	global $data, $error ; 
	global $versionNumber ;
	if (isset($data['query']['debug'])) {
		$use = 'debug' ; 
	} else {
		$use = $data['features']['action'] ;
	}
	$to = 'json' ;
	if(isset($data['features']['to'])) {
		$to = $data['features']['to'] ;
	}
	$pathBase = $data['features']['pathBase'] ;
// 	setCookie('AKRprefs',$cookie,strtotime( '+30 days' ),'/') ;

	switch ($use) {
	case 'parse' :
		$out  = '' ;
		$response = $data['parse'] ;
		break; 
	case 'resolve' :
		$out  = '' ;
		$response = $data['features'] ;
		break ;
	case 'debug' : 
		$out  = '' ;
		$response = $data ;	
		break ;
	default :
		$to = $use ; 
		if(isset($data['response'])) {
			$out = $data['response']['preferred'] ;	
			$response = stripslashes(prettyPrint(json_encode($data['response']), 4 ) )  ;
		} else {
			$out = '' ;
			$response = $data ;
			$error = true ; 
		}
	}
	
	switch ($to) {
	case 'json': 
		header('Content-type: application/json; charset=utf-8');	
		echo json_encode($response);
		break; 
	case 'xml': 
		header('Content-type: text/xml');
		echo xml_encode(array('parse'=>$response));
		break; 
	case 'text': 
		header('Content-type: text/plain; charset=utf-8');	
		echo print_r($response,true) ;
		break; 
	case 'redirect' :
		header("Location: $out", true, 302);
		break; 
	case 'frame' :
		require_once('admin/toolbar.php'); 
		break; 
	case 'debug' :
		p($data) ;
		break; 
	default: 
		echo "<a target='_new' href='$out'>Unknown request $use. Click here to be redirected to $out</a>" ;
		break; 
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

if (!function_exists('p')) {
	function p($s) {
		echo ('<xmp>') ;
		print_r($s) ;
		echo ('</xmp>') ;
	}
}

function prettyPrint( $json, $entab=0 )
{
    $result = '';
    $level = 0;
    $in_quotes = false;
    $in_escape = false;
    $ends_line_level = NULL;
    $json_length = strlen( $json );

    for( $i = 0; $i < $json_length; $i++ ) {
        $char = $json[$i];
        $new_line_level = NULL;
        $post = "";
        if( $ends_line_level !== NULL ) {
            $new_line_level = $ends_line_level;
            $ends_line_level = NULL;
        }
        if ( $in_escape ) {
            $in_escape = false;
        } else if( $char === '"' ) {
            $in_quotes = !$in_quotes;
        } else if( ! $in_quotes ) {
            switch( $char ) {
                case '}': case ']':
                    $level--;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                case '{': case '[':
                    $level++;
                case ',':
                    $ends_line_level = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ": case "\t": case "\n": case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
            }
        } else if ( $char === '\\' ) {
            $in_escape = true;
        }
        if( $new_line_level !== NULL ) {
            $result .= "\n".str_repeat( "\t", $entab).str_repeat( "\t", $new_line_level );
        }
        $result .= $char.$post;
    }
    return $result;
}


// https://www.darklaunch.com/2009/05/23/php-xml-encode-using-domdocument-convert-array-to-xml-json-encode
function xml_encode($mixed, $domElement=null, $DOMDocument=null) {
    if (is_null($DOMDocument)) {
        $DOMDocument =new DOMDocument;
        $DOMDocument->formatOutput = true;
        xml_encode($mixed, $DOMDocument, $DOMDocument);
        return $DOMDocument->saveXML();
    }
    else {
        if (is_array($mixed)) {
            foreach ($mixed as $index => $mixedElement) {
                if (is_int($index)) {
                    if ($index === 0) {
                        $node = $domElement;
                    }
                    else {
                        $node = $DOMDocument->createElement($domElement->tagName);
                        $domElement->parentNode->appendChild($node);
                    }
                }
                else {
                    $plural = $DOMDocument->createElement($index);
                    $domElement->appendChild($plural);
                    $node = $plural;
                    if (!(rtrim($index, 's') === $index)) {
                        $singular = $DOMDocument->createElement(rtrim($index, 's'));
                        $plural->appendChild($singular);
                        $node = $singular;
                    }
                }

                xml_encode($mixedElement, $node, $DOMDocument);
            }
        }
        else {
            $mixed = is_bool($mixed) ? ($mixed ? 'true' : 'false') : $mixed;
            $domElement->appendChild($DOMDocument->createTextNode($mixed));
        }
    }
}

?>