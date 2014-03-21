<?php
/* @var $this SiteController */
/* @var $model LeadGen */
/* @var $form CActiveForm */
?>
        <div class="wrapper">
            <div class="landing_main">
                <h1><?php echo Yii::t('LeadGen', 'Let us help you get the best deal'); ?></h1>
                <h2><?php echo Yii::t('LeadGen', 'Before you buy a new car, compare prices and financing from several dealers and banks'); ?></h2>
                
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
					
					<?php echo $form->error($model,'int_fabrikat'); ?>
					<?php  $makes = $this->getMakes(); 
						echo $form->dropDownList($model, 'int_fabrikat', $makes, array(
							'prompt' =>  Yii::t('LeadGen', 'Select a Make'), 
							'ajax' => array(
									'type' => 'POST',
									'url' => CController::createUrl('models'),
									'update' =>   '#'. CHtml::activeId($model, 'int_modell'), //selector to update - '#LeadGen_int_modell'
									),			 
									'onchange'=>'makeChanged();'
							)
						);
					?>
				
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

					<?php echo $form->error($model,'int_modell'); ?>
					<?php echo $form->dropDownList($model, 'int_modell', $model_list, array(
							'disabled' =>$disable,
							'prompt' => Yii::t('LeadGen', 'Select a Model'), 
							'onchange' => 'modelChanged();'
							)
						);
					?>

                    </fieldset>

                    <fieldset id="zip_button">
					<?php 
						if(!empty($model->attributes['int_staat']))	// (int_staat == state) post vars are saved from page to page in the state, so pick up from here if EVER set
							$state = $model->attributes['int_staat']; 
					?>
					<?php echo $form->error($model,'int_staat'); ?>
					<?php $states = $this->getStates(); 
						echo $form->dropDownList($model, 'int_staat', $states, array(
							'prompt' =>  Yii::t('LeadGen', 'Select Your State'),
							'ajax' => array(
									'type' => 'POST',
									'url' => CController::createUrl('cities'),
									'update' =>   '#'. CHtml::activeId($model, 'int_stadt'), //selector to update - '#LeadGen_int_stadt'
									),			 
									'onchange'=>'stateChanged();'
							)
						);
					?>

					<?php 
						if(!empty($state))
						{
							$city_list = $this->GetCities($state); // get the models if existing post
							$disable='';
						}
						else
						{
							$city_list = array();
							$disable='disable';
						}?>
					<?php echo $form->error($model,'int_stadt'); ?>
					<?php echo $form->dropDownList($model, 'int_stadt', $city_list, array(
							'disabled' =>$disable, 
							'prompt' => Yii::t('LeadGen', 'Select Your City'), 
							)
						); 
					?>
					<?php // echo CHtml::hiddenField('LeadGen[int_plz]',$model->int_plz, array('id' => 'LeadGen_int_plz')); ?>

                    </fieldset>
					<div id="submit_button">
						<?php echo CHtml::submitButton(Yii::t('LeadGen', 'Get Started'), array('name'=>'quote')); ?>
					</div>
				<?php $this->endWidget(); ?>
            </div>
            <div class="landing_overview">
                <!-- START MAKE LANDING -->
				<div id="show_makes">
					<div class="landing_overview_makeCar">
						<a href="#" id="mm_click_1" title="">
							<img id="mm_img_1" src="" alt="" />
						</a>
						
						<h4 id="mm_txt_1"></h4>
					</div>
					<div class="landing_overview_makeCar">
						<a href="#" id="mm_click_2" title="">
							<img id="mm_img_2" src="" alt="" />
						</a>
						<h4 id="mm_txt_2"></h4>
					</div>
					<div class="landing_overview_makeCar">
						<a href="#" id="mm_click_3" title="">
							<img id="mm_img_3" src="" alt="" />
						</a>
						<h4 id="mm_txt_3"></h4>
					</div>
                </div>
                
                <div id="show_models" >
					<div class="landing_overview_modelCar">
						<img id="selected_model_img" src="" alt="" />
						<h4 id="selected_model_txt">Year Make Model</h4>
					</div>
					<div class="landing_overview_adspace">
						<h4>Lorem, Ipsum, Etc</h4>
					</div>
                </div>
                
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque placerat purus ac neque eleifend, vitae pretium ligula pharetra. Integer hendrerit metus sed ultricies pharetra. Morbi cursus diam vulputate sapien eleifend, non vehicula mauris accumsan. Phasellus nec massa est. Praesent a congue massa. Donec sollicitudin ornare sapien eu aliquam. Etiam nulla elit, pretium in volutpat quis, mattis eu massa. Ut quis nisi eu turpis commodo pulvinar nec vitae quam. Phasellus ac orci ullamcorper, dapibus metus sit amet, ultrices ipsum. Mauris turpis ipsum, adipiscing quis sodales et, imperdiet eget massa. Phasellus vulputate accumsan luctus. Nunc erat magna, vulputate id orci eu, rutrum gravida odio. Suspendisse euismod magna nec augue feugiat, vel vulputate metus rutrum. Vivamus imperdiet pellentesque porta.</p>
                <p>Integer eget viverra diam. Pellentesque tempor eros sapien, in pretium risus tincidunt id. Mauris mi ligula, gravida fermentum sapien sit amet, pellentesque placerat lorem. Mauris feugiat dictum elementum. Nunc pellentesque, mi sit amet faucibus facilisis, est ligula hendrerit leo, a iaculis urna ligula quis nisi. Praesent sit amet lectus quis mauris facilisis scelerisque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec id erat nisl. Etiam vulputate nec lacus in consequat. Nulla pharetra enim sit amet justo condimentum luctus. Sed luctus arcu massa, ut euismod elit fermentum et. Praesent risus augue, tristique varius pellentesque ut, egestas vitae magna. </p>
            </div>
        </div>
