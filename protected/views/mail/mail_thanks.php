<?php if(isset($name)) echo Yii::t('mail', 'Dear') . ' ' . $name . ',';?>
<?php 

	if(isset($dlr_list) && count($dlr_list) > 0)
	{
		echo '<p>'; 
		echo Yii::t('mail', 'We received your request for a price quote on a') . ' ';  
		if(isset($make_name)) echo $make_name . ' '; 
		if(isset($model_name)) echo $model_name . ' '; 
		if(isset($year)) echo $year . ' '; 
		if(isset($color)) echo $color; 
		echo ' ' . Yii::t('mail','from') . '</p>'; 
		if(isset($image) && $image != false)
		{
			echo '<img style="border : 0" alt="achacarro.com" src="' . $image . '" />';
		}
		Yii::t('mail', 'Below is a list of your selected dealers');
		echo '<ul>';
		foreach($dlr_list as $dlr_id)
		{
			$rec = $this->GetDealerInfo($dlr_id);

			if(!empty($rec))
			{
				echo '<li>';
				echo '<span style="color:#EC1D25;font-size:18px;">';
				echo $rec['name'];
				echo '</span>';
				echo '<br>' . $rec['street'];
				echo '<br>' . $rec['city'] . ', ' . $rec['state'];
				echo '<br>' . $rec['postal'];
				echo '<br>' . $rec['phone'];
				echo '</li>';
			}
		}
		echo '</ul>';
		if(isset($message)) 
			echo '<p>' . $message . '</p>';
		echo '<br>Eduardo Gonzales';
	}
	else
	{	
		// no dealers in the list
		echo '<p>'; 
		echo Yii::t('mail', 'We received your request for a price quote on a') . ' ';  
		if(isset($make_name)) echo $make_name . ' '; 
		if(isset($model_name)) echo $model_name . ' '; 
		if(isset($year)) echo $year . ' '; 
		if(isset($color)) echo $color; 
		echo '. ' . Yii::t('mail', 'Unfortunately, we could not find a participating dealer near you.');
		echo '<p>' . Yii::t('mail', 'Our apologies for the inconvenience,') . '</p>';
		echo '<br>Lolita Gonzales';
	}
?>
<?php Yii::t('mail', 'Customer Support') ?>
<br><a href="http://www.achacarro.com/">Achacarro.com</a>
<br>suporte@achacarro.com
<p>	<?php if(isset($footer)) echo $footer; ?></p>

