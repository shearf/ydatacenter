<?php

/**
 * This is the model class for table "company_search_result".
 *
 * The followings are the available columns in table 'company_search_result':
 * @property integer $id
 * @property string $url
 * @property integer $category_id
 * @property integer $location_id
 * @property string $data_catch_url
 * @property integer $page_num
 * @property integer $company_num
 * @property integer $locked
 * @property integer $valid
 * @property integer $valid_page_num
 * @property integer $valid_company_num
 * @property integer $web_id
 */
class CompanySearchResult extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CompanySearchResult the static model class
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
		return 'company_search_result';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url, category_id, location_id, data_catch_url, web_id', 'required'),
			array('category_id, location_id, page_num, company_num, locked, valid, valid_page_num, valid_company_num, web_id', 'numerical', 'integerOnly'=>true),
			array('data_catch_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url, category_id, location_id, data_catch_url, page_num, company_num, locked, valid, valid_page_num, valid_company_num, web_id', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'url' => 'Url',
			'category_id' => 'Category',
			'location_id' => 'Location',
			'data_catch_url' => 'Data Catch Url',
			'page_num' => 'Page Num',
			'company_num' => 'Company Num',
			'locked' => 'Locked',
			'valid' => 'Valid',
			'valid_page_num' => 'Valid Page Num',
			'valid_company_num' => 'Valid Company Num',
			'web_id' => 'Web',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('location_id',$this->location_id);
		$criteria->compare('data_catch_url',$this->data_catch_url,true);
		$criteria->compare('page_num',$this->page_num);
		$criteria->compare('company_num',$this->company_num);
		$criteria->compare('locked',$this->locked);
		$criteria->compare('valid',$this->valid);
		$criteria->compare('valid_page_num',$this->valid_page_num);
		$criteria->compare('valid_company_num',$this->valid_company_num);
		$criteria->compare('web_id',$this->web_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}