<?PHP
	function getDoc($s) { 
		global $doctypes ; 
		if (array_key_exists($s[0], $doctypes)) { 
			return $doctypes[$s[0]] ;
		} else {
			return 'doc' ;
		}
	}

function fixParse($parse) {
// p($parse) ; 

	$intermediate = array() ; 		
	$intermediate['frbr'] = 'work' ;
	$domain = $parse['domain'] ;
	
	switch ($domain) {
	case 'http://data.europa.eu/':
		$intermediate['country'] = 'eu' ; 
		$intermediate['typedoc'] = $parse['typedoc'] ; 
		$intermediate['date'] = $parse['year'] ;
		$intermediate['number'] = $parse['natural_number'] ; 
		if (strpos($parse['pattern'],'corrigendum')!==false) {
			$intermediate['number'] = $parse['typedoc'] . '-' . $parse['natural_number'] . '-' . $parse['year'] ; 
			$intermediate['date'] = $parse['pub_date'] ; 
			$intermediate['typedoc'] = 'corrigendum' ; 
			unset($intermediate['pub_date']) ; 
		}
		if (contains($parse,'subelement')) {
			$intermediate['subelement'] = explode('/',$parse['subelement']) ;
			array_shift($intermediate['subelement']) ; 
		}			
		if (contains($parse,array('lang','pointintime', 'origin') )) {
			$intermediate['frbr'] = 'expression' ;
			$intermediate['lang'] = 'und' ;
			if (contains($parse,'lang') ) 
				$intermediate['lang'] = $parse['lang'] ;			
			if (contains($parse,'origin') ) 
				$intermediate['versionAuthor'] = $parse['origin'] ;
			if (contains($parse,'pointintime') ) 
				$intermediate['pointintime'] = $parse['pointintime'] ; 
		}
		if (contains($parse,'format')) {
			$intermediate['frbr'] = 'manifestation' ;
			$intermediate['format'] = $parse['format'] ;
		}	
		break; 
	case 'http://www.legifrance.gouv.fr/': 
		$intermediate['country'] = 'fr' ; 		
		$intermediate['typedoc'] = $parse['typedoc'] ; 
		$intermediate['date'] = $parse['year'].'-'.$parse['month'].'-'.$parse['day'] ;
		if (!contains($parse,'natural_identifier')) {
			$intermediate['number'] = 'nn' ;
		} else {
			$intermediate['number'] = $parse['natural_identifier']  ;			
			if (contains($parse,'rectificatif') || substr($parse['natural_identifier'], -1) === 'Z') {
				$intermediate['number'] = $parse['typedoc'] . '-' . $parse['natural_identifier']  ; 
				$intermediate['typedoc'] = 'rectificatif' ; 
			}
		}
		if (contains($parse,'subelement')) {
			$intermediate['subelement'] = array($parse['subelement'] ) ;
		}			
		if (contains($parse,array('lang','point_in_time', 'origin') )) {
			$intermediate['frbr'] = 'expression' ;
			$intermediate['lang'] = 'und' ;
			if (contains($parse,'lang') ) 
				$intermediate['lang'] = 'fra' ;			
			if (contains($parse,'origin') ) 
				$intermediate['versionAuthor'] = $parse['origin'] ;
			if (contains($parse,'pointintime') ) 
				$intermediate['pointintime'] = $parse['pointintime'] ; 
		}
		if (contains($parse,'format')) {
			$intermediate['frbr'] = 'manifestation' ;
			$intermediate['format'] = $parse['format'] ;
		}
		break; 
	case'http://www.irishstatutebook.ie/': 
//		$map = $maps[$domain] ;
//		return realMap($parse, $maps[$domain]) ;

		//   {domain:http://www.irishstatutebook.ie/}eli/{year:$d4}/{type:$w+}/
		//   {natural_identifier}(/{level1:$subIE})?/{version:$w+}
		//   (/{pointInTime:$date})?/{language:$w2}"
		$intermediate['country'] = 'ie' ; 
		$intermediate['typedoc'] = $parse['type'] ; 
		$intermediate['date'] = $parse['year'] ;
		$intermediate['number'] = $parse['natural_identifier'] ; 
		if (contains($parse,array('language','version','pointInTime') )) {
			$intermediate['frbr'] = 'expression' ;
			$intermediate['lang'] = 'und' ; 
			if (contains($parse,'language') )    $intermediate['lang'] = "eng"  ;
			if (contains($parse,'pointInTime') ) $intermediate['versionDate'] = $parse['pointInTime'] ; 
			if (contains($parse,'version') )     $intermediate['versionString'] = $parse['version'] ; 
		}
		if (contains($parse,'level1')) {
			$intermediate['subelement'] = array(join('_',explode('/',$parse['level1'])));
		}			
		if (contains($parse,'format')) {
			$intermediate['frbr'] = 'manifestation' ;
			$intermediate['format'] = $parse['format'] ;			
		}
		break; 
	case 'http://www.gazzettaufficiale.it/': 
		$intermediate['country'] = 'it' ; 
		if (contains($parse,'typedoc')) {
			$intermediate['typedoc'] = $parse['typedoc'] ; 
			$intermediate['number'] = $parse['natural_number'] ; 
		}
		if (contains($parse,'codiceRedazionale')) {
			$intermediate['number'] = $parse['codiceRedazionale'] ; 
		}
		if (contains($parse,'tipoSerie')) {
			$intermediate['number'] .= '-'. $parse['tipoSerie'] ; 
		}
		if (contains($parse,'art')) {
			$intermediate['subelement'] = 'art_'. $parse['art'] ; 
		}
		$intermediate['date'] = $parse['year'] ; 
		if (contains($parse,'month')) {
			$intermediate['date'] = $parse['year'].'-'.$parse['month'].'-'.$parse['day'] ;
		}		
		break; 
	}
	return $intermediate ; 
}

function realMap($input,$map) {
	$ret = array() ;
	foreach ($map as $key => $value) {
		$changed = false ;
		if (contains($value,'default')) { 
			$ret[$key] = $value['default'] ;
			$changed = true ; 
		}
		if (contains($value,'property') ) {
			if (contains($input,$value['property']) ) {
				if (contains($value,'map')) {
					$val = $input[$value['property']] ;
					foreach ($value['map'] as $v => $l) {
						if (is_array($l) ) {
// p("Looking for $val in [".q($l)."] giving $v") ; 
							if (array_search($val,$l)!==false ) {
								$ret[$key] = $v ;
// p('Found') ; 
								break; 
							}
						} else if ($l === $val) {
							$ret[$key] = $v ; 
							break; 
						} 
					}
				
				} else if (contains($value,'separator')) {
					$ret[$key] = explode($value['separator'],$input[$value['property']]) ;
				} else {
					$ret[$key] = $input[$value['property']] ;
				}
				$changed = true ; 
			}
		}
		if (contains($value,'function') ) {
		}
		if ($changed && contains($value, 'frbr')) {
			$ret['frbr'] = $value['frbr'] ;
		}			
	}	
	return $ret ;
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

?>