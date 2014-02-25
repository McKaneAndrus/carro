<?php

/**
 * This is the model class for table "lead_gen".
 *
 * The followings are the available columns in table 'lead_gen':
 * @property integer $id_lead
 * @property integer $make
 * @property integer $model
 * @property integer $model_year
 * @property integer $color
 * @property integer $trim
 * @property string $user_comment
 * @property integer $status
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $street_address
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $params
 * @property string $update_date
 */
class LeadGen extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lead_gen';
	}
	
	public function init()
	{
		$this->model_year = 1962;	// default warning if this is seen in the database
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		
		return array(
		
		// example below where 'on' defines the page or scenario for the rule.
		//      array('first_name, last_name, gender, dob', 'required', 'on'=>'page1'),
		//		array('address_1, city, state, country, phone_number_1, email_1', 'required', 'on'=>'page2'),
	
	
		// sjg - messages need to be localized, should be broken out to each field as a rule
		
			array('make','required', 'on'=>'landing', 'message'=>'Please Select a Make'),
			array('model','required', 'on'=>'landing', 'message'=>'Please Select a Model'),
			array('zipcode','required', 'on'=>'landing', 'message'=>'Please Enter a Postal Code'),
			
			array('trim', 'required', 'on'=>'quote', 'message'=>'Please Select a Trim'),
			array('color', 'required', 'on'=>'quote', 'message'=>'Please Select a Color'),
			array('model_year, color, first_name, last_name, phone, email', 'required', 'on'=>'quote'),
			array('email', 'email', 'on'=>'quote', 'message'=>'Invalid Email Address'),

			array('make, model, model_year, color, trim, status', 'numerical', 'integerOnly'=>true),
			
			// regx for brazil postal code is to validate numbers in the format of 00000-000
			
			array('zipcode', 'match', 'pattern' =>'/[0-9]{5}-[0-9]{3}/', 'message'=>'Invalid Format, use 00000-000'),
			array('zipcode', 'length', 'max'=>9),	// specific for BR, format of 00000-000

			array('phone', 'match', 'pattern' =>'/^[0-9+\(\)#\.\s\/ext-]+$/', 'message'=>'Invalid Phone Number'),
			array('phone', 'length', 'max'=>20),
		
			array('user_comment, params', 'length', 'max'=>255),
			array('first_name, last_name, email, street_address, city, state', 'length', 'max'=>64),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			
			 // set a default value if needed
			 // array('dte_created, dte_modified', 'default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false,'on'=>'insert')
			
			array('id_lead', 'safe', 'on'=>'search'),	// only allow search by id, if that is even needed
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

// sjg - Need to be localized

		return array(
			'id_lead' => 'Id Lead',
			'make' => 'Make',
			'model' => 'Model',
			'model_year' => 'Model Year',
			'color' => 'Color',
			'trim' => 'Trim',
			'user_comment' => 'User Comment',
			'status' => 'Status',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'phone' => 'Phone',
			'email' => 'Email',
			'street_address' => 'Street Address',
			'city' => 'City',
			'state' => 'State',
			'zipcode' => 'Your ZIP:',
			'params' => 'Params',
			'update_date' => 'Update Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_lead',$this->id_lead);
		$criteria->compare('make',$this->make);
		$criteria->compare('model',$this->model);
		$criteria->compare('model_year',$this->model_year);
		$criteria->compare('color',$this->color);
		$criteria->compare('trim',$this->trim);
		$criteria->compare('user_comment',$this->user_comment,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('street_address',$this->street_address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zipcode',$this->zipcode,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('update_date',$this->update_date,true);

		return new CActiveDataProvider($this, array('criteria'=>$criteria,));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LeadGen the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
