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


/* chars: /[a-zA-Z_]+/ */
protected $match_chars_typestack = array('chars');
function match_chars ($stack = array()) {
	$matchrule = "chars"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->rx( '/[a-zA-Z_]+/' ) ) !== FALSE) {
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
	$_14 = NULL;
	do {
		$matcher = 'match_'.'chars'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_14 = FALSE; break; }
		while (true) {
			$res_13 = $result;
			$pos_13 = $this->pos;
			$_12 = NULL;
			do {
				$_10 = NULL;
				do {
					$res_7 = $result;
					$pos_7 = $this->pos;
					$matcher = 'match_'.'number'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres );
						$_10 = TRUE; break;
					}
					$result = $res_7;
					$this->pos = $pos_7;
					$matcher = 'match_'.'chars'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres );
						$_10 = TRUE; break;
					}
					$result = $res_7;
					$this->pos = $pos_7;
					$_10 = FALSE; break;
				}
				while(0);
				if( $_10 === FALSE) { $_12 = FALSE; break; }
				$_12 = TRUE; break;
			}
			while(0);
			if( $_12 === FALSE) {
				$result = $res_13;
				$this->pos = $pos_13;
				unset( $res_13 );
				unset( $pos_13 );
				break;
			}
		}
		$_14 = TRUE; break;
	}
	while(0);
	if( $_14 === TRUE ) { return $this->finalise($result); }
	if( $_14 === FALSE) { return FALSE; }
}


/* string: (number | chars)+ */
protected $match_string_typestack = array('string');
function match_string ($stack = array()) {
	$matchrule = "string"; $result = $this->construct($matchrule, $matchrule, null);
	$count = 0;
	while (true) {
		$res_22 = $result;
		$pos_22 = $this->pos;
		$_21 = NULL;
		do {
			$_19 = NULL;
			do {
				$res_16 = $result;
				$pos_16 = $this->pos;
				$matcher = 'match_'.'number'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$_19 = TRUE; break;
				}
				$result = $res_16;
				$this->pos = $pos_16;
				$matcher = 'match_'.'chars'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$_19 = TRUE; break;
				}
				$result = $res_16;
				$this->pos = $pos_16;
				$_19 = FALSE; break;
			}
			while(0);
			if( $_19 === FALSE) { $_21 = FALSE; break; }
			$_21 = TRUE; break;
		}
		while(0);
		if( $_21 === FALSE) {
			$result = $res_22;
			$this->pos = $pos_22;
			unset( $res_22 );
			unset( $pos_22 );
			break;
		}
		$count++;
	}
	if ($count >= 1) { return $this->finalise($result); }
	else { return FALSE; }
}


/* dashHier: dashRecur  */
protected $match_dashHier_typestack = array('dashHier');
function match_dashHier ($stack = array()) {
	$matchrule = "dashHier"; $result = $this->construct($matchrule, $matchrule, null);
	$matcher = 'match_'.'dashRecur'; $key = $matcher; $pos = $this->pos;
	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
	if ($subres !== FALSE) {
		$this->store( $result, $subres );
		return $this->finalise($result);
	}
	else { return FALSE; }
}

public function dashHier_dashRecur (&$res, $sub) {
		if (count($sub['item'])>1) 
			array_unshift($sub['item'],$sub['text']);
		$res['item'] = $sub['item'];
	}

/* dashRecur: item:string '-' a:dashRecur | c:string */
protected $match_dashRecur_typestack = array('dashRecur');
function match_dashRecur ($stack = array()) {
	$matchrule = "dashRecur"; $result = $this->construct($matchrule, $matchrule, null);
	$_31 = NULL;
	do {
		$res_24 = $result;
		$pos_24 = $this->pos;
		$_28 = NULL;
		do {
			$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "item" );
			}
			else { $_28 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == '-') {
				$this->pos += 1;
				$result["text"] .= '-';
			}
			else { $_28 = FALSE; break; }
			$matcher = 'match_'.'dashRecur'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "a" );
			}
			else { $_28 = FALSE; break; }
			$_28 = TRUE; break;
		}
		while(0);
		if( $_28 === TRUE ) { $_31 = TRUE; break; }
		$result = $res_24;
		$this->pos = $pos_24;
		$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "c" );
			$_31 = TRUE; break;
		}
		$result = $res_24;
		$this->pos = $pos_24;
		$_31 = FALSE; break;
	}
	while(0);
	if( $_31 === TRUE ) { return $this->finalise($result); }
	if( $_31 === FALSE) { return FALSE; }
}

