<?php

/**
 * This is the model class for table "jc001_company_info".
 *
 * The followings are the available columns in table 'jc001_company_info':
 * @property string $company_id
 * @property string $introduce
 * @property string $capital
 * @property string $register_date
 * @property string $register_location
 * @property string $legal
 * @property string $bank
 * @property string $account
 * @property string $acreage
 * @property string $brand
 * @property string $employee
 * @property string $developer
 * @property string $turnover
 * @property string $certify
 * @property string $quality
 * @property string $market
 * @property string $costomer
 * @property integer $create_time
 * @property integer $update_time
 * @property integet $products
 * @property string $data_catch_url
 */
class CompanyInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CompanyInfo the static model class
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
		return 'jc001_company_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, introduce, data_catch_url', 'required'),
			array('create_time, update_time', 'numerical', 'integerOnly'=>true),
			array('company_id', 'length', 'max'=>20),
			array('capital', 'length', 'max'=>10),
			array('register_date', 'length', 'max'=>50),
			array('register_location, bank, account, acreage, certify, quality, market, costomer', 'length', 'max'=>128),
			array('legal', 'length', 'max'=>32),
			array('brand, employee, developer, turnover', 'length', 'max'=>64),
			array('data_catch_url', 'length', 'max' => 128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('company_id, introduce, capital, register_date, data_catch_url,register_location, legal, bank, account, acreage, brand, employee, developer, turnover, certify, quality, market, costomer, create_time, update_time', 'safe', 'on'=>'search'),
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
			'introduce' => 'Introduce',
			'capital' => 'Capital',
			'register_date' => 'Register Date',
			'register_location' => 'Register Location',
			'legal' => 'Legal',
			'bank' => 'Bank',
			'account' => 'Account',
			'acreage' => 'Acreage',
			'brand' => 'Brand',
			'employee' => 'Employee',
			'developer' => 'Developer',
			'turnover' => 'Turnover',
			'certify' => 'Certify',
			'quality' => 'Quality',
			'market' => 'Market',
			'costomer' => 'Costomer',
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
		$criteria->compare('introduce',$this->introduce,true);
		$criteria->compare('capital',$this->capital,true);
		$criteria->compare('register_date',$this->register_date,true);
		$criteria->compare('register_location',$this->register_location,true);
		$criteria->compare('legal',$this->legal,true);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('acreage',$this->acreage,true);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('employee',$this->employee,true);
		$criteria->compare('developer',$this->developer,true);
		$criteria->compare('turnover',$this->turnover,true);
		$criteria->compare('certify',$this->certify,true);
		$criteria->compare('quality',$this->quality,true);
		$criteria->compare('market',$this->market,true);
		$criteria->compare('market',$this->data_catch_url,true);
		$criteria->compare('costomer',$this->costomer,true);
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