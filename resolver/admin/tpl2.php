<?PHP
class tpl {
	static private $staticValues = array() ;
	private $tpl;
	private $values = array() ;

	
	function toArray() {
		return array('static' => $this->staticValues, 'values' => $this->values, 'tpl' => $this->tpl) ;
	}

	function __toString() {
		$this->allValues=array_merge($this->values, self::$staticValues) ;
		$x = "<xmp>AllValues\n".print_r($this->allValues,true).'</xmp>' ;
		$x .= '<xmp>'.print_r($this,true).'</xmp>' ;
		unset($this->allValues) ;
		return $x ;
	}
	
	function __construct($tpl='') {
		if ($tpl!='') {
			$this->tpl = $tpl;
		}
	}
	function set($tpl) {
		$this->tpl = $tpl;
	}
	function add($search,$replace) {
		$this->values[$search] = $replace;
	}
	
	function addMany($array) {
		$this->values = array_merge($this->values, $array) ;
	}

	static function addToAll($search,$replace) {
		self::$staticValues[$search] = $replace;
	}
	
	function patternize($x) { return "+\{$x\}+"; }

	function flatten($features) {
		$new = array_merge(array(), $features);
		foreach($new as $name => $value) {
			if (is_array($value) ) {
				foreach ($value as $n => $v) {
					$new[$name."__".$n] = $v ;
				}
//				unset($new[$name]) ; 
			}
		}
		return $new ; 
	}

	function apply($clean=false) {
		$values = $this->flatten(array_merge($this->values,self::$staticValues)) ;
// p($values) ;
		$ret = $this->tpl ;
		$ret = preg_replace("+\[\[+","==IF==",$ret) ;
		$ret = preg_replace("+\|\|+","==ELSE==",$ret) ;
		$ret = preg_replace("+\]\]+","==ENDIF==",$ret) ;

		$ret = preg_replace("+\{+","==SP==",$ret) ;
		$ret = preg_replace("+\}+","==EP==",$ret) ;
		$ret = preg_replace("+\|+","==SEP==",$ret) ;

		$ret = preg_replace("/\[([^\]]+)\]/","__$1",$ret) ;
		$any = '[^==]*' ;
		
		foreach ($values as $k => $v) {
			if (is_array($v)) {
				if (is_multi($v) ) {
					$v = '' ;
				} else {
					$v = implode($v,"_____") ;
				}
			}

			$pt = "+==IF==($any)==SP==($k)==EP==($any)==ELSE==($any)==ENDIF==+" ;
			$ret = preg_replace($pt,"$1 ====== $v ====== $3",$ret) ;
			$pt = "+==IF==($any)==SP==($k)==SEP==($any)==EP==($any)==ELSE==($any)==ENDIF==+" ;
			$ret = preg_replace($pt,"$1==SP==$k==SEP==$3==EP==$4",$ret) ;
			$pt = "+==IF==($any)==SP==($k)==EP==($any)==ENDIF==+" ;
			$ret = preg_replace($pt,"$1 ====== $v ====== $3",$ret) ;
			$pt = "+==IF==($any)==SP==($k)==SEP==($any)==EP==($any)==ENDIF==+" ;
			$ret = preg_replace($pt,"$1==SP==$k==SEP==$3==EP==$4",$ret) ;

			$pt = "+==SP==($k)==SEP==($any)==EP==+";
			preg_match($pt,$ret,$match) ;
			$ret = preg_replace($pt,"$v",$ret) ;
			if ($match) {
				$ret = preg_replace('+_____+',"$match[2]",$ret) ;
			}

			$pt = "+==SP==($k)==EP==+" ;
			$ret = preg_replace($pt,"$v",$ret) ;
			$ret = preg_replace('+_____+',"",$ret) ;
		}
// The remaining [[ x{a}y | z ]] and [[ x{a}y ]]
// transformed as IF (a) THEN (xay) ELSE (z) ENDIF and IF (a) THEN (xay) ENDIF
// become z and ''
		$pt = "+==IF==($any)==SP==($any)==EP==($any)==ELSE==($any)==ENDIF==+" ;
		$ret = preg_replace($pt,"$4",$ret) ;
		$pt = "+==IF==($any)==SP==($any)==SEP==($any)==EP==($any)==ELSE==($any)==ENDIF==+" ;
		$ret = preg_replace($pt,"$5",$ret) ;
		$pt = "+==IF==($any)==SP==($any)==EP==($any)==ENDIF==+" ;
		$ret = preg_replace($pt,"",$ret) ;
		$pt = "+==IF==($any)==SP==($any)==SEP==($any)==EP==($any)==ENDIF==+" ;
		$ret = preg_replace($pt,"",$ret) ;
		$pt = "+==IF==($any)==ENDIF==+" ;
		$ret = preg_replace($pt,"",$ret) ;
// If clean, all remaining {a} are removed. 
		if ($clean) {
			foreach ($values as $k => $v) {
				$pt = "+==SP==($any)==EP==+" ;
				$ret = preg_replace($pt,"",$ret) ;
				$pt = "+==SP==($any)==SEP==($any)==EP==+";
				$ret = preg_replace($pt,'',$ret) ;
			}
		} 
// otherwise all {a} are reinstated. 
			$ret = preg_replace("+==SEP==($any)==EP==+","|$1}",$ret) ;
			$ret = preg_replace("+==SP==+","{",$ret) ;
			$ret = preg_replace("+==EP==+","}",$ret) ;
			$ret = preg_replace("/__(\d+)/","[$1]",$ret) ;
// remove all remaining converted strange strings
		$ret = preg_replace("+==IF==+","[[",$ret) ;
		$ret = preg_replace("+==ELSE==+","||",$ret) ;
		$ret = preg_replace("+==ENDIF==+","]]",$ret) ;
		$ret = preg_replace('+ ====== +','',$ret) ;
		return $ret ;
	}
	
	
}

function is_multi($array) {
	return (count($array) != count($array, 1));
}
?>