<?php
class SubjectController extends Controller
{
	
	public function init()
	{
		$this->leftMenu = array(
			array('label' => '创建项目', 'url' => array('/subject/create')),
			array('label' => '已有项目', 'url' => array('/subject/index')),
		);
		
		$this->breadcrumbs['项目'] = array('url' => $this->getId());
	}
	
	
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionCreate()
	{
		$model = new Subject();
		if (isset($_POST['Subject'])) {
			$model->attributes = $_POST['Subject'];
			if ($model->validate()) {
				if ($model->save()) {
					if ($model->parent_id != 0) {
						$model_parent = Subject::model()->findByPk($model->parent_id);
						if ($model_parent->child == 0) {
							$model_parent->child = 1;
							$model_parent->save();
						}
					}
					Yii::app()->user->setFlash('result', new CResult(CResult::RESULT_SUCESS, '添加项目成果！'));
				}
				else {
					Yii::app()->user->setFlash('result', new CResult(CResult::RESULT_FAIL, '添加项目失败！'));
				}
			}
		}
		
		$this->render('create', array('model' => $model));
	}
	
	public function actionUpdate()
	{
		
	}
	
	public function actionView()
	{
		
	}
	
	public function actionAdmin()
	{
		
	}
	
	public function actionDelete()
	{
		
	}
}
?>