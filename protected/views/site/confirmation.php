<?php
/* @var $this SiteController */
/* @var $model LeadGen */
/* @var $form CActiveForm */
?>

        <div class="wrapper">
            <div class="confirm_wrapper">
				
				<!-- Need a form here -->
				
				<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'leadgen-form',
						'enableAjaxValidation'=>false,
					  'stateful'=>true,
					)); ?>
				
                <h1>Thank you for your request</h1>
                
                <div class="confirm_message">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque placerat purus ac neque eleifend, vitae pretium ligula pharetra. Integer hendrerit metus sed ultricies pharetra. Morbi cursus diam vulputate sapien eleifend, non vehicula mauris accumsan. Phasellus nec massa est. Praesent a congue massa. Donec sollicitudin ornare sapien eu aliquam. Etiam nulla elit, pretium in volutpat quis, mattis eu massa.</p>
                    <div class="confirm_anotherQuote">
                        <h2>Would you like to get another quote?</h2>
	                        <button title="Get another quote"></button>
							<?php echo CHtml::submitButton('', array('name'=>'restart')); ?>
							<?php echo CHtml::hiddenField('mdl' ,$model->int_modell, array('id' => 'hmdl')); ?>
							<?php echo CHtml::hiddenField('trm' ,$model->int_ausstattung, array('id' => 'htrm')); ?>
	                   
                    </div>
                </div>
                
                <div class="confirm_vehicle">
                    <h2>Your selected vehicle</h2>
						<img id="mmt_img_1" src="images/Mercedes-200x.jpg" alt="" />
						</br>
						<h4 id="mmt_txt_1">Year Make Model</h4>
                </div>
                
                <div class="confirm_affiliates">
                    <h3>Save even more with these offers:</h3>
                    <span>
                        <div>
                            <h5>Affiliate</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque placerat purus ac neque eleifend, vitae pretium ligula pharetra.</p>
                            <button>Get Deal</button>
                        </div>
                        <div>
                            <h5>Affiliate</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque placerat purus ac neque eleifend, vitae pretium ligula pharetra.</p>
                            <button>Get Deal</button>
                        </div>
                        <div>
                            <h5>Affiliate</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque placerat purus ac neque eleifend, vitae pretium ligula pharetra.</p>
                            <button>Get Deal</button>
                        </div>
                    </span>
                </div>
                
                <!-- end yii form here -->
				<?php $this->endWidget(); ?>
				
            </div>
        </div>
<?php
$trim_image_update_code = CHtml::ajax(
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
);

$model_image_update_code = CHtml::ajax(
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
);

$cs = Yii::app()->getClientScript();  
$cs->registerScript(
	'LeadGenJS',							// unique script ID
	'$(document).ready(function() {
		if($("#htrm").val() == -1)
		' . $model_image_update_code . '
		else
		' . $trim_image_update_code . '
	}
	);	
	',
	CClientScript::POS_END					// Script insert Position 
);
?>      
