<?php
/* @var $this SiteController */
/* @var $model LeadGen */
/* @var $form CActiveForm */
?>        
        <div class="wrapper">
            <div class="quote_wrapper">
                <ol>
                    <li>1. Select Trim and Color</li>
                    <li>2. Select Dealers</li>
                    <li>3. Enter Your Info</li>
                </ol>
                
					<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'leadgen-form',
						'enableAjaxValidation'=>false,
					  'stateful'=>true,
					)); ?>

                    <div class="quote_column">
                        <h2>
							 <?php echo $this->GetMakeName($model->int_fabrikat) . ' ' . $this->GetModelName($model->int_modell); ?>
                        </h2>
                        <!-- <img src="" alt="" /> add image if wanted from make / model -->
                        
						<label for="">Trim:</label>
			
					<?php 
						// check out the trim field by looking at the model
						
						// $trim = $model->trim;	// get trim from model, will be zero if NOT set, so don't use 0 as a valid select value 
						
						//BEGIN HACK
						$trim = $model->int_modell; // HACK so color will be displayed off of model, disabled color selector is broke because of this
						// END HACK
						
						$trims = array($this->DEFAULT_ANY_VALUE => $this->LANG_ANY_TRIM_PROMPT);
						$trims += $this->GetTrims($model->int_modell);
						
						echo $form->dropDownList($model, 'int_ausstattung', $trims, array(
								'prompt' => $this->LANG_TRIM_PROMPT,
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

						<label for="">Color:</label>
						
						<?php						
							$color_list = array($this->DEFAULT_ANY_VALUE => $this->LANG_ANY_COLOR_PROMPT);

							if($trim == 0)	// empty, not set
							{
								$disable='disable';
							}
							else
								if($trim > 0)	// we have a real trim from the db
								{
									$color_list += $this->GetColors($trim); // get the models for if existing post
									$disable='';
								}
								else 			// we have no trim set, so no color enabled
								{
									$disable='';
								}?>

						
						<?php echo $form->dropDownList($model, 'int_farbe', $color_list, array('disabled' =>$disable, 'prompt' => $this->LANG_COLOR_PROMPT));?>
                        <?php echo $form->error($model,'int_farbe'); ?>
						<br>
						<?php echo CHtml::submitButton('', array('name'=>'landing', 'id'=>'back')); ?>

                    </div>
                    
                    <!-- START COLUMN 2 -->
                    <div class="quote_column">
                        
                        <!-- get premium dealers first -->
                        
                        <h3>Best Dealers in Your Area</h3>
						<?php $dealer_list = $this->GetDealers('01000-123', 10); 
						
						$model->dlrs = $dealer_list;
						?>
						<?php  // var_dump($dealer_list) ?>
                        <div class="quote_special">
							
						<?php $model->dlrs = array_keys($dealer_list); ?>
						<?php  echo $form->CheckBoxList($model, 'dlrs', $dealer_list,  
								array('separator'=>'', 
									  'template'=>'<div class="quote_dealer"><div>{input}</div><div>{label}</div></div>')); 
						?>
						
						</div>

						<!-- Then all the rest-->
                        <h3>More Dealers</h3>
                        <div class="quote_more_dealers">
						<?php $model->dlrs = array_keys($dealer_list); ?>
						<?php  echo $form->CheckBoxList($model, 'dlrs', $dealer_list,  
								array('separator'=>'', 
									  'template'=>'<div class="quote_dealer"><div>{input}</div><div>{label}</div></div>')); 
						?>
						</div>

<!--
						
                        <div class="quote_special">
                            <div class="quote_dealer">
                            <div>
                                <input type="checkbox" />
                            </div>
                            <div>
                                Dealer Name<br />
                                123 Street Name<br />
                                City, State 99999
                            </div>
                        </div>
                            <div class="quote_dealer">
                            <div>
                                <input type="checkbox" />
                            </div>
                            <div>
                                Dealer Name<br />
                                123 Street Name<br />
                                City, State 99999
                            </div>
                        </div>
                            <div class="quote_dealer">
                            <div>
                                <input type="checkbox" />
                            </div>
                            <div>
                                Dealer Name<br />
                                123 Street Name<br />
                                City, State 99999
                            </div>
                        </div>
                        </div>
                        
                        <h3>More Dealers</h3>
                        <div class="quote_more_dealers">
                            <div class="quote_dealer">
                            <div>
                                <input type="checkbox" />
                            </div>
                            <div>
                                Dealer Name<br />
                                123 Street Name<br />
                                City, State 99999
                            </div>
                        </div>
                            <div class="quote_dealer">
                            <div>
                                <input type="checkbox" />
                            </div>
                            <div>
                                Dealer Name<br />
                                123 Street Name<br />
                                City, State 99999
                            </div>
                        </div>
                            <div class="quote_dealer">
                            <div>
                                <input type="checkbox" />
                            </div>
                            <div>
                                Dealer Name<br />
                                123 Street Name<br />
                                City, State 99999
                            </div>
                        </div>
                            <div class="quote_dealer">
                                <div>
                                    <input type="checkbox" />
                                </div>
                                <div>
                                    Dealer Name<br />
                                    123 Street Name<br />
                                    City, State 99999
                                </div>
                            </div>
                        </div>
             -->
                        
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
						</p>
						<?php echo CHtml::submitButton('', array('name'=>'submit')); ?>
                        
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
			$("#LeadGen_int_farbe").empty(); 

			if($("#int_ausstattung").val() == "") 
			{
				$("#LeadGen_int_farbe").prop("disabled", true);
			}
			else
			{
				$("#LeadGen_int_farbe").prop("disabled", false);
			}
		}',
  CClientScript::POS_END						// Script insert Position 
);
?>
        
        
