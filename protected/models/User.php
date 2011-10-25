<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $uid
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property integer $status
 * @property integer $registertime
 *
 * The followings are the available model relations:
 * @property Rule[] $rules
 * @property Subject[] $subjects
 * @property Url[] $urls
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	
	const USER_ENABLED = 1;
	const USER_DISABLED = 0;
	
	public $pass;
	public $password_confirm;
	public $verifyCode;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, pass, password_confirm, verifyCode', 'required', 'on' => 'register'),
			array('username, password,verifyCode', 'required', 'on' => 'login'),
			array('password_confirm', 'compare', 'compareAttribute' => 'pass', 'on' => 'register'),
			array('uid, status, registertime', 'numerical', 'integerOnly'=>true),
			array('username', 'unique', 'on' => 'register'),
			array('username', 'length', 'max'=>45),
			array('password, salt', 'length', 'max'=>128),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'on' => 'register, login'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uid, username, password,status, registertime', 'safe', 'on'=>'search'),
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
			'rules' => array(self::HAS_MANY, 'Rule', 'uid'),
			'subjects' => array(self::HAS_MANY, 'Subject', 'uid'),
			'urls' => array(self::HAS_MANY, 'Url', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'Uid',
			'username' => '用户名',
			'password' => '密码',
			'salt' => '随机数',
			'status' => '用户状态',
			'registertime' => '注册时间',
			'pass' => '密码',
			'password_confirm' => '确认密码',
			'verifyCode' => '验证码',
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

		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('registertime',$this->registertime);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	private function genRandomString($len)
	{
		$chars = array(
       	"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", 
        	"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", 
        	"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", 
        	"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", 
        	"S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", 
        	"3", "4", "5", "6", "7", "8", "9", "-", "#", "@", "!", "(", ")",
			"%", "$", "^", "*"
    	);
    	$charsLen = count($chars) - 1;
    	shuffle($chars); 
    	$output = "";
    	for ($i=0; $i<$len; $i++)
    	{
        	$output .= $chars[mt_rand(0, $charsLen)];
    	}
    	return $output;
	}
	
	public function generateSalt()
	{
		return md5($this->genRandomString(32));
	}
	
	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->password;
	}
	
	public function hashPassword($password,$salt)
	{
		return md5($salt.$password);
	}
	
	
	public static function userStates() 
	{
		return array(USER_ENABLED, USER_DISABLED);
	}
	
	public static function get_all_user()
	{
		$models = self::model()->enabled()->findAll();
		
		foreach ($models as $model)
		{
			$user[$model->uid] = $model->username;
		}
		
		return $user;
	}
	
	public static function has_enabled_user($uid)
	{
		//return self::model()->findAllByPk($uid, 'enabled = :enabled', array(':enabled' => self::USER_ENABLED)) ? true : false;
		return self::model()->enabled()->findByPk($uid) ? true : false;
	}
	
	public static function get_enabled_user($uid)
	{
		$model = self::model()->enabled()->findByPk($uid);
		return $model;
	}
	
}