public function dashRecur_c (&$res, $sub) {
		$res['item'] = array($sub);
	}

public function dashRecur_a (&$res, $sub) {
		array_unshift($sub['item'],$res['item']);
		$res['item'] = $sub['item'];
	}

/* slashHier: slashRecur  */
protected $match_slashHier_typestack = array('slashHier');
function match_slashHier ($stack = array()) {
	$matchrule = "slashHier"; $result = $this->construct($matchrule, $matchrule, null);
	$matcher = 'match_'.'slashRecur'; $key = $matcher; $pos = $this->pos;
	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
	if ($subres !== FALSE) {
		$this->store( $result, $subres );
		return $this->finalise($result);
	}
	else { return FALSE; }
}

public function slashHier_slashRecur (&$res, $sub) {
		if (count($sub['item'])>1) 
			array_unshift($sub['item'],$sub['text']);
		$res['item'] = $sub['item'];
	}

/* slashRecur: item:string SL a:slashRecur | c:string */
protected $match_slashRecur_typestack = array('slashRecur');
function match_slashRecur ($stack = array()) {
	$matchrule = "slashRecur"; $result = $this->construct($matchrule, $matchrule, null);
	$_41 = NULL;
	do {
		$res_34 = $result;
		$pos_34 = $this->pos;
		$_38 = NULL;
		do {
			$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "item" );
			}
			else { $_38 = FALSE; break; }
			$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_38 = FALSE; break; }
			$matcher = 'match_'.'slashRecur'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "a" );
			}
			else { $_38 = FALSE; break; }
			$_38 = TRUE; break;
		}
		while(0);
		if( $_38 === TRUE ) { $_41 = TRUE; break; }
		$result = $res_34;
		$this->pos = $pos_34;
		$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "c" );
			$_41 = TRUE; break;
		}
		$result = $res_34;
		$this->pos = $pos_34;
		$_41 = FALSE; break;
	}
	while(0);
	if( $_41 === TRUE ) { return $this->finalise($result); }
	if( $_41 === FALSE) { return FALSE; }
}

public function slashRecur_c (&$res, $sub) {
		$res['item'] = array($sub);
	}

public function slashRecur_a (&$res, $sub) {
		array_unshift($sub['item'],$res['item']);
		$res['item'] = $sub['item'];
	}

/* date: dateElements | stringDate */
protected $match_date_typestack = array('date');
function match_date ($stack = array()) {
	$matchrule = "date"; $result = $this->construct($matchrule, $matchrule, null);
	$_46 = NULL;
	do {
		$res_43 = $result;
		$pos_43 = $this->pos;
		$matcher = 'match_'.'dateElements'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres );
			$_46 = TRUE; break;
		}
		$result = $res_43;
		$this->pos = $pos_43;
		$matcher = 'match_'.'stringDate'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres );
			$_46 = TRUE; break;
		}
		$result = $res_43;
		$this->pos = $pos_43;
		$_46 = FALSE; break;
	}
	while(0);
	if( $_46 === TRUE ) { return $this->finalise($result); }
	if( $_46 === FALSE) { return FALSE; }
}

public function date_dateElements (&$res, $sub) {
		$res = $sub;
		$res['string'] = $res['text'] ; 
	}

