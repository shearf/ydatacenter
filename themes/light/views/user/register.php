<?php	
$this->pageTitle=Yii::app()->name . ' - 用户注册';
$this->breadcrumbs['注册']=array(
	'url' => Yii::app()->request->getUrl(),
	'htmlOptions' => array('class' => 'active'),
);
?>

<?php if(Yii::app()->user->hasFlash('result')): ?>
	<?php $arrResult = Yii::app()->user->getFlash('result');?>
	<div class="flash-<?php echo $arrResult['type'];?>">
		<?php echo $arrResult['msg']; ?>
	</div>

<?php endif;?>
<h3>用户注册</h3>
<?php $form=$this->beginWidget('CActiveForm', array('htmlOptions' => array('class' => 'jNice')));?>
<fieldset>
	<?php echo $form->errorSummary($model); ?>
	
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<p>
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</p>
	<p>
		<?php echo $form->labelEx($model,'pass'); ?>
		<?php echo $form->passwordField($model,'pass'); ?>
		<?php echo $form->error($model,'pass'); ?>
	</p>
	<p>
		<?php echo $form->labelEx($model,'password_confirm'); ?>
		<?php echo $form->passwordField($model,'password_confirm'); ?>
		<?php echo $form->error($model,'password_confirm'); ?>
	</p>
	
	<div class="verify-code">
	<?php if(CCaptcha::checkRequirements()): ?>
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">请输入验证码</div>
	<?php endif; ?>
	</div>
	<p>
		<?php echo CHtml::submitButton('注册');?>
		<?php echo CHtml::resetButton('重置');?>
	</p>
</fieldset>
<?php $this->endWidget(); ?>
