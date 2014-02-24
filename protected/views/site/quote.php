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
							 <?php echo $model->model_year . ' ' . $this->GetMakeName($model->make) . ' ' . $this->GetModelName($model->model); ?>
                        </h2>
                        <img src="" alt="" />
                        
						<label for="">Trim:</label>
			
					<?php 
						// check out the trim field by looking at the model
						$trim = $model->trim;	// get trim from model, will be zero if NOT set, so don't use 0 as a valid select value 
						$trims = array($this->DEFAULT_ANY_VALUE => $this->LANG_ANY_TRIM_PROMPT);
						$trims += $this->GetTrims($model->model);
						echo $form->dropDownList($model, 'trim', $trims, array(
								'prompt' => $this->LANG_TRIM_PROMPT,
								'ajax' => array(
										'type' => 'POST',
										'url' => CController::createUrl('colors'),
										'update' => '#LeadGen_color',
										), 
										'onchange'=>'trimChanged();'
								)
							);
						?>
						
                        <?php echo $form->error($model,'trim'); ?>

						<label for="">Color:</label>
						
						<?php echo $form->error($model,'make'); ?>
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

						
						<?php echo $form->dropDownList($model, 'color', $color_list, array('disabled' =>$disable, 'prompt' => $this->LANG_COLOR_PROMPT));?>
                        <?php echo $form->error($model,'color'); ?>
						<br>
						<?php echo CHtml::submitButton('', array('name'=>'landing', 'id'=>'back')); ?>




                    </div>
                    
                    <!-- START COLUMN 2 -->
                    <div class="quote_column">
                        <h3>Best Dealers in Your Area</h3>
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
                    </div>
                    
                    <!-- START COLUMN 3 -->
                    <div class="quote_column">
						
							<?php echo $form->labelEx($model,'first_name'); ?>
							<?php echo $form->textField($model,'first_name'); ?>
							<?php echo $form->error($model,'first_name'); ?>

							<?php echo $form->labelEx($model,'last_name'); ?>
							<?php echo $form->textField($model,'last_name'); ?>
							<?php echo $form->error($model,'last_name'); ?>

							<?php echo $form->labelEx($model,'phone'); ?>
							<?php echo $form->textField($model,'phone'); ?>
							<?php echo $form->error($model,'phone'); ?>

							<?php echo $form->labelEx($model,'email'); ?>
							<?php echo $form->textField($model,'email'); ?>
							<?php echo $form->error($model,'email'); ?>

							<?php echo $form->labelEx($model,'street_address'); ?>
							<?php echo $form->textField($model,'street_address'); ?>
							<?php echo $form->error($model,'street_address'); ?>

							<?php echo $form->labelEx($model,'user_comment'); ?>
							<?php echo $form->textArea($model,'user_comment'); ?>
							<?php echo $form->error($model,'user_comment'); ?>
                        
                        <p class="quote_city">
							<?php $cs_rec = $this->GetCityState($model->zipcode);?>
							<?php echo $cs_rec->city . ', ' . $cs_rec->state . ' ' . $model->zipcode; ?>
						</p>
						<?php echo $form->hiddenField($model, 'city', array('value'=>$cs_rec->city)); ?>
						<?php echo $form->hiddenField($model, 'state', array('value'=>$cs_rec->state)); ?>
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
			$("#LeadGen_color").empty(); 

			if($("#LeadGen_trim").val() == "") 
			{
				$("#LeadGen_color").prop("disabled", true);
			}
			else
			{
				$("#LeadGen_color").prop("disabled", false);
			}
		}',
  CClientScript::POS_END						// Script insert Position 
);
?>
        
        
