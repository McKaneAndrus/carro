<?php
/* @var $this SiteController */
/* @var $model LeadGen */
/* @var $form CActiveForm */
?>
<div class="wrapper">
	<div class="landing_main">
		<h1><?php echo Yii::t('LeadGen', 'Looking for a Great Deal On a New Car?'); ?></h1>
		<h2><?php echo Yii::t('LeadGen', 'Get a free Internet Price Quote now'); ?></h2>
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

			<?php echo $form->labelEx($model,'int_plz'); ?>

			<div class="input-append">
			<?php echo $form->textField($model,'int_plz'); ?>
			<?php echo TbHtml::button('x', array(
						'color' => TbHtml::BUTTON_COLOR_DEFAULT,
						'onclick'=> 'erasePostalCode();',
						'tabindex' => '-1',
						)); 
				  echo TbHtml::button(Yii::t('LeadGen', 'Postal Code Help'), array(
						'color' => 'custom',
						'onclick'=> 'showPostalModal();',
						'tabindex' => '-1'
						)); ?>
			</div>			
			<?php echo $form->error($model,'int_plz'); ?>
			<div class="zip_modal">
			<?php					
				$states = $this->getStates(); 	
				$this->widget('bootstrap.widgets.TbModal', array(
				'id' => 'ModalZipHelper',
				'header' => Yii::t('LeadGen', 'Postal Code Help'),
				'show'=> false,
				'content' => CHtml::dropDownList('state_helper', '', $states, array(
								'prompt' =>  Yii::t('LeadGen', 'Select Your State'),
								'ajax' => array(
										'type' => 'POST',
										'url' => CController::createUrl('cities'),
										'update' =>   '#city_helper', //selector to update
										),
										'onchange' => 'stateHelperChanged();'
									)
								) .  
							  CHtml::dropDownList('city_helper','', array(
									'prompt' => Yii::t('LeadGen', 'Select Your City')),
									 array('onchange' => 'cityHelperChanged();')) . '<br />' .
									 Yii::t('LeadGen','Please Select Nearest City and State'),
				
				'footer' => array(
					TbHtml::button(Yii::t('LeadGen', 'Save'), array('data-dismiss' => 'modal', 'id' => 'save_zip', 'name'=>'save_zip', 'color' => 'custom', 'onclick'=>'getPostalCode();')),
					TbHtml::button(Yii::t('LeadGen', 'Cancel'), array('data-dismiss' => 'modal')),
						),	
					)); 
			?>
			</div> 
			</fieldset>
			<div id="submit_button">
				<?php echo TbHtml::submitButton(Yii::t('LeadGen', 'Start saving today'), array('id'=> 'landing_submit','name' => 'quote', 'color' => 'custom', 'size' => TbHtml::BUTTON_SIZE_LARGE)); ?>
			</div>
		<?php $this->endWidget(); ?>
	</div>
	<div class="landing_overview">
		<!-- START MAKE LANDING -->
		<h3><?php echo Yii::t('LeadGen', 'As easy as 1-2-3'); ?></h3>
		<div id="show_makes">
			<div class="landing_overview_makeCar">
				<a href="#" id="mm_click_1" title="">
					<img id="mm_img_1" src="<?php echo Yii::app()->request->baseUrl;?>/images/no_pic.jpg" alt="" />
				</a>
				<h4 id="mm_txt_1"></h4>
			</div>
			<div class="landing_overview_makeCar">
				<a href="#" id="mm_click_2" title="">
					<img id="mm_img_2" src="<?php echo Yii::app()->request->baseUrl;?>/images/no_pic.jpg" alt="" />
				</a>
				<h4 id="mm_txt_2"></h4>
			</div>
			<div class="landing_overview_makeCar">
				<a href="#" id="mm_click_3" title="">
					<img id="mm_img_3" src="<?php echo Yii::app()->request->baseUrl;?>/images/no_pic.jpg" alt="" />
				</a>
				<h4 id="mm_txt_3"></h4>
			</div>
		</div>
		<div id="show_models" >
			<div class="landing_overview_modelCar">
				<img id="selected_model_img" src="" alt="" />
				<h4 id="selected_model_txt"> </h4>
			</div>
			<div class="landing_overview_adspace">
				<div class="testimonial">
					<div> <?php echo Yii::t('LeadGen','Your free service not only connected me to a friendly dealer in my neighborhood but it also helped me save a lot of money on my new car purchase. I will recommend you to all my friends.');?><br /><p></p><b><?php echo Yii::t('LeadGen','Maria Delgado'); ?></b></div>
				</div>
				<img src="<?php echo Yii::app()->request->baseUrl;?>/images/testimonial-photo-3.png"  alt="testimonial"/>
			</div>
		</div>
		<div class="cms_content" id="cms_content_1">
			<?php 
			
				/*
				// DEBUG DEBUG DEBUG 
				
				echo 'MAKE >> ' . $model->int_fabrikat .  '  ';
				if(empty($model->int_fabrikat))
					echo 'Make is empty <br>';

				echo 'MODEL >> ' .  $model->int_modell . '  ';
				if(empty($model->int_modell))
					echo 'Model is empty <br>';
			
				*/
				
				if(($cms_content = $this->getCMSContent(array('site' => 0, 'page' => 0, 'element' => 0, 'make' => $model->int_fabrikat, 'model' => $model->int_modell), true)) !== false)
					echo $cms_content;
				else
				{
					echo '<div class="easy123"><ol>';
					echo '<li>' . Yii::t('LeadGen', 'Select the make and model you are interest in and we will connect you with dealers in your neighborhood that will give you a great deal.') . '</li>';
					echo '<li>' . Yii::t('LeadGen', 'Complete the email form and your selected dealers will contact you with their best internet pricing.') . '</li>';
					echo '<li>' . Yii::t('LeadGen', 'Choose the deal you like best, visit the dealership and complete your new car purchase.') . ' </li>';
					echo '</ol></div>';
				}
			?>
		</div>
		<div class="landing_overview_below">
			<?php echo Yii::t('LeadGen', 'At Carro, we offer a huge selection of new cars, trucks, SUVs, hybrids and more to choose from. Our dealer network is interested in offering you great deals on your new vehicle purchase. Dealers compete for your business, so take advantage of our no-haggle online quote process now!'); ?>
		</div>
				<!-- test for accordian / collapsable content -->

