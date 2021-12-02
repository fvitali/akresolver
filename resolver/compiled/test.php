<?PHP
require_once '../peg/autoloader.php';
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


/* DP: ':' */
protected $match_DP_typestack = array('DP');
function match_DP ($stack = array()) {
	$matchrule = "DP"; $result = $this->construct($matchrule, $matchrule, null);
	if (substr($this->string,$this->pos,1) == ':') {
		$this->pos += 1;
		$result["text"] .= ':';
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* PV: ';' */
protected $match_PV_typestack = array('PV');
function match_PV ($stack = array()) {
	$matchrule = "PV"; $result = $this->construct($matchrule, $matchrule, null);
	if (substr($this->string,$this->pos,1) == ';') {
		$this->pos += 1;
		$result["text"] .= ';';
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* V: ',' */
protected $match_V_typestack = array('V');
function match_V ($stack = array()) {
	$matchrule = "V"; $result = $this->construct($matchrule, $matchrule, null);
	if (substr($this->string,$this->pos,1) == ',') {
		$this->pos += 1;
		$result["text"] .= ',';
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* PLUS: '+' */
protected $match_PLUS_typestack = array('PLUS');
function match_PLUS ($stack = array()) {
	$matchrule = "PLUS"; $result = $this->construct($matchrule, $matchrule, null);
	if (substr($this->string,$this->pos,1) == '+') {
		$this->pos += 1;
		$result["text"] .= '+';
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


/* chars: /[a-zA-Z\.]+/ */
protected $match_chars_typestack = array('chars');
function match_chars ($stack = array()) {
	$matchrule = "chars"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->rx( '/[a-zA-Z\.]+/' ) ) !== FALSE) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* numero: /[0-9]/ */
protected $match_numero_typestack = array('numero');
function match_numero ($stack = array()) {
	$matchrule = "numero"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->rx( '/[0-9]/' ) ) !== FALSE) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* minuscolo: /[a-z]/ */
protected $match_minuscolo_typestack = array('minuscolo');
function match_minuscolo ($stack = array()) {
	$matchrule = "minuscolo"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->rx( '/[a-z]/' ) ) !== FALSE) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* normale: (numero | minuscolo | '.' | '-' | '_')+ */
protected $match_normale_typestack = array('normale');
function match_normale ($stack = array()) {
	$matchrule = "normale"; $result = $this->construct($matchrule, $matchrule, null);
	$count = 0;
	while (true) {
		$res_29 = $result;
		$pos_29 = $this->pos;
		$_28 = NULL;
		do {
			$_26 = NULL;
			do {
				$res_11 = $result;
				$pos_11 = $this->pos;
				$matcher = 'match_'.'numero'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$_26 = TRUE; break;
				}
				$result = $res_11;
				$this->pos = $pos_11;
				$_24 = NULL;
				do {
					$res_13 = $result;
					$pos_13 = $this->pos;
					$matcher = 'match_'.'minuscolo'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres );
						$_24 = TRUE; break;
					}
					$result = $res_13;
					$this->pos = $pos_13;
					$_22 = NULL;
					do {
						$res_15 = $result;
						$pos_15 = $this->pos;
						if (substr($this->string,$this->pos,1) == '.') {
							$this->pos += 1;
							$result["text"] .= '.';
							$_22 = TRUE; break;
						}
						$result = $res_15;
						$this->pos = $pos_15;
						$_20 = NULL;
						do {
							$res_17 = $result;
							$pos_17 = $this->pos;
							if (substr($this->string,$this->pos,1) == '-') {
								$this->pos += 1;
								$result["text"] .= '-';
								$_20 = TRUE; break;
							}
							$result = $res_17;
							$this->pos = $pos_17;
							if (substr($this->string,$this->pos,1) == '_') {
								$this->pos += 1;
								$result["text"] .= '_';
								$_20 = TRUE; break;
							}
							$result = $res_17;
							$this->pos = $pos_17;
							$_20 = FALSE; break;
						}
						while(0);
						if( $_20 === TRUE ) { $_22 = TRUE; break; }
						$result = $res_15;
						$this->pos = $pos_15;
						$_22 = FALSE; break;
					}
					while(0);
					if( $_22 === TRUE ) { $_24 = TRUE; break; }
					$result = $res_13;
					$this->pos = $pos_13;
					$_24 = FALSE; break;
				}
				while(0);
				if( $_24 === TRUE ) { $_26 = TRUE; break; }
				$result = $res_11;
				$this->pos = $pos_11;
				$_26 = FALSE; break;
			}
			while(0);
			if( $_26 === FALSE) { $_28 = FALSE; break; }
			$_28 = TRUE; break;
		}
		while(0);
		if( $_28 === FALSE) {
			$result = $res_29;
			$this->pos = $pos_29;
			unset( $res_29 );
			unset( $pos_29 );
			break;
		}
		$count++;
	}
	if ($count >= 1) { return $this->finalise($result); }
	else { return FALSE; }
}


/* other: /=-_'()/ */
protected $match_other_typestack = array('other');
function match_other ($stack = array()) {
	$matchrule = "other"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->rx( '/=-_\'()/' ) ) !== FALSE) {
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


/* token: normale* */
protected $match_token_typestack = array('token');
function match_token ($stack = array()) {
	$matchrule = "token"; $result = $this->construct($matchrule, $matchrule, null);
	while (true) {
		$res_32 = $result;
		$pos_32 = $this->pos;
		$matcher = 'match_'.'normale'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else {
			$result = $res_32;
			$this->pos = $pos_32;
			unset( $res_32 );
			unset( $pos_32 );
			break;
		}
	}
	return $this->finalise($result);
}


/* string: (number | chars )+ */
protected $match_string_typestack = array('string');
function match_string ($stack = array()) {
	$matchrule = "string"; $result = $this->construct($matchrule, $matchrule, null);
	$count = 0;
	while (true) {
		$res_39 = $result;
		$pos_39 = $this->pos;
		$_38 = NULL;
		do {
			$_36 = NULL;
			do {
				$res_33 = $result;
				$pos_33 = $this->pos;
				$matcher = 'match_'.'number'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$_36 = TRUE; break;
				}
				$result = $res_33;
				$this->pos = $pos_33;
				$matcher = 'match_'.'chars'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres );
					$_36 = TRUE; break;
				}
				$result = $res_33;
				$this->pos = $pos_33;
				$_36 = FALSE; break;
			}
			while(0);
			if( $_36 === FALSE) { $_38 = FALSE; break; }
			$_38 = TRUE; break;
		}
		while(0);
		if( $_38 === FALSE) {
			$result = $res_39;
			$this->pos = $pos_39;
			unset( $res_39 );
			unset( $pos_39 );
			break;
		}
		$count++;
	}
	if ($count >= 1) { return $this->finalise($result); }
	else { return FALSE; }
}