/* dateElements: year:number4 '-' month:number2 '-' day:number2 !number | year:number4 '-' month:number2 !number | year:number4 */
protected $match_dateElements_typestack = array('dateElements');
function match_dateElements ($stack = array()) {
	$matchrule = "dateElements"; $result = $this->construct($matchrule, $matchrule, null);
	$_67 = NULL;
	do {
		$res_48 = $result;
		$pos_48 = $this->pos;
		$_55 = NULL;
		do {
			$matcher = 'match_'.'number4'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "year" );
			}
			else { $_55 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == '-') {
				$this->pos += 1;
				$result["text"] .= '-';
			}
			else { $_55 = FALSE; break; }
			$matcher = 'match_'.'number2'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "month" );
			}
			else { $_55 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == '-') {
				$this->pos += 1;
				$result["text"] .= '-';
			}
			else { $_55 = FALSE; break; }
			$matcher = 'match_'.'number2'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "day" );
			}
			else { $_55 = FALSE; break; }
			$res_54 = $result;
			$pos_54 = $this->pos;
			$matcher = 'match_'.'number'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres );
				$result = $res_54;
				$this->pos = $pos_54;
				$_55 = FALSE; break;
			}
			else {
				$result = $res_54;
				$this->pos = $pos_54;
			}
			$_55 = TRUE; break;
		}
		while(0);
		if( $_55 === TRUE ) { $_67 = TRUE; break; }
		$result = $res_48;
		$this->pos = $pos_48;
		$_65 = NULL;
		do {
			$res_57 = $result;
			$pos_57 = $this->pos;
			$_62 = NULL;
			do {
				$matcher = 'match_'.'number4'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "year" );
				}
				else { $_62 = FALSE; break; }
				if (substr($this->string,$this->pos,1) == '-') {
					$this->pos += 1;
					$result["text"] .= '-';
				}
				else { $_62 = FALSE; break; }
				$matcher = 'match_'.'number2'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "month" );
				}
				else { $_62 = FALSE; break; }
				$res_61 = $result;
				$pos_61 = $this->pos;
				$matcher = 'match_'.'number'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$result = $res_61;
					$this->pos = $pos_61;
					$_62 = FALSE; break;
				}
				else {
					$result = $res_61;
					$this->pos = $pos_61;
				}
				$_62 = TRUE; break;
			}
			while(0);
			if( $_62 === TRUE ) { $_65 = TRUE; break; }
			$result = $res_57;
			$this->pos = $pos_57;
			$matcher = 'match_'.'number4'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "year" );
				$_65 = TRUE; break;
			}
			$result = $res_57;
			$this->pos = $pos_57;
			$_65 = FALSE; break;
		}
		while(0);
		if( $_65 === TRUE ) { $_67 = TRUE; break; }
		$result = $res_48;
		$this->pos = $pos_48;
		$_67 = FALSE; break;
	}
	while(0);
	if( $_67 === TRUE ) { return $this->finalise($result); }
	if( $_67 === FALSE) { return FALSE; }
}


/* stringDate: year:chars '-' month:chars '-' day:chars */
protected $match_stringDate_typestack = array('stringDate');
function match_stringDate ($stack = array()) {
	$matchrule = "stringDate"; $result = $this->construct($matchrule, $matchrule, null);
	$_74 = NULL;
	do {
		$matcher = 'match_'.'chars'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "year" );
		}
		else { $_74 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '-') {
			$this->pos += 1;
			$result["text"] .= '-';
		}
		else { $_74 = FALSE; break; }
		$matcher = 'match_'.'chars'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "month" );
		}
		else { $_74 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '-') {
			$this->pos += 1;
			$result["text"] .= '-';
		}
		else { $_74 = FALSE; break; }
		$matcher = 'match_'.'chars'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "day" );
		}
		else { $_74 = FALSE; break; }
		$_74 = TRUE; break;
	}
	while(0);
	if( $_74 === TRUE ) { return $this->finalise($result); }
	if( $_74 === FALSE) { return FALSE; }
}


/* expr: > :uri > extra:any? > | extra:any */
protected $match_expr_typestack = array('expr');
function match_expr ($stack = array()) {
	$matchrule = "expr"; $result = $this->construct($matchrule, $matchrule, null);
	$_85 = NULL;
	do {
		$res_76 = $result;
		$pos_76 = $this->pos;
		$_82 = NULL;
		do {
			if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
			$matcher = 'match_'.'uri'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "uri" );
			}
			else { $_82 = FALSE; break; }
			if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
			$res_80 = $result;
			$pos_80 = $this->pos;
			$matcher = 'match_'.'any'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "extra" );
			}
			else {
				$result = $res_80;
				$this->pos = $pos_80;
				unset( $res_80 );
				unset( $pos_80 );
			}
			if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
			$_82 = TRUE; break;
		}
		while(0);
		if( $_82 === TRUE ) { $_85 = TRUE; break; }
		$result = $res_76;
		$this->pos = $pos_76;
		$matcher = 'match_'.'any'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "extra" );
			$_85 = TRUE; break;
		}
		$result = $res_76;
		$this->pos = $pos_76;
		$_85 = FALSE; break;
	}
	while(0);
	if( $_85 === TRUE ) { return $this->finalise($result); }
	if( $_85 === FALSE) { return FALSE; }
}


