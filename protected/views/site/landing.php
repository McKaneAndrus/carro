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
						if(!empty($model->attributes['int_fabrikat']))	// (int_fabrikat == make) post vars are saved from page to page in the state, so pick up from here if EVER set
							$make = $model->attributes['int_fabrikat'];
					?>
					
					<?php $makes = CHtml::listData(MakeLookup::model()->findAll(array('order' => 'fab_bez')), 'fab_id', 'fab_bez');	// id and description, order by description
						echo $form->dropDownList($model, 'int_fabrikat', $makes, array(
							'prompt' =>  $this->LANG_MAKE_PROMPT,
							'ajax' => array(
									'type' => 'POST',
									'url' => CController::createUrl('models'),
									'update' =>   '#'. CHtml::activeId($model, 'int_modell'), //selector to update - '#LeadGen_int_modell'
									),			 
									'onchange'=>'makeChanged();'
							)
						);
					?>
					<?php echo $form->error($model,'int_fabrikat'); ?>
				
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

					<?php echo $form->dropDownList($model, 'int_modell', $model_list, array(
							'disabled' =>$disable, 
							'prompt' => $this->LANG_MODEL_PROMPT,
							'onchange' => 'modelChanged();'
							)
						); 
					?>
					
					<?php echo $form->error($model,'int_modell'); ?>

                    </fieldset>
                    <fieldset id="zip_button">
						<?php echo $form->labelEx($model,'int_plz'); ?>
						<?php echo $form->textField($model,'int_plz'); ?>
						<?php echo $form->error($model,'int_plz'); ?>
						<?php echo CHtml::submitButton('', array('name'=>'quote')); ?>
                    </fieldset>
				<?php $this->endWidget(); ?>
            </div>
            <div class="landing_overview">
                <!-- START MAKE LANDING -->
				<div id="show_makes">
					<div class="landing_overview_makeCar">
						<img id="mm_img_1" src="/images/cars/no_pic.png" alt="" />
						<h4 id="mm_txt_1"></h4>
					</div>
					<div class="landing_overview_makeCar">
						<img id="mm_img_2" src="/images/cars/no_pic.png" alt="" />
						<h4 id="mm_txt_2"></h4>
					</div>
					<div class="landing_overview_makeCar">
						<img id="mm_img_3" src="/images/cars/no_pic.png" alt="" />
						<h4 id="mm_txt_3"></h4>
					</div>
                </div>
                
                <div id="show_models" >
					<div class="landing_overview_modelCar">
						<img id="selected_model_img" src="/images/cars/no_pic.png" alt="" />
						<h4 id="selected_model_txt">Year Make Model</h4>
					</div>
					<div class="landing_overview_adspace">
						<h4>Lorem, Ipsum, Etc</h4>
					</div>
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
                <p> Lorem ipsum dolor sit amete, consectetur adipiscing elit. Quisque placerat purus ac neque eleifend, vitae pretium ligula pharetra. Integer hendrerit metus sed ultricies pharetra. Morbi cursus diam vulputate sapien eleifend, non vehicula mauris accumsan. Phasellus nec massa est. Praesent a congue massa. Donec sollicitudin ornare sapien eu aliquam. Etiam nulla elit, pretium in volutpat quis, mattis eu massa. Ut quis nisi eu turpis commodo pulvinar nec vitae quam. Phasellus ac orci ullamcorper, dapibus metus sit amet, ultrices ipsum. Mauris turpis ipsum, adipiscing quis sodales et, imperdiet eget massa. Phasellus vulputate accumsan luctus. Nunc erat magna, vulputate id orci eu, rutrum gravida odio. Suspendisse euismod magna nec augue feugiat, vel vulputate metus rutrum. Vivamus imperdiet pellentesque porta.</p>
                <p>Integer eget viverra diam. Pellentesque tempor eros sapien, in pretium risus tincidunt id. Mauris mi ligula, gravida fermentum sapien sit amet, pellentesque placerat lorem. Mauris feugiat dictum elementum. Nunc pellentesque, mi sit amet faucibus facilisis, est ligula hendrerit leo, a iaculis urna ligula quis nisi. Praesent sit amet lectus quis mauris facilisis scelerisque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec id erat nisl. Etiam vulputate nec lacus in consequat. Nulla pharetra enim sit amet justo condimentum luctus. Sed luctus arcu massa, ut euismod elit fermentum et. Praesent risus augue, tristique varius pellentesque ut, egestas vitae magna. </p>
                <p>Integer eget viverra diam. Pellentesque tempor eros sapien, in pretium risus tincidunt id. Mauris mi ligula, gravida fermentum sapien sit amet, pellentesque placerat lorem. Mauris feugiat dictum elementum. Nunc pellentesque, mi sit amet faucibus facilisis, est ligula hendrerit leo, a iaculis urna ligula quis nisi. Praesent sit amet lectus quis mauris facilisis scelerisque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec id erat nisl. Etiam vulputate nec lacus in consequat. Nulla pharetra enim sit amet justo condimentum luctus. Sed luctus arcu massa, ut euismod elit fermentum et. Praesent risus augue, tristique varius pellentesque ut, egestas vitae magna. </p-->
                <!-- END MODEL LANDING -->
            </div>
        </div>
