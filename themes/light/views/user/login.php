<?php	
$this->pageTitle=Yii::app()->name . ' - 用户登录';
$this->breadcrumbs['登录']=array(
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

<h3>用户登录</h3>
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
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
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
		<?php echo CHtml::submitButton('登陆');?>
	</p>
</fieldset>
<?php $this->endWidget(); ?>
