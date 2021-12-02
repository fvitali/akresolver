<?PHP
require_once './peg/autoloader.php';
use hafriedlander\Peg\Parser;
class parsingMachine extends Parser\Basic {
/* SL: '/' */
protected $match_SL_typestack = array('SL');
function match_SL ($stack = array()) {
	$matchrule = "SL"; $result = $this->construct($matchrule, $matchrule, null);
	if (substr($this->string,$this->pos,1) == '/') {
		$this->pos += 1;
		$result["text"] .= '/';
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* C: ':' */
protected $match_C_typestack = array('C');
function match_C ($stack = array()) {
	$matchrule = "C"; $result = $this->construct($matchrule, $matchrule, null);
	if (substr($this->string,$this->pos,1) == ':') {
		$this->pos += 1;
		$result["text"] .= ':';
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* number: /[0-9]+/ */
protected $match_number_typestack = array('number');
function match_number ($stack = array()) {
	$matchrule = "number"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->rx( '/[0-9]+/' ) ) !== FALSE) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* number2: /[0-9]{2}/ */
protected $match_number2_typestack = array('number2');
function match_number2 ($stack = array()) {
	$matchrule = "number2"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->rx( '/[0-9]{2}/' ) ) !== FALSE) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* number4: /[0-9]{4}/ */
protected $match_number4_typestack = array('number4');
function match_number4 ($stack = array()) {
	$matchrule = "number4"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->rx( '/[0-9]{4}/' ) ) !== FALSE) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* chars: /[a-zA-Z]+/ */
protected $match_chars_typestack = array('chars');
function match_chars ($stack = array()) {
	$matchrule = "chars"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->rx( '/[a-zA-Z]+/' ) ) !== FALSE) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* any: /.+/ */
protected $match_any_typestack = array('any');
function match_any ($stack = array()) {
	$matchrule = "any"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->rx( '/.+/' ) ) !== FALSE) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* token: chars (number | chars)* */
protected $match_token_typestack = array('token');
function match_token ($stack = array()) {
	$matchrule = "token"; $result = $this->construct($matchrule, $matchrule, null);
	$_15 = NULL;
	do {
		$matcher = 'match_'.'chars'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_15 = FALSE; break; }
		while (true) {
			$res_14 = $result;
			$pos_14 = $this->pos;
			$_13 = NULL;
			do {
				$_11 = NULL;
				do {
					$res_8 = $result;
					$pos_8 = $this->pos;
					$matcher = 'match_'.'number'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres );
						$_11 = TRUE; break;
					}
					$result = $res_8;
					$this->pos = $pos_8;
					$matcher = 'match_'.'chars'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres );
						$_11 = TRUE; break;
					}
					$result = $res_8;
					$this->pos = $pos_8;
					$_11 = FALSE; break;
				}
				while(0);
				if( $_11 === FALSE) { $_13 = FALSE; break; }
				$_13 = TRUE; break;
			}
			while(0);
			if( $_13 === FALSE) {
				$result = $res_14;
				$this->pos = $pos_14;
				unset( $res_14 );
				unset( $pos_14 );
				break;
			}
		}
		$_15 = TRUE; break;
	}
	while(0);
	if( $_15 === TRUE ) { return $this->finalise($result); }
	if( $_15 === FALSE) { return FALSE; }
}


/* string: (number | chars)+ */
protected $match_string_typestack = array('string');
function match_string ($stack = array()) {
	$matchrule = "string"; $result = $this->construct($matchrule, $matchrule, null);
	$count = 0;
	while (true) {
		$res_23 = $result;
		$pos_23 = $this->pos;
		$_22 = NULL;
		do {
			$_20 = NULL;
			do {
				$res_17 = $result;
				$pos_17 = $this->pos;
				$matcher = 'match_'.'number'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$_20 = TRUE; break;
				}
				$result = $res_17;
				$this->pos = $pos_17;
				$matcher = 'match_'.'chars'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$_20 = TRUE; break;
				}
				$result = $res_17;
				$this->pos = $pos_17;
				$_20 = FALSE; break;
			}
			while(0);
			if( $_20 === FALSE) { $_22 = FALSE; break; }
			$_22 = TRUE; break;
		}
		while(0);
		if( $_22 === FALSE) {
			$result = $res_23;
			$this->pos = $pos_23;
			unset( $res_23 );
			unset( $pos_23 );
			break;
		}
		$count++;
	}
	if ($count >= 1) { return $this->finalise($result); }
	else { return FALSE; }
}


