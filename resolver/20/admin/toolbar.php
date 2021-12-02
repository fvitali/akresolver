<!DOCTYPE html>
<html lang="en"                                                          ng-app="wrapApp">
	<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">

			<!-- Bootstrap core CSS -->
			<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">

			<!-- Custom styles for this template -->
	
			<link href='<?PHP echo "$pathBase/admin/toolbar.css" ?>' rel="stylesheet">

			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
				<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
				<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
			<![endif]-->
			<script>
				var theFeatures = JSON.parse('<?PHP echo str_replace(chr(39),chr(92).chr(39),str_replace(chr(47),chr(92).chr(47),json_encode($features))); ?>')
				var pathBase = '<?PHP echo $pathBase; ?>'
			</script>
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular.min.js"></script>
		<!--	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script> -->
			<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.10.0.js"></script>
			<script src='<?PHP echo "$pathBase/admin/toolbar.js" ?>'> </script>
	</head>
	<body                                                     ng-controller="wrapAppCtrl">
		<script>
			var wrapApp = angular.module('wrapApp', ['ui.bootstrap']);
			wrapApp.controller('wrapAppCtrl', function($scope) {
				$scope.f = theFeatures
			});
		</script>
		<div 	class="navbar navbar-default" 
				role="navigation" 
				id="toolbar">
			<div class="navbar-header">
				<button type="button" 
						class="navbar-toggle" 
						data-toggle="collapse" 
						data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<span class="navbar-brand"> Akoma Ntoso URI Resolver </span>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							Requested URI <i>{{f.features.path}}</i> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu corrextWidth">
							<li><a ng-href="{{f.pathBase}}{{f.manifURI}}">Resolved manifestation URI: <i>{{f.manifURI}}</i></a></li>
							<li><a ng-href="{{f.preferred}}">Physical item URL: <i>{{f.preferred}}</i></a></li>
							<li class="divider" id="suggestions"> </li>
							<li ng-repeat='s in f.suggestions'><a ng-href="{{f.pathBase}}/{{s}}">See also <i>{{s}}</i></a></li>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
				<li class='dropdown'><a href="#" role="dropdown-toggle" data-toggle="dropdown">
					<span title='Options' class="larger glyphicon glyphicon-cog"></span></a>
					<ul class="dropdown-menu veryWide">
						<li><a href="#" role="button" data-toggle="modal" data-target="#about">About...</a></li>
						<li><a href="#" role="button" data-toggle="modal" data-target="#license">License...</a></li>
						<li class="divider"> </li>
						<li><a href="#" role="button" data-toggle="modal" data-target="#help">Help...</a></li>
						<li><a href="#" role="button" data-toggle="modal" data-target="#pref">Preferences...</a></li>
						<li><a href="/admin/documentation.html" role="button">Documentation...</a></li>
						<li class="divider"> </li>
						<li><a href="#" role="button" data-toggle="modal" data-target="#details">Resolution details...</a></li>
					</ul>
				</li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
		<div id='iframe'>
		</div>
		<div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="about" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title">
							<img id='logo' src="" alt="Akoma Ntoso logo" style="height:50px;" />
							About</h3>
					</div>
					<div class="modal-body big">
						<h3 class="text-center text-primary">The Akoma Ntoso URI Resolver</h3>
						<p class="lead text-center text-info">Version 2.0 - March 2014</p>
						<p>By:</p>
						<ul>
							<li><a href="mailto:fabio.vitali@unibo.it">Fabio Vitali</a>, <i class="small">Department of Computer
							Science and Engineering, University of Bologna</i></li>
							<li><a href="mailto:monica.palmirani@unibo.it">Monica Palmirani</a>, <i class="small">CIRSFID, University of Bologna</i></li>
							<li><a href="mailto:luca.cervone@unibo.it">Luca Cervone</a>, <i class="small">CIRSFID, University of Bologna</i></li>
						</ul>
						<div class="text-right">
							<button type="button" class="closeButton btn btn-primary" data-close='about'>Ok</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="license" tabindex="-1" role="dialog" aria-labelledby="license" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title">
 							License</h3>
					</div>
					<div class="modal-body big">
						<?PHP include 'license.html' ?>
						<div class="text-right">
							<button type="button" class="closeButton btn btn-primary" data-close='license'>Ok</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title">
							Help</h3>
					</div>
					<div class="modal-body big">
						<?PHP include 'info.html' ?>
						<div class="text-right">
							<button type="button" class="closeButton btn btn-primary" data-close='help'>Ok</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="details" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Details</h4>
					</div>
					<div class="modal-body big">
						<?PHP include 'details.html' ?>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="pref" tabindex="-1" role="dialog" aria-labelledby="preferences" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Preferences</h4>
					</div>
					<div class="modal-body big">
						<?PHP include 'prefs.html' ?>
					</div>
				</div>
			</div>
		</div>
<script type="text/javascript" id="cookiebanner"
    src="<?PHP echo "$pathBase/admin/cookiebanner.js" ?>"
    data-height="40px" data-position="bottom"
    data-message="Usiamo cookie per garantire il funzionamento di questo servizio. We use cookies to provide this service.">
</script>
	</body>
</html>