/* dataString: number4 '-' number2 '-' number2 */
protected $match_dataString_typestack = array('dataString');
function match_dataString ($stack = array()) {
	$matchrule = "dataString"; $result = $this->construct($matchrule, $matchrule, null);
	$_45 = NULL;
	do {
		$matcher = 'match_'.'number4'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_45 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '-') {
			$this->pos += 1;
			$result["text"] .= '-';
		}
		else { $_45 = FALSE; break; }
		$matcher = 'match_'.'number2'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_45 = FALSE; break; }
		if (substr($this->string,$this->pos,1) == '-') {
			$this->pos += 1;
			$result["text"] .= '-';
		}
		else { $_45 = FALSE; break; }
		$matcher = 'match_'.'number2'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_45 = FALSE; break; }
		$_45 = TRUE; break;
	}
	while(0);
	if( $_45 === TRUE ) { return $this->finalise($result); }
	if( $_45 === FALSE) { return FALSE; }
}


/* expr: > :schema :documento :versione? :comunicato* :manifestazione? :partizione? :proprieta? :extra? > | :extra */
protected $match_expr_typestack = array('expr');
function match_expr ($stack = array()) {
	$matchrule = "expr"; $result = $this->construct($matchrule, $matchrule, null);
	$_61 = NULL;
	do {
		$res_47 = $result;
		$pos_47 = $this->pos;
		$_58 = NULL;
		do {
			if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
			$matcher = 'match_'.'schema'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "schema" );
			}
			else { $_58 = FALSE; break; }
			$matcher = 'match_'.'documento'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "documento" );
			}
			else { $_58 = FALSE; break; }
			$res_51 = $result;
			$pos_51 = $this->pos;
			$matcher = 'match_'.'versione'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "versione" );
			}
			else {
				$result = $res_51;
				$this->pos = $pos_51;
				unset( $res_51 );
				unset( $pos_51 );
			}
			while (true) {
				$res_52 = $result;
				$pos_52 = $this->pos;
				$matcher = 'match_'.'comunicato'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "comunicato" );
				}
				else {
					$result = $res_52;
					$this->pos = $pos_52;
					unset( $res_52 );
					unset( $pos_52 );
					break;
				}
			}
			$res_53 = $result;
			$pos_53 = $this->pos;
			$matcher = 'match_'.'manifestazione'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "manifestazione" );
			}
			else {
				$result = $res_53;
				$this->pos = $pos_53;
				unset( $res_53 );
				unset( $pos_53 );
			}
			$res_54 = $result;
			$pos_54 = $this->pos;
			$matcher = 'match_'.'partizione'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "partizione" );
			}
			else {
				$result = $res_54;
				$this->pos = $pos_54;
				unset( $res_54 );
				unset( $pos_54 );
			}
			$res_55 = $result;
			$pos_55 = $this->pos;
			$matcher = 'match_'.'proprieta'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "proprieta" );
			}
			else {
				$result = $res_55;
				$this->pos = $pos_55;
				unset( $res_55 );
				unset( $pos_55 );
			}
			$res_56 = $result;
			$pos_56 = $this->pos;
			$matcher = 'match_'.'extra'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "extra" );
			}
			else {
				$result = $res_56;
				$this->pos = $pos_56;
				unset( $res_56 );
				unset( $pos_56 );
			}
			if (( $subres = $this->whitespace(  ) ) !== FALSE) { $result["text"] .= $subres; }
			$_58 = TRUE; break;
		}
		while(0);
		if( $_58 === TRUE ) { $_61 = TRUE; break; }
		$result = $res_47;
		$this->pos = $pos_47;
		$matcher = 'match_'.'extra'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "extra" );
			$_61 = TRUE; break;
		}
		$result = $res_47;
		$this->pos = $pos_47;
		$_61 = FALSE; break;
	}
	while(0);
	if( $_61 === TRUE ) { return $this->finalise($result); }
	if( $_61 === FALSE) { return FALSE; }
}


