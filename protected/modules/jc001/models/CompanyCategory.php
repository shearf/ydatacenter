<?php

/**
 * This is the model class for table "jc001_company_category".
 *
 * The followings are the available columns in table 'jc001_company_category':
 * @property integer $category_id
 * @property string $category_name
 * @property integer $parent_id
 * @property integer $has_child
 */
class CompanyCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CompanyCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jc001_company_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('category_name', 'required'),
		array('parent_id, has_child', 'numerical', 'integerOnly'=>true),
		array('category_name', 'length', 'max'=>32),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('category_id, category_name, parent_id, has_child', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'category_id' => 'Category',
            'category_name' => 'Category Name',
            'parent_id' => 'Parent',
            'has_child' => 'Has Child',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('category_name',$this->category_name,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('has_child',$this->has_child);

		return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
		));
	}
	
	public static function loadModel($pk)
	{
		return self::model()->findByPk($pk);
	}
}
?>