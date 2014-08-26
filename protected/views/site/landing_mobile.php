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
    	text-align: center;
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
    	height: 180px;
    	width: 60%;
    	background-color: #D7D7D7;
    	border-radius: 5px;
    	position: relative;
    	top: -15px;
    	z-index: 5;
    	max-width: 100%;
  		margin: 0 auto;
  		padding: 5px;

    }

    .select-box {
    	padding: 2px;
    	margin: 5px auto;
    }

    .btn-custom { 
	background-color: hsl(360, 100%, 44%) !important; 
	background-repeat: repeat-x; 
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ff4747", endColorstr="#e00000"); 
	background-image: -khtml-gradient(linear, left top, left bottom, from(#ff4747), to(#e00000)); 
	background-image: -moz-linear-gradient(top, #ff4747, #e00000); 
	background-image: -ms-linear-gradient(top, #ff4747, #e00000); 
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ff4747), color-stop(100%, #e00000)); 
	background-image: -webkit-linear-gradient(top, #ff4747, #e00000); 
	background-image: -o-linear-gradient(top, #ff4747, #e00000); 
	background-image: linear-gradient(#ff4747, #e00000); 
	border-color: #e00000 #e00000 hsl(360, 100%, 39%); 
	margin-top: 15px;
	color: #fff !important; 
	/*text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.33); */
    text-shadow: -1px -1px 0 rgba(0,0,0,.4);

	-webkit-font-smoothing: antialiased; 
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
				<div class="col-xs-12">
					<div class="mmzform">
					<form role="form">
					  <div class="form-group center-block">
					    <select class="form-control select-box" id="makeSelect">
					      <option>Selecione uma Marca</option>
					      <option>2</option>
					      <option>3</option>
					      <option>4</option>
					      <option>5</option>
					      <option>2</option>
					      <option>3</option>
					      <option>4</option>
					      <option>5</option>
					      <option>2</option>
					      <option>3</option>
					      <option>4</option>
					      <option>5</option>
					      <option>2</option>
					      <option>3</option>
					      <option>4</option>
					      <option>5</option>
					      <option>2</option>
					      <option>3</option>
					      <option>4</option>
					      <option>5</option>
					    </select>
					    <select class="form-control select-box" id="modelSelect" disabled="disabled">
					      <option>Selecione um Modelo</option>
					      <option>2</option>
					      <option>3</option>
					      <option>4</option>
					      <option>5</option>
					    </select>
					    <input type="text" class="form-control" placeholder="Código Postal">
					    <button class="btn btn-custom">Consiga o Melhor Preco</button>
					  </div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<script>
alert("did I even do this?");
$(#makeSelect).onchange({
	alert("heyo");
	if($(#makeSelect).val()!="Selecione uma Marca")
		{	alert("homerfree");
			$(#modelSelect).prop('disabled', false);}
})

</script>
</body>
</html>