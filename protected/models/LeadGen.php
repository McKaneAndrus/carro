<?php

/**
 * This is the model class for table "{{interessenten}}".
 *
 */
 
class LeadGen extends CActiveRecord
{
	public $skipConquest = false;
	public $conquest_campaign = -999;
	public $conquest_make = -999;
	public $conquest_model = -999;
	public $conquest_trim = -999;
	public $conquest_confirm = false;
	public $conquest_primary_lead = -1;	// indicates no primary lead for a conquest
	public $skipOEM = 'false';
	
	/**
	 * @return string the associated database table name
	 */
	 
	public function tableName()
	{
		return '{{interessenten}}';
	}

	/*
	* make names pretty, force lower then upcase first.
	* does not mess with accented char so they will stay as is.
	* Also sets the insert date on int_anlage to override the trigger which
	* may not have the same time basis as the rest of the system (AMAZON RDS issue)
	*/
	
	protected function beforeSave() 
	{
		$this->int_vname = ucwords(strtolower($this->int_vname));
		$this->int_name = ucwords(strtolower($this->int_name));
		$this->int_anlage = date("Y-m-d H:i:s"); // get current date hack to default it for the db
				
		return parent::beforeSave();
	}
	
	
	public function CEP_Validator($attribute, $params) 
	{
		// hard check some dumb user values. Most all will fail the DB Check
		// but why waste a db call for the common fakes
		
		$fails = array(
				'00000-000',
				'11111-111',
				'22222-222', 
				'33333-333', 
				'44444-444', 
				'55555-555', 
				'66666-666', 
				'77777-777', 
				'88888-888', 
				'99999-999',
				'12345-678',
				'12345-123'
			);

		if(!isset($params['message']))
			$params['message'] = Yii::t('yii', '{attribute} is invalid.', array('{attribute}' => $attribute));

		// keep the simple cases out without a db call, if in the above table, or an underscore (from mask) and finally a dbcall
		// empty string might be same as 'required' but it's here just in case this gets called prior to the required test.
		
		if(in_array($this->int_plz, $fails) || strpos($this->int_plz, '_') || strlen($this->int_plz) == 0)
			$this->addError($attribute, $params['message']);
		elseif(!$this->PostalCodeExists($this->int_plz))            
			$this->addError($attribute, $params['message']);
	}
	
	/*
	* Given a postal code string in the form of '00000-000' the value
	* is checked in the extended postal code table
	*
	* if found returns true, false if not found (invalid)
	*/
	
	public function PostalCodeExists($postal_code_str)
	{
		// expects postal code to be well formed as '00000-000' otherwise fail

		$sql = Yii::app()->db->createCommand();
		$sql->select('code');
		$sql->from('{{extended_postal_codes}}');									// will prepend country
		$sql->where('code=:postal_code', array(':postal_code' => $postal_code_str));
		$sql->limit(1);
		$rec = $sql->queryRow();	 // false if nothing set, row record otherwise
	
		return ($rec == false)? false : true;
	}

		
	/**
	 * @return array validation rules for model attributes.
	 */
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that will receive user inputs.

