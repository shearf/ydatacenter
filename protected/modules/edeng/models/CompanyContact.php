<?php

/**
 * This is the model class for table "edeng_company_contact".
 *
 * The followings are the available columns in table 'edeng_company_contact':
 * @property string $company_id
 * @property string $contact_user
 * @property string $telephone
 * @property string $email
 * @property string $location
 * @property string $address
 * @property string $data_catch_url
 * @property integer $create_time
 * @property integer $update_time
 */
class CompanyContact extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CompanyContact the static model class
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
		return 'edeng_company_contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, contact_user, telephone, email, location, data_catch_url', 'required'),
			array('create_time, update_time', 'numerical', 'integerOnly'=>true),
			array('company_id', 'length', 'max'=>20),
			array('contact_user', 'length', 'max'=>50),
			array('telephone', 'length', 'max'=>64),
			array('location, email, address, data_catch_url', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('company_id, contact_user, telephone, email, location, address, data_catch_url, create_time, update_time', 'safe', 'on'=>'search'),
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
			'contact_user' => 'Contact User',
			'telephone' => 'Telephone',
			'email' => 'Email',
			'location' => 'Location',
			'address' => 'Address',
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
		$criteria->compare('contact_user',$this->contact_user,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('data_catch_url',$this->data_catch_url,true);
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
}