/* extra: any */
protected $match_extra_typestack = array('extra');
function match_extra ($stack = array()) {
	$matchrule = "extra"; $result = $this->construct($matchrule, $matchrule, null);
	$matcher = 'match_'.'any'; $key = $matcher; $pos = $this->pos;
	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
	if ($subres !== FALSE) {
		$this->store( $result, $subres );
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* schema: "urn:nir:" */
protected $match_schema_typestack = array('schema');
function match_schema ($stack = array()) {
	$matchrule = "schema"; $result = $this->construct($matchrule, $matchrule, null);
	if (( $subres = $this->literal( 'urn:nir:' ) ) !== FALSE) {
		$result["text"] .= $subres;
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* documento: :autorita DP :provvedimento (DP :estremi (DP :annesso)*)? */
protected $match_documento_typestack = array('documento');
function match_documento ($stack = array()) {
	$matchrule = "documento"; $result = $this->construct($matchrule, $matchrule, null);
	$_76 = NULL;
	do {
		$matcher = 'match_'.'autorita'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "autorita" );
		}
		else { $_76 = FALSE; break; }
		$matcher = 'match_'.'DP'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_76 = FALSE; break; }
		$matcher = 'match_'.'provvedimento'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "provvedimento" );
		}
		else { $_76 = FALSE; break; }
		$res_75 = $result;
		$pos_75 = $this->pos;
		$_74 = NULL;
		do {
			$matcher = 'match_'.'DP'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_74 = FALSE; break; }
			$matcher = 'match_'.'estremi'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "estremi" );
			}
			else { $_74 = FALSE; break; }
			while (true) {
				$res_73 = $result;
				$pos_73 = $this->pos;
				$_72 = NULL;
				do {
					$matcher = 'match_'.'DP'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) { $this->store( $result, $subres ); }
					else { $_72 = FALSE; break; }
					$matcher = 'match_'.'annesso'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "annesso" );
					}
					else { $_72 = FALSE; break; }
					$_72 = TRUE; break;
				}
				while(0);
				if( $_72 === FALSE) {
					$result = $res_73;
					$this->pos = $pos_73;
					unset( $res_73 );
					unset( $pos_73 );
					break;
				}
			}
			$_74 = TRUE; break;
		}
		while(0);
		if( $_74 === FALSE) {
			$result = $res_75;
			$this->pos = $pos_75;
			unset( $res_75 );
			unset( $pos_75 );
		}
		$_76 = TRUE; break;
	}
	while(0);
	if( $_76 === TRUE ) { return $this->finalise($result); }
	if( $_76 === FALSE) { return FALSE; }
}


/* autorita: :soggetto (PLUS :soggetto)* */
protected $match_autorita_typestack = array('autorita');
function match_autorita ($stack = array()) {
	$matchrule = "autorita"; $result = $this->construct($matchrule, $matchrule, null);
	$_83 = NULL;
	do {
		$matcher = 'match_'.'soggetto'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "soggetto" );
		}
		else { $_83 = FALSE; break; }
		while (true) {
			$res_82 = $result;
			$pos_82 = $this->pos;
			$_81 = NULL;
			do {
				$matcher = 'match_'.'PLUS'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_81 = FALSE; break; }
				$matcher = 'match_'.'soggetto'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "soggetto" );
				}
				else { $_81 = FALSE; break; }
				$_81 = TRUE; break;
			}
			while(0);
			if( $_81 === FALSE) {
				$result = $res_82;
				$this->pos = $pos_82;
				unset( $res_82 );
				unset( $pos_82 );
				break;
			}
		}
		$_83 = TRUE; break;
	}
	while(0);
	if( $_83 === TRUE ) { return $this->finalise($result); }
	if( $_83 === FALSE) { return FALSE; }
}


/* soggetto: 
	istituzione:token PV organo:token PV organo:token PV organo:token PV organo:token PV funzione:token | 
	istituzione:token PV organo:token PV organo:token PV organo:token PV funzione:token | 
	istituzione:token PV organo:token PV organo:token PV funzione:token | 
	istituzione:token PV organo:token PV funzione:token | 
	istituzione:token PV funzione:token | 
	carica:token */
