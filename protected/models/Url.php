<?php

/**
 * This is the model class for table "url".
 *
 * The followings are the available columns in table 'url':
 * @property integer $url_id
 * @property string $url
 * @property integer $web_id
 * @property integer $analysis_rule_id
 * @property integer $target_rule_id
 * @property integer $subject_id
 *
 * The followings are the available model relations:
 * @property Rule $analysisRule
 * @property Subject $subject
 * @property Rule $targetRule
 */
class Url extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Url the static model class
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
		return 'url';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url, web_id, analysis_rule_id, target_rule_id, subject_id', 'required'),
			array('web_id, analysis_rule_id, target_rule_id, subject_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('url_id, url, web_id, analysis_rule_id, target_rule_id, subject_id', 'safe', 'on'=>'search'),
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
			'analysisRule' => array(self::BELONGS_TO, 'Rule', 'analysis_rule_id'),
			'subject' => array(self::BELONGS_TO, 'Subject', 'subject_id'),
			'targetRule' => array(self::BELONGS_TO, 'Rule', 'target_rule_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'url_id' => 'Url',
			'url' => 'Url',
			'web_id' => 'Web',
			'analysis_rule_id' => 'Analysis Rule',
			'target_rule_id' => 'Target Rule',
			'subject_id' => 'Subject',
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

		$criteria->compare('url_id',$this->url_id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('web_id',$this->web_id);
		$criteria->compare('analysis_rule_id',$this->analysis_rule_id);
		$criteria->compare('target_rule_id',$this->target_rule_id);
		$criteria->compare('subject_id',$this->subject_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}