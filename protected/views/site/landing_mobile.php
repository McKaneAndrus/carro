<!DOCTYPE html>
<html>
<head>
   <title>Acha Mobile</title>
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<!-- <script src="http://localhost/carro/protected/extensions/jquery.mobile-1.4.3/jquery.mobile-1.4.3.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://localhost/carro/protected/extensions/jquery.mobile-1.4.3/jquery.mobile-1.4.3.min.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.css">
	<script src="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.js"></script>

	<script>
	var heightDevice=$(window).height()
	$(".container-fluid").css("height", heightDevice);
	</script>

    <style type="text/css">

/*    body {
    	position: absolute;
    	text-align: center;
    	height: 100%;
    	width: 100%;
    	top: 0;
    	bottom: 0;
    }*/

   /* .quote_mobile {
    	background: url('/carro/images/red_shirt.jpg') no-repeat;
    	background-size: 90%;
    	width: 100%;
    	height: 100% }*/

 /*   @media screen and (max-width: 361px) {
    	.container-fluid {
    		width: 100%; }

    	.quote_mobile {
    		background: url('/carro/images/red_shirt.jpg') no-repeat fixed;
    		background-size: 60%;
    		background-position: 50% 15%;
    	}

    	#logo {
    		width: 100%;
    	}
	}*/



    
    
    
   </style>
</head>
<body>
	<div class="quote_mobile">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12"><img src="/carro/images/achacarro_logo.png" id="logo"></div>
			</div>
			<div class="row">
				<div class="col-xs-12"><img src="/carro/images/red_shirt.jpg" id="logo"></div>
			</div>
		</div>
	</div>
</body>
</html>