/* uri: scheme? work expression manifestation? component? fragment? format | scheme? work expression? component? fragment?  */
protected $match_uri_typestack = array('uri');
function match_uri ($stack = array()) {
	$matchrule = "uri"; $result = $this->construct($matchrule, $matchrule, null);
	$_104 = NULL;
	do {
		$res_87 = $result;
		$pos_87 = $this->pos;
		$_95 = NULL;
		do {
			$res_88 = $result;
			$pos_88 = $this->pos;
			$matcher = 'match_'.'scheme'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else {
				$result = $res_88;
				$this->pos = $pos_88;
				unset( $res_88 );
				unset( $pos_88 );
			}
			$matcher = 'match_'.'work'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_95 = FALSE; break; }
			$matcher = 'match_'.'expression'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_95 = FALSE; break; }
			$res_91 = $result;
			$pos_91 = $this->pos;
			$matcher = 'match_'.'manifestation'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else {
				$result = $res_91;
				$this->pos = $pos_91;
				unset( $res_91 );
				unset( $pos_91 );
			}
			$res_92 = $result;
			$pos_92 = $this->pos;
			$matcher = 'match_'.'component'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else {
				$result = $res_92;
				$this->pos = $pos_92;
				unset( $res_92 );
				unset( $pos_92 );
			}
			$res_93 = $result;
			$pos_93 = $this->pos;
			$matcher = 'match_'.'fragment'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else {
				$result = $res_93;
				$this->pos = $pos_93;
				unset( $res_93 );
				unset( $pos_93 );
			}
			$matcher = 'match_'.'format'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_95 = FALSE; break; }
			$_95 = TRUE; break;
		}
		while(0);
		if( $_95 === TRUE ) { $_104 = TRUE; break; }
		$result = $res_87;
		$this->pos = $pos_87;
		$_102 = NULL;
		do {
			$res_97 = $result;
			$pos_97 = $this->pos;
			$matcher = 'match_'.'scheme'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else {
				$result = $res_97;
				$this->pos = $pos_97;
				unset( $res_97 );
				unset( $pos_97 );
			}
			$matcher = 'match_'.'work'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_102 = FALSE; break; }
			$res_99 = $result;
			$pos_99 = $this->pos;
			$matcher = 'match_'.'expression'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else {
				$result = $res_99;
				$this->pos = $pos_99;
				unset( $res_99 );
				unset( $pos_99 );
			}
			$res_100 = $result;
			$pos_100 = $this->pos;
			$matcher = 'match_'.'component'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else {
				$result = $res_100;
				$this->pos = $pos_100;
				unset( $res_100 );
				unset( $pos_100 );
			}
			$res_101 = $result;
			$pos_101 = $this->pos;
			$matcher = 'match_'.'fragment'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else {
				$result = $res_101;
				$this->pos = $pos_101;
				unset( $res_101 );
				unset( $pos_101 );
			}
			$_102 = TRUE; break;
		}
		while(0);
		if( $_102 === TRUE ) { $_104 = TRUE; break; }
		$result = $res_87;
		$this->pos = $pos_87;
		$_104 = FALSE; break;
	}
	while(0);
	if( $_104 === TRUE ) { return $this->finalise($result); }
	if( $_104 === FALSE) { return FALSE; }
}

public function uri_STR (&$res, $sub) {
		if (!isset($res['parts'])) $res['parts'] = array() ;
		$res['parts'] =array_merge($res['parts'],$sub) ;
	}

/* scheme: SL? 'akn' */
protected $match_scheme_typestack = array('scheme');
function match_scheme ($stack = array()) {
	$matchrule = "scheme"; $result = $this->construct($matchrule, $matchrule, null);
	$_108 = NULL;
	do {
		$res_106 = $result;
		$pos_106 = $this->pos;
		$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else {
			$result = $res_106;
			$this->pos = $pos_106;
			unset( $res_106 );
			unset( $pos_106 );
		}
		if (( $subres = $this->literal( 'akn' ) ) !== FALSE) { $result["text"] .= $subres; }
		else { $_108 = FALSE; break; }
		$_108 = TRUE; break;
	}
	while(0);
	if( $_108 === TRUE ) { return $this->finalise($result); }
	if( $_108 === FALSE) { return FALSE; }
}


/* work: SL?
	jurisdiction:dashHier SL 
	worktype:token SL 
	((worksubtype:dashHier SL workactor:dashHier SL workDate:date SL workNumber: dashHier) |
	(worksubtype:dashHier SL workDate:date SL workNumber: dashHier) |
	(workDate:date SL workNumber: dashHier)) */
