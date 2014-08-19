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

    <style type="text/css">

    .wrapper {
    	width: 100%;
    	height: 640px;}

    .quote_mobile {
    	background: url('/carro/images/red_shirt.jpg') no-repeat fixed;
    	background-position: 49px;
    	background-size: 70%;
    	width: 100%;
    	height: 100%; }

    #logo {
    	position: relative;
    	right: center; }

    @media screen and (max-width: 361px) {
    	.wrapper {
    		width: 100%;
    		height: 100%;}

    	.quote_mobile {
    		background: url('/carro/images/red_shirt.jpg') no-repeat fixed;
    		background-size: 60%;
    		background-position: 0 15%;
    		width: 100%;
    		height: 100%; }

    	#logo {
    		width: 100%;
    	}
    @
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