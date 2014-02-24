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
                       
                    </div>
                </div>
                
                <div class="confirm_vehicle">
                    <h2>Your selected vehicle:<br />
						<?php echo $this->GetMakeName($model->make) . ' ' . $this->GetModelName($model->model); ?>
						<?php echo $this->GetTrimName($model->trim) . '<br />'?>
						<?php echo $this->GetColorName($model->color); ?>
                    </h2>
                    <img src="" alt="" />
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
        
