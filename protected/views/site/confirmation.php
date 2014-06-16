<?php
/* @var $this SiteController */
/* @var $model LeadGen */
/* @var $form CActiveForm */
?>
        <div class="wrapper">
            <div class="confirm_wrapper">
				<?php 
				$form=$this->beginWidget('CActiveForm', array('id'=>'leadgen-form',	'enableAjaxValidation'=>false, 'stateful'=>true)); 
				if($model->skipConquest === false)
				{
					echo '<style type="text/css"> .modal-body {max-height: 512px; }</style>';
					$conquest_cars = $this->getConquests($model->int_modell,1);
					// we only look at the first conquest even though more can exist...
					if($conquest_cars !== false)
					{
						$conquest_make = $conquest_cars[0]['make'];
						$conquest_model = $conquest_cars[0]['model'];
						$campaign_id = $conquest_cars[0]['campaign_id'];

						$image_src_info = $this->GetModelImage($model->int_modell);
						$image_dest_info = $this->GetModelImage($conquest_model);
						$src_logo_image = $this->GetMakeLogo($model->int_fabrikat);
						$dest_logo_image = $this->GetMakeLogo($conquest_make);

						$model->conquest_modell = $conquest_model;
						$model->conquest_make = $conquest_make;
						
						$search_img_tags = array(
											'{{src_image}}', 
											'{{dest_image}}',
											'{{src_logo_image}}',
											'{{dest_logo_image}}',
											);
						
						$replace_img_html = array(
											'<img src=' . $image_src_info['image_path'] . '>', 
											'<img src=' . $image_dest_info['image_path'] . '>',
											'<img src=' . $src_logo_image . '>',
											'<img src=' . $dest_logo_image . '>',
											);
						
						// DumbyTemplate system
					  
						$conquest_content = str_replace($search_img_tags, $replace_img_html, $conquest_cars[0]['html']);
					  
						echo '<div class="conquest_modal">';
					  
						$this->widget('bootstrap.widgets.TbModal', array(
						'id' => 'myModal',
						'header' =>  Yii::t('LeadGen', 'Comparible Vehicle'),
						'show'=> true,
						'content' => $conquest_content,
						'footer' => array(
								TbHtml::submitButton(Yii::t('LeadGen', 'OK'), array('name'=>'conquest', 'color' => 'custom')),
								TbHtml::button(Yii::t('LeadGen', 'Close'), array('data-dismiss' => 'modal')),
								),	
						)); 
						echo CHtml::hiddenField('cmake', $conquest_make);
						echo CHtml::hiddenField('cmodel', $conquest_model);
						echo CHtml::hiddenField('csrc', $campaign_id);
						
						echo '</div>';
					}
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
						$("#mmt_img_conq").attr("src", data.image_path);
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
						$("#mmt_img_conq").attr("src", data.image_path);
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
