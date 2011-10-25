<?php
$this->pageTitle = Yii::app()->name . ' - 创建项目';
$this->breadcrumbs['创建项目'] = array(
	'url' => Yii::app()->request->getUrl(),
	'htmlOptions' => array('class' => 'active'),
);
?>

<?php $form = $this->beginWidget('CActiveForm', array('htmlOptions' => array('class' => 'jNice')));?>


<fieldset>
	<?php echo $form->errorSummary($model); ?>
	<p>
		<?php echo $form->labelEx($model, 'subject_name');?>
		<?php echo $form->textField($model, 'subject_name', array('class' => 'text-long'));?>
		<?php echo $form->error($model, 'subject_name');?>
	</p>
	<?php echo $form->hiddenField($model, 'parent_id');?>
	<p>
		<?php echo CHtml::submitButton('添加新项目');?>
		<?php echo CHtml::resetButton('重置');?>
	</p>
</fieldset>

<?php $this->endWidget();?>