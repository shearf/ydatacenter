<?php

/**
 * This is the model class for table "rule".
 *
 * The followings are the available columns in table 'rule':
 * @property integer $rule_id
 * @property integer $type
 * @property string $method
 * @property string $params
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Url[] $urls
 * @property Url[] $urls1
 */
class Rule extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Rule the static model class
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
		return 'rule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, method, params', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('method', 'length', 'max'=>100),
			array('params', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rule_id, type, method, params, description', 'safe', 'on'=>'search'),
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
			'urls' => array(self::HAS_MANY, 'Url', 'analysis_rule_id'),
			'urls1' => array(self::HAS_MANY, 'Url', 'target_rule_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rule_id' => 'Rule',
			'type' => 'Type',
			'method' => 'Method',
			'params' => 'Params',
			'description' => 'Description',
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

		$criteria->compare('rule_id',$this->rule_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('method',$this->method,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}