<?php

$cs = Yii::app()->getClientScript();  
$cs->registerScript(
	'LeadGenJS',							// unique script ID
	'function updateImages(data)
	 {

			$("#mm_img_1").attr("src", data[0].image_path);
			$("#mm_img_2").attr("src", data[1].image_path);
			$("#mm_img_3").attr("src", data[2].image_path); 
			$("#mm_img_1").attr("alt", data[0].image_desc);
			$("#mm_img_2").attr("alt", data[1].image_desc);
			$("#mm_img_3").attr("alt", data[2].image_desc);
			
			$("#mm_click_1").attr("onclick", "clickMakeModelImage(" + data[0].fab_id + "," + data[0].mod_id + ");");
			$("#mm_click_1").attr("title", data[0].image_desc);
			$("#mm_click_2").attr("onclick", "clickMakeModelImage(" + data[1].fab_id + "," + data[1].mod_id + ");");
			$("#mm_click_2").attr("title", data[1].image_desc);
			$("#mm_click_3").attr("onclick", "clickMakeModelImage(" + data[2].fab_id + "," + data[2].mod_id + ");");
			$("#mm_click_3").attr("title", data[2].image_desc);
		
			$("#mm_txt_1").html(data[0].image_desc);
			$("#mm_txt_2").html(data[1].image_desc);
			$("#mm_txt_3").html(data[2].image_desc);
	}
	
	function makeChanged() 
 	{
		$("#show_makes").show();
		$("#show_models").hide();

		if($("#LeadGen_int_fabrikat").val() == "") 
		{
			' . CHtml::ajax(
				array(
					'url' => Yii::app()->createUrl('site/homepagephotos'), 
					'type'=>'POST',           
					'dataType'=>'json',
					'data'=>'js:{ "ajax":true}',
					'success'=>'js:function(data) {
						updateImages(data);
						$("#LeadGen_int_modell").prop("disabled", true);
					}'
					)		
				) .
			'
		}
		else
		{
			' .CHtml::ajax(
					array(
						'url' => Yii::app()->createUrl('site/photomakes'), 
						'type'=>'POST',           
						'dataType'=>'json',
						'data'=>'js:{ "ajax":true, "make_id":$("#LeadGen_int_fabrikat").val() }',
						'success'=>'js:function(data) {
							updateImages(data);
							$("#LeadGen_int_modell").prop("disabled", false);
						}'
						)
				) . 
			'
		}
	}
	
	function modelChanged()
	{
		if($("#LeadGen_int_modell").val() == "" || $("#LeadGen_int_modell").val() == null) 
		{
			$("#show_makes").show();
			$("#show_models").hide();

			$("#selected_model_img").attr("src", "/images/cars/no_pic.png");
			$("#selected_model_txt").html("");
		}
		else
		{
		' .	CHtml::ajax(
			   array(
					'url' => Yii::app()->createUrl('site/photomodel'), 
					'type'=>'POST',           
					'dataType'=>'json',
					'data'=>'js:{ "ajax":true, "model_id":$("#LeadGen_int_modell").val() }',
					'success'=>'js:function(data){
						$("#selected_model_img").attr("src", data.image_path);
						$("#selected_model_txt").html(data.image_desc);
						$("#selected_model_img").attr("alt", data.image_desc);
						$("#LeadGen_int_modell").prop("disabled", false);
					 }'
			   )
			) .
			
			'
		
			$("#show_makes").hide();
			$("#show_models").show();

		}
	}

	function stateChanged() 
 	{
		if($("#LeadGen_int_staat").val() == "") 
		{
			$("#LeadGen_int_stadt").prop("disabled", true);
		}
		else
		{
			$("#LeadGen_int_stadt").prop("disabled", false);
		}
	}
	
	function clickMakeModelImage(make_id, model_id)
	{
	
		$("#LeadGen_int_fabrikat").val(make_id);
		makeChanged();
		
		' . CHtml::ajax(
			array(
				'url' => Yii::app()->createUrl('site/models'), 
				'type'=>'POST', 
				'data'=>'js:{"LeadGen[int_fabrikat]":$("#LeadGen_int_fabrikat").val() }',
				'success'=>'js:function(html){
					jQuery("#LeadGen_int_modell").html(html);
					$("#LeadGen_int_modell").prop("disabled", false);
					$("#LeadGen_int_modell").val(model_id);
					modelChanged();

				}'
				)
			) . '
	}

	$(window).load(function() {

		save_model = $("#LeadGen_int_modell").val();
		save_city = $("#LeadGen_int_stadt").val()

		if($("#LeadGen_int_fabrikat").val() != "" && $("#LeadGen_int_fabrikat").val() != null) 
		{
		' .	CHtml::ajax(
			   array(
					'url' => Yii::app()->createUrl('site/models'), 
					'type'=>'POST', 
					'data'=>'js:{"LeadGen[int_fabrikat]":$("#LeadGen_int_fabrikat").val() }',
					'success'=>'js:function(html){
						jQuery("#LeadGen_int_modell").html(html);
						$("#LeadGen_int_modell").val(save_model);
					}'
			   )
			) .
		'				
		}

		makeChanged();
		modelChanged();	

		if($("#LeadGen_int_staat").val() != "" && $("#LeadGen_int_staat").val() != null)
		{
		' .	CHtml::ajax(
			   array(
					'url' => Yii::app()->createUrl('site/cities'), 
					'type'=>'POST',           
					'data'=>'js:{"LeadGen[int_staat]":$("#LeadGen_int_staat").val() }',
					'success'=>'js:function(html){
						jQuery("#LeadGen_int_stadt").html(html);
						$("#LeadGen_int_stadt").val(save_city);
					}'
			   )
			) . 
			'
		}
		
		stateChanged();
	});
	'
	,
	CClientScript::POS_END						// Script insert Position 
);
?>
