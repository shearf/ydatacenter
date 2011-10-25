<?php

/**
 * This is the model class for table "company_register".
 *
 * The followings are the available columns in table 'company_register':
 * @property string $company_id
 * @property string $address
 * @property integer $capital
 * @property string $register_date
 * @property integer $unit
 * @property string $business
 * @property string $code
 * @property string $legal
 * @property string $type
 * @property string $registration
 * @property integer $check_year
 * @property string $apply_user
 * @property integer $gender
 * @property string $department
 * @property string $position
 * @property string $data_catch_url
 * @property integer $valid
 * @property string $from_date
 * @property string $to_date
 * @property integer $locked
 */
class CompanyRegister extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return CompanyRegister the static model class
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
        return 'company_register';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, address, capital, type,register_date, unit, business, code, legal, registration, check_year, apply_user, gender, data_catch_url, from_date, to_date', 'required'),
            array('capital, unit, check_year, gender, valid, locked', 'numerical', 'integerOnly'=>true),
            array('company_id', 'length', 'max'=>20),
            array('address, registration', 'length', 'max'=>128),
            array('business', 'length', 'max'=>255),
            array('code', 'length', 'max'=>32),
            array('register_date', 'date', 'format' => 'yyyy-MM-dd'),
            array('legal, apply_user, department, position', 'length', 'max'=>32),
            array('type', 'length', 'max'=>64),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('company_id, address, capital, register_year, unit, business, code, legal, type, registration, check_year, apply_user, gender, department, position, data_catch_url, valid, locked', 'safe', 'on'=>'search'),
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
            'address' => 'Address',
            'capital' => 'Capital',
            'register_year' => 'Register Year',
            'unit' => 'Unit',
            'business' => 'Business',
            'code' => 'Code',
            'legal' => 'Legal',
            'type' => 'Business Model',
            'registration' => 'Registration',
            'check_year' => 'Check Year',
            'apply_user' => 'Apply User',
            'gender' => 'Gender',
            'department' => 'Department',
            'position' => 'Position',
            'data_catch_url' => 'Data Catch Url',
            'valid' => 'Valid',
            'locked' => 'Locked',
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
        $criteria->compare('address',$this->address,true);
        $criteria->compare('capital',$this->capital);
        $criteria->compare('register_year',$this->register_year,true);
        $criteria->compare('unit',$this->unit);
        $criteria->compare('business',$this->business,true);
        $criteria->compare('code',$this->code,true);
        $criteria->compare('legal',$this->legal,true);
        $criteria->compare('type',$this->type,true);
        $criteria->compare('registration',$this->registration,true);
        $criteria->compare('check_year',$this->check_year);
        $criteria->compare('apply_user',$this->apply_user,true);
        $criteria->compare('gender',$this->gender);
        $criteria->compare('department',$this->department,true);
        $criteria->compare('position',$this->position,true);
        $criteria->compare('data_catch_url',$this->data_catch_url,true);
        $criteria->compare('valid',$this->valid);
        $criteria->compare('locked',$this->locked);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
    
    protected function beforeSave()
    {
    	if ($this->getIsNewRecord()) {
    		$this->create_time = time();
    	}
    	
    	return parent::beforeSave();
    }
    
    public static function loadModel($pk)
    {
    	return self::model()->findByPk($pk);
    }
} 