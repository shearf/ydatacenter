<?php

/**
 * This is the model class for table "company_categories".
 *
 * The followings are the available columns in table 'company_categories':
 * @property integer $categories_id
 * @property string $categories_name
 * @property integer $parent_id
 * @property integer $child
 */
class CompanyCategories extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CompanyCategories the static model class
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
		return 'company_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('categories_name', 'required'),
			array('parent_id, child', 'numerical', 'integerOnly'=>true),
			array('categories_name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('categories_id, categories_name, parent_id, child', 'safe', 'on'=>'search'),
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
			'categories_id' => 'Categories',
			'categories_name' => 'Categories Name',
			'parent_id' => 'Parent',
			'child' => 'Child',
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

		$criteria->compare('categories_id',$this->categories_id);
		$criteria->compare('categories_name',$this->categories_name,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('child',$this->child);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}