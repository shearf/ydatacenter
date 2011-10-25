<?php

/**
 * This is the model class for table "jc001_company_search".
 *
 * The followings are the available columns in table 'jc001_company_search':
 * @property integer $search_id
 * @property string $search_url
 * @property integer $location_id
 * @property integer $category_id
 * @property integer $items
 * @property integer $pages
 * @property integer $locked
 * @property integer $valid
 */
class CompanySearch extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CompanySearch the static model class
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
		return 'jc001_company_search';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('search_url, location_id, category_id', 'required'),
		array('location_id, category_id, items, pages', 'numerical', 'integerOnly'=>true),
		array('search_url', 'length', 'max'=>255),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('search_id, search_url, location_id, category_id, items, pages', 'safe', 'on'=>'search'),
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
            'search_id' => 'Search',
            'search_url' => 'Search Url',
            'location_id' => 'Province',
            'category_id' => 'Category',
            'items' => 'Items',
            'pages' => 'Pages',
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

		$criteria->compare('search_id',$this->search_id);
		$criteria->compare('search_url',$this->search_url,true);
		$criteria->compare('location_id',$this->location_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('items',$this->items);
		$criteria->compare('pages',$this->pages);

		return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
		));
	}
}
?>