<?php

/**
 * This is the model class for table "jc001_company".
 *
 * The followings are the available columns in table 'jc001_company':
 * @property string $company_id
 * @property string $company_name
 * @property string $logo
 * @property integer $type
 * @property integer $category_id
 * @property integer $location_id
 * @property string $company_url
 * @property integer $vip
 * @property integer $locked
 * @property integer $valid
 * @property string $data_catch_url
 * @property integer $create_time
 * @property integer $update_time
 */
class Company extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Company the static model class
	 */
	
	const COMPANY_PRODUCE = 1;
	const COMPANY_SELL = 2;
	
	private static $companyType = array(
		self::COMPANY_PRODUCE => '生产商',
		self::COMPANY_SELL => '销售商',
	);
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jc001_company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, type, category_id, location_id, company_url, vip, data_catch_url', 'required'),
			array('type, category_id, location_id, vip, locked, valid, create_time, update_time', 'numerical', 'integerOnly'=>true),
			array('company_name, logo, company_url, data_catch_url', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('company_id, company_name, logo, type, category_id, location_id, company_url, vip, locked, valid, data_catch_url, create_time, update_time', 'safe', 'on'=>'search'),
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
			'logo' => 'Logo',
			'type' => 'Type',
			'category_id' => 'Category',
			'location_id' => 'Location',
			'company_url' => 'Company Url',
			'vip' => 'Vip',
			'locked' => 'Locked',
			'valid' => 'Valid',
			'data_catch_url' => 'Data Catch Url',
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
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('location_id',$this->location_id);
		$criteria->compare('company_url',$this->company_url,true);
		$criteria->compare('vip',$this->vip);
		$criteria->compare('locked',$this->locked);
		$criteria->compare('valid',$this->valid);
		$criteria->compare('data_catch_url',$this->data_catch_url,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getCompanyTypeLabels()
	{
		return self::$companyType;
	}
	
	public static function getCompanyTypeLabel($type)
	{
		return self::$companyType[$type];
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
}