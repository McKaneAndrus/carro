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
						<img id="mmt_img_1" src="<?php echo Yii::app()->request->baseUrl;?>/images/no_pic.jpg" alt="" />
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

						<?php
						
						// get check box options from db
						
						$options_list = $this->getQuoteOptions();
						if(count($options_list))
						{
							echo CHtml::label(Yii::t('LeadGen', 'Select Options'), false);
							echo '<div class="quote_options_cb">';
							$options_select_list = array_keys($options_list);
							echo TbHtml::checkBoxList('optionsCb', $options_select_list, $options_list, $htmlOptions = array()); 
							echo '</div>';
						}	
						?>

                    </div>
                    
                    <!-- START COLUMN 2 -->
                    <div class="quote_column">
						<?php						
							if(($logo_url = $this->GetMakeLogo($model->int_fabrikat)) !== false)
							{
								echo '<img src=' . $logo_url . '>';
							}	

							$special_dealer_display_count = 5; // 0 = No display of Special Dealers div
							$dealer_list = $this->GetDealers($model->int_fabrikat, $model->int_plz, $special_dealer_display_count);
							$dealer_select_list = array_keys($dealer_list);

							$dlr_cnt = count($dealer_list);
							if( $dlr_cnt == 0)
							{
								 echo '<strong>' . Yii::t('LeadGen', 'Unable to Locate Local Dealers') . '</strong>';
								 echo '<p>' . Yii::t('LeadGen','Carro Specialist will forward request,') . '</br></p>';
								 echo Yii::t('LeadGen','Please continue with submission.'). '</br></br>' . Yii::t('LeadGen','Thank You');
							}
							
							if($special_dealer_display_count > 0 && $dlr_cnt)
							{
								/* 
								REMOVE, TEXT TOO LENGTHY 
								echo '<div class="quote_checkbox">';
								echo '<img src="'. Yii::app()->request->baseUrl . '/images/checkbox-green-sm.png">';
								echo '<div>' . Yii::t('LeadGen','Select more than one dealer to receive multiple price quotes. This will give you additional negotiation power at the dealership and save you money on your next new car purchase.') . '</div>';
								echo '</div>';
								*/
								
								echo '<strong>' . Yii::t('LeadGen', 'Best Dealers in Your Area') . '</strong>';
								echo '<div class="quote_special">';

								// Get results, but only top X
							
								$special_dealer_list = array_slice($dealer_list, 0, $special_dealer_display_count, true);
								$special_dealer_select_list = array_keys($special_dealer_list);
							
								echo CHtml::checkBoxList('Inthae[special_dlrs]', $special_dealer_select_list, $special_dealer_list,
								array('separator'=>'', 
										'template'=>'<div class="quote_dealer"><div>{input}</div><div>{label}</div></div>')); 
								
								echo '</div>';
							}
						?>
                        
                    </div>
                    
                    <!-- START COLUMN 3 -->
                    <div class="quote_column">
					<?php	
							echo $form->labelEx($model,'int_vname');
							echo $form->textField($model,'int_vname');
							echo $form->error($model,'int_vname');

							echo $form->labelEx($model,'int_name');
							echo $form->textField($model,'int_name');
							echo $form->error($model,'int_name');

							echo $form->labelEx($model,'int_tel');
							echo $form->textField($model,'int_tel');
							echo $form->error($model,'int_tel');

							echo $form->labelEx($model,'int_mail');
							echo $form->textField($model,'int_mail');
							echo $form->error($model,'int_mail');

							echo $form->labelEx($model,'int_str');
							echo $form->textField($model,'int_str');
							echo $form->error($model,'int_str'); 

							echo '<p class="quote_city">' . $model->int_stadt . ', ' . $model->int_staat . ' ' . $model->int_plz . '</p>';

							echo $form->labelEx($model,'int_text');
							echo $form->textArea($model,'int_text');
							echo $form->error($model,'int_text'); 
							echo '<br>';
							echo CHtml::hiddenField('mdl' ,$model->int_modell , array('id' => 'hmdl'));
							
							echo '<div class="submit_button">' . TbHtml::submitButton(Yii::t('LeadGen', 'Get Your Price Now'), array('id'=>'quote_submit', 'name'=>'submit', 'color' => 'custom', 'size' => TbHtml::BUTTON_SIZE_LARGE));
							$this->widget('bootstrap.widgets.TbModal', array(
								'id' => 'ModalTrust',
								'header' => Yii::t('LeadGen', 'Privacy Information'),
								'show'=> false,
								'content' => '<img  src="'. Yii::app()->request->baseUrl . '/images/privacy_1.png">' . Yii::t('LeadGen', 'We do not sell or release your information to anyone but the dealers.'),
								'footer' => array(TbHtml::button(Yii::t('LeadGen','Close'), array('data-dismiss' => 'modal', 'color'=> 'custom'))),
							));
							echo '<img id="privacy_img_1" data-toggle="modal" data-target="#ModalTrust" src="'. Yii::app()->request->baseUrl . '/images/privacy_1.png">'; 
							echo '</div>';
						?>
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
			if($("#LeadGen_int_ausstattung").val() == "") 
			{
				$("#LeadGen_int_farbe").prop("disabled", true);
			}
			else
			{
				if($("#LeadGen_int_ausstattung").val() == -1)
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
			save_color = $("#LeadGen_int_farbe").val();

		' .	CHtml::ajax(
			   array(
					'url' => Yii::app()->createUrl('site/colors'), 
					'type'=>'POST',           
					'data'=>'js:{"LeadGen[int_ausstattung]":$("#LeadGen_int_ausstattung").val() }',
					'success'=>'js:function(html){
						$("#LeadGen_int_farbe").html(html);
						$("#LeadGen_int_farbe").val(save_color);
					}'
			   )
			) .			
			'
			trimChanged();
		}
	});	
	',
	CClientScript::POS_END						// Script insert Position 
);
?>
