<?php

/**
 * This is the model class for table "jc001_process".
 *
 * The followings are the available columns in table 'jc001_process':
 * @property string $id
 * @property integer $type
 * @property integer $locked
 * @property integer $valid
 */
class Process extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Process the static model class
	 */
	const TYPES_COMPANY = 1;
	const TYPES_COMPANY_INFO = 2;
	const TYPES_COMPANY_CONTACT = 3;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jc001_process';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, locked, valid', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, locked, valid', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('locked',$this->locked);
		$criteria->compare('valid',$this->valid);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}