		return array(

			// specify validations for each page
			// Landing Page - Make, Model, Postal Code

			array('int_fabrikat','required', 'on'=>'landing', 'message'=>Yii::t('LeadGen','Please Select a Make')),
			array('int_modell','required', 'on'=>'landing', 'message'=>Yii::t('LeadGen','Please Select a Model')),
			array('int_plz', 'required', 'on'=>'landing', 'message'=>Yii::t('LeadGen', 'CEP Required')),

			
			// Quote Page - Trim, Color, Email
			
			array('int_ausstattung', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Please Select a Trim')),
			array('int_farbe', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Please Select a Color')),
			array('int_name', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Last Name Required')),
			array('int_vname', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','First Name Required')),
			array('int_tel', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Telephone Required')),

			array('int_cpf', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','CPF Required')),
			array('int_cpf', 'ext.validators.cpf', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Invalid CPF Number')),	

			array('int_mail', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Email Required')),
			array('int_stadt', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Please Select Your City')),
			array('int_staat', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Please Select Your State')),

			array('int_mail', 'email', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Invalid Email Address')),
			array('int_tel', 'match', 'pattern' =>'/^[0-9+\(\)#\.\s\/ext-]+$/', 'message'=>Yii::t('LeadGen','Invalid Phone Number')),
			array('int_tel', 'ext.validators.PhoneValidator', 'on'=>'quote', 'areaCode' => true, 'message'=>Yii::t('LeadGen','Invalid Phone Number')),	
			
			// add each string field, int_name, int_vname, etc so each can have their own error message


			// /^[\sa-zA-Z\x80-\xff]+$/ -  this regx will allow only alpha and extended char set (UTF8 encoded) anchored beginning and ending of string
			array('int_vname', 'match', 'pattern' =>'/^[\s\.\-\'a-zA-Z\x80-\xff]+$/', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Invalid Characters')),
			array('int_name', 'match', 'pattern' =>'/^[\s\.\-\'a-zA-Z\x80-\xff]+$/', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Invalid Characters')),
		
			// specific validation and regx for Brazil postal code is to validate numbers in the format of 00000-000

			array('int_plz', 'CEP_Validator', 'message'=>Yii::t('LeadGen','Invalid CEP Number')),
			array('int_plz', 'match', 'pattern' =>'/[0-9]{5}-[0-9]{3}/', 'message'=>Yii::t('LeadGen','Invalid Format, use 00000-000')),
			array('int_plz', 'length', 'max'=>9),
			
			// Make Id, Model Id, Trim Id, Color Id, Dealer Id, etc

			array('int_fabrikat, int_modell, int_ausstattung, int_farbe, int_haendler', 'numerical', 'integerOnly'=>true),
			
			// Odd case to catch a zero entry as a model (empty field since it's an integer)
			
			array('int_modell','compare','compareValue'=>'0', 'operator'=>'!=', 'message'=>Yii::t('LeadGen','Please Select a Model')),

			// String Data types get length limits
			
			array('int_cpf', 'length', 'max'=>14),
			array('int_text', 'length', 'max'=>255),			
			array('int_name, int_vname, int_str', 'length', 'max'=>30),
			array('int_plz', 'length', 'max'=>20),
			array('int_tel', 'length', 'min' => 9, 'max'=>15), // >>>>> VALIDATE THIS AGAIN
			array('int_mail', 'length', 'max'=>64),
			array('int_stadt', 'length', 'max'=>180),
			array('int_staat', 'length', 'max'=>100),

			array('int_anlage, int_ort, int_text', 'safe'),	// mark as safe incase we need these, likely not...
			
			array('int_erreichbar, int_mobil, int_id, int_status, int_premium_id', 'safe'), // not using these below
			array('int_mitarbeiter, int_kvs_status, int_entfernung, int_grund', 'safe'),
			array('int_alt_ausstattung, int_bericht_wv, int_bericht_status, int_bericht_ma', 'safe'),
			array('int_kenntnis, int_suchwort, int_suchmaschine, int_kontakt', 'safe'),
			array('int_zahlungsart, int_kaufzeitpunkt, int_bauart', 'safe'),
			array('int_leadcomment, int_leadstatus, int_premium', 'safe'),
			array('int_conquest_id, int_delivery_status, int_score', 'safe'),
			
			array('conquest_primary_lead', 'safe'),	// must be safe or won't assign in page state!
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			
			array('int_id, int_name, int_vname, int_plz, int_status, int_mail, int_fabrikat, int_modell', 'safe', 'on'=>'search'),
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
			'int_id' => 'Int',
			'int_name' => Yii::t('LeadGen', 'Last Name'),
			'int_vname' => Yii::t('LeadGen', 'First Name'),
			'int_plz' => Yii::t('LeadGen', 'Zip Code'),
			'int_ort' => 'Location',
			'int_str' => Yii::t('LeadGen', 'Street Address'),
			'int_stadt' => Yii::t('LeadGen','City'),
			'int_staat' => Yii::t('LeadGen','State'),
			'int_tel' => Yii::t('LeadGen', 'Telephone'),
			'int_mobil' => 'Mobil Phone',
			'int_mail' => Yii::t('LeadGen', 'Email'),
			'int_fabrikat' => Yii::t('LeadGen', 'Make'),
			'int_modell' => Yii::t('LeadGen', 'Model'),
			'int_bauart' => 'Type',
			'int_ausstattung' => Yii::t('LeadGen', 'Trim'),
			'int_farbe' => Yii::t('LeadGen', 'Color'),
			'int_kaufzeitpunkt' => 'Int Kaufzeitpunkt',
			'int_zahlungsart' => 'Int Zahlungsart',
			'int_kontakt' => 'Int Kontakt',
			'int_haendler' => 'Int Haendler',
			'int_anlage' => 'Create Date',
			'int_suchmaschine' => 'Int Suchmaschine',
			'int_suchwort' => 'Int Suchwort',
			'int_erreichbar' => 'Int Erreichbar',
			'int_kenntnis' => 'Int Kenntnis',
			'int_text' => Yii::t('LeadGen', 'Message'),
			'int_bericht_ma' => 'Int Bericht Ma',
			'int_bericht_status' => 'Int Bericht Status',
			'int_bericht_wv' => 'Int Bericht Wv',
			'int_alt_ausstattung' => 'Int Alt Ausstattung',
			'int_grund' => 'Int Grund',
			'int_entfernung' => 'Int Entfernung',
			'int_kvs_status' => 'Int Kvs Status',
			'int_mitarbeiter' => 'Int Mitarbeiter',
			'int_premium_id' => 'Int Premium',
			'int_conquest_id' => 'Int Conquest Id',
			'int_delivery_status' => 'Int Delivery Status',
			'int_score' => 'Int Score',
			'int_status' => 'Int Status',
			'int_cpf'  => Yii::t('LeadGen', 'SSN'),
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

		$criteria->compare('int_id',$this->int_id);
		$criteria->compare('int_name',$this->int_name,true);
		$criteria->compare('int_vname',$this->int_vname,true);
		$criteria->compare('int_plz',$this->int_plz,true);
		$criteria->compare('int_ort',$this->int_ort,true);
		$criteria->compare('int_str',$this->int_str,true);
		$criteria->compare('int_stadt',$this->int_stadt,true);
		$criteria->compare('int_staat',$this->int_staat,true);		
		$criteria->compare('int_tel',$this->int_tel,true);
		$criteria->compare('int_mail',$this->int_mail,true);
		$criteria->compare('int_fabrikat',$this->int_fabrikat);
		$criteria->compare('int_modell',$this->int_modell);
		$criteria->compare('int_bauart',$this->int_bauart);
		$criteria->compare('int_ausstattung',$this->int_ausstattung);
		$criteria->compare('int_farbe',$this->int_farbe);
		$criteria->compare('int_kontakt',$this->int_kontakt);
		$criteria->compare('int_haendler',$this->int_haendler);
		$criteria->compare('int_anlage',$this->int_anlage,true);
		$criteria->compare('int_text',$this->int_text,true);
		$criteria->compare('int_premium_id',$this->int_premium_id);
		$criteria->compare('int_status',$this->int_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
