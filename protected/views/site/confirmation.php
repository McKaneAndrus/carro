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
					$conquest_cars = $this->getConquests($model->int_fabrikat, $model->int_modell, $model->int_ausstattung, 1);
					// we only look at the first conquest even though more can exist...
					if($conquest_cars !== false)
					{
						$conquest_make = $conquest_cars[0]['make'];
						$conquest_model = $conquest_cars[0]['model'];
						$conquest_trim = $conquest_cars[0]['trim'];
						$campaign_id = $conquest_cars[0]['campaign_id'];

						// if valid trims specified then use trim images
						
						if($model->int_ausstattung == -1)
							$image_src_info = $this->GetModelImage($model->int_modell);
						else
							$image_src_info = $this->GetTrimImage($model->int_ausstattung);

						if($conquest_trim == -1)
							$image_dest_info = $this->GetModelImage($conquest_model);
						else
							$image_dest_info = $this->GetTrimImage($conquest_trim);
						
						$src_logo_image = $this->GetMakeLogo($model->int_fabrikat);
						$dest_logo_image = $this->GetMakeLogo($conquest_make);

						$model->conquest_model = $conquest_model;	// may not be needed...
						$model->conquest_make = $conquest_make;
						$model->conquest_trim = $conquest_trim;
						
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
					  
						$conquest_content = str_replace($search_img_tags, $replace_img_html, $conquest_cars[0]['map_html']);
					  
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
						echo CHtml::hiddenField('ctrim', $conquest_trim);
						echo CHtml::hiddenField('cqid', $campaign_id);
						
						echo '</div>';
					}
				}
				?>
				
                <h1><?php echo Yii::t('LeadGen', 'Thank you for your request'); ?></h1>
                
                <div class="confirm_message">
                    <p><h4><?php echo Yii::t('LeadGen', 'One of the dealers within your neighborhood should contact you within 48 hours to give you great pricing on a car you are looking for.'); ?></p></h4>
                    <p><?php echo Yii::t('LeadGen', 'Achacarro is a transaction facilitator between buyers and dealerships and as such cannot be deemed responsible in case the selected dealerships do not contact or send a proposal to a buyer.'); ?></p>
                </div>
                
                <div class="confirm_vehicle">
					<div class="confirm_vehicle_img">
							<?php 
								if($model->int_ausstattung == -1)
									$car_info =  $this->getModelImage($model->int_modell); 
								else
									$car_info =  $this->getTrimImage($model->int_ausstattung); 
			
								$car_pic_url = $car_info['image_path'];
								$car_pic_desc = $car_info['image_desc'];
								echo '<img id="mmt_img_1" src="' . $car_pic_url . '" alt="'  . $car_pic_desc . '" /></br><h4 id="mmt_txt_1">' . $car_pic_desc . '</h4>';
							?>
					</div>
                </div>
                <?php
				if($model->conquest_confirm == true)
				{
					echo '<div class="confirm_conquest">';
					echo '<div class="confirm_conquest_img">';

					if($model->conquest_trim == -1)
						$car_info =  $this->getModelImage($model->conquest_model); 
					else
						$car_info =  $this->getTrimImage($model->conquest_trim); 
				
					$car_pic_url = $car_info['image_path'];
					$car_pic_desc = $car_info['image_desc'];
					
					echo '<img id="mmt_img_2" src="' . $car_pic_url . '" alt="'  . $car_pic_desc . '" /></br><h4 id="mmt_txt_2">' . $car_pic_desc . '</h4> ';
					echo '</div>';
					echo '<div class="confirm_conquest_message">';
					echo $this->getConquestConfirmMsg($model->conquest_campaign);
					echo '</div>';
					echo '<div class="confirm_conquest_logo">';
					echo '<img src=' . $this->GetMakeLogo($model->conquest_make) . '>';
					echo '</div>';
					echo '</div>';
				}
				?>
				
				<div class="confirm_anotherQuote">
					<h2><?php echo Yii::t('LeadGen', 'Would you like to get another quote?'); ?></h2>
						<?php echo TbHtml::submitButton(Yii::t('LeadGen', 'Get Another Quote'), array('name'=>'restart', 'color'=>'custom', 'size'=>TbHtml::BUTTON_SIZE_LARGE)); ?>
						<?php echo CHtml::hiddenField('mdl' ,$model->int_modell, array('id' => 'hmdl')); ?>
						<?php echo CHtml::hiddenField('trm' ,$model->int_ausstattung, array('id' => 'htrm')); ?>
						<?php echo CHtml::hiddenField('cpl', $model->conquest_primary_lead); ?>
						<?php 
							$model->skipOEM = 'true'; // pass this to landing screen
							echo CHtml::hiddenField('oem', $model->skipOEM, array('id' => 'hoem')); 
						?>
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
        
