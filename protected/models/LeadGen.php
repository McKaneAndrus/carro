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
 * @property string $int_stadt
 * @property string $int_staat
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
 * @property integer $int_leadstatus
 * @property string  $int_leadcomment
 * @property integer $int_conquest_id
 * @property integer $int_delivery_status
 * @property integer $int_status
 */
 
class LeadGen extends CActiveRecord
{
	public $skipConquest = false;
	public $conquest_make = -999;
	public $conquest_model = -999;
	public $conquest_trim = -999;
	
	/**
	 * @return string the associated database table name
	 */
	 
	public function tableName()
	{
		return '{{interessenten}}';
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

			array('int_fabrikat','required', 'on'=>'landing', 'message'=>Yii::t('LeadGen','Please Select a Make')),
			array('int_modell','required', 'on'=>'landing', 'message'=>Yii::t('LeadGen','Please Select a Model')),
			array('int_plz', 'required', 'on'=>'landing', 'message'=>Yii::t('LeadGen', 'Please Enter a Postal Code')),

			
			// Quote Page - Trim, Color, Email
			
			array('int_ausstattung', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Please Select a Trim')),
			array('int_farbe', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Please Select a Color')),
			array('int_name', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Last Name Required')),
			array('int_vname', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','First Name Required')),
			array('int_tel', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Telephone Required')),
			array('int_mail', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Email Required')),
			array('int_stadt', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Please Select Your City')),
			array('int_staat', 'required', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Please Select Your State')),

			array('int_mail', 'email', 'on'=>'quote', 'message'=>Yii::t('LeadGen','Invalid Email Address')),
			array('int_tel', 'match', 'pattern' =>'/^[0-9+\(\)#\.\s\/ext-]+$/', 'message'=>Yii::t('LeadGen','Invalid Phone Number')),
			
			// add each string field, int_name, int_vname, etc so each can have their own error message
		
			// specific validation and regx for Brazil postal code is to validate numbers in the format of 00000-000

			array('int_plz', 'match', 'pattern' =>'/[0-9]{5}-[0-9]{3}/', 'message'=>Yii::t('LeadGen','Invalid Format, use 00000-000')),
			array('int_plz', 'length', 'max'=>9),

			// Make Id, Model Id, Trim Id, Color Id, Dealer Id, etc

			array('int_fabrikat, int_modell, int_ausstattung, int_farbe, int_haendler', 'numerical', 'integerOnly'=>true),
			
			// Odd case to catch a zero entry as a model (empty field since it's an integer)
			
			array('int_modell','compare','compareValue'=>'0', 'operator'=>'!=', 'message'=>Yii::t('LeadGen','Please Select a Model')),

			// String Data types get length limits
			
			array('int_text', 'length', 'max'=>255),			
			array('int_name, int_vname, int_str', 'length', 'max'=>30),
			array('int_plz', 'length', 'max'=>20),
			array('int_tel', 'length', 'min' => 7, 'max'=>20), // minimum number of characters is 7
			array('int_mail', 'length', 'max'=>64),
			array('int_stadt', 'length', 'max'=>180),
			array('int_staat', 'length', 'max'=>100),

			array('int_anlage, int_ort, int_text', 'safe'),	// mark as safe incase we need these, likely not...
			
			array('int_erreichbar, int_mobil, int_id, int_status, int_premium_id', 'safe'), // not using these below
			array('int_mitarbeiter, int_kvs_status, int_entfernung, int_grund', 'safe'),
			array('int_alt_ausstattung, int_bericht_wv, int_bericht_status, int_bericht_ma', 'safe'),
			array('int_kenntnis, int_suchwort, int_suchmaschine, int_kontakt', 'safe'),
			array('int_zahlungsart, int_kaufzeitpunkt, int_bauart', 'safe'),
			array('int_leadcomment, int_leadstatus', 'safe'),
			array('int_conquest_id, int_delivery_status, int_score', 'safe'),
			
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
