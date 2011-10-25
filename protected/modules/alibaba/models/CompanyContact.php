<?php

/**
 * This is the model class for table "company_contact".
 *
 * The followings are the available columns in table 'company_contact':
 * @property integer $company_id
 * @property string $url
 * @property string $contact_user
 * @property integer $gender
 * @property string $position
 * @property string $telephone
 * @property string $mobile
 * @property string $email
 * @property string $fax
 * @property string $address
 * @property string $postcode
 * @property string $extend_company_url
 * @property string $wangwang
 * @property string $qq
 * @property string $msn
 *
 * The followings are the available model relations:
 * @property Company $company
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
		return 'company_contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, url, contact_user, gender, position, telephone, mobile, email, fax, address, postcode, extend_company_url', 'required'),
			array('company_id, gender', 'numerical', 'integerOnly'=>true),
			array('contact_user, postcode', 'length', 'max'=>30),
			array('position, telephone, mobile, email, fax', 'length', 'max'=>100),
			array('address', 'length', 'max'=>255),
			array('wangwang, qq', 'length', 'max'=>20),
			array('msn', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('company_id, url, contact_user, gender, position, telephone, mobile, email, fax, address, postcode, extend_company_url, wangwang, qq, msn', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'company_id' => 'Company',
			'url' => 'Url',
			'contact_user' => 'Contact User',
			'gender' => 'Gender',
			'position' => 'Position',
			'telephone' => 'Telephone',
			'mobile' => 'Mobile',
			'email' => 'Email',
			'fax' => 'Fax',
			'address' => 'Address',
			'postcode' => 'Postcode',
			'extend_company_url' => 'Extend Company Url',
			'wangwang' => 'Wangwang',
			'qq' => 'Qq',
			'msn' => 'Msn',
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('contact_user',$this->contact_user,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('extend_company_url',$this->extend_company_url,true);
		$criteria->compare('wangwang',$this->wangwang,true);
		$criteria->compare('qq',$this->qq,true);
		$criteria->compare('msn',$this->msn,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}