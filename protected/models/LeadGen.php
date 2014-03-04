<?php

/**
 * This is the model class for table "{{interessenten}}".
 *
 * The followings are the available columns in table '{{interessenten}}':
 * @property integer $int_id
 * @property string $int_name
 * @property string $int_vname
 * @property string $int_plz
 * @property string $int_ort
 * @property string $int_str
 * @property string $int_tel
 * @property string $int_mobil
 * @property string $int_mail
 * @property integer $int_fabrikat
 * @property integer $int_modell
 * @property integer $int_bauart
 * @property integer $int_ausstattung
 * @property integer $int_farbe
 * @property integer $int_kaufzeitpunkt
 * @property integer $int_zahlungsart
 * @property integer $int_kontakt
 * @property integer $int_haendler
 * @property string $int_anlage
 * @property integer $int_suchmaschine
 * @property integer $int_suchwort
 * @property string $int_erreichbar
 * @property integer $int_kenntnis
 * @property string $int_text
 * @property integer $int_bericht_ma
 * @property integer $int_bericht_status
 * @property string $int_bericht_wv
 * @property integer $int_alt_ausstattung
 * @property integer $int_grund
 * @property integer $int_entfernung
 * @property integer $int_kvs_status
 * @property integer $int_mitarbeiter
 * @property integer $int_premium_id
 * @property integer $int_status
 *
 * German to English Translation
 * int_id prospect id int(8)
 * int_name name varchar(30)
 * int_vname forename/firstname varchar(30)
 * int_plz zip varchar(5)
 * int_ort location varchar(30)
 * int_str street address varchar(30)
 * int_tel phone varchar(20)
 * int_mobil cell phone varchar(20)
 * int_mail Email varchar(64)
 * int_fabrikat make id int(8)
 * int_modell model id int(8)
 * int_bauart type int(5)
 * int_ausstattung trim id int(20)
 * int_farbe int(8)
 * int_kaufzeitpunkt purchase time smallint(2)
 * int_zahlungsart payment method smallint(2)
 * int_kontakt contact id smallint(2)
 * int_haendler dealer id int(8)
 * int_anlage creation date datetime
 * int_suchmaschine search engine id int(8)
 * int_suchwort keyword id int(8)
 * int_erreichbar reachable varchar(40)
 * int_kenntnis having regard terms smallint(1)
 * int_text report text
 * int_bericht_ma report user id (employee) int(8)
 * int_bericht_status report status smallint(1)
 * int_bericht_wv report reminder
 * int_alt_ausstattung alternate trim smallint(1)
 * int_grund reason for contact id (table x_.._entfernung) smallint(2)
 * int_entfernung distance to dealer id (table x_.._entfernung) smallint(2)
 * int_kvs_status smallint(1)
 * int_mitarbeiter ???? smallint(4)
 * int_premium_id ???? int(8)
 * int_status smallint(1)
 */
 