protected $match_soggetto_typestack = array('soggetto');
function match_soggetto ($stack = array()) {
	$matchrule = "soggetto"; $result = $this->construct($matchrule, $matchrule, null);
	$_144 = NULL;
	do {
		$res_85 = $result;
		$pos_85 = $this->pos;
		$_97 = NULL;
		do {
			$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "istituzione" );
			}
			else { $_97 = FALSE; break; }
			$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_97 = FALSE; break; }
			$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "organo" );
			}
			else { $_97 = FALSE; break; }
			$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_97 = FALSE; break; }
			$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "organo" );
			}
			else { $_97 = FALSE; break; }
			$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_97 = FALSE; break; }
			$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "organo" );
			}
			else { $_97 = FALSE; break; }
			$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_97 = FALSE; break; }
			$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "organo" );
			}
			else { $_97 = FALSE; break; }
			$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_97 = FALSE; break; }
			$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "funzione" );
			}
			else { $_97 = FALSE; break; }
			$_97 = TRUE; break;
		}
		while(0);
		if( $_97 === TRUE ) { $_144 = TRUE; break; }
		$result = $res_85;
		$this->pos = $pos_85;
		$_142 = NULL;
		do {
			$res_99 = $result;
			$pos_99 = $this->pos;
			$_109 = NULL;
			do {
				$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "istituzione" );
				}
				else { $_109 = FALSE; break; }
				$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_109 = FALSE; break; }
				$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "organo" );
				}
				else { $_109 = FALSE; break; }
				$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_109 = FALSE; break; }
				$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "organo" );
				}
				else { $_109 = FALSE; break; }
				$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_109 = FALSE; break; }
				$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "organo" );
				}
				else { $_109 = FALSE; break; }
				$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_109 = FALSE; break; }
				$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "funzione" );
				}
				else { $_109 = FALSE; break; }
				$_109 = TRUE; break;
			}
			while(0);
			if( $_109 === TRUE ) { $_142 = TRUE; break; }
			$result = $res_99;
			$this->pos = $pos_99;
			$_140 = NULL;
			do {
				$res_111 = $result;
				$pos_111 = $this->pos;
				$_119 = NULL;
				do {
					$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "istituzione" );
					}
					else { $_119 = FALSE; break; }
					$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) { $this->store( $result, $subres ); }
					else { $_119 = FALSE; break; }
					$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "organo" );
					}
					else { $_119 = FALSE; break; }
					$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) { $this->store( $result, $subres ); }
					else { $_119 = FALSE; break; }
					$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "organo" );
					}
					else { $_119 = FALSE; break; }
					$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) { $this->store( $result, $subres ); }
					else { $_119 = FALSE; break; }
					$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "funzione" );
					}
					else { $_119 = FALSE; break; }
					$_119 = TRUE; break;
				}
				while(0);
				if( $_119 === TRUE ) { $_140 = TRUE; break; }
				$result = $res_111;
				$this->pos = $pos_111;
				$_138 = NULL;
				do {
					$res_121 = $result;
					$pos_121 = $this->pos;
					$_127 = NULL;
					do {
						$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres, "istituzione" );
						}
						else { $_127 = FALSE; break; }
						$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres );
						}
						else { $_127 = FALSE; break; }
						$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres, "organo" );
						}
						else { $_127 = FALSE; break; }
						$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres );
						}
						else { $_127 = FALSE; break; }
						$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres, "funzione" );
						}
						else { $_127 = FALSE; break; }
						$_127 = TRUE; break;
					}
					while(0);
					if( $_127 === TRUE ) { $_138 = TRUE; break; }
					$result = $res_121;
					$this->pos = $pos_121;
					$_136 = NULL;
					do {
						$res_129 = $result;
						$pos_129 = $this->pos;
						$_133 = NULL;
						do {
							$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
							$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
							if ($subres !== FALSE) {
								$this->store( $result, $subres, "istituzione" );
							}
							else { $_133 = FALSE; break; }
							$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
							$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
							if ($subres !== FALSE) {
								$this->store( $result, $subres );
							}
							else { $_133 = FALSE; break; }
							$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
							$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
							if ($subres !== FALSE) {
								$this->store( $result, $subres, "funzione" );
							}
							else { $_133 = FALSE; break; }
							$_133 = TRUE; break;
						}
						while(0);
						if( $_133 === TRUE ) { $_136 = TRUE; break; }
						$result = $res_129;
						$this->pos = $pos_129;
						$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres, "carica" );
							$_136 = TRUE; break;
						}
						$result = $res_129;
						$this->pos = $pos_129;
						$_136 = FALSE; break;
					}
					while(0);
					if( $_136 === TRUE ) { $_138 = TRUE; break; }
					$result = $res_121;
					$this->pos = $pos_121;
					$_138 = FALSE; break;
				}
				while(0);
				if( $_138 === TRUE ) { $_140 = TRUE; break; }
				$result = $res_111;
				$this->pos = $pos_111;
				$_140 = FALSE; break;
			}
			while(0);
			if( $_140 === TRUE ) { $_142 = TRUE; break; }
			$result = $res_99;
			$this->pos = $pos_99;
			$_142 = FALSE; break;
		}
		while(0);
		if( $_142 === TRUE ) { $_144 = TRUE; break; }
		$result = $res_85;
		$this->pos = $pos_85;
		$_144 = FALSE; break;
	}
	while(0);
	if( $_144 === TRUE ) { return $this->finalise($result); }
	if( $_144 === FALSE) { return FALSE; }
}


/* suggetto: elemento:token (PV elemento:token)* */
protected $match_suggetto_typestack = array('suggetto');
function match_suggetto ($stack = array()) {
	$matchrule = "suggetto"; $result = $this->construct($matchrule, $matchrule, null);
	$_151 = NULL;
	do {
		$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "elemento" );
		}
		else { $_151 = FALSE; break; }
		while (true) {
			$res_150 = $result;
			$pos_150 = $this->pos;
			$_149 = NULL;
			do {
				$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_149 = FALSE; break; }
				$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "elemento" );
				}
				else { $_149 = FALSE; break; }
				$_149 = TRUE; break;
			}
			while(0);
			if( $_149 === FALSE) {
				$result = $res_150;
				$this->pos = $pos_150;
				unset( $res_150 );
				unset( $pos_150 );
				break;
			}
		}
		$_151 = TRUE; break;
	}
	while(0);
	if( $_151 === TRUE ) { return $this->finalise($result); }
	if( $_151 === FALSE) { return FALSE; }
}


/* provvedimento: tipo:token ( PV :spec)* */
protected $match_provvedimento_typestack = array('provvedimento');
function match_provvedimento ($stack = array()) {
	$matchrule = "provvedimento"; $result = $this->construct($matchrule, $matchrule, null);
	$_158 = NULL;
	do {
		$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "tipo" );
		}
		else { $_158 = FALSE; break; }
		while (true) {
			$res_157 = $result;
			$pos_157 = $this->pos;
			$_156 = NULL;
			do {
				$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_156 = FALSE; break; }
				$matcher = 'match_'.'spec'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "spec" );
				}
				else { $_156 = FALSE; break; }
				$_156 = TRUE; break;
			}
			while(0);
			if( $_156 === FALSE) {
				$result = $res_157;
				$this->pos = $pos_157;
				unset( $res_157 );
				unset( $pos_157 );
				break;
			}
		}
		$_158 = TRUE; break;
	}
	while(0);
	if( $_158 === TRUE ) { return $this->finalise($result); }
	if( $_158 === FALSE) { return FALSE; }
}


