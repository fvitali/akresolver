<!DOCTYPE html>
<html lang="en"                                                          ng-app="frameApp">
	<head>
			<meta charset="utf-8">
			<meta9 http-equiv="X-UA-Compatible" content="IE=edge">
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
		<h1>Error 422 - Unprocessable entity </h1>
		<h2> <?PHP echo $data['error']; ?> </h2>
		<p>In the following you can find details about the error</p>
		<pre class="q"><?PHP print_r($data)?> </pre>
		<?PHP include 'prefs.html' ?>
<script type="text/javascript" id="cookiebanner"
    src="<?PHP echo "$pathBase/admin/cookiebanner.js" ?>"
    data-height="40px" data-position="bottom"
    data-message="Usiamo cookie per garantire il funzionamento di questo servizio. We use cookies to provide this service.">
</script>
	</body>
</html>