/* dashH: recurDash  */
protected $match_dashH_typestack = array('dashH');
function match_dashH ($stack = array()) {
	$matchrule = "dashH"; $result = $this->construct($matchrule, $matchrule, null);
	$matcher = 'match_'.'recurDash'; $key = $matcher; $pos = $this->pos;
	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
	if ($subres !== FALSE) {
		$this->store( $result, $subres );
		return $this->finalise($result);
	}
	else { return FALSE; }
}

public function dashH_recurDash (&$res, $sub) {
		if (count($sub['item'])>1) 
			array_unshift($sub['item'],$sub['text']);
		$res['item'] = $sub['item'];
	}

/* recurDash: item:string '-' a:recurDash | c:string */
protected $match_recurDash_typestack = array('recurDash');
function match_recurDash ($stack = array()) {
	$matchrule = "recurDash"; $result = $this->construct($matchrule, $matchrule, null);
	$_32 = NULL;
	do {
		$res_25 = $result;
		$pos_25 = $this->pos;
		$_29 = NULL;
		do {
			$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "item" );
			}
			else { $_29 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == '-') {
				$this->pos += 1;
				$result["text"] .= '-';
			}
			else { $_29 = FALSE; break; }
			$matcher = 'match_'.'recurDash'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "a" );
			}
			else { $_29 = FALSE; break; }
			$_29 = TRUE; break;
		}
		while(0);
		if( $_29 === TRUE ) { $_32 = TRUE; break; }
		$result = $res_25;
		$this->pos = $pos_25;
		$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "c" );
			$_32 = TRUE; break;
		}
		$result = $res_25;
		$this->pos = $pos_25;
		$_32 = FALSE; break;
	}
	while(0);
	if( $_32 === TRUE ) { return $this->finalise($result); }
	if( $_32 === FALSE) { return FALSE; }
}

public function recurDash_c (&$res, $sub) {
		$res['item'] = array($sub);
	}

public function recurDash_a (&$res, $sub) {
		array_unshift($sub['item'],$res['item']);
		$res['item'] = $sub['item'];
	}

/* dotH: recurDot  */
protected $match_dotH_typestack = array('dotH');
function match_dotH ($stack = array()) {
	$matchrule = "dotH"; $result = $this->construct($matchrule, $matchrule, null);
	$matcher = 'match_'.'recurDot'; $key = $matcher; $pos = $this->pos;
	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
	if ($subres !== FALSE) {
		$this->store( $result, $subres );
		return $this->finalise($result);
	}
	else { return FALSE; }
}

public function dotH_recurDot (&$res, $sub) {
		if (count($sub['item'])>1) 
			array_unshift($sub['item'],$sub['text']);
		$res['item'] = $sub['item'];
	}

/* recurDot: item:string '.' a:recurDot | c:string */
protected $match_recurDot_typestack = array('recurDot');
function match_recurDot ($stack = array()) {
	$matchrule = "recurDot"; $result = $this->construct($matchrule, $matchrule, null);
	$_42 = NULL;
	do {
		$res_35 = $result;
		$pos_35 = $this->pos;
		$_39 = NULL;
		do {
			$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "item" );
			}
			else { $_39 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == '.') {
				$this->pos += 1;
				$result["text"] .= '.';
			}
			else { $_39 = FALSE; break; }
			$matcher = 'match_'.'recurDot'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "a" );
			}
			else { $_39 = FALSE; break; }
			$_39 = TRUE; break;
		}
		while(0);
		if( $_39 === TRUE ) { $_42 = TRUE; break; }
		$result = $res_35;
		$this->pos = $pos_35;
		$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "c" );
			$_42 = TRUE; break;
		}
		$result = $res_35;
		$this->pos = $pos_35;
		$_42 = FALSE; break;
	}
	while(0);
	if( $_42 === TRUE ) { return $this->finalise($result); }
	if( $_42 === FALSE) { return FALSE; }
}

public function recurDot_c (&$res, $sub) {
		$res['item'] = array($sub);
	}

public function recurDot_a (&$res, $sub) {
		array_unshift($sub['item'],$res['item']);
		$res['item'] = $sub['item'];
	}

/* date: dateElements */
protected $match_date_typestack = array('date');
function match_date ($stack = array()) {
	$matchrule = "date"; $result = $this->construct($matchrule, $matchrule, null);
	$matcher = 'match_'.'dateElements'; $key = $matcher; $pos = $this->pos;
	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
	if ($subres !== FALSE) {
		$this->store( $result, $subres );
		return $this->finalise($result);
	}
	else { return FALSE; }
}