class LeadGen extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{interessenten}}';
	}


	public function init()
	{
		$this->int_anlage = date("Y-m-d"); // get current date hack to default it for the db
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.

		return array(

			// specify validations for each page
			// Landing Page - Make, Model, Postal Code

			array('int_fabrikat','required', 'on'=>'landing', 'message'=>'Please Select a Make'),
			array('int_modell','required', 'on'=>'landing', 'message'=>'Please Select a Model'),
			array('int_plz','required', 'on'=>'landing', 'message'=>'Please Enter a Postal Code'),
			
			// Quote Page - Trim, Color, Email
			
			array('int_ausstattung', 'required', 'on'=>'quote', 'message'=>'Please Select a Trim'),
			array('int_farbe', 'required', 'on'=>'quote', 'message'=>'Please Select a Color'),
			array('int_name', 'required', 'on'=>'quote', 'message'=>'Last Name Required'),
			array('int_vname', 'required', 'on'=>'quote', 'message'=>'First Name Required'),
			array('int_tel', 'required', 'on'=>'quote', 'message'=>'Telephone Required'),
			array('int_mail', 'required', 'on'=>'quote', 'message'=>'Email Required'),

			array('int_mail', 'email', 'on'=>'quote', 'message'=>'Invalid Email Address'),
			array('int_tel', 'match', 'pattern' =>'/^[0-9+\(\)#\.\s\/ext-]+$/', 'message'=>'Invalid Phone Number'),
			
			// add each string field, int_name, int_vname, etc so each can have their own error message
		
			// specific validation and regx for Brazil postal code is to validate numbers in the format of 00000-000

			array('int_plz', 'match', 'pattern' =>'/[0-9]{5}-[0-9]{3}/', 'message'=>'Invalid Format, use 00000-000'),
			array('int_plz', 'length', 'max'=>9),

			// Make Id, Model Id, Trim Id, Color Id, Dealer Id

			array('int_fabrikat, int_modell, int_ausstattung, int_farbe, int_haendler', 'numerical', 'integerOnly'=>true),

			// String Data types get length limits
			
			array('int_text', 'length', 'max'=>255),			
			array('int_name, int_vname, int_str', 'length', 'max'=>30),
			array('int_plz', 'length', 'max'=>20),
			array('int_tel', 'length', 'min' => 7, 'max'=>20), // minimum number of characters is 7
			array('int_mail', 'length', 'max'=>64),
					
			// set a default value if needed, in this case stuff the create date (int_anlage) with current db time

			array('int_anlage, int_ort, int_text', 'safe'),	// mark as safe incase we need these, likely not...
			
			array('int_erreichbar, int_mobil, int_id, int_status, int_premium_id', 'safe'), // not using these below
			array('int_mitarbeiter, int_kvs_status, int_entfernung, int_grund', 'safe'),
			array('int_alt_ausstattung, int_bericht_wv, int_bericht_status, int_bericht_ma', 'safe'),
			array('int_kenntnis, int_suchwort, int_suchmaschine, int_kontakt', 'safe'),
			array('int_zahlungsart, int_kaufzeitpunkt, int_bauart', 'safe'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			
			array('int_id, int_name, int_vname, int_plz, int_status', 'safe', 'on'=>'search'),
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
			
			// the inthae (this table is the many part, which is selected dealers of a particular lead
							// variable => Relationship, Class name, foriegn_key
			'inthae'=>array(self::HAS_MANY, 'Inthae', 'ih_prospect_id'),
			'dlrs'=>array(self::HAS_MANY, 'DealerLookup', 'hd_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'int_id' => 'Int',
			'int_name' => 'Last Name',
			'int_vname' => 'First Name',
			'int_plz' => 'Your ZIP:',
			'int_ort' => 'Location',
			'int_str' => 'Street Address',
			'int_tel' => 'Telephone',
			'int_mobil' => 'Mobil Phone',
			'int_mail' => 'Email',
			'int_fabrikat' => 'Color',
			'int_modell' => 'Model',
			'int_bauart' => 'Type',
			'int_ausstattung' => 'Trim',
			'int_farbe' => 'Color',
			'int_kaufzeitpunkt' => 'Int Kaufzeitpunkt',
			'int_zahlungsart' => 'Int Zahlungsart',
			'int_kontakt' => 'Int Kontakt',
			'int_haendler' => 'Int Haendler',
			'int_anlage' => 'Create Date',
			'int_suchmaschine' => 'Int Suchmaschine',
			'int_suchwort' => 'Int Suchwort',
			'int_erreichbar' => 'Int Erreichbar',
			'int_kenntnis' => 'Int Kenntnis',
			'int_text' => 'Message',
			'int_bericht_ma' => 'Int Bericht Ma',
			'int_bericht_status' => 'Int Bericht Status',
			'int_bericht_wv' => 'Int Bericht Wv',
			'int_alt_ausstattung' => 'Int Alt Ausstattung',
			'int_grund' => 'Int Grund',
			'int_entfernung' => 'Int Entfernung',
			'int_kvs_status' => 'Int Kvs Status',
			'int_mitarbeiter' => 'Int Mitarbeiter',
			'int_premium_id' => 'Int Premium',
			'int_status' => 'Int Status',
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
		$criteria->compare('int_tel',$this->int_tel,true);
		$criteria->compare('int_mobil',$this->int_mobil,true);
		$criteria->compare('int_mail',$this->int_mail,true);
		$criteria->compare('int_fabrikat',$this->int_fabrikat);
		$criteria->compare('int_modell',$this->int_modell);
		$criteria->compare('int_bauart',$this->int_bauart);
		$criteria->compare('int_ausstattung',$this->int_ausstattung);
		$criteria->compare('int_farbe',$this->int_farbe);
		$criteria->compare('int_kaufzeitpunkt',$this->int_kaufzeitpunkt);
		$criteria->compare('int_zahlungsart',$this->int_zahlungsart);
		$criteria->compare('int_kontakt',$this->int_kontakt);
		$criteria->compare('int_haendler',$this->int_haendler);
		$criteria->compare('int_anlage',$this->int_anlage,true);
		$criteria->compare('int_suchmaschine',$this->int_suchmaschine);
		$criteria->compare('int_suchwort',$this->int_suchwort);
		$criteria->compare('int_erreichbar',$this->int_erreichbar,true);
		$criteria->compare('int_kenntnis',$this->int_kenntnis);
		$criteria->compare('int_text',$this->int_text,true);
		$criteria->compare('int_bericht_ma',$this->int_bericht_ma);
		$criteria->compare('int_bericht_status',$this->int_bericht_status);
		$criteria->compare('int_bericht_wv',$this->int_bericht_wv,true);
		$criteria->compare('int_alt_ausstattung',$this->int_alt_ausstattung);
		$criteria->compare('int_grund',$this->int_grund);
		$criteria->compare('int_entfernung',$this->int_entfernung);
		$criteria->compare('int_kvs_status',$this->int_kvs_status);
		$criteria->compare('int_mitarbeiter',$this->int_mitarbeiter);
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