/* estremi: 
	(:date (PV :numeri (V :numeri)*) ?) |
	(:periodo PV :date (PV :numeri (V :numeri)*) ?) |
	(:periodo (PV :numeri (V :numeri)*) ?) */
protected $match_estremi_typestack = array('estremi');
function match_estremi ($stack = array()) {
	$matchrule = "estremi"; $result = $this->construct($matchrule, $matchrule, null);
	$_199 = NULL;
	do {
		$res_160 = $result;
		$pos_160 = $this->pos;
		$_170 = NULL;
		do {
			$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "date" );
			}
			else { $_170 = FALSE; break; }
			$res_169 = $result;
			$pos_169 = $this->pos;
			$_168 = NULL;
			do {
				$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_168 = FALSE; break; }
				$matcher = 'match_'.'numeri'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "numeri" );
				}
				else { $_168 = FALSE; break; }
				while (true) {
					$res_167 = $result;
					$pos_167 = $this->pos;
					$_166 = NULL;
					do {
						$matcher = 'match_'.'V'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres );
						}
						else { $_166 = FALSE; break; }
						$matcher = 'match_'.'numeri'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres, "numeri" );
						}
						else { $_166 = FALSE; break; }
						$_166 = TRUE; break;
					}
					while(0);
					if( $_166 === FALSE) {
						$result = $res_167;
						$this->pos = $pos_167;
						unset( $res_167 );
						unset( $pos_167 );
						break;
					}
				}
				$_168 = TRUE; break;
			}
			while(0);
			if( $_168 === FALSE) {
				$result = $res_169;
				$this->pos = $pos_169;
				unset( $res_169 );
				unset( $pos_169 );
			}
			$_170 = TRUE; break;
		}
		while(0);
		if( $_170 === TRUE ) { $_199 = TRUE; break; }
		$result = $res_160;
		$this->pos = $pos_160;
		$_197 = NULL;
		do {
			$res_172 = $result;
			$pos_172 = $this->pos;
			$_184 = NULL;
			do {
				$matcher = 'match_'.'periodo'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "periodo" );
				}
				else { $_184 = FALSE; break; }
				$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_184 = FALSE; break; }
				$matcher = 'match_'.'date'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "date" );
				}
				else { $_184 = FALSE; break; }
				$res_183 = $result;
				$pos_183 = $this->pos;
				$_182 = NULL;
				do {
					$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) { $this->store( $result, $subres ); }
					else { $_182 = FALSE; break; }
					$matcher = 'match_'.'numeri'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "numeri" );
					}
					else { $_182 = FALSE; break; }
					while (true) {
						$res_181 = $result;
						$pos_181 = $this->pos;
						$_180 = NULL;
						do {
							$matcher = 'match_'.'V'; $key = $matcher; $pos = $this->pos;
							$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
							if ($subres !== FALSE) {
								$this->store( $result, $subres );
							}
							else { $_180 = FALSE; break; }
							$matcher = 'match_'.'numeri'; $key = $matcher; $pos = $this->pos;
							$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
							if ($subres !== FALSE) {
								$this->store( $result, $subres, "numeri" );
							}
							else { $_180 = FALSE; break; }
							$_180 = TRUE; break;
						}
						while(0);
						if( $_180 === FALSE) {
							$result = $res_181;
							$this->pos = $pos_181;
							unset( $res_181 );
							unset( $pos_181 );
							break;
						}
					}
					$_182 = TRUE; break;
				}
				while(0);
				if( $_182 === FALSE) {
					$result = $res_183;
					$this->pos = $pos_183;
					unset( $res_183 );
					unset( $pos_183 );
				}
				$_184 = TRUE; break;
			}
			while(0);
			if( $_184 === TRUE ) { $_197 = TRUE; break; }
			$result = $res_172;
			$this->pos = $pos_172;
			$_195 = NULL;
			do {
				$matcher = 'match_'.'periodo'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "periodo" );
				}
				else { $_195 = FALSE; break; }
				$res_194 = $result;
				$pos_194 = $this->pos;
				$_193 = NULL;
				do {
					$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) { $this->store( $result, $subres ); }
					else { $_193 = FALSE; break; }
					$matcher = 'match_'.'numeri'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "numeri" );
					}
					else { $_193 = FALSE; break; }
					while (true) {
						$res_192 = $result;
						$pos_192 = $this->pos;
						$_191 = NULL;
						do {
							$matcher = 'match_'.'V'; $key = $matcher; $pos = $this->pos;
							$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
							if ($subres !== FALSE) {
								$this->store( $result, $subres );
							}
							else { $_191 = FALSE; break; }
							$matcher = 'match_'.'numeri'; $key = $matcher; $pos = $this->pos;
							$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
							if ($subres !== FALSE) {
								$this->store( $result, $subres, "numeri" );
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
							break;
						}
					}
					$_193 = TRUE; break;
				}
				while(0);
				if( $_193 === FALSE) {
					$result = $res_194;
					$this->pos = $pos_194;
					unset( $res_194 );
					unset( $pos_194 );
				}
				$_195 = TRUE; break;
			}
			while(0);
			if( $_195 === TRUE ) { $_197 = TRUE; break; }
			$result = $res_172;
			$this->pos = $pos_172;
			$_197 = FALSE; break;
		}
		while(0);
		if( $_197 === TRUE ) { $_199 = TRUE; break; }
		$result = $res_160;
		$this->pos = $pos_160;
		$_199 = FALSE; break;
	}
	while(0);
	if( $_199 === TRUE ) { return $this->finalise($result); }
	if( $_199 === FALSE) { return FALSE; }
}