public function date_dateElements (&$res, $sub) {
		$res = $sub;
		$res['string'] = $res['text'] ; 
	}

/* dateElements: year:number4 '-' month:number2 '-' day:number2 !number | year:number4 '-' month:number2 !number | year:number4 */
protected $match_dateElements_typestack = array('dateElements');
function match_dateElements ($stack = array()) {
	$matchrule = "dateElements"; $result = $this->construct($matchrule, $matchrule, null);
	$_64 = NULL;
	do {
		$res_45 = $result;
		$pos_45 = $this->pos;
		$_52 = NULL;
		do {
			$matcher = 'match_'.'number4'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "year" );
			}
			else { $_52 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == '-') {
				$this->pos += 1;
				$result["text"] .= '-';
			}
			else { $_52 = FALSE; break; }
			$matcher = 'match_'.'number2'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "month" );
			}
			else { $_52 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == '-') {
				$this->pos += 1;
				$result["text"] .= '-';
			}
			else { $_52 = FALSE; break; }
			$matcher = 'match_'.'number2'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "day" );
			}
			else { $_52 = FALSE; break; }
			$res_51 = $result;
			$pos_51 = $this->pos;
			$matcher = 'match_'.'number'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres );
				$result = $res_51;
				$this->pos = $pos_51;
				$_52 = FALSE; break;
			}
			else {
				$result = $res_51;
				$this->pos = $pos_51;
			}
			$_52 = TRUE; break;
		}
		while(0);
		if( $_52 === TRUE ) { $_64 = TRUE; break; }
		$result = $res_45;
		$this->pos = $pos_45;
		$_62 = NULL;
		do {
			$res_54 = $result;
			$pos_54 = $this->pos;
			$_59 = NULL;
			do {
				$matcher = 'match_'.'number4'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "year" );
				}
				else { $_59 = FALSE; break; }
				if (substr($this->string,$this->pos,1) == '-') {
					$this->pos += 1;
					$result["text"] .= '-';
				}
				else { $_59 = FALSE; break; }
				$matcher = 'match_'.'number2'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "month" );
				}
				else { $_59 = FALSE; break; }
				$res_58 = $result;
				$pos_58 = $this->pos;
				$matcher = 'match_'.'number'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$result = $res_58;
					$this->pos = $pos_58;
					$_59 = FALSE; break;
				}
				else {
					$result = $res_58;
					$this->pos = $pos_58;
				}
				$_59 = TRUE; break;
			}
			while(0);
			if( $_59 === TRUE ) { $_62 = TRUE; break; }
			$result = $res_54;
			$this->pos = $pos_54;
			$matcher = 'match_'.'number4'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "year" );
				$_62 = TRUE; break;
			}
			$result = $res_54;
			$this->pos = $pos_54;
			$_62 = FALSE; break;
		}
		while(0);
		if( $_62 === TRUE ) { $_64 = TRUE; break; }
		$result = $res_45;
		$this->pos = $pos_45;
		$_64 = FALSE; break;
	}
	while(0);
	if( $_64 === TRUE ) { return $this->finalise($result); }
	if( $_64 === FALSE) { return FALSE; }
}


/* Expr: > :uri > extra:any? > | extra:any */
protected $match_Expr_typestack = array('Expr');
function match_Expr ($stack = array()) {
	$matchrule = "Expr"; $result = $this->construct($matchrule, $matchrule, null);
	$_75 = NULL;
	do {
		$res_66 = $result;
		$pos_66 = $this->pos;
		$_72 = NULL;
		do {
			if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
			$matcher = 'match_'.'uri'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "uri" );
			}
			else { $_72 = FALSE; break; }
			if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
			$res_70 = $result;
			$pos_70 = $this->pos;
			$matcher = 'match_'.'any'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "extra" );
			}
			else {
				$result = $res_70;
				$this->pos = $pos_70;
				unset( $res_70 );
				unset( $pos_70 );
			}
			if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
			$_72 = TRUE; break;
		}
		while(0);
		if( $_72 === TRUE ) { $_75 = TRUE; break; }
		$result = $res_66;
		$this->pos = $pos_66;
		$matcher = 'match_'.'any'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "extra" );
			$_75 = TRUE; break;
		}
		$result = $res_66;
		$this->pos = $pos_66;
		$_75 = FALSE; break;
	}
	while(0);
	if( $_75 === TRUE ) { return $this->finalise($result); }
	if( $_75 === FALSE) { return FALSE; }
}