protected $match_work_typestack = array('work');
function match_work ($stack = array()) {
	$matchrule = "work"; $result = $this->construct($matchrule, $matchrule, null);
	$_144 = NULL;
	do {
		$res_110 = $result;
		$pos_110 = $this->pos;
		$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else {
			$result = $res_110;
			$this->pos = $pos_110;
			unset( $res_110 );
			unset( $pos_110 );
		}
		$matcher = 'match_'.'dashHier'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "jurisdiction" );
		}
		else { $_144 = FALSE; break; }
		$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_144 = FALSE; break; }
		$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "worktype" );
		}
		else { $_144 = FALSE; break; }
		$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_144 = FALSE; break; }
		$_142 = NULL;
		do {
			$_140 = NULL;
			do {
				$res_115 = $result;
				$pos_115 = $this->pos;
				$_123 = NULL;
				do {
					$matcher = 'match_'.'dashHier'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "worksubtype" );
					}
					else { $_123 = FALSE; break; }
					$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) { $this->store( $result, $subres ); }
					else { $_123 = FALSE; break; }
					$matcher = 'match_'.'dashHier'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "workactor" );
					}
					else { $_123 = FALSE; break; }
					$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) { $this->store( $result, $subres ); }
					else { $_123 = FALSE; break; }
					$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "workDate" );
					}
					else { $_123 = FALSE; break; }
					$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) { $this->store( $result, $subres ); }
					else { $_123 = FALSE; break; }
					$matcher = 'match_'.'dashHier'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "workNumber" );
					}
					else { $_123 = FALSE; break; }
					$_123 = TRUE; break;
				}
				while(0);
				if( $_123 === TRUE ) { $_140 = TRUE; break; }
				$result = $res_115;
				$this->pos = $pos_115;
				$_138 = NULL;
				do {
					$res_125 = $result;
					$pos_125 = $this->pos;
					$_131 = NULL;
					do {
						$matcher = 'match_'.'dashHier'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres, "worksubtype" );
						}
						else { $_131 = FALSE; break; }
						$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres );
						}
						else { $_131 = FALSE; break; }
						$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres, "workDate" );
						}
						else { $_131 = FALSE; break; }
						$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres );
						}
						else { $_131 = FALSE; break; }
						$matcher = 'match_'.'dashHier'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres, "workNumber" );
						}
						else { $_131 = FALSE; break; }
						$_131 = TRUE; break;
					}
					while(0);
					if( $_131 === TRUE ) { $_138 = TRUE; break; }
					$result = $res_125;
					$this->pos = $pos_125;
					$_136 = NULL;
					do {
						$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres, "workDate" );
						}
						else { $_136 = FALSE; break; }
						$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres );
						}
						else { $_136 = FALSE; break; }
						$matcher = 'match_'.'dashHier'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres, "workNumber" );
						}
						else { $_136 = FALSE; break; }
						$_136 = TRUE; break;
					}
					while(0);
					if( $_136 === TRUE ) { $_138 = TRUE; break; }
					$result = $res_125;
					$this->pos = $pos_125;
					$_138 = FALSE; break;
				}
				while(0);
				if( $_138 === TRUE ) { $_140 = TRUE; break; }
				$result = $res_115;
				$this->pos = $pos_115;
				$_140 = FALSE; break;
			}
			while(0);
			if( $_140 === FALSE) { $_142 = FALSE; break; }
			$_142 = TRUE; break;
		}
		while(0);
		if( $_142 === FALSE) { $_144 = FALSE; break; }
		$_144 = TRUE; break;
	}
	while(0);
	if( $_144 === TRUE ) { return $this->finalise($result); }
	if( $_144 === FALSE) { return FALSE; }
}


/* expression: 
	SL lang:dashHier 
	( 
		'@' (versDate:date '-' versPhase:string | versDate:date | versPhase:string | today:"") | 
		':' (viewRange:range | viewDate:date | today:"") 
	)(
		(SL exprSource:token)? 
		SL exprDate:date
	)? */
