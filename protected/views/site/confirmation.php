<?php
/* @var $this SiteController */
/* @var $model LeadGen */
/* @var $form CActiveForm */
?>
        <div class="wrapper">
            <div class="confirm_wrapper">

				
				<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'leadgen-form',
						'enableAjaxValidation'=>false,
					  'stateful'=>true,
					)); ?>

		
		 <?php
		 
		  if($model->skipConquest === false)
		  {
		  $this->widget('bootstrap.widgets.TbModal', array(
			'id' => 'myModal',
			'header' => 'Conquest Header - You are being Conquested right now!',
			'show'=> true,
			'content' => '<img id="mmt_img_conq" src="' . Yii::app()->request->baseUrl . '/images/no_pic.jpg" alt="" />
<p>This is a test of a modal window that is popped up. It will scroll if the content is too tall, but only if taller then the preset height</p>' 
			. 'Model Id ' . $model->int_modell
			. '<br>Make  Id ' . $model->int_fabrikat,
			'footer' => array(
				TbHtml::submitButton('Conquest Me', array('name'=>'conquest', 'color' => 'custom')),
				TbHtml::button('Cancel', array('data-dismiss' => 'modal')),
					),	
				)); 
			}
		?>
				
                <h1><?php echo Yii::t('LeadGen', 'Thank you for your request'); ?></h1>
                
                <div class="confirm_message">
                    <p><?php echo Yii::t('LeadGen', 'One of the dealers within your neighborhood should contact you within 48 hours to give you great pricing on a car you are looking for.'); ?></p>
                    <p><?php echo Yii::t('LeadGen', 'Achacarro is a transaction facilitator between buyers and dealerships and as such cannot be deemed responsible in case the selected dealerships do not contact or send a proposal to a buyer.'); ?></p>
                    <div class="confirm_anotherQuote">
                        <h2><?php echo Yii::t('LeadGen', 'Would you like to get another quote?'); ?></h2>
							<?php echo TbHtml::submitButton(Yii::t('LeadGen', 'Get Another Quote'), array('name'=>'restart', 'color'=>'custom', 'size'=>TbHtml::BUTTON_SIZE_LARGE)); ?>
							<?php echo CHtml::hiddenField('mdl' ,$model->int_modell, array('id' => 'hmdl')); ?>
							<?php echo CHtml::hiddenField('trm' ,$model->int_ausstattung, array('id' => 'htrm')); ?>
	                   
                    </div>
                </div>
                
                <div class="confirm_vehicle">
                    <h2><?php echo Yii::t('LeadGen', 'Your selected vehicle'); ?></h2>
						<img id="mmt_img_1" src="<?php echo Yii::app()->request->baseUrl;?>/images/no_pic.jpg" alt="" />
						</br>
						<h4 id="mmt_txt_1"></h4>
                </div>
                <!-- end yii form here -->
				<?php $this->endWidget(); ?>
				
            </div>
        </div>
		<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 975361460;
		var google_conversion_language = "en";
		var google_conversion_format = "3";
		var google_conversion_color = "ffffff";
		var google_conversion_label = "LqAACMzMoAkQtKuL0QM";
		var google_remarketing_only = false;
		/* ]]> */
		</script>
		<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/975361460/?label=LqAACMzMoAkQtKuL0QM&amp;guid=ON&amp;script=0"/>
		</div>
		</noscript>        
        
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
						$("#mmt_img_conq").attr("src", data.image_path); // hack test REMOVE 
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
