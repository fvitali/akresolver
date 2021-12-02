<?PHP 
date_default_timezone_set('Europe/Rome') ;

$old_cookie = $_COOKIE['AKRprefs'];
$old = json_decode(base64_decode($old_cookie)) ;
$new = $_POST ;
$new_cookie = base64_encode(json_encode($new)) ;
setCookie('AKRprefs',$new_cookie,strtotime( '+30 days' ),'/') ;

echo '<h1>Old cookie</h1>' ;
p($old) ; 
echo '<h1>New cookie</h1>' ;
p($new) ;

function p($s) {
	echo ('<xmp>') ;
	print_r($s) ;
	echo ('</xmp>') ;
}


?>
