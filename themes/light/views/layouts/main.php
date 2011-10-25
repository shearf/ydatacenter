<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>

<!-- CSS -->
<link href="<?php echo Yii::app()->theme->baseUrl;?>/css/transdmin.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if IE 6]><link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->theme->baseUrl;?>/css/ie6.css" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->theme->baseUrl;?>/css/ie7.css" /><![endif]-->

<!-- JavaScripts-->
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/jNice.js"></script>
</head>

<body>
	<div id="wrapper">
		<!-- h1 tag stays for the logo, you can use the a tag for linking the index page -->
		<h1 class="logo">
			<a href="<?php echo Yii::app()->homeUrl;?>" title="<?php echo Yii::app()->name;?>"><span><?php echo Yii::app()->name;?></span></a>
		</h1>
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'项目', 'url'=>array('/subject/index')),
				//array('label'=>'分析', 'url'=>array('/site/contact')),
				array('label'=>'登陆', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>Yii::app()->user->name, 'url'=>array('/user/view', 'id' => Yii::app()->user->id), 'htmlOption' => array('class' => 'logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
			'lastItemCssClass' => 'logout',
			'id' => 'mainNav'
			)); ?>
		<!-- // #end mainNav -->

		<div id="containerHolder">
			<div id="container">
				<div id="sidebar">
					<?php $this->widget('zii.widgets.CMenu',array(
                	 	'items' => $this->leftMenu,
						'htmlOptions' => array('class' => 'sideNav'),
				));
				?>
					<!-- // .sideNav -->
				</div>
				<!-- // #sidebar -->

				<!-- h2 stays for breadcrumbs -->
				<?php $this->widget('application.components.DCBreadcrumbs', array(
                	'links' => $this->breadcrumbs,
                	'tagName' => 'h2',
				));?>
				<div id="main">
					<?php echo $content;?>
				</div>
				<!-- // #main -->

				<div class="clear"></div>
			</div>
			<!-- // #container -->
		</div>
		<!-- // #containerHolder -->

		<p id="footer">
			Copyright &copy; <?php echo date('Y'); ?> by Shearf. <a href="mailto:xiahaihu2009@gmail.com" title="联系我">xiahaihu2009@gmail.com</a><br/>
			All Rights Reserved.<br/>
			<?php echo Yii::powered(); ?>
			Theme by <a href="http://www.perspectived.com">http://www.perspectived.com.</a>
		</p>
	</div>
	<!-- // #wrapper -->
</body>
</html>
