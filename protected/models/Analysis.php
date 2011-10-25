<?php

/**
 * This is the model class for table "analysis".
 *
 * The followings are the available columns in table 'analysis':
 * @property integer $analysis_id
 * @property integer $url_id
 * @property string $time
 * @property string $result
 */
class Analysis extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Analysis the static model class
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
		return 'analysis';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url_id, time, result', 'required'),
			array('url_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('analysis_id, url_id, time, result', 'safe', 'on'=>'search'),
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
			'analysis_id' => 'Analysis',
			'url_id' => 'Url',
			'time' => 'Time',
			'result' => 'Result',
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

		$criteria->compare('analysis_id',$this->analysis_id);
		$criteria->compare('url_id',$this->url_id);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('result',$this->result,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}