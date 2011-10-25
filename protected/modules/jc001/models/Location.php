<?php

/**
 * This is the model class for table "jc001_location".
 *
 * The followings are the available columns in table 'jc001_location':
 * @property integer $location_id
 * @property string $location
 * @property integer $parent_id
 * @property string $data_catch_url
 */
class Location extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Location the static model class
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
		return 'jc001_location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('location, data_catch_url', 'required'),
		array('parent_id', 'numerical', 'integerOnly'=>true),
		array('location', 'length', 'max'=>32),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('location_id, location, parent_id, data_catch_url', 'safe', 'on'=>'search'),
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
            'location_id' => 'Location',
            'location' => 'Location',
            'parent_id' => 'Parent',
            'data_catch_url' => 'Data Catch Url',
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

		$criteria->compare('location_id',$this->location_id);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('data_catch_url',$this->data_catch_url,true);

		return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
		));
	}
}
?>