/* date: data:dataString (V data:dataString)* */
protected $match_date_typestack = array('date');
function match_date ($stack = array()) {
	$matchrule = "date"; $result = $this->construct($matchrule, $matchrule, null);
	$_206 = NULL;
	do {
		$matcher = 'match_'.'dataString'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "data" );
		}
		else { $_206 = FALSE; break; }
		while (true) {
			$res_205 = $result;
			$pos_205 = $this->pos;
			$_204 = NULL;
			do {
				$matcher = 'match_'.'V'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_204 = FALSE; break; }
				$matcher = 'match_'.'dataString'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "data" );
				}
				else { $_204 = FALSE; break; }
				$_204 = TRUE; break;
			}
			while(0);
			if( $_204 === FALSE) {
				$result = $res_205;
				$this->pos = $pos_205;
				unset( $res_205 );
				unset( $pos_205 );
				break;
			}
		}
		$_206 = TRUE; break;
	}
	while(0);
	if( $_206 === TRUE ) { return $this->finalise($result); }
	if( $_206 === FALSE) { return FALSE; }
}


/* data: data:dataString */
protected $match_data_typestack = array('data');
function match_data ($stack = array()) {
	$matchrule = "data"; $result = $this->construct($matchrule, $matchrule, null);
	$matcher = 'match_'.'dataString'; $key = $matcher; $pos = $this->pos;
	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
	if ($subres !== FALSE) {
		$this->store( $result, $subres, "data" );
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* periodo: token */
protected $match_periodo_typestack = array('periodo');
function match_periodo ($stack = array()) {
	$matchrule = "periodo"; $result = $this->construct($matchrule, $matchrule, null);
	$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
	if ($subres !== FALSE) {
		$this->store( $result, $subres );
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* numeri: 'nir-' numero+ | token */
protected $match_numeri_typestack = array('numeri');
function match_numeri ($stack = array()) {
	$matchrule = "numeri"; $result = $this->construct($matchrule, $matchrule, null);
	$_216 = NULL;
	do {
		$res_210 = $result;
		$pos_210 = $this->pos;
		$_213 = NULL;
		do {
			if (( $subres = $this->literal( 'nir-' ) ) !== FALSE) { $result["text"] .= $subres; }
			else { $_213 = FALSE; break; }
			$count = 0;
			while (true) {
				$res_212 = $result;
				$pos_212 = $this->pos;
				$matcher = 'match_'.'numero'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else {
					$result = $res_212;
					$this->pos = $pos_212;
					unset( $res_212 );
					unset( $pos_212 );
					break;
				}
				$count++;
			}
			if ($count >= 1) {  }
			else { $_213 = FALSE; break; }
			$_213 = TRUE; break;
		}
		while(0);
		if( $_213 === TRUE ) { $_216 = TRUE; break; }
		$result = $res_210;
		$this->pos = $pos_210;
		$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres );
			$_216 = TRUE; break;
		}
		$result = $res_210;
		$this->pos = $pos_210;
		$_216 = FALSE; break;
	}
	while(0);
	if( $_216 === TRUE ) { return $this->finalise($result); }
	if( $_216 === FALSE) { return FALSE; }
}


/* annesso: id:token (PV :spec)* */
protected $match_annesso_typestack = array('annesso');
function match_annesso ($stack = array()) {
	$matchrule = "annesso"; $result = $this->construct($matchrule, $matchrule, null);
	$_223 = NULL;
	do {
		$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "id" );
		}
		else { $_223 = FALSE; break; }
		while (true) {
			$res_222 = $result;
			$pos_222 = $this->pos;
			$_221 = NULL;
			do {
				$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_221 = FALSE; break; }
				$matcher = 'match_'.'spec'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "spec" );
				}
				else { $_221 = FALSE; break; }
				$_221 = TRUE; break;
			}
			while(0);
			if( $_221 === FALSE) {
				$result = $res_222;
				$this->pos = $pos_222;
				unset( $res_222 );
				unset( $pos_222 );
				break;
			}
		}
		$_223 = TRUE; break;
	}
	while(0);
	if( $_223 === TRUE ) { return $this->finalise($result); }
	if( $_223 === FALSE) { return FALSE; }
}


