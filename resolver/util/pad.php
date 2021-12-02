<?php
	function out($s,$return=true) { echo $s.($return?'<br/>':''); }
	function p($s) { echo ('<xmp>') ; print_r($s) ; echo ('</xmp>') ; }

	if ($_SERVER['REQUEST_METHOD']=='POST') {
		$x = file_get_contents("php://input") ;
		eval(trim($x!=='')?$x:"") ;
	} else {
		header('Content-Type: text/html') ;
		echo <<<endendend
<html>
	<head>
		<title>Fabio's pad</title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"> </script>
		<script type="text/javascript" src="http://files.aw20.net/jquery-linedtextarea/jquery-linedtextarea.js"> </script>
		<link href="http://files.aw20.net/jquery-linedtextarea/jquery-linedtextarea.css" type="text/css" rel="stylesheet" />
		<style>
		.style, .linedtextarea textarea {
			font-family: Courier;
			font-size: 10pt;
			tab-size: 2; 
			-moz-tab-size: 2; 
			-o-tab-size: 2;
			vertical-align: 'top';
			overflow: scroll;
			height: 600px ;
		}
		</style>
	</head>
	<body>
		<script type="text/javascript">
			var dir = location.pathname.split("/")
			var appName = "FVpad-"+dir[dir.length-2]
			if (localStorage[appName]) 
				var ls = JSON.parse(localStorage[appName]) ;
			else 
				var ls = {lang: 0, content:[] }
			
			$(document).ready(function(){
				load(ls.lang) ;
								
				$("#sorgente").linedtextarea();

				$('#sorgente').keydown(function() {
					if (event.keyCode == 93) exec() ;
					if (event.keyCode == 9) { 
						event.preventDefault(); 
						var s = this.selectionStart;
						this.value = this.value.substring(0,this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
						this.selectionEnd = s+1; 
					} 
				});
				
				$('#sorgente').keyup(function() {
					if (event.which==186) exec()
				});
			})
			
			function out(t,clear) {
				var h = $('#output').html()
				$('#output').html((clear?"":h)+(t||"")+"<br/>")
			}
			
			function load(n) {
				$("#slider")[0].value = ls.lang = n || $("#slider")[0].value
				$('#sorgente')[0].value = ls.content[ls.lang]
				exec() ;
			}

			function exec() {
				ls.content[ls.lang] = $('#sorgente')[0].value.replace(String.fromCharCode(0),"")
				localStorage[appName]=JSON.stringify(ls);
				
				if (ls.lang==0) {
					$.ajax({ 
						url: document.location ,
						method: 'POST',
						data: ls.content[ls.lang],
						success: function(data) { out(data,true) },
						error: function(r) { out("Error "+r.status+' on resource "'+this.url+'":'+r.statusText); }
					})
				} else {
					out("",true) 
					out(eval(ls.content[ls.lang])) ;
				}
			}
			
		</script>
		<table width="100%" border="1" cellpadding="0" cellspacing="0">
  			<tr>
  			  	<th width="50%"> 
      				PHP <input type="range" id="slider" min="0" max="1" style="width: 40px;" onchange="load()"/> JS
      			</th>
				<th width="50%">Output</th>
			</tr>
			<tr>
				<td valign='top' width="50%"><textarea id='sorgente' rows='40' cols="100" class="style"></textarea></td>
				<td valign='top' width="50%"><div id="output" class="style"> </div></td>
			</tr>
		</table>
	</body>
</html> 
endendend;
	}
?>
