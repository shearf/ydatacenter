<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $company_id
 * @property integer $web_id
 * @property string $company_name
 * @property integer $category_id
 * @property integer $location_id
 * @property string $company_url
 * @property string $data_catch_url
 * @property integer $valid_info
 * @property integer $valid_contact
 * @property integer $locked_contact
 * @property integer $locked_info
 *
 * The followings are the available model relations:
 * @property CompanyContact $companyContact
 * @property CompanyInfo $companyInfo
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
		return 'company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('web_id, company_name, category_id, location_id, company_url, data_catch_url', 'required'),
			array('web_id, category_id, location_id, valid_info, valid_contact, locked_contact, locked_info', 'numerical', 'integerOnly'=>true),
			array('company_name', 'length', 'max'=>200),
			array('company_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('company_id, web_id, company_name, category_id, location_id, company_url, data_catch_url, valid_info, valid_contact, locked_contact, locked_info', 'safe', 'on'=>'search'),
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
			'companyContact' => array(self::HAS_ONE, 'CompanyContact', 'company_id'),
			'companyInfo' => array(self::HAS_ONE, 'CompanyInfo', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'company_id' => 'Company',
			'web_id' => 'Web',
			'company_name' => 'Company Name',
			'category_id' => 'Category',
			'location_id' => 'Location',
			'company_url' => 'Company Url',
			'data_catch_url' => 'Data Catch Url',
			'valid_info' => 'Valid Info',
			'valid_contact' => 'Valid Contact',
			'locked_contact' => 'Locked Contact',
			'locked_info' => 'Locked Info',
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

		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('web_id',$this->web_id);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('location_id',$this->location_id);
		$criteria->compare('company_url',$this->company_url,true);
		$criteria->compare('data_catch_url',$this->data_catch_url,true);
		$criteria->compare('valid_info',$this->valid_info);
		$criteria->compare('valid_contact',$this->valid_contact);
		$criteria->compare('locked_contact',$this->locked_contact);
		$criteria->compare('locked_info',$this->locked_info);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}