/* uri: SL? w:Work (SL e:Expression (m:Manifestation)? )? */
protected $match_uri_typestack = array('uri');
function match_uri ($stack = array()) {
	$matchrule = "uri"; $result = $this->construct($matchrule, $matchrule, null);
	$_86 = NULL;
	do {
		$res_77 = $result;
		$pos_77 = $this->pos;
		$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else {
			$result = $res_77;
			$this->pos = $pos_77;
			unset( $res_77 );
			unset( $pos_77 );
		}
		$matcher = 'match_'.'Work'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "w" );
		}
		else { $_86 = FALSE; break; }
		$res_85 = $result;
		$pos_85 = $this->pos;
		$_84 = NULL;
		do {
			$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_84 = FALSE; break; }
			$matcher = 'match_'.'Expression'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "e" );
			}
			else { $_84 = FALSE; break; }
			$res_83 = $result;
			$pos_83 = $this->pos;
			$_82 = NULL;
			do {
				$matcher = 'match_'.'Manifestation'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "m" );
				}
				else { $_82 = FALSE; break; }
				$_82 = TRUE; break;
			}
			while(0);
			if( $_82 === FALSE) {
				$result = $res_83;
				$this->pos = $pos_83;
				unset( $res_83 );
				unset( $pos_83 );
			}
			$_84 = TRUE; break;
		}
		while(0);
		if( $_84 === FALSE) {
			$result = $res_85;
			$this->pos = $pos_85;
			unset( $res_85 );
			unset( $pos_85 );
		}
		$_86 = TRUE; break;
	}
	while(0);
	if( $_86 === TRUE ) { return $this->finalise($result); }
	if( $_86 === FALSE) { return FALSE; }
}

public function uri_STR (&$res, $sub) {
		if (!isset($res['parts'])) $res['parts'] = array() ;
		$res['parts'] =array_merge($res['parts'],$sub) ;
	}

/* Work: 
	worktype:ecli C
	jurisdiction:dashH C
	workactor:dashH C
	workDate:date C
	workNumber:dotH */
protected $match_Work_typestack = array('Work');
function match_Work ($stack = array()) {
	$matchrule = "Work"; $result = $this->construct($matchrule, $matchrule, null);
	$_97 = NULL;
	do {
		$matcher = 'match_'.'ecli'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "worktype" );
		}
		else { $_97 = FALSE; break; }
		$matcher = 'match_'.'C'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_97 = FALSE; break; }
		$matcher = 'match_'.'dashH'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "jurisdiction" );
		}
		else { $_97 = FALSE; break; }
		$matcher = 'match_'.'C'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_97 = FALSE; break; }
		$matcher = 'match_'.'dashH'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "workactor" );
		}
		else { $_97 = FALSE; break; }
		$matcher = 'match_'.'C'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_97 = FALSE; break; }
		$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "workDate" );
		}
		else { $_97 = FALSE; break; }
		$matcher = 'match_'.'C'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_97 = FALSE; break; }
		$matcher = 'match_'.'dotH'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "workNumber" );
		}
		else { $_97 = FALSE; break; }
		$_97 = TRUE; break;
	}
	while(0);
	if( $_97 === TRUE ) { return $this->finalise($result); }
	if( $_97 === FALSE) { return FALSE; }
}


/* Expression: 
	lang:dashH 
	( 
		'@' :version | 
		':' :view 
	)(
		';' exprSource:token 
		(SL exprDate:date)?
	)? */
