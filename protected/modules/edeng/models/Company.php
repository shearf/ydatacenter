<?php

/**
 * This is the model class for table "edeng_company".
 *
 * The followings are the available columns in table 'edeng_company':
 * @property string $company_id
 * @property string $company_name
 * @property string $company_url
 * @property integer $location_id
 * @property integer $category_id
 * @property string $data_catch_url
 * @property integer $locked
 * @property integer $valid
 * @property integer $create_time
 * @property integer $update_time
 * @property string $logo
 * @property string $introduce
 */
class Company extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Company the static model class
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
		return 'edeng_company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, company_url', 'required'),
			array('location_id, category_id, locked, valid, create_time, update_time', 'numerical', 'integerOnly'=>true),
			array('company_name', 'length', 'max'=>128),
			array('data_catch_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('company_id, company_name, company_url, location_id, category_id, data_catch_url, locked, valid, create_time, update_time', 'safe', 'on'=>'search'),
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
			'company_id' => 'Company',
			'company_name' => 'Company Name',
			'company_url' => 'Company Url',
			'location_id' => 'Location',
			'category_id' => 'Category',
			'data_catch_url' => 'Data Catch Url',
			'locked' => 'Locked',
			'valid' => 'Valid',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('company_url',$this->company_url);
		$criteria->compare('location_id',$this->location_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('data_catch_url',$this->data_catch_url,true);
		$criteria->compare('locked',$this->locked);
		$criteria->compare('valid',$this->valid);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeSave()
	{
		if ($this->getIsNewRecord()) {
			$this->create_time = time();
			$this->update_time = $this->create_time;
		}
		else {
			$this->update_time = time();
		}
		return parent::beforeSave();
	}
	
	public static function loadModel($pk)
	{
		return self::model()->findByPk($pk);
	}
}