/* spec: token */
protected $match_spec_typestack = array('spec');
function match_spec ($stack = array()) {
	$matchrule = "spec"; $result = $this->construct($matchrule, $matchrule, null);
	$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
	if ($subres !== FALSE) {
		$this->store( $result, $subres );
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* vigenza: data */
protected $match_vigenza_typestack = array('vigenza');
function match_vigenza ($stack = array()) {
	$matchrule = "vigenza"; $result = $this->construct($matchrule, $matchrule, null);
	$matcher = 'match_'.'data'; $key = $matcher; $pos = $this->pos;
	$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
	if ($subres !== FALSE) {
		$this->store( $result, $subres );
		return $this->finalise($result);
	}
	else { return FALSE; }
}


/* versione: '@' (:data | :spec) ( PV (:vigenza | :spec))? */
protected $match_versione_typestack = array('versione');
function match_versione ($stack = array()) {
	$matchrule = "versione"; $result = $this->construct($matchrule, $matchrule, null);
	$_245 = NULL;
	do {
		if (substr($this->string,$this->pos,1) == '@') {
			$this->pos += 1;
			$result["text"] .= '@';
		}
		else { $_245 = FALSE; break; }
		$_233 = NULL;
		do {
			$_231 = NULL;
			do {
				$res_228 = $result;
				$pos_228 = $this->pos;
				$matcher = 'match_'.'data'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "data" );
					$_231 = TRUE; break;
				}
				$result = $res_228;
				$this->pos = $pos_228;
				$matcher = 'match_'.'spec'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "spec" );
					$_231 = TRUE; break;
				}
				$result = $res_228;
				$this->pos = $pos_228;
				$_231 = FALSE; break;
			}
			while(0);
			if( $_231 === FALSE) { $_233 = FALSE; break; }
			$_233 = TRUE; break;
		}
		while(0);
		if( $_233 === FALSE) { $_245 = FALSE; break; }
		$res_244 = $result;
		$pos_244 = $this->pos;
		$_243 = NULL;
		do {
			$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_243 = FALSE; break; }
			$_241 = NULL;
			do {
				$_239 = NULL;
				do {
					$res_236 = $result;
					$pos_236 = $this->pos;
					$matcher = 'match_'.'vigenza'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "vigenza" );
						$_239 = TRUE; break;
					}
					$result = $res_236;
					$this->pos = $pos_236;
					$matcher = 'match_'.'spec'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "spec" );
						$_239 = TRUE; break;
					}
					$result = $res_236;
					$this->pos = $pos_236;
					$_239 = FALSE; break;
				}
				while(0);
				if( $_239 === FALSE) { $_241 = FALSE; break; }
				$_241 = TRUE; break;
			}
			while(0);
			if( $_241 === FALSE) { $_243 = FALSE; break; }
			$_243 = TRUE; break;
		}
		while(0);
		if( $_243 === FALSE) {
			$result = $res_244;
			$this->pos = $pos_244;
			unset( $res_244 );
			unset( $pos_244 );
		}
		$_245 = TRUE; break;
	}
	while(0);
	if( $_245 === TRUE ) { return $this->finalise($result); }
	if( $_245 === FALSE) { return FALSE; }
}


/* comunicato: '*' tipo:token PV :data */
protected $match_comunicato_typestack = array('comunicato');
function match_comunicato ($stack = array()) {
	$matchrule = "comunicato"; $result = $this->construct($matchrule, $matchrule, null);
	$_251 = NULL;
	do {
		if (substr($this->string,$this->pos,1) == '*') {
			$this->pos += 1;
			$result["text"] .= '*';
		}
		else { $_251 = FALSE; break; }
		$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "tipo" );
		}
		else { $_251 = FALSE; break; }
		$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) { $this->store( $result, $subres ); }
		else { $_251 = FALSE; break; }
		$matcher = 'match_'.'data'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "data" );
		}
		else { $_251 = FALSE; break; }
		$_251 = TRUE; break;
	}
	while(0);
	if( $_251 === TRUE ) { return $this->finalise($result); }
	if( $_251 === FALSE) { return FALSE; }
}


/* manifestazione: '$' formato:(formato:token (PV :spec)*) editore:(DP nome:token (PV :spec)*) (componente:(DP nome:token (PV :spec)*))? */
protected $match_manifestazione_typestack = array('manifestazione');
function match_manifestazione ($stack = array()) {
	$matchrule = "manifestazione"; $result = $this->construct($matchrule, $matchrule, null);
	$_279 = NULL;
	do {
		if (substr($this->string,$this->pos,1) == '$') {
			$this->pos += 1;
			$result["text"] .= '$';
		}
		else { $_279 = FALSE; break; }
		$stack[] = $result; $result = $this->construct( $matchrule, "formato" ); 
		$_259 = NULL;
		do {
			$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "formato" );
			}
			else { $_259 = FALSE; break; }
			while (true) {
				$res_258 = $result;
				$pos_258 = $this->pos;
				$_257 = NULL;
				do {
					$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) { $this->store( $result, $subres ); }
					else { $_257 = FALSE; break; }
					$matcher = 'match_'.'spec'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "spec" );
					}
					else { $_257 = FALSE; break; }
					$_257 = TRUE; break;
				}
				while(0);
				if( $_257 === FALSE) {
					$result = $res_258;
					$this->pos = $pos_258;
					unset( $res_258 );
					unset( $pos_258 );
					break;
				}
			}
			$_259 = TRUE; break;
		}
		while(0);
		if( $_259 === TRUE ) {
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'formato' );
		}
		if( $_259 === FALSE) {
			$result = array_pop($stack);
			$_279 = FALSE; break;
		}
		$stack[] = $result; $result = $this->construct( $matchrule, "editore" ); 
		$_267 = NULL;
		do {
			$matcher = 'match_'.'DP'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) { $this->store( $result, $subres ); }
			else { $_267 = FALSE; break; }
			$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
			$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
			if ($subres !== FALSE) {
				$this->store( $result, $subres, "nome" );
			}
			else { $_267 = FALSE; break; }
			while (true) {
				$res_266 = $result;
				$pos_266 = $this->pos;
				$_265 = NULL;
				do {
					$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) { $this->store( $result, $subres ); }
					else { $_265 = FALSE; break; }
					$matcher = 'match_'.'spec'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "spec" );
					}
					else { $_265 = FALSE; break; }
					$_265 = TRUE; break;
				}
				while(0);
				if( $_265 === FALSE) {
					$result = $res_266;
					$this->pos = $pos_266;
					unset( $res_266 );
					unset( $pos_266 );
					break;
				}
			}
			$_267 = TRUE; break;
		}
		while(0);
		if( $_267 === TRUE ) {
			$subres = $result; $result = array_pop($stack);
			$this->store( $result, $subres, 'editore' );
		}
		if( $_267 === FALSE) {
			$result = array_pop($stack);
			$_279 = FALSE; break;
		}
		$res_278 = $result;
		$pos_278 = $this->pos;
		$_277 = NULL;
		do {
			$stack[] = $result; $result = $this->construct( $matchrule, "componente" ); 
			$_275 = NULL;
			do {
				$matcher = 'match_'.'DP'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) { $this->store( $result, $subres ); }
				else { $_275 = FALSE; break; }
				$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
				$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
				if ($subres !== FALSE) {
					$this->store( $result, $subres, "nome" );
				}
				else { $_275 = FALSE; break; }
				while (true) {
					$res_274 = $result;
					$pos_274 = $this->pos;
					$_273 = NULL;
					do {
						$matcher = 'match_'.'PV'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres );
						}
						else { $_273 = FALSE; break; }
						$matcher = 'match_'.'spec'; $key = $matcher; $pos = $this->pos;
						$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
						if ($subres !== FALSE) {
							$this->store( $result, $subres, "spec" );
						}
						else { $_273 = FALSE; break; }
						$_273 = TRUE; break;
					}
					while(0);
					if( $_273 === FALSE) {
						$result = $res_274;
						$this->pos = $pos_274;
						unset( $res_274 );
						unset( $pos_274 );
						break;
					}
				}
				$_275 = TRUE; break;
			}
			while(0);
			if( $_275 === TRUE ) {
				$subres = $result; $result = array_pop($stack);
				$this->store( $result, $subres, 'componente' );
			}
			if( $_275 === FALSE) {
				$result = array_pop($stack);
				$_277 = FALSE; break;
			}
			$_277 = TRUE; break;
		}
		while(0);
		if( $_277 === FALSE) {
			$result = $res_278;
			$this->pos = $pos_278;
			unset( $res_278 );
			unset( $pos_278 );
		}
		$_279 = TRUE; break;
	}
	while(0);
	if( $_279 === TRUE ) { return $this->finalise($result); }
	if( $_279 === FALSE) { return FALSE; }
}