protected $match_expression_typestack = array('expression');
function match_expression ($stack = array()) {
	$matchrule = "expression"; $result = $this->construct($matchrule, $matchrule, null);
	$_197 = NULL;
	do {
		$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_197 = FALSE; break; }
		$matcher = 'match_'.'dashHier'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "lang" );
		}
		else { $_197 = FALSE; break; }
		$_187 = NULL;
		do {
			$_185 = NULL;
			do {
				$res_148 = $result;
				$pos_148 = $this->pos;
				$_169 = NULL;
				do {
					if (substr($this->string,$this->pos,1) == '@') {
						$this->pos += 1;
						$result["text"] .= '@';
					}
					else { $_169 = FALSE; break; }
					$_167 = NULL;
					do {
						$_165 = NULL;
						do {
							$res_150 = $result;
							$pos_150 = $this->pos;
							$_154 = NULL;
							do {
								$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
								$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
								if ($subres !== FALSE) {
									$this->store( $result, $subres, "versDate" );
								}
								else { $_154 = FALSE; break; }
								if (substr($this->string,$this->pos,1) == '-') {
									$this->pos += 1;
									$result["text"] .= '-';
								}
								else { $_154 = FALSE; break; }
								$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
								$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
								if ($subres !== FALSE) {
									$this->store( $result, $subres, "versPhase" );
								}
								else { $_154 = FALSE; break; }
								$_154 = TRUE; break;
							}
							while(0);
							if( $_154 === TRUE ) { $_165 = TRUE; break; }
							$result = $res_150;
							$this->pos = $pos_150;
							$_163 = NULL;
							do {
								$res_156 = $result;
								$pos_156 = $this->pos;
								$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
								$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
								if ($subres !== FALSE) {
									$this->store( $result, $subres, "versDate" );
									$_163 = TRUE; break;
								}
								$result = $res_156;
								$this->pos = $pos_156;
								$_161 = NULL;
								do {
									$res_158 = $result;
									$pos_158 = $this->pos;
									$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
									$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
									if ($subres !== FALSE) {
										$this->store( $result, $subres, "versPhase" );
										$_161 = TRUE; break;
									}
									$result = $res_158;
									$this->pos = $pos_158;
									$stack[] = $result; $result = $this->construct( $matchrule, "today" ); 
									if (( $subres = $this->literal( '' ) ) !== FALSE) {
										$result["text"] .= $subres;
										$subres = $result; $result = array_pop($stack);
										$this->store( $result, $subres, 'today' );
										$_161 = TRUE; break;
									}
									else { $result = array_pop($stack); }
									$result = $res_158;
									$this->pos = $pos_158;
									$_161 = FALSE; break;
								}
								while(0);
								if( $_161 === TRUE ) { $_163 = TRUE; break; }
								$result = $res_156;
								$this->pos = $pos_156;
								$_163 = FALSE; break;
							}
							while(0);
							if( $_163 === TRUE ) { $_165 = TRUE; break; }
							$result = $res_150;
							$this->pos = $pos_150;
							$_165 = FALSE; break;
						}
						while(0);
						if( $_165 === FALSE) { $_167 = FALSE; break; }
						$_167 = TRUE; break;
					}
					while(0);
					if( $_167 === FALSE) { $_169 = FALSE; break; }
					$_169 = TRUE; break;
				}
				while(0);
				if( $_169 === TRUE ) { $_185 = TRUE; break; }
				$result = $res_148;
				$this->pos = $pos_148;
				$_183 = NULL;
				do {
					if (substr($this->string,$this->pos,1) == ':') {
						$this->pos += 1;
						$result["text"] .= ':';
					}
					else { $_183 = FALSE; break; }
					$_181 = NULL;
					do {
						$_179 = NULL;
						do {
							$res_172 = $result;
							$pos_172 = $this->pos;
							$matcher = 'match_'.'range'; $key = $matcher; $pos = $this->pos;
							$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
							if ($subres !== FALSE) {
								$this->store( $result, $subres, "viewRange" );
								$_179 = TRUE; break;
							}
							$result = $res_172;
							$this->pos = $pos_172;
							$_177 = NULL;
							do {
								$res_174 = $result;
								$pos_174 = $this->pos;
								$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
								$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
								if ($subres !== FALSE) {
									$this->store( $result, $subres, "viewDate" );
									$_177 = TRUE; break;
								}
								$result = $res_174;
								$this->pos = $pos_174;
								$stack[] = $result; $result = $this->construct( $matchrule, "today" ); 
								if (( $subres = $this->literal( '' ) ) !== FALSE) {
									$result["text"] .= $subres;
									$subres = $result; $result = array_pop($stack);
									$this->store( $result, $subres, 'today' );
									$_177 = TRUE; break;
								}
								else { $result = array_pop($stack); }
								$result = $res_174;
								$this->pos = $pos_174;
								$_177 = FALSE; break;
							}
							while(0);
							if( $_177 === TRUE ) { $_179 = TRUE; break; }
							$result = $res_172;
							$this->pos = $pos_172;
							$_179 = FALSE; break;
						}
						while(0);
						if( $_179 === FALSE) { $_181 = FALSE; break; }
						$_181 = TRUE; break;
					}
					while(0);
					if( $_181 === FALSE) { $_183 = FALSE; break; }
					$_183 = TRUE; break;
				}
				while(0);
				if( $_183 === TRUE ) { $_185 = TRUE; break; }
				$result = $res_148;
				$this->pos = $pos_148;
				$_185 = FALSE; break;
			}
			while(0);
			if( $_185 === FALSE) { $_187 = FALSE; break; }
			$_187 = TRUE; break;
		}
		while(0);
		if( $_187 === FALSE) { $_197 = FALSE; break; }
		$res_196 = $result;
		$pos_196 = $this->pos;
		$_195 = NULL;
		do {
			$res_192 = $result;
			$pos_192 = $this->pos;
			$_191 = NULL;
			do {
				$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_191 = FALSE; break; }
				$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "exprSource" );
				}
				else { $_191 = FALSE; break; }
				$_191 = TRUE; break;
			}
			while(0);
			if( $_191 === FALSE) {
				$result = $res_192;
				$this->pos = $pos_192;
				unset( $res_192 );
				unset( $pos_192 );
			}
			$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_195 = FALSE; break; }
			$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "exprDate" );
			}
			else { $_195 = FALSE; break; }
			$_195 = TRUE; break;
		}
		while(0);
		if( $_195 === FALSE) {
			$result = $res_196;
			$this->pos = $pos_196;
			unset( $res_196 );
			unset( $pos_196 );
		}
		$_197 = TRUE; break;
	}
	while(0);
	if( $_197 === TRUE ) { return $this->finalise($result); }
	if( $_197 === FALSE) { return FALSE; }
}

