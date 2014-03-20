<?php
/* @var $this SiteController */
/* @var $model LeadGen */
/* @var $form CActiveForm */
?>        
        <div class="wrapper">
            <div class="quote_wrapper">
                <ol>
                    <li><?php echo Yii::t('LeadGen', '1. Select Trim and Color'); ?></li>
                    <li><?php echo Yii::t('LeadGen', '2. Select Dealers'); ?></li>
                    <li><?php echo Yii::t('LeadGen', '3. Enter Your Info'); ?></li>
                </ol>
                
					<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'leadgen-form',
						'enableAjaxValidation'=>false,
					  'stateful'=>true,
					)); ?>

                    <div class="quote_column">
						<img id="mmt_img_1" src="/images/cars/no_pic.png" alt="" />
						<h4 id="mmt_txt_1"></h4>
						<label for=""><?php echo $form->labelEx($model,'int_ausstattung'); ?></label>
			
					<?php 
						// check out the trim field by looking at the LeadGen model to see if it was ever set
						
						$trim = $model->int_ausstattung;	// get trim (int_ausstattung), will be zero if NOT set, so don't use 0 as a valid select value 
						
						$trims = array(SiteController::DEFAULT_ANY_VALUE => Yii::t('LeadGen','Any Trim'));
						$trims += $this->GetTrims($model->int_modell);
						
						echo $form->dropDownList($model, 'int_ausstattung', $trims, array(
								'prompt' => Yii::t('LeadGen','Select a Trim'),
								'ajax' => array(
										'type' => 'POST',
										'url' => CController::createUrl('colors'),
										'update' => '#LeadGen_int_farbe',		// color select
										), 
										'onchange'=>'trimChanged();'
								)
							);
						?>
						
                        <?php echo $form->error($model,'int_ausstattung'); ?>

						<label for=""><?php echo $form->labelEx($model,'int_farbe'); ?></label>
						
						<?php						
							$color_list = array(SiteController::DEFAULT_ANY_VALUE => Yii::t('LeadGen','Any Color'));

							if($trim == 0)	// empty, not set
							{
								$disable='disable';
							}
							else
								if($trim > 0)	// we have a real trim from the db
								{
									$color_list += $this->GetColors($trim); // get the models if existing post
									$disable='';
								}
								else 			// we have no trim set, so no color enabled
								{
									$disable='';
								}?>

						
						<?php echo $form->dropDownList($model, 'int_farbe', $color_list, array(
								'disabled' =>$disable, 'prompt' => Yii::t('LeadGen','Select a Color')));?>
                        <?php echo $form->error($model,'int_farbe'); ?>

                    </div>
                    
                    <!-- START COLUMN 2 -->
                    <div class="quote_column">
                        
                        <!-- get premium dealers first -->
                        
						<?php $special_dealer_display_count = 3; // 0 = No display of Special Dealers div ?>
						
						<?php $dealer_list = $this->GetDealers($model->int_plz, 10); ?>
						<?php $dealer_select_list = array_keys($dealer_list);?>
						<?php //var_dump($dealer_list); ?>
				
						<?php 
							$dlr_cnt = count($dealer_list);
							if( $dlr_cnt == 0)
							{
								 echo '<h3>' . Yii::t('LeadGen', 'Unable to Locate Local Dealers') . '</h3>';
								 echo Yii::t('LeadGen','Carro Specialist will forward request,') . '</br>';
								 echo Yii::t('LeadGen','Please continue with submission.'). '</br></br>' . Yii::t('LeadGen','Thank You');
							}
							
							if($special_dealer_display_count > 0 && $dlr_cnt)
							{
								echo '<h3>' . Yii::t('LeadGen', 'Best Dealers in Your Area') . '</h3>';
								echo '<div class="quote_special">';

								// Get results, but only top X
							
								$special_dealer_list = array_slice($dealer_list, 0, $special_dealer_display_count, true);
								$special_dealer_select_list = array_keys($special_dealer_list);
							
								echo CHtml::checkBoxList('Inthae[special_dlrs]', $special_dealer_select_list, $special_dealer_list,
								array('separator'=>'', 
										'template'=>'<div class="quote_dealer"><div>{input}</div><div>{label}</div></div>')); 
								
								// shift first top N elements off the list as they have been seen above
								
								$dealer_list = array_slice($dealer_list, $special_dealer_display_count, $dlr_cnt, true);
								$dealer_select_list = array_keys($dealer_list);
								echo '</div>';
							}
						?>
				
						<!-- Then all the rest if any -->
						
						<?php
							// if we have more then three, render the more box...
							if(($cnt = count($dealer_list)) > 0)
							{	
								echo '<h3>' . Yii::t('LeadGen', 'More Dealers') . ' (' . $cnt . ') </h3>';
								echo '<div class="quote_more_dealers">';
								echo CHtml::checkBoxList('Inthae[more_dlrs]', $dealer_select_list, $dealer_list,
								array('separator'=>'', 
									'template'=>'<div class="quote_dealer"><div>{input}</div><div>{label}</div></div>')); 
								echo '</div>';
							}
						?>
                        
                    </div>
                    
                    <!-- START COLUMN 3 -->
                    <div class="quote_column">
						
							<?php echo $form->labelEx($model,'int_vname'); ?>
							<?php echo $form->textField($model,'int_vname'); ?>
							<?php echo $form->error($model,'int_vname'); ?>

							<?php echo $form->labelEx($model,'int_name'); ?>
							<?php echo $form->textField($model,'int_name'); ?>
							<?php echo $form->error($model,'int_name'); ?>

							<?php echo $form->labelEx($model,'int_tel'); ?>
							<?php echo $form->textField($model,'int_tel'); ?>
							<?php echo $form->error($model,'int_tel'); ?>

							<?php echo $form->labelEx($model,'int_mail'); ?>
							<?php echo $form->textField($model,'int_mail'); ?>
							<?php echo $form->error($model,'int_mail'); ?>

							<?php echo $form->labelEx($model,'int_str'); ?>
							<?php echo $form->textField($model,'int_str'); ?>
							<?php echo $form->error($model,'int_str'); ?>

							<?php echo $form->labelEx($model,'int_text'); ?>
							<?php echo $form->textArea($model,'int_text'); ?>
							<?php echo $form->error($model,'int_text'); ?>
                        
                        <p class="quote_city">
							<?php $cs_rec = $this->GetCityState($model->int_plz);?>
							<?php echo $cs_rec->city . ', ' . $cs_rec->state . ' ' . $model->int_plz; ?>
							<?php echo '<br>' . bin2hex($cs_rec->state) ?>
						</p>
						
						<?php echo CHtml::hiddenField('mdl' ,$model->int_modell , array('id' => 'hmdl')); ?>
						<?php echo CHtml::submitButton(Yii::t('LeadGen', 'Get Your Price Now'), array('name'=>'submit')); ?>
                        
                    </div>
				<?php $this->endWidget(); ?>
            </div>
        </div>        
