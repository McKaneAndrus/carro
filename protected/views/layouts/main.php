<?php /* @var $this Controller */ ?>
<?php Yii::app()->bootstrap->register(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="carro novo, cotacao gratis, preco do carro novo, Achacarro" />
  	<meta name="description" content="Procurando uma otima oferta no seu carro novo? Nossa rede de concessionárias está interessada em lhe oferecer ótimas ofertas na compra do seu carro novo." />
	<meta http-equiv="Content-Language" content="pt-BR" />

	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/ico" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" /> 


	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
</head>

<body>

<div class="container" id="page">
	<div id="header">
            <div class="header_wrapper">
                <a href="<?php echo Yii::app()->request->baseUrl; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/achacarro_logo.png" alt="Achacarro" class="header_logo"/></a>
            </div>
	</div><!-- header -->

	<?php echo $content; ?>

	<div class="clear"></div>
        <footer>
            <div class="footer_wrapper">
                <div>
                    <span class="footer_carro">
						<a href="<?php echo Yii::app()->request->baseUrl; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/achacarro_logo_sm.png" alt="Achacarro" class="footer_logo"/></a>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <a href="<?php echo Yii::app()->request->baseUrl; ?>/about">About</a> <a href="<?php echo Yii::app()->request->baseUrl; ?>/privacy">Privacy</a> Copyright &copy; 2014 Revmaker
                    </span>
                </div>
            </div> <!-- footer_wrapper -->
        </footer>
</div><!-- page -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-51074389-1', 'achacarro.com');
  ga('send', 'pageview');
</script>
</body>
</html>