public function expression_today ( &$res, $sub ) { $res['date'] = 'TODAY' ;}

/* manifestation: 
	SL manifSource:token 
	(SL manifDate:date)?  */
protected $match_manifestation_typestack = array('manifestation');
function match_manifestation ($stack = array()) {
	$matchrule = "manifestation"; $result = $this->construct($matchrule, $matchrule, null);
	$_205 = NULL;
	do {
		$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_205 = FALSE; break; }
		$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "manifSource" );
		}
		else { $_205 = FALSE; break; }
		$res_204 = $result;
		$pos_204 = $this->pos;
		$_203 = NULL;
		do {
			$matcher = 'match_'.'SL'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_203 = FALSE; break; }
			$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "manifDate" );
			}
			else { $_203 = FALSE; break; }
			$_203 = TRUE; break;
		}
		while(0);
		if( $_203 === FALSE) {
			$result = $res_204;
			$this->pos = $pos_204;
			unset( $res_204 );
			unset( $pos_204 );
		}
		$_205 = TRUE; break;
	}
	while(0);
	if( $_205 === TRUE ) { return $this->finalise($result); }
	if( $_205 === FALSE) { return FALSE; }
}


/* format: '.' format:token */
protected $match_format_typestack = array('format');
function match_format ($stack = array()) {
	$matchrule = "format"; $result = $this->construct($matchrule, $matchrule, null);
	$_209 = NULL;
	do {
		if (substr($this->string,$this->pos,1) == '.') {
			$this->pos += 1;
			$result["text"] .= '.';
		}
		else { $_209 = FALSE; break; }
		$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "format" );
		}
		else { $_209 = FALSE; break; }
		$_209 = TRUE; break;
	}
	while(0);
	if( $_209 === TRUE ) { return $this->finalise($result); }
	if( $_209 === FALSE) { return FALSE; }
}

public function format_format ( &$res, $sub ) { $res['format'] = array($sub) ;}

/* component: '!' component:slashHier */
protected $match_component_typestack = array('component');
function match_component ($stack = array()) {
	$matchrule = "component"; $result = $this->construct($matchrule, $matchrule, null);
	$_213 = NULL;
	do {
		if (substr($this->string,$this->pos,1) == '!') {
			$this->pos += 1;
			$result["text"] .= '!';
		}
		else { $_213 = FALSE; break; }
		$matcher = 'match_'.'slashHier'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "component" );
		}
		else { $_213 = FALSE; break; }
		$_213 = TRUE; break;
	}
	while(0);
	if( $_213 === TRUE ) { return $this->finalise($result); }
	if( $_213 === FALSE) { return FALSE; }
}


/* fragment: '~' fragment:string */
protected $match_fragment_typestack = array('fragment');
function match_fragment ($stack = array()) {
	$matchrule = "fragment"; $result = $this->construct($matchrule, $matchrule, null);
	$_217 = NULL;
	do {
		if (substr($this->string,$this->pos,1) == '~') {
			$this->pos += 1;
			$result["text"] .= '~';
		}
		else { $_217 = FALSE; break; }
		$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "fragment" );
		}
		else { $_217 = FALSE; break; }
		$_217 = TRUE; break;
	}
	while(0);
	if( $_217 === TRUE ) { return $this->finalise($result); }
	if( $_217 === FALSE) { return FALSE; }
}


