<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="description" content="Carro Online" />
	<meta name="keywords" content="carro, online, carros" />
	<meta http-equiv="Content-Language" content="pt-BR" />

	<link rel="shortcut icon" href="http://carroonline.terra.com.br/sitestatic/logocarro.ico" type="image/ico" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" /> 


	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
</head>

<body>

<div class="container" id="page">
	<div id="header">
        <header>
            <div class="header_wrapper">
                <a href="http://www.achacarro.com"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ashacarro3.png" alt="AshaCarro" class="header_logo"/></a>
            </div>
	</header>
	</div><!-- header -->

	<?php echo $content; ?>

	<div class="clear"></div>

<!--
	<div id="footer"> 
        <footer>
            <div class="footer_wrapper">
                <div>
                    <span class="footer_carro">
                    </span>
                    <p>Copyright &copy; 2014<br />Revmaker</p>
                </div>
            </div>
        </footer>
	</div>
-->
</div><!-- page -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-42494165-1', 'carroglobo.com');
  ga('send', 'pageview');
</script>
</body>
</html>
