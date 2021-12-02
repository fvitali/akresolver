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

function apply($clean=false) {
		$values = array_merge($this->values,self::$staticValues) ;
		$ret = $this->tpl ;
		$ret = preg_replace("+\[+","£IF£",$ret) ;
		$ret = preg_replace("+\{+","£SP£",$ret) ;
		$ret = preg_replace("+\}+","£EP£",$ret) ;
		$ret = preg_replace("+\|+","£ELSE£",$ret) ;
		$ret = preg_replace("+\]+","£ENDIF£",$ret) ;
		$any = '[^£]*' ;
		foreach ($values as $k => $v) {
			$pt = "+£IF£($any)£SP£($k)£EP£($any)£ELSE£($any)£ENDIF£+" ;
			$ret = preg_replace($pt,"$1 £££ $v £££ $3",$ret) ;
		}
		foreach ($values as $k => $v) {
			$pt = "+£IF£($any)£SP£($any)£EP£($any)£ELSE£($any)£ENDIF£+" ;
			$ret = preg_replace($pt,"$4",$ret) ;
		}
		foreach ($values as $k => $v) {
			$pt = "+£IF£($any)£SP£($k)£EP£($any)£ENDIF£+" ;
			$ret = preg_replace($pt,"$1 £££ $v £££ $3",$ret) ;
		}
		foreach ($values as $k => $v) {
			$pt = "+£IF£($any)£SP£($any)£EP£($any)£ENDIF£+" ;
			$ret = preg_replace($pt,"",$ret) ;
		}
		foreach ($values as $k => $v) {
			$pt = "+£SP£($k)£EP£+" ;
			$ret = preg_replace($pt,"$v",$ret) ;
		}
		foreach ($values as $k => $v) {
			$pt = "+£SP£($any)£EP£+" ;
			$ret = preg_replace($pt,"",$ret) ;
		}
		$ret = preg_replace('+ £££ +','',$ret) ;
		return $ret ;
	}
	
	
}

?>