/* version: date:date '-' phase:string | date:date | phase:string | today:"" */
protected $match_version_typestack = array('version');
function match_version ($stack = array()) {
	$matchrule = "version"; $result = $this->construct($matchrule, $matchrule, null);
	$_234 = NULL;
	do {
		$res_219 = $result;
		$pos_219 = $this->pos;
		$_223 = NULL;
		do {
			$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "date" );
			}
			else { $_223 = FALSE; break; }
			if (substr($this->string,$this->pos,1) == '-') {
				$this->pos += 1;
				$result["text"] .= '-';
			}
			else { $_223 = FALSE; break; }
			$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "phase" );
			}
			else { $_223 = FALSE; break; }
			$_223 = TRUE; break;
		}
		while(0);
		if( $_223 === TRUE ) { $_234 = TRUE; break; }
		$result = $res_219;
		$this->pos = $pos_219;
		$_232 = NULL;
		do {
			$res_225 = $result;
			$pos_225 = $this->pos;
			$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "date" );
				$_232 = TRUE; break;
			}
			$result = $res_225;
			$this->pos = $pos_225;
			$_230 = NULL;
			do {
				$res_227 = $result;
				$pos_227 = $this->pos;
				$matcher = 'match_'.'string'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "phase" );
					$_230 = TRUE; break;
				}
				$result = $res_227;
				$this->pos = $pos_227;
				$stack[] = $result; $result = $this->construct( $matchrule, "today" ); 
				if (( $subres = $this->literal( '' ) ) !== FALSE) {
					$result["text"] .= $subres;
					$subres = $result; $result = array_pop($stack);
					$this->store( $result, $subres, 'today' );
					$_230 = TRUE; break;
				}
				else { $result = array_pop($stack); }
				$result = $res_227;
				$this->pos = $pos_227;
				$_230 = FALSE; break;
			}
			while(0);
			if( $_230 === TRUE ) { $_232 = TRUE; break; }
			$result = $res_225;
			$this->pos = $pos_225;
			$_232 = FALSE; break;
		}
		while(0);
		if( $_232 === TRUE ) { $_234 = TRUE; break; }
		$result = $res_219;
		$this->pos = $pos_219;
		$_234 = FALSE; break;
	}
	while(0);
	if( $_234 === TRUE ) { return $this->finalise($result); }
	if( $_234 === FALSE) { return FALSE; }
}

public function version_today ( &$res, $sub ) { $res['date'] = 'TODAY' ;}

/* view: range:range | date:date | today:"" */
protected $match_view_typestack = array('view');
function match_view ($stack = array()) {
	$matchrule = "view"; $result = $this->construct($matchrule, $matchrule, null);
	$_243 = NULL;
	do {
		$res_236 = $result;
		$pos_236 = $this->pos;
		$matcher = 'match_'.'range'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "range" );
			$_243 = TRUE; break;
		}
		$result = $res_236;
		$this->pos = $pos_236;
		$_241 = NULL;
		do {
			$res_238 = $result;
			$pos_238 = $this->pos;
			$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "date" );
				$_241 = TRUE; break;
			}
			$result = $res_238;
			$this->pos = $pos_238;
			$stack[] = $result; $result = $this->construct( $matchrule, "today" ); 
			if (( $subres = $this->literal( '' ) ) !== FALSE) {
				$result["text"] .= $subres;
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'today' );
				$_241 = TRUE; break;
			}
			else { $result = array_pop($stack); }
			$result = $res_238;
			$this->pos = $pos_238;
			$_241 = FALSE; break;
		}
		while(0);
		if( $_241 === TRUE ) { $_243 = TRUE; break; }
		$result = $res_236;
		$this->pos = $pos_236;
		$_243 = FALSE; break;
	}
	while(0);
	if( $_243 === TRUE ) { return $this->finalise($result); }
	if( $_243 === FALSE) { return FALSE; }
}

public function view_today ( &$res, $sub ) { $res['date'] = 'TODAY' ;}

/* range: from:date '-' to:date  */
protected $match_range_typestack = array('range');
function match_range ($stack = array()) {
	$matchrule = "range"; $result = $this->construct($matchrule, $matchrule, null);
	$_248 = NULL;
	do {
		$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "from" );
		}
		else { $_248 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '-') {
			$this->pos += 1;
			$result["text"] .= '-';
		}
		else { $_248 = FALSE; break; }
		$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "to" );
		}
		else { $_248 = FALSE; break; }
		$_248 = TRUE; break;
	}
	while(0);
	if( $_248 === TRUE ) { return $this->finalise($result); }
	if( $_248 === FALSE) { return FALSE; }
}



}
?>