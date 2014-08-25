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
    <link rel="stylesheet" href="http://localhost/carro/protected/extensions/jquery.mobile-1.4.3/jquery.mobile-1.4.3.min.css"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.css">
	<script src="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.js"></script>-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


	<script>
	/*var heightDevice=$(window).height()
	$(".container").css("height", heightDevice);*/
	</script>

    <style type="text/css">

    body {
    	background-color: #fff;
    }

    .center-block {
  		display: block;
  		margin-left: auto;
 		margin-right: auto;
	}

    #background{
    	width: 50%;
    	height: 50%;
    }

    .mmzform {
    	height: 120px;
    	width: 80%;
    	background-color: #D7D7D7;
    	border-radius: 5px;
    	position: relative;
    	top: -10px;
    	z-index: 5;
    	max-width: 100%;

    }

    .select-box {
    	padding: 2px;
    	margin: 8px;
    }

/*    body {
    	position: absolute;
    	text-align: center;
    	height: 100%;
    	width: 100%;
    	top: 0;
    	bottom: 0;
    }*/

   /* .landing_mobile {
    	background: url('/carro/images/red_shirt.jpg') no-repeat;
    	background-size: 90%;
    	width: 100%;
    	height: 100% }*/

 /*   @media screen and (max-width: 361px) {
    	.container {
    		width: 100%; }

    	.landing_mobile {
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
	<div class="landing_mobile">
		<div class="container">
			<div class="row">
				<div class="col-xs-12"><img src="/carro/images/achacarro_logo.png" id="logo" class="img-responsive center-block"></div>
			</div>
			<div class="row">
				<div class="col-xs-12"><img src="/carro/images/red_shirt.jpg" id="background" class="img-responsive center-block"></div>
			</div>
			<div class="row">
				<div class="col-xs-12 mmzform">
					<form role="form">
					  <div class="form-group">
					    <select class="form-control select-box">
					      <option>Selecione uma Marca</option>
					      <option>2</option>
					      <option>3</option>
					      <option>4</option>
					      <option>5</option>
					    </select>
					    <select class="form-control select-box">
					      <option>Selecione um Modelo</option>
					      <option>2</option>
					      <option>3</option>
					      <option>4</option>
					      <option>5</option>
					    </select>
					  </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>