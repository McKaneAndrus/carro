<!DOCTYPE html>
<html>
<head>
   <title>Acha Mobile</title>
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<!-- <script src="http://localhost/carro/protected/extensions/jquery.mobile-1.4.3/jquery.mobile-1.4.3.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://localhost/carro/protected/extensions/jquery.mobile-1.4.3/jquery.mobile-1.4.3.min.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.css">
	<script src="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.js"></script>

	<script>
	var heightDevice=$(window).height()
	$(".wrapper").css("height", heightDevice);
	</script>

    <style type="text/css">

    body {
    	position: absolute;
    	text-align: center;
    	height: 100%;
    	width: 100%;
    	top: 0;
    	bottom: 0;
    }

    .wrapper {
    	width: 100%;
    	height: 100%;
    }

    .quote_mobile {
    	background: url('/carro/images/red_shirt.jpg') no-repeat fixed;
    	background-position: 49px;
    	background-size: 90%;
    	width: 100%;
    	height: 100% }

    #logo {
    	position: absolute;
    	right: center; }

    @media screen and (max-width: 361px) {
    	.wrapper {
    		width: 100%; }

    	.quote_mobile {
    		background: url('/carro/images/red_shirt.jpg') no-repeat fixed;
    		background-size: 60%;
    		background-position: 50% 15%;
    	}

    	#logo {
    		width: 100%;
    	}
	}



    
    
    
   </style>
</head>
<body>
	<div class="wrapper">
		<div class="quote_mobile">
			<img src="/carro/images/achacarro_logo.png" id="logo">
		</div>
	</div>
</body>
</html>