<?php
$make_image_update_code = CHtml::ajax(
   array(
		'url' => Yii::app()->createUrl('site/photomakes'), 
		'type'=>'POST',           
		'dataType'=>'json',
		'data'=>'js:{ "ajax":true, "make_id":$("#LeadGen_int_fabrikat").val() }',
		'success'=>'js:function(data){
			$("#mm_img_1").attr("src", data[0].image_path);
			$("#mm_img_2").attr("src", data[1].image_path);
			$("#mm_img_3").attr("src", data[2].image_path); 
			$("#mm_txt_1").html(data[0].image_desc);
			$("#mm_txt_2").html(data[1].image_desc);
			$("#mm_txt_3").html(data[2].image_desc);
		 }'
   )
);

$model_image_update_code = CHtml::ajax(
   array(
		'url' => Yii::app()->createUrl('site/photomodel'), 
		'type'=>'POST',           
		'dataType'=>'json',
		'data'=>'js:{ "ajax":true, "model_id":$("#LeadGen_int_modell").val() }',
		'success'=>'js:function(data){
			$("#selected_model_img").attr("src", data.image_path);
			$("#selected_model_txt").html(data.image_desc);
		 }'
   )
);

$model_list_update = CHtml::ajax(
   array(
		'url' => Yii::app()->createUrl('site/models'), 
		'type'=>'POST',           
		'data'=>'js:{"LeadGen[int_fabrikat]":$("#LeadGen_int_fabrikat").val() }',
		'success'=>'js:function(html){
			jQuery("#LeadGen_int_modell").html(html)
		}'
   )
);

$cs = Yii::app()->getClientScript();  
$cs->registerScript(
	'LeadGenJS',							// unique script ID
	'function makeChanged() 
 	{
		// $("#LeadGen_int_modell").empty(); 

		$("#show_makes").show();
		$("#show_models").hide();

		if($("#LeadGen_int_fabrikat").val() == "") 
		{
			$("#LeadGen_int_modell").prop("disabled", true);

			$("#mm_img_1").attr("src", "/images/cars/no_pic.png");
			$("#mm_img_2").attr("src", "/images/cars/no_pic.png");
			$("#mm_img_3").attr("src", "/images/cars/no_pic.png");
			$("#mm_txt_1").html("");
			$("#mm_txt_2").html("");
			$("#mm_txt_3").html("");
		}
		else
		{
			$("#LeadGen_int_modell").prop("disabled", false);

			// get the make and update the images if something selected

		' . $make_image_update_code . '
		}
	}
	
	function modelChanged()
	{
		$("#show_makes").hide();
		$("#show_models").show();

		if($("#LeadGen_int_modell").val() == "") 
		{
			$("#selected_model_img").attr("src", "/images/cars/no_pic.png");
			$("#selected_model_txt").html("");
		}
		else
		{
			$("#LeadGen_int_modell").prop("disabled", false);

			// get the make and update the images if something selected

		' . $model_image_update_code . '
		}
	}
	
	$(document).ready(function() {
		if($("#LeadGen_int_modell").val() != "")
		{
			modelChanged();
		}
		else
		{
			makeChanged();
			
			' . $model_list_update . '
			
		}

		//$("#LeadGen_int_fabrikat option:first-child").attr("selected", "selected");

	});
	'
	,
	CClientScript::POS_END						// Script insert Position 
);
?>