/* partizione: '~' id:token */
protected $match_partizione_typestack = array('partizione');
function match_partizione ($stack = array()) {
	$matchrule = "partizione"; $result = $this->construct($matchrule, $matchrule, null);
	$_283 = NULL;
	do {
		if (substr($this->string,$this->pos,1) == '~') {
			$this->pos += 1;
			$result["text"] .= '~';
		}
		else { $_283 = FALSE; break; }
		$matcher = 'match_'.'token'; $key = $matcher; $pos = $this->pos;
		$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
		if ($subres !== FALSE) {
			$this->store( $result, $subres, "id" );
		}
		else { $_283 = FALSE; break; }
		$_283 = TRUE; break;
	}
	while(0);
	if( $_283 === TRUE ) { return $this->finalise($result); }
	if( $_283 === FALSE) { return FALSE; }
}


/* proprieta: '!' ( 'vig=' vigore:data | 'eff=' efficacia:data) */
protected $match_proprieta_typestack = array('proprieta');
function match_proprieta ($stack = array()) {
	$matchrule = "proprieta"; $result = $this->construct($matchrule, $matchrule, null);
	$_299 = NULL;
	do {
		if (substr($this->string,$this->pos,1) == '!') {
			$this->pos += 1;
			$result["text"] .= '!';
		}
		else { $_299 = FALSE; break; }
		$_297 = NULL;
		do {
			$_295 = NULL;
			do {
				$res_286 = $result;
				$pos_286 = $this->pos;
				$_289 = NULL;
				do {
					if (( $subres = $this->literal( 'vig=' ) ) !== FALSE) { $result["text"] .= $subres; }
					else { $_289 = FALSE; break; }
					$matcher = 'match_'.'data'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "vigore" );
					}
					else { $_289 = FALSE; break; }
					$_289 = TRUE; break;
				}
				while(0);
				if( $_289 === TRUE ) { $_295 = TRUE; break; }
				$result = $res_286;
				$this->pos = $pos_286;
				$_293 = NULL;
				do {
					if (( $subres = $this->literal( 'eff=' ) ) !== FALSE) { $result["text"] .= $subres; }
					else { $_293 = FALSE; break; }
					$matcher = 'match_'.'data'; $key = $matcher; $pos = $this->pos;
					$subres = ( $this->packhas( $key, $pos ) ? $this->packread( $key, $pos ) : $this->packwrite( $key, $pos, $this->$matcher(array_merge($stack, array($result))) ) );
					if ($subres !== FALSE) {
						$this->store( $result, $subres, "efficacia" );
					}
					else { $_293 = FALSE; break; }
					$_293 = TRUE; break;
				}
				while(0);
				if( $_293 === TRUE ) { $_295 = TRUE; break; }
				$result = $res_286;
				$this->pos = $pos_286;
				$_295 = FALSE; break;
			}
			while(0);
			if( $_295 === FALSE) { $_297 = FALSE; break; }
			$_297 = TRUE; break;
		}
		while(0);
		if( $_297 === FALSE) { $_299 = FALSE; break; }
		$_299 = TRUE; break;
	}
	while(0);
	if( $_299 === TRUE ) { return $this->finalise($result); }
	if( $_299 === FALSE) { return FALSE; }
}



}
?>