<style>

 div.accordion-heading a {
    color:#000;
    text-decoration:none;
}

div.accordion-heading a:hover, a:focus {
    color:#EC1D25;
}


</style>		
                 <?php $this->beginWidget('bootstrap.widgets.TbCollapse', array(
                                'toggle'      => true, // show all bars
                                'htmlOptions' => array('class' => 'accordion', 'id'=>'accordian3'))
							);

					echo '<div class="accordion-group">';
					echo '<div class="accordion-heading">';
					echo '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse-0">';
					echo '<h2>JAC J2 </h2>';
					echo '</a>';
					echo '</div>';
					echo '<div id="collapse-0" class="accordion-body collapse in">';	// 'collapse in' is expanded 'collapse' is that
					echo '<div class="accordion-inner">';
?>
		<div class="car-details">
		<div class="well">
			  <h3>Pontos Positivos</h3>O motor 1.3 de 108 cv é eficiente na tarefa de impulsionar seus 915 kg. Temar-condicionado, sistema de som, airbag, ABS e seis anos de garantia.
		</div>
		<div class="well">
			  <h3>Pontos Negativos</h3>O acabamento é bastante simples, o espaço traseiro é muito limitado e o por-malas de pouco mais de 100 litros é praticamente figurativo.
		</div>
		<div class="well">
			  <h3>Conforto</h3><p>As suspensões de curso limitado e o repasse excessivo das irregularidades da pista aos ocupantes comprometem um pouco o conforto. O espaço é bastante limitado no banco traseiro e o acesso também não é dos melhores. Os itens de conforto acima da média ajudam para melhorar a habitabilidade.</p>
		</div>

		<div class="well">
			  <h3>Performance</h3><p>O motor é suficiente para impulsionar os 900 kg do modelo. Mas como seus torque e potência aparecem em rotações altas, o motorista precisa recorrer muito a trocas de marcha, o que é cansativo, principalmente porque os engates não são precisos. A suspensão macia causa desconforto em curvas.</p>
		</div>

		<div class="well">
			  <h3>Bolso</h3><p>Para quem quer um carro urbano, sem pretensões de desempenho, o J2 é uma opção interessante. Seu visual é moderninho e, pelo que custa, há muito poucas opções com tantos equipamentos e tanto tempo de garantia no mercado. Ausência do sistema flex pode pesar no bolso em algumas regiões.</p>
		</div>

        <table class="table table-hover table-striped">
        <thead class="gray-gradient ">
          <tr>
            <th colspan="2"><strong>Especificações Técnicas</strong></th>
          </tr>
        </thead>


        <tbody>
          <tr>
            <td>Motor</td>
            <td>Dianteiro, transversal</td>
          </tr>

          <tr>
            <td>Número de cilindros</td>
            <td>4 cilindros</td>
          </tr>

          <tr>
            <td>Número de válvulas</td>
            <td>16 válvulas</td>
          </tr>

          <tr>
            <td>Combustível</td>
            <td>Gasolina</td>
          </tr>

          <tr>
            <td>Cilindrada (cm³)</td>
            <td>1 332 cm³</td>
          </tr>

          <tr>
            <td>Potência (cv)</td>
			<td>108 cv a 6 000 rpm</td>
          </tr>

          <tr>
            <td>Torque (mkgf)</td>
            <td>14,0 mkgf a 4 500 rpm</td>
          </tr>

          <tr>
            <td>Câmbio</td>
            <td>Manual, 5 marchas</td>
          </tr>

          <tr>
            <td>Tração</td>
            <td>Dianteira</td>
          </tr>

          <tr>
            <td>Suspensão dianteira</td>
            <td>Independente, McPherson</td>
          </tr>

          <tr>
            <td>Suspensão traseira</td>
            <td>Eixo de torção</td>
          </tr>

          <tr>
            <td>Direção</td>
            <td>Elétrica</td>
          </tr>

          <tr>
            <td>Rodas</td>
            <td>Liga leve, 14</td>
          </tr>

          <tr>
            <td>Pneus</td>
            <td>175/60 R14</td>
          </tr>

          <tr>
            <td>Comprimento (m)</td>
            <td>3,53 m</td>
          </tr>

          <tr>
            <td>Largura (m)</td>
            <td>1,64 m</td>
          </tr>

          <tr>
            <td>Altura (m)</td>
            <td>1,47 m</td>
          </tr>

          <tr>
            <td>Entre-eixos</td>
            <td>2,39 m</td>
          </tr>

          <tr>
            <td>Porta-malas / Caçamba (l)</td>
            <td>121 l</td>
          </tr>

          <tr>
            <td>Tanque (l)</td>
            <td>35 l</td>
          </tr>

          <tr>
            <td>Peso em ordem de marcha (kg)</td>
            <td>915 kg</td>
          </tr>
        </tbody>
      </table>

      <table class="table table-hover table-striped">
        <thead class="gray-gradient">
          <tr>
            <th colspan="2"><strong>Manutenção</strong></th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>Garantia</td>
            <td>6 anos</td>
          </tr>

          <tr>
            <td>Rede de concessionárias</td>
            <td>50 concessionárias</td>
          </tr>
        </tbody>
      </table>
