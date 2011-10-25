<?php	
$this->pageTitle=Yii::app()->name . ' - 用户详情';
$this->breadcrumbs['用户详情']=array(
	'url' => Yii::app()->request->getUrl(),
	'htmlOptions' => array('class' => 'active'),
);

$this->breadcrumbs[$userinfo->username];
?>

<h3><?php echo $userinfo->username;?></h3>


