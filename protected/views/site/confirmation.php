<?php
/* @var $this SiteController */
/* @var $model LeadGen */
/* @var $form CActiveForm */
?>
		<!--main nav bar -->
		<nav>
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

        <div class="wrapper">
            <div class="confirm_wrapper">
				
				<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'leadgen-form',
						'enableAjaxValidation'=>false,
					  'stateful'=>true,
					)); ?>
				
                <h1><?php echo Yii::t('LeadGen', 'Thank you for your request'); ?></h1>
                
                <div class="confirm_message">
                    <p><?php echo Yii::t('LeadGen', 'One of the dealers within your neighborhood should contact you within 48 hours to give you great pricing on a car you are looking for.'); ?></p>
                    <div class="confirm_anotherQuote">
                        <h2><?php echo Yii::t('LeadGen', 'Would you like to get another quote?'); ?></h2>
							<?php echo CHtml::submitButton(Yii::t('LeadGen', 'Get Another Quote'), array('name'=>'restart')); ?>
							<?php echo CHtml::hiddenField('mdl' ,$model->int_modell, array('id' => 'hmdl')); ?>
							<?php echo CHtml::hiddenField('trm' ,$model->int_ausstattung, array('id' => 'htrm')); ?>
	                   
                    </div>
                </div>
                
                <div class="confirm_vehicle">
                    <h2><?php echo Yii::t('LeadGen', 'Your selected vehicle'); ?></h2>
						<img id="mmt_img_1" src="<?php echo Yii::app()->request->baseUrl;?>/images/no_pic.png" alt="" />
						</br>
						<h4 id="mmt_txt_1"></h4>
                </div>
                
                <div class="confirm_affiliates">
                    <h3><?php echo Yii::t('LeadGen', 'Save even more with these offers');?></h3>
                    <span>
                        <div>
                            <h5><?php echo Yii::t('LeadGen', 'Affiliate'); ?></h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque placerat purus ac neque eleifend, vitae pretium ligula pharetra.</p>
                            <button><?php echo Yii::t('LeadGen', 'Get Deal'); ?></button>
                        </div>
                        <div>
                            <h5><?php echo Yii::t('LeadGen', 'Affiliate'); ?></h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque placerat purus ac neque eleifend, vitae pretium ligula pharetra.</p>
                            <button><?php echo Yii::t('LeadGen', 'Get Deal'); ?></button>
                        </div>
                        <div>
                            <h5><?php echo Yii::t('LeadGen', 'Affiliate'); ?></h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque placerat purus ac neque eleifend, vitae pretium ligula pharetra.</p>
                            <button><?php echo Yii::t('LeadGen', 'Get Deal'); ?></button>
                        </div>
                    </span>
                </div>
                
                <!-- end yii form here -->
				<?php $this->endWidget(); ?>
				
            </div>
        </div>
<?php
$cs = Yii::app()->getClientScript();  
$cs->registerScript(
	'LeadGenJS',							// unique script ID
	'$(document).ready(function() {
		if($("#htrm").val() == -1)
		{
		' .	CHtml::ajax(
				array(
					'url' => Yii::app()->createUrl('site/photomodel'), 
					'type'=>'POST',           
					'dataType'=>'json',
					'data'=>'js:{ "ajax":true, "model_id":$("#hmdl").val() }',
					'success'=>'js:function(data){
						$("#mmt_img_1").attr("src", data.image_path);
						$("#mmt_txt_1").html(data.image_desc);
					 }'
				)
			) .
			'
		}
		else
		{
		' .	CHtml::ajax(
			   array(
					'url' => Yii::app()->createUrl('site/phototrim'), 
					'type'=>'POST',           
					'dataType'=>'json',
					'data'=>'js:{ "ajax":true, "trim_id":$("#htrm").val() }',
					'success'=>'js:function(data){
						$("#mmt_img_1").attr("src", data.image_path);
						$("#mmt_txt_1").html(data.image_desc);
					 }'
			   )
			) .
		'
		
		}
	}
	);	
	',
	CClientScript::POS_END
);
?>      