</body>
</div>
				<?php
				echo '</div>';
				echo '</div>';
				echo '</div>';

                for($i=1; $i < 3; $i++) 
                {

					echo '<div class="accordion-group">';
					echo '<div class="accordion-heading">';
					echo '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse-' . $i . '">';
					echo '<h2>Ford Fiesta ' . $i . '</h2>';
					echo '</a>';
					echo '</div>';
					echo '<div id="collapse-' . $i . '" class="accordion-body collapse">';	// 'collapse in' is expanded 'collapse' is that

					echo '<div class="accordion-inner">';
					echo 'This is the data in the collapsable element';
					echo '</div>';
					echo '</div>';
					echo '</div>';
                }

                $this->endWidget();
				
				?>

	</div>
		<!-- Special OEM PopUp -->
		<div>
			<?php
				echo '<div class="oem_modal">';
				echo CHtml::hiddenField('oem', $model->skipOEM, array('id' => 'hoem')); 
				$this->widget('bootstrap.widgets.TbModal', array(
				'id' => 'ModalOEM',
				'header' => Yii::t('LeadGen', 'Special Offer'),
				'show'=> false,
				'content' => 'Você está qualificado(a) a receber uma cotação especial de internet para o seu novo JAC com:' .
							 '<img src="/images/logos/199.png" >'.  
							 '<ol>' .
							  '<li>Melhor oferta das concessionárias</li>' .
							  '<li>Taxa de 0,99% a.m.</li>' .
							  '<li>6 anos de garantia</li>' .
							  '<li>Mais equipamentos de série</li>' .
							  '</ol>' . 'Para receber sua cotação especial sem compromisso, continue informando o seu CEP',
				'footer' => array(
					TbHtml::button(Yii::t('LeadGen', 'Continue'), array('data-dismiss' => 'modal', 'color' => 'custom')),
						),	
					)); 
				echo '</div>';
			?>
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
	
	function updateCMSContent()
	{

		if($("#LeadGen_int_fabrikat").val() != "" && $("#LeadGen_int_fabrikat").val() != null) 
			save_make = $("#LeadGen_int_fabrikat").val();
		else
			save_make = 0;	// default

		if($("#LeadGen_int_modell").val() != "" && $("#LeadGen_int_modell").val() != null) 
			save_model = $("#LeadGen_int_modell").val();
		else
			save_model = 0;	// default
	
		' .CHtml::ajax(
				array(
					'url' => Yii::app()->createUrl('site/cmscontent'), 
					'type'=>'POST',           
					'data'=>'js:{"ajax":true, "site_id":0, "page_id":0, "element_id":0, "make_id":save_make, "model_id":save_model }',
					'success'=>'js:function(html_data) {
							$("#cms_content_1").html(html_data);
					}'
					)
			) . 
		'		

	}
	
	function makeChanged() 
 	{
		$("#show_makes").show();
		$("#show_models").hide();

		$("#LeadGen_int_modell").val(0);

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
						updateCMSContent();
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
							updateCMSContent();
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

			$("#selected_model_img").attr("src", "' . Yii::app()->request->baseUrl . '/images/no_pic.jpg");
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
						updateCMSContent();

					 }'
			   )
			) .
			
			'
			$("#show_makes").hide();
			$("#show_models").show();

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

	function showPostalModal()
	{
		$("#state_helper").val("");
		$("#city_helper").val("");
		$("#save_zip").attr("disabled", "disabled");
		$("select[id$=city_helper] > option").remove();
		$("#ModalZipHelper").modal("toggle");		
	}
	
	function getPostalCode() 
 	{
			if($("#state_helper").val() != "")
			{
			' . CHtml::ajax(
				array(
					'url' => Yii::app()->createUrl('site/postalcode'), 
					'type'=>'POST',           
					'data'=>'js:{ "ajax":true, "state":$("#state_helper").val(), "city":$("#city_helper").val()}',
					'success'=>'js:function(html) {
						$("#LeadGen_int_plz").val(html);
					}'
					)		
				) .
			'
			}
			$("#LeadGen_int_plz").removeAttr("class");
			$("#city_helper").prop("disabled", true);
	}

	function erasePostalCode()
	{
		$("#LeadGen_int_plz").val("");
	}

	function stateHelperChanged() 
 	{
		if($("#state_helper").val() == "") 
		{
			$("#city_helper").prop("disabled", true);
			$("#save_zip").attr("disabled", "disabled");
		}
		else
		{
			$("#city_helper").prop("disabled", false);
		}
	}

	function cityHelperChanged() 
 	{

		if($("#state_helper").val() != "" && $("#city_helper").val() != "") 
		{
			$("#save_zip").removeAttr("disabled");
		}
		else
		{
			$("#save_zip").attr("disabled", "disabled");
		}
	}

	$(window).load(function() {
		save_model = $("#LeadGen_int_modell").val();
		save_make = $("#LeadGen_int_fabrikat").val();
		
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
			if(save_make == 199 && $("#hoem").val() != "true")	// JAC
			{
				$("#ModalOEM").modal("toggle");		// pop test
				$("#hoem").val("true");
			}
		}
		makeChanged();
		modelChanged();	
		$("#city_helper").prop("disabled", true);
		$("#save_zip").attr("disabled", "disabled");
	});
	'
	,
	CClientScript::POS_END						// Script insert Position 
);
?>
