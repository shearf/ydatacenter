<?php

/**
 * This is the model class for table "company_info".
 *
 * The followings are the available columns in table 'company_info':
 * @property integer $company_id
 * @property string $url
 * @property string $products
 * @property string $industry
 * @property string $type
 * @property string $business_model
 * @property string $capital
 * @property string $register_address
 * @property string $employees
 * @property string $register_date
 * @property string $legal
 * @property string $turnover
 * @property string $business_area
 * @property string $market
 * @property string $band
 * @property string $management
 * @property string $oem
 * @property string $quality
 * @property string $developers
 * @property string $plant_area
 * @property string $registration
 * @property string $in_exports
 * @property string $on_imports
 * @property string $customers
 * @property string $month_produce
 * @property string $technology
 * @property string $service
 * @property string $bank
 * @property string $account
 * @property string $introductions
 * @property integer $locked
 * @property integer $valid
 *
 * The followings are the available model relations:
 * @property Company $company
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
		return 'company_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, url, products, industry, type, business_model, introductions', 'required'),
			array('company_id, locked, valid', 'numerical', 'integerOnly'=>true),
			array('type, employees, turnover, developers, plant_area, registration', 'length', 'max'=>50),
			array('business_model, register_date, legal', 'length', 'max'=>20),
			array('capital, register_address, band, quality, in_exports, on_imports, month_produce, bank', 'length', 'max'=>100),
			array('management, customers, technology, service', 'length', 'max'=>255),
			array('oem', 'length', 'max'=>200),
			array('account', 'length', 'max'=>40),
			array('business_area, market', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('company_id, url, products, industry, type, business_model, capital, register_address, employees, register_date, legal, turnover, business_area, market, band, management, oem, quality, developers, plant_area, registration, in_exports, on_imports, customers, month_produce, technology, service, bank, account, introductions, locked, valid', 'safe', 'on'=>'search'),
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
			'products' => 'Products',
			'industry' => 'Industry',
			'type' => 'Type',
			'business_model' => 'Business Model',
			'capital' => 'Capital',
			'register_address' => 'Register Address',
			'employees' => 'Employees',
			'register_date' => 'Register Date',
			'legal' => 'Legal',
			'turnover' => 'Turnover',
			'business_area' => 'Business Area',
			'market' => 'Market',
			'band' => 'Band',
			'management' => 'Management',
			'oem' => 'Oem',
			'quality' => 'Quality',
			'developers' => 'Developers',
			'plant_area' => 'Plant Area',
			'registration' => 'Registration',
			'in_exports' => 'In Exports',
			'on_imports' => 'On Imports',
			'customers' => 'Customers',
			'month_produce' => 'Month Produce',
			'technology' => 'Technology',
			'service' => 'Service',
			'bank' => 'Bank',
			'account' => 'Account',
			'introductions' => 'Introductions',
			'locked' => 'Locked',
			'valid' => 'Valid',
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
		$criteria->compare('products',$this->products,true);
		$criteria->compare('industry',$this->industry,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('business_model',$this->business_model,true);
		$criteria->compare('capital',$this->capital,true);
		$criteria->compare('register_address',$this->register_address,true);
		$criteria->compare('employees',$this->employees,true);
		$criteria->compare('register_date',$this->register_date,true);
		$criteria->compare('legal',$this->legal,true);
		$criteria->compare('turnover',$this->turnover,true);
		$criteria->compare('business_area',$this->business_area,true);
		$criteria->compare('market',$this->market,true);
		$criteria->compare('band',$this->band,true);
		$criteria->compare('management',$this->management,true);
		$criteria->compare('oem',$this->oem,true);
		$criteria->compare('quality',$this->quality,true);
		$criteria->compare('developers',$this->developers,true);
		$criteria->compare('plant_area',$this->plant_area,true);
		$criteria->compare('registration',$this->registration,true);
		$criteria->compare('in_exports',$this->in_exports,true);
		$criteria->compare('on_imports',$this->on_imports,true);
		$criteria->compare('customers',$this->customers,true);
		$criteria->compare('month_produce',$this->month_produce,true);
		$criteria->compare('technology',$this->technology,true);
		$criteria->compare('service',$this->service,true);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('introductions',$this->introductions,true);
		$criteria->compare('locked',$this->locked);
		$criteria->compare('valid',$this->valid);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}