'use strict';

/* Controllers */
var tag = '<iframe frameborder="0" wmode="transparent" allowfullscreen="" src="URI"></iframe>'	

$(document).ready(main);

function main() {
	addIframe('iframe', theFeatures['preferred']) 
	resizeIframe();
	$('#logo').attr('src',pathBase+"/admin/an.gif") ;
	$(window).resize( function() {resizeIframe();} );
	$('.closeButton').on('click',function() {
		var w = $(this).attr('data-close') ;
		$('#'+w).modal('hide'); 
	})
}

function addIframe(loc,uri) {
	if (uri.substr(0,7) == 'http://' ) {
		tag = tag.replace('URI',uri) 
		$('#'+loc).html(tag)
	}
}

function resizeIframe() {
	$("#iframe").height( WindowHeight() - getObjHeight(document.getElementById("toolbar")) );
}

function WindowHeight() {
	var de = document.documentElement;
	return self.innerHeight ||
		(de && de.clientHeight ) ||
		document.body.clientHeight;
}

function getObjHeight(obj) {
	if( obj.offsetWidth ) {
		return obj.offsetHeight;
	}
	return obj.clientHeight;
}

Array.prototype.indexBy = function(value,prop,reverse) {
	return $.grep(this,function(k) { 
		if (reverse) return k[prop] !== value 
			else return k[prop] == value
		}) 
}

Date.prototype.parse = function(d,f) {
	var defaultFormat = this.preferredInputFormat || "CCYYMMDD" ;
	f = f || defaultFormat
	if (typeof d=='string') {
		var v = d.match(/(\d{2})[- /\\]*(\d{2})[- /\\]*(\d{2})[- /\\]*(\d{2})/)
		var g = f.replace("YYYY","CCYY").match(/([CYMD]{2})[- /\\]*([CYMD]{2})[- /\\]*([CYMD]{2})[- /\\]*([CYMD]{2})/)
		var o = {}; 
		for (var i=1; i<=4; i++) { 
			o[g[i]] = v[i] 
		}; 
		o["YYYY"] = o["CC"]+o["YY"] 
		this.setFullYear(parseInt(o['YYYY'],10))
		this.setMonth(parseInt(o['MM'],10)-1)
		this.setDate(parseInt(o['DD'],10))
	}
	return this
}

Date.prototype.oldToString = Date.prototype.toString;
Date.prototype.toString = function(f) {
	var defaultFormat = this.preferredOutputFormat || "DD/MM/CCYY" ;
	f = (f || defaultFormat).replace("YYYY","CCYY")
	var o = {
		"CC" : Math.floor(this.getFullYear() / 100),
		"YY" : this.getFullYear() % 100,
		"MM" : this.getMonth()+1, 
		"DD" : this.getDate()
	}
	var r = f
	for (var i in o) {
		r = r.replace(i,("00"+o[i]).substr(-2))
	}
	return r
}
