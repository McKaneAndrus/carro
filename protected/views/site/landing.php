<?php
/* @var $this SiteController */
/* @var $model LeadGen */
/* @var $form CActiveForm */
?>
        <div class="wrapper">
            <div class="landing_main">
                <h1>Let us help you get the best deal</h1>
                <h2>Before you buy a new car, compare prices and financing from several dealers and banks</h2>
                
					<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'leadgen-form',
						'enableAjaxValidation'=>false,
					  'stateful'=>true,
					)); ?>

                    <fieldset id="mm_selects">

					<?php 
						if(!empty($model->attributes['make']))	// post vars are saved from page to page in the state, so pick up from here if EVER set
							$make = $model->attributes['make'];
					?>
					
					<?php $makes = CHtml::listData(MakeLookup::model()->findAll(array('order' => 'fab_bez')), 'fab_id', 'fab_bez');	// id and description, order by description
						echo $form->dropDownList($model, 'make', $makes, array(
							'prompt' =>  $this->LANG_MAKE_PROMPT,
							'ajax' => array(
									'type' => 'POST',
									'url' => CController::createUrl('models'),
									'update' =>   '#'. CHtml::activeId($model, 'model'), //selector to update - '#LeadGen_model'
									),			 
									'onchange'=>'makeChanged();'
							)
					);
					?>
					<?php echo $form->error($model,'make'); ?>
					
					<?php 
						if(!empty($make))
						{
							$model_list = $this->GetModels($make); // get the models if existing post
							$disable='';
						}
						else
						{
							$model_list = array();
							$disable='disable';
						}?>

					<?php echo $form->dropDownList($model, 'model', $model_list, array('disabled' =>$disable, 'prompt' => $this->LANG_MODEL_PROMPT)); ?>
					<?php echo $form->error($model,'model'); ?>

                    </fieldset>
                    <fieldset id="zip_button">

						<?php echo $form->labelEx($model,'zipcode'); ?>
						<?php echo $form->textField($model,'zipcode'); ?>
						<?php echo $form->error($model,'zipcode'); ?>
						<?php echo $form->hiddenField($model, 'model_year', array('value'=>'2014')); ?>
						<?php echo CHtml::submitButton('', array('name'=>'quote')); ?>
                    </fieldset>
				<?php $this->endWidget(); ?>
            </div>
            <div class="landing_overview">
                <!-- START MAKE LANDING -->
                <div class="landing_overview_makeCar">
                    <img src="" alt="" />
                    <h4>Year Make Model</h4>
                </div>
                <div class="landing_overview_makeCar">
                    <img src="" alt="" />
                    <h4>Year Make Model</h4>
                </div>
                <div class="landing_overview_makeCar">
                    <img src="" alt="" />
                    <h4>Year Make Model</h4>
                </div>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque placerat purus ac neque eleifend, vitae pretium ligula pharetra. Integer hendrerit metus sed ultricies pharetra. Morbi cursus diam vulputate sapien eleifend, non vehicula mauris accumsan. Phasellus nec massa est. Praesent a congue massa. Donec sollicitudin ornare sapien eu aliquam. Etiam nulla elit, pretium in volutpat quis, mattis eu massa. Ut quis nisi eu turpis commodo pulvinar nec vitae quam. Phasellus ac orci ullamcorper, dapibus metus sit amet, ultrices ipsum. Mauris turpis ipsum, adipiscing quis sodales et, imperdiet eget massa. Phasellus vulputate accumsan luctus. Nunc erat magna, vulputate id orci eu, rutrum gravida odio. Suspendisse euismod magna nec augue feugiat, vel vulputate metus rutrum. Vivamus imperdiet pellentesque porta.</p>
                <p>Integer eget viverra diam. Pellentesque tempor eros sapien, in pretium risus tincidunt id. Mauris mi ligula, gravida fermentum sapien sit amet, pellentesque placerat lorem. Mauris feugiat dictum elementum. Nunc pellentesque, mi sit amet faucibus facilisis, est ligula hendrerit leo, a iaculis urna ligula quis nisi. Praesent sit amet lectus quis mauris facilisis scelerisque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec id erat nisl. Etiam vulputate nec lacus in consequat. Nulla pharetra enim sit amet justo condimentum luctus. Sed luctus arcu massa, ut euismod elit fermentum et. Praesent risus augue, tristique varius pellentesque ut, egestas vitae magna. </p>
                <p>Integer eget viverra diam. Pellentesque tempor eros sapien, in pretium risus tincidunt id. Mauris mi ligula, gravida fermentum sapien sit amet, pellentesque placerat lorem. Mauris feugiat dictum elementum. Nunc pellentesque, mi sit amet faucibus facilisis, est ligula hendrerit leo, a iaculis urna ligula quis nisi. Praesent sit amet lectus quis mauris facilisis scelerisque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec id erat nisl. Etiam vulputate nec lacus in consequat. Nulla pharetra enim sit amet justo condimentum luctus. Sed luctus arcu massa, ut euismod elit fermentum et. Praesent risus augue, tristique varius pellentesque ut, egestas vitae magna. </p-->
                <!-- END MAKE LANDING -->
            
            <!-- START MODEL LANDING -->
                <!--div class="landing_overview_car">
                    <img src="" alt="" />
                    <h4>Year Make Model</h4>
                </div>
                <h3>Year Make Model</h3>
                <p class="landing_price">Price: <span>$99,999</span> - <span>$99,999</span>
                <br />Your price: Ask Us</p>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque placerat purus ac neque eleifend, vitae pretium ligula pharetra. Integer hendrerit metus sed ultricies pharetra. Morbi cursus diam vulputate sapien eleifend, non vehicula mauris accumsan. Phasellus nec massa est. Praesent a congue massa. Donec sollicitudin ornare sapien eu aliquam. Etiam nulla elit, pretium in volutpat quis, mattis eu massa. Ut quis nisi eu turpis commodo pulvinar nec vitae quam. Phasellus ac orci ullamcorper, dapibus metus sit amet, ultrices ipsum. Mauris turpis ipsum, adipiscing quis sodales et, imperdiet eget massa. Phasellus vulputate accumsan luctus. Nunc erat magna, vulputate id orci eu, rutrum gravida odio. Suspendisse euismod magna nec augue feugiat, vel vulputate metus rutrum. Vivamus imperdiet pellentesque porta.</p>
                <p>Integer eget viverra diam. Pellentesque tempor eros sapien, in pretium risus tincidunt id. Mauris mi ligula, gravida fermentum sapien sit amet, pellentesque placerat lorem. Mauris feugiat dictum elementum. Nunc pellentesque, mi sit amet faucibus facilisis, est ligula hendrerit leo, a iaculis urna ligula quis nisi. Praesent sit amet lectus quis mauris facilisis scelerisque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec id erat nisl. Etiam vulputate nec lacus in consequat. Nulla pharetra enim sit amet justo condimentum luctus. Sed luctus arcu massa, ut euismod elit fermentum et. Praesent risus augue, tristique varius pellentesque ut, egestas vitae magna. </p>
                <p>Integer eget viverra diam. Pellentesque tempor eros sapien, in pretium risus tincidunt id. Mauris mi ligula, gravida fermentum sapien sit amet, pellentesque placerat lorem. Mauris feugiat dictum elementum. Nunc pellentesque, mi sit amet faucibus facilisis, est ligula hendrerit leo, a iaculis urna ligula quis nisi. Praesent sit amet lectus quis mauris facilisis scelerisque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec id erat nisl. Etiam vulputate nec lacus in consequat. Nulla pharetra enim sit amet justo condimentum luctus. Sed luctus arcu massa, ut euismod elit fermentum et. Praesent risus augue, tristique varius pellentesque ut, egestas vitae magna. </p-->
                <!-- END MODEL LANDING -->
            </div>
        </div>

<?php
$cs = Yii::app()->getClientScript();  
$cs->registerScript(
	'LeadGenJS',							// unique script ID
	'function makeChanged() 
 	{
			$("#LeadGen_model").empty(); 

			if($("#LeadGen_make").val() == "") 
			{
				$("#LeadGen_model").prop("disabled", true);
			}
			else
			{
				$("#LeadGen_model").prop("disabled", false);
			}
		}',
  CClientScript::POS_END						// Script insert Position 
);
?>