<?php

$cs = Yii::app()->getClientScript();  
$cs->registerScript(
	'LeadGenJS',							// unique script ID
	'function trimChanged() 
 	{
			// $("#LeadGen_int_farbe").empty(); 

			if($("#LeadGen_int_ausstattung").val() == "") 
			{
				$("#LeadGen_int_farbe").prop("disabled", true);
			}
			else
			{
			' .	CHtml::ajax(
				   array(
						'url' => Yii::app()->createUrl('site/phototrim'), 
						'type'=>'POST',           
						'dataType'=>'json',
						'data'=>'js:{ "ajax":true, "trim_id":$("#LeadGen_int_ausstattung").val() }',
						'success'=>'js:function(data){
							$("#mmt_img_1").attr("src", data.image_path);
							$("#mmt_img_1").attr("alt", data.image_desc);
							$("#mmt_txt_1").html(data.image_desc);
						 }'
				   )
				) . 
			'
				$("#LeadGen_int_farbe").prop("disabled", false);
			}
	}
	
	$(document).ready(function() 
	{
		if($("#LeadGen_int_ausstattung").val() == "" || $("#LeadGen_int_ausstattung").val() == -1) 
		{
		' .	CHtml::ajax(
			   array(
					'url' => Yii::app()->createUrl('site/photomodel'), 
					'type'=>'POST',           
					'dataType'=>'json',
					'data'=>'js:{ "ajax":true, "model_id":$("#hmdl").val() }',
					'success'=>'js:function(data){
						$("#mmt_img_1").attr("src", data.image_path);
						$("#mmt_img_1").attr("alt", data.image_desc);
						$("#mmt_txt_1").html(data.image_desc);
					 }'
			   )
			) .
		'
		}
		else
		{
			trimChanged();
		' .	CHtml::ajax(
			   array(
					'url' => Yii::app()->createUrl('site/colors'), 
					'type'=>'POST',           
					'data'=>'js:{"LeadGen[int_ausstattung]":$("#LeadGen_int_ausstattung").val() }',
					'success'=>'js:function(html){
						$("#LeadGen_int_farbe").html(html);
					}'
			   )
			) .			
			'
		}
	});	
	',
	CClientScript::POS_END						// Script insert Position 
);
?>
