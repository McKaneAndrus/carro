<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<div class="error_main">
	<div class="error">
		<h1>Error <?php echo $code; ?></h1>
		<?php echo CHtml::encode($message); ?>
	</div>
</div>
