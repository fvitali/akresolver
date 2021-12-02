<!DOCTYPE html>
<html lang="en"                                                          ng-app="frameApp">
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
				var versionNumber = '<?PHP echo $versionNumber; ?>'
				var pathBase = '<?PHP echo $pathBase; ?>'
				var theFeatures = <?PHP echo $response; ?> ;
			</script>
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular.min.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular-cookies.js"></script>
		<!--	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script> -->
			<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.10.0.js"></script>

			<script src='<?PHP echo "$pathBase/admin/toolbar.js" ?>'> </script>
	</head>
	<body                                                     ng-controller="frameAppCtrl">
		<title>{{f.features.title}} -- The Akoma Ntoso IRI Resolver v. {{versionNumber}}</title>
		<script>
			var frameApp = angular.module('frameApp', ['ui.bootstrap','ngCookies']);
			frameApp.controller('frameAppCtrl', function($scope) {
				$scope.pathBase = pathBase
				$scope.f = theFeatures
				$scope.versionNumber = versionNumber
			});
		</script>
<div class="btn-group" style="
	position: absolute; 
	margin: 10px; 
	top: 0px; 
	left: 0px; 
">
	<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> 
		<img src='<?PHP echo "$pathBase/admin/an-2.gif" ?>' alt="Akoma Ntoso IRI Resolver">
	</a>
	<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
		<li class="dropdown-header">Resolution details</li>	
		<li><a href="#">Requested IRI: <i>{{f.features.schema}}{{f.features.path}}</i></a></li>
		<li><a ng-href="{{pathBase}}{{f.manifestation}}">Resolved manifestation IRI: <i>{{f.manifestation}}</i></a></li>
		<li><a ng-href="{{f.preferred}}">Physical item URL: <i>{{f.preferred}}</i></a></li>
		<li><a href="#" role="button" data-toggle="modal" data-target="#details">More resolution details...</a></li>
		<li class="divider" id="suggestions"> </li>
		<li class="dropdown-header">See also:</li>
		<li ng-repeat='s in f.suggestions'><a ng-href="{{pathBase}}{{s}}">{{s}}</a></li>
		<li class="divider" id="suggestions"> </li>
		<li class="dropdown-header">The Akoma Ntoso IRI Resolver v. {{versionNumber}}</li>
		<li><a href="#" role="button" data-toggle="modal" data-target="#about">About...</a></li>
		<li><a href="#" role="button" data-toggle="modal" data-target="#pref">Preferences...</a></li>
		<li><a href="#" role="button" data-toggle="modal" data-target="#license">License...</a></li>
		<li><a href="#" role="button" data-toggle="modal" data-target="#help">Help...</a></li>
		<li><a href='<?PHP echo "$pathBase/admin/documentation.html" ?>' role="button">Documentation...</a></li>
	</ul>
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
						<h3 class="text-center text-primary">The Akoma Ntoso IRI Resolver</h3>
						<p class="lead text-center text-info">Version {{versionNumber}}</p>
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
			<div class="modal-dialog large">
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
		<?PHP include 'prefs.html' ?>
<script type="text/javascript" id="cookiebanner"
    src="<?PHP echo "$pathBase/admin/cookiebanner.js" ?>"
    data-height="40px" data-position="bottom"
    data-message="Usiamo cookie per garantire il funzionamento di questo servizio. We use cookies to provide this service.">
</script>
	</body>
</html>