protected $match_Expression_typestack = array('Expression');
function match_Expression ($stack = array()) {
	$matchrule = "Expression"; $result = $this->construct($matchrule, $matchrule, null);
	$_121 = NULL;
	do {
		$matcher = 'match_'.'dashH'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "lang" );
		}
		else { $_121 = FALSE; break; }
		$_111 = NULL;
		do {
			$_109 = NULL;
			do {
				$res_100 = $result;
				$pos_100 = $this->pos;
				$_103 = NULL;
				do {
					if (substr($this->string,$this->pos,1) == '@') {
						$this->pos += 1;
						$result["text"] .= '@';
					}
					else { $_103 = FALSE; break; }
					$matcher = 'match_'.'version'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "version" );
					}
					else { $_103 = FALSE; break; }
					$_103 = TRUE; break;
				}
				while(0);
				if( $_103 === TRUE ) { $_109 = TRUE; break; }
				$result = $res_100;
				$this->pos = $pos_100;
				$_107 = NULL;
				do {
					if (substr($this->string,$this->pos,1) == ':') {
						$this->pos += 1;
						$result["text"] .= ':';
					}
					else { $_107 = FALSE; break; }
					$matcher = 'match_'.'view'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "view" );
					}
					else { $_107 = FALSE; break; }
					$_107 = TRUE; break;
				}
				while(0);
				if( $_107 === TRUE ) { $_109 = TRUE; break; }
				$result = $res_100;
				$this->pos = $pos_100;
				$_109 = FALSE; break;
			}
			while(0);
			if( $_109 === FALSE) { $_111 = FALSE; break; }
			$_111 = TRUE; break;
		}
		while(0);
		if( $_111 === FALSE) { $_121 = FALSE; break; }
		$res_120 = $result;
		$pos_120 = $this->pos;
		$_119 = NULL;
		do {
			if (substr($this->string,$this->pos,1) == ';') {
				$this->pos += 1;
				$result["text"] .= ';';
			}
			else { $_119 = FALSE; break; }
			$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "exprSource" );
			}
			else { $_119 = FALSE; break; }
			$res_118 = $result;
			$pos_118 = $this->pos;
			$_117 = NULL;
			do {
				$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_117 = FALSE; break; }
				$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "exprDate" );
				}
				else { $_117 = FALSE; break; }
				$_117 = TRUE; break;
			}
			while(0);
			if( $_117 === FALSE) {
				$result = $res_118;
				$this->pos = $pos_118;
				unset( $res_118 );
				unset( $pos_118 );
			}
			$_119 = TRUE; break;
		}
		while(0);
		if( $_119 === FALSE) {
			$result = $res_120;
			$this->pos = $pos_120;
			unset( $res_120 );
			unset( $pos_120 );
		}
		$_121 = TRUE; break;
	}
	while(0);
	if( $_121 === TRUE ) { return $this->finalise($result); }
	if( $_121 === FALSE) { return FALSE; }
}


/* Manifestation: 
	(SL manifSource:token)? 
	(SL exprDate:date)? 
	'.' format:token */
protected $match_Manifestation_typestack = array('Manifestation');
function match_Manifestation ($stack = array()) {
	$matchrule = "Manifestation"; $result = $this->construct($matchrule, $matchrule, null);
	$_133 = NULL;
	do {
		$res_126 = $result;
		$pos_126 = $this->pos;
		$_125 = NULL;
		do {
			$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_125 = FALSE; break; }
			$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "manifSource" );
			}
			else { $_125 = FALSE; break; }
			$_125 = TRUE; break;
		}
		while(0);
		if( $_125 === FALSE) {
			$result = $res_126;
			$this->pos = $pos_126;
			unset( $res_126 );
			unset( $pos_126 );
		}
		$res_130 = $result;
		$pos_130 = $this->pos;
		$_129 = NULL;
		do {
			$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_129 = FALSE; break; }
			$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "exprDate" );
			}
			else { $_129 = FALSE; break; }
			$_129 = TRUE; break;
		}
		while(0);
		if( $_129 === FALSE) {
			$result = $res_130;
			$this->pos = $pos_130;
			unset( $res_130 );
			unset( $pos_130 );
		}
		if (substr($this->string,$this->pos,1) == '.') {
			$this->pos += 1;
			$result["text"] .= '.';
		}
		else { $_133 = FALSE; break; }
		$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "format" );
		}
		else { $_133 = FALSE; break; }
		$_133 = TRUE; break;
	}
	while(0);
	if( $_133 === TRUE ) { return $this->finalise($result); }
	if( $_133 === FALSE) { return FALSE; }
}

public function Manifestation_format ( &$res, $sub ) { $res['format'] = array($sub) ;}

