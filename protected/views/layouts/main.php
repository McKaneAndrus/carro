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

	<link rel="stylesheet" type="text/css" href="http://carroonline.terra.com.br/sitestatic/css/reset.css"/> 
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" /> 
	
	<!--Fontawesome-->
	<link href="http://carroonline.terra.com.br/sitestatic/css/font-awesome/css/font-awesome.css" rel="stylesheet">
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
</head>

<body>

<div class="container" id="page">
	<div id="header">
        <header>
            <div class="header_wrapper">
                <a href="http://carroonline.terra.com.br/"><img src="images/logo-carro.png" alt="Carro" class="header_logo"/></a>
                <div style="width: 728px; height: 90px; background-color: #ccc;display: inline-block; vertical-align: middle">
					<!--BANNER AD GOES HERE-->
					
<script type="text/javascript"><!--
google_ad_client = "ca-pub-3657518844311529";
/* Horizonal */
google_ad_slot = "1283543855";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>				
					</div>
            </div>
	<nav>
		<!-- added lastItemCssClass for the social -->
		<?php $this->widget('zii.widgets.CMenu',array('encodeLabel'=>false, 'lastItemCssClass'=>'nav_social',
			'items'=>array(
				array('label'=>'Já dirigimos', 'url'=>"http://carroonline.terra.com.br/ja-dirigimos"),
				array('label'=>'Notícias', 'url'=>"http://carroonline.terra.com.br/noticias"),
				array('label'=>'Dicas e Serviços', 'url'=>"http://carroonline.terra.com.br/dicas-e-servicos" ),
				array('label'=>'Vídeos', 'url'=>"http://carroonline.terra.com.br/videos" ),
				array('label'=>'Teste 100 dias', 'url'=>"http://carroonline.terra.com.br/blogs"),
				array('label'=>'Revista Racing', 'url'=>"http://racing.terra.com.br/", 'linkOptions'=>array('target'=>'_blank')),
				array('label'=>'<a target="_blank" href="http://www.facebook.com/revistacarro"><img src="http://carroonline.terra.com.br/sitestatic/images/face-icon.png"></a><a target="_blank" href="http://www.twitter.com/carro_hoje"><img src="http://carroonline.terra.com.br/sitestatic/images/tweet-icon.png"></a>'),
				
			),
		)); ?>
	</nav>
	</header>
	</div><!-- header -->

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer"> <!-- sjg Added Carro Footer -->
        <footer>
            <div class="footer_wrapper">
                <div>
                    <span class="footer_carro">
                        <a href="/"><img width="150" height="46" src="http://carroonline.terra.com.br/sitestatic/images/logo-carro.png"></a>
                        <a target="_blank" href="http://www.assinemotorpress.com.br/Assine-Carro.asp?Site_txt=ASSINEMOTORPRESS&amp;Origem_txt=&amp;Formato_txt=LINKDIRETO&amp;Banner_txt=&amp;Versao_txt=#.UfgjZZJQHzx"><img width="140" height="31" src="http://carroonline.terra.com.br/sitestatic/images/btn-assinar.png"></a>
                    </span>
                    <a href="/" class="footer_motorpress"><img width="155" height="44" src="http://carroonline.terra.com.br/sitestatic/images/logo-motorpress.png"></a>
                    <p>Copyright &copy; 2010<br />Editora MotorPress Brasil</p>
                </div>
                
                <div>
                    <h5>Motorpress</h5>
                    <ul>
    					<li><a target="_blank" href="http://www.motorpressbrasil.com.br/anuncie.asp">Anuncie</a></li>
    					<li><a rel="nofollow" target="_blank" href="http://www.assinemotorpress.com.br/">Assinaturas</a></li>
    					<li><a target="_blank" href="http://www.assinemotorpress.com.br/faleconosco">Expediente</a></li>
    					<li><a target="_self" href="http://carroonline.terra.com.br/contato">Fale Conosco</a></li>
    				</ul>
                </div>
                
                <div>
                    <h5>Revistas</h5>
                    <ul>
					    <li><a target="_blank" href="http://motociclismo.terra.com.br/">Motociclismo</a></li>
                        <li><a target="_blank" href="http://racing.terra.com.br/">Racing</a></li>
                        <li><a target="_blank" href="http://sportlife.terra.com.br/">Sport Life</a></li>
                        <li><a target="_blank" href="http://www.revistatransportemundial.com.br/">Transporte Mundial</a></li>
                    </ul>
				</div>
				
				<div>
				    <h5>Na Rede</h5>
                    <ul class="footer_social">
					    <li><a target="_blank" href="http://carroonline.terra.com.br/rss"><span class="footer_rss"></span>RSS</a></li>
                        <li><a target="_blank" href="http://www.facebook.com/revistacarro"><span class="footer_facebook"></span>Facebook</a></li>
                        <li><a target="_blank" href="http://twitter.com/carroonline/"><span class="footer_twitter"></span>Twitter</a></li>
                        <li><a target="_blank" href="http://www.youtube.com/carroonline "><span class="footer_youtube"></span>Youtube</a></li>
					    <li><a target="_blank" href="http://instagram.com/revistacarro/"><span class="footer_instagram"></span>Instagram</a></li>
                    </ul>
				</div>
            </div>
        </footer>
	</div><!-- footer -->
</div><!-- page -->

</body>
</html>
