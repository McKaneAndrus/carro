<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Privacy';
$this->breadcrumbs=array(
	'Privacy',
);
?>
<div class="static_body">
	<h1>Privacy</h1>

	 <img src="<?php echo Yii::app()->request->baseUrl?>/images/privacy_1.png">
	<?php echo Yii::t('LeadGen', 'We do not sell or release your information to anyone but the dealers.'); ?>
</div>