/* version: date:date '-' number:string | date:date | number:string | today:"" */
protected $match_version_typestack = array('version');
function match_version ($stack = array()) {
	$matchrule = "version"; $result = $this->construct($matchrule, $matchrule, null);
	$_150 = NULL;
	do {
		$res_135 = $result;
		$pos_135 = $this->pos;
		$_139 = NULL;
		do {
			$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "date" );
			}
			else { $_139 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == '-') {
				$this->pos += 1;
				$result["text"] .= '-';
			}
			else { $_139 = FALSE; break; }
			$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "number" );
			}
			else { $_139 = FALSE; break; }
			$_139 = TRUE; break;
		}
		while(0);
		if( $_139 === TRUE ) { $_150 = TRUE; break; }
		$result = $res_135;
		$this->pos = $pos_135;
		$_148 = NULL;
		do {
			$res_141 = $result;
			$pos_141 = $this->pos;
			$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "date" );
				$_148 = TRUE; break;
			}
			$result = $res_141;
			$this->pos = $pos_141;
			$_146 = NULL;
			do {
				$res_143 = $result;
				$pos_143 = $this->pos;
				$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "number" );
					$_146 = TRUE; break;
				}
				$result = $res_143;
				$this->pos = $pos_143;
				$stack[] = $result; $result = $this->construct( $matchrule, "today" ); 
				if (( $subres = $this->literal( '' ) ) !== FALSE) {
					$result["text"] .= $subres;
					$subres = $result; $result = array_pop($stack);
					$this->store( $result, $subres, 'today' );
					$_146 = TRUE; break;
				}
				else { $result = array_pop($stack); }
				$result = $res_143;
				$this->pos = $pos_143;
				$_146 = FALSE; break;
			}
			while(0);
			if( $_146 === TRUE ) { $_148 = TRUE; break; }
			$result = $res_141;
			$this->pos = $pos_141;
			$_148 = FALSE; break;
		}
		while(0);
		if( $_148 === TRUE ) { $_150 = TRUE; break; }
		$result = $res_135;
		$this->pos = $pos_135;
		$_150 = FALSE; break;
	}
	while(0);
	if( $_150 === TRUE ) { return $this->finalise($result); }
	if( $_150 === FALSE) { return FALSE; }
}

public function version_today ( &$res, $sub ) { $res['date'] = 'TODAY' ;}

/* view: range:range | date:date | today:"" */
protected $match_view_typestack = array('view');
function match_view ($stack = array()) {
	$matchrule = "view"; $result = $this->construct($matchrule, $matchrule, null);
	$_159 = NULL;
	do {
		$res_152 = $result;
		$pos_152 = $this->pos;
		$matcher = 'match_'.'range'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "range" );
			$_159 = TRUE; break;
		}
		$result = $res_152;
		$this->pos = $pos_152;
		$_157 = NULL;
		do {
			$res_154 = $result;
			$pos_154 = $this->pos;
			$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "date" );
				$_157 = TRUE; break;
			}
			$result = $res_154;
			$this->pos = $pos_154;
			$stack[] = $result; $result = $this->construct( $matchrule, "today" ); 
			if (( $subres = $this->literal( '' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'today' );
				$_157 = TRUE; break;
			}
			else { $result = array_pop($stack); }
			$result = $res_154;
			$this->pos = $pos_154;
			$_157 = FALSE; break;
		}
		while(0);
		if( $_157 === TRUE ) { $_159 = TRUE; break; }
		$result = $res_152;
		$this->pos = $pos_152;
		$_159 = FALSE; break;
	}
	while(0);
	if( $_159 === TRUE ) { return $this->finalise($result); }
	if( $_159 === FALSE) { return FALSE; }
}

public function view_today ( &$res, $sub ) { $res['date'] = 'TODAY' ;}

/* range: from:date '-' to:date  */
protected $match_range_typestack = array('range');
function match_range ($stack = array()) {
	$matchrule = "range"; $result = $this->construct($matchrule, $matchrule, null);
	$_164 = NULL;
	do {
		$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "from" );
		}
		else { $_164 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '-') {
			$this->pos += 1;
			$result["text"] .= '-';
		}
		else { $_164 = FALSE; break; }
		$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "to" );
		}
		else { $_164 = FALSE; break; }
		$_164 = TRUE; break;
	}
	while(0);
	if( $_164 === TRUE ) { return $this->finalise($result); }
	if( $_164 === FALSE) { return FALSE; }
}


/* ecli: e:'ECLI' */
protected $match_ecli_typestack = array('ecli');
function match_ecli ($stack = array()) {
	$matchrule = "ecli"; $result = $this->construct($matchrule, $matchrule, null);
	$stack[] = $result; $result = $this->construct( $matchrule, "e" ); 
	if (( $subres = $this->literal( 'ECLI' ) ) !== FALSE) {
		$result["text"] .= $subres;
		$subres = $result; $result = array_pop($stack);
		$this->store( $result, $subres, 'e' );
		return $this->finalise($result);
	}
	else {
		$result = array_pop($stack);
		return FALSE;
	}
}

public function ecli_e ( &$res, $sub ) {
		$res['text'] = 'judgment' ; 		
	}


}
?>