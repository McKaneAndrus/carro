<?php

/**
 * This is the model class for table "{{haendler}}".
 *
 * The followings are the available columns in table '{{haendler}}':
 * @property integer $hd_id
 * @property integer $hd_kdnr
 * @property string $hd_name
 * @property string $hd_anschrift2
 * @property string $hd_ansprech
 * @property string $hd_str
 * @property string $hd_plz
 * @property string $hd_ort
 * @property string $hd_tel
 * @property string $hd_fax
 * @property string $hd_mobil
 * @property string $hd_mail
 * @property string $hd_url
 * @property integer $hd_fabrikat
 * @property string $hd_gebiet_von
 * @property string $hd_gebiet_bis
 * @property string $hd_leadpreis
 * @property integer $hd_leadslimit
 * @property integer $hd_einzelnachweis
 * @property integer $hd_leads_monat
 * @property integer $hd_leads_jahr
 * @property integer $hd_leads_gesamt
 * @property string $hd_umsatz_monat
 * @property string $hd_umsatz_jahr
 * @property string $hd_umsatz_ges
 * @property string $hd_anlage
 * @property string $hd_anlage_user
 * @property string $hd_letz_aend
 * @property string $hd_aender_user
 * @property string $hd_letz_lead
 * @property string $hd_text
 * @property integer $hd_mitarbeiter
 * @property integer $hd_premiumkz
 * @property integer $hd_mahnkz
 * @property string $hd_laufzeit
 * @property integer $hd_anzahl_filialen
 * @property integer $hd_status
 * @property double $latitude
 * @property double $longitude
 */
class DealerLookup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{haendler}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hd_plz, hd_text', 'required'),
			array('hd_kdnr, hd_fabrikat, hd_leadslimit, hd_einzelnachweis, hd_leads_monat, hd_leads_jahr, hd_leads_gesamt, hd_mitarbeiter, hd_premiumkz, hd_mahnkz, hd_anzahl_filialen, hd_status', 'numerical', 'integerOnly'=>true),
			array('latitude, longitude', 'numerical'),
			array('hd_name, hd_anschrift2', 'length', 'max'=>40),
			array('hd_ansprech, hd_str, hd_ort', 'length', 'max'=>30),
			array('hd_plz, hd_tel, hd_fax, hd_mobil', 'length', 'max'=>20),
			array('hd_mail', 'length', 'max'=>64),
			array('hd_url', 'length', 'max'=>128),
			array('hd_gebiet_von, hd_gebiet_bis', 'length', 'max'=>5),
			array('hd_leadpreis, hd_umsatz_monat, hd_umsatz_jahr, hd_umsatz_ges', 'length', 'max'=>11),
			array('hd_anlage_user, hd_aender_user', 'length', 'max'=>12),
			array('hd_anlage, hd_letz_aend, hd_letz_lead, hd_laufzeit', 'safe'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			
			array('hd_id, hd_kdnr, hd_name, hd_anschrift2, hd_ansprech, hd_str, hd_plz, hd_ort, hd_tel, hd_fax, hd_mobil, hd_mail, hd_url, hd_fabrikat, hd_gebiet_von, hd_gebiet_bis, hd_leadpreis, hd_leadslimit, hd_einzelnachweis, hd_leads_monat, hd_leads_jahr, hd_leads_gesamt, hd_umsatz_monat, hd_umsatz_jahr, hd_umsatz_ges, hd_anlage, hd_anlage_user, hd_letz_aend, hd_aender_user, hd_letz_lead, hd_text, hd_mitarbeiter, hd_premiumkz, hd_mahnkz, hd_laufzeit, hd_anzahl_filialen, hd_status, latitude, longitude', 'safe', 'on'=>'search'),
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
			'hd_id' => 'Hd',
			'hd_kdnr' => 'Hd Kdnr',
			'hd_name' => 'Hd Name',
			'hd_anschrift2' => 'Hd Anschrift2',
			'hd_ansprech' => 'Hd Ansprech',
			'hd_str' => 'Hd Str',
			'hd_plz' => 'Hd Plz',
			'hd_ort' => 'Hd Ort',
			'hd_tel' => 'Hd Tel',
			'hd_fax' => 'Hd Fax',
			'hd_mobil' => 'Hd Mobil',
			'hd_mail' => 'Hd Mail',
			'hd_url' => 'Hd Url',
			'hd_fabrikat' => 'Hd Fabrikat',
			'hd_gebiet_von' => 'Hd Gebiet Von',
			'hd_gebiet_bis' => 'Hd Gebiet Bis',
			'hd_leadpreis' => 'Hd Leadpreis',
			'hd_leadslimit' => 'Hd Leadslimit',
			'hd_einzelnachweis' => 'Hd Einzelnachweis',
			'hd_leads_monat' => 'Hd Leads Monat',
			'hd_leads_jahr' => 'Hd Leads Jahr',
			'hd_leads_gesamt' => 'Hd Leads Gesamt',
			'hd_umsatz_monat' => 'Hd Umsatz Monat',
			'hd_umsatz_jahr' => 'Hd Umsatz Jahr',
			'hd_umsatz_ges' => 'Hd Umsatz Ges',
			'hd_anlage' => 'Hd Anlage',
			'hd_anlage_user' => 'Hd Anlage User',
			'hd_letz_aend' => 'Hd Letz Aend',
			'hd_aender_user' => 'Hd Aender User',
			'hd_letz_lead' => 'Hd Letz Lead',
			'hd_text' => 'Hd Text',
			'hd_mitarbeiter' => 'Hd Mitarbeiter',
			'hd_premiumkz' => 'Hd Premiumkz',
			'hd_mahnkz' => 'Hd Mahnkz',
			'hd_laufzeit' => 'Hd Laufzeit',
			'hd_anzahl_filialen' => 'Hd Anzahl Filialen',
			'hd_status' => 'Hd Status',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
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

		$criteria->compare('hd_id',$this->hd_id);
		$criteria->compare('hd_kdnr',$this->hd_kdnr);
		$criteria->compare('hd_name',$this->hd_name,true);
		$criteria->compare('hd_anschrift2',$this->hd_anschrift2,true);
		$criteria->compare('hd_ansprech',$this->hd_ansprech,true);
		$criteria->compare('hd_str',$this->hd_str,true);
		$criteria->compare('hd_plz',$this->hd_plz,true);
		$criteria->compare('hd_ort',$this->hd_ort,true);
		$criteria->compare('hd_tel',$this->hd_tel,true);
		$criteria->compare('hd_fax',$this->hd_fax,true);
		$criteria->compare('hd_mobil',$this->hd_mobil,true);
		$criteria->compare('hd_mail',$this->hd_mail,true);
		$criteria->compare('hd_url',$this->hd_url,true);
		$criteria->compare('hd_fabrikat',$this->hd_fabrikat);
		$criteria->compare('hd_gebiet_von',$this->hd_gebiet_von,true);
		$criteria->compare('hd_gebiet_bis',$this->hd_gebiet_bis,true);
		$criteria->compare('hd_leadpreis',$this->hd_leadpreis,true);
		$criteria->compare('hd_leadslimit',$this->hd_leadslimit);
		$criteria->compare('hd_einzelnachweis',$this->hd_einzelnachweis);
		$criteria->compare('hd_leads_monat',$this->hd_leads_monat);
		$criteria->compare('hd_leads_jahr',$this->hd_leads_jahr);
		$criteria->compare('hd_leads_gesamt',$this->hd_leads_gesamt);
		$criteria->compare('hd_umsatz_monat',$this->hd_umsatz_monat,true);
		$criteria->compare('hd_umsatz_jahr',$this->hd_umsatz_jahr,true);
		$criteria->compare('hd_umsatz_ges',$this->hd_umsatz_ges,true);
		$criteria->compare('hd_anlage',$this->hd_anlage,true);
		$criteria->compare('hd_anlage_user',$this->hd_anlage_user,true);
		$criteria->compare('hd_letz_aend',$this->hd_letz_aend,true);
		$criteria->compare('hd_aender_user',$this->hd_aender_user,true);
		$criteria->compare('hd_letz_lead',$this->hd_letz_lead,true);
		$criteria->compare('hd_text',$this->hd_text,true);
		$criteria->compare('hd_mitarbeiter',$this->hd_mitarbeiter);
		$criteria->compare('hd_premiumkz',$this->hd_premiumkz);
		$criteria->compare('hd_mahnkz',$this->hd_mahnkz);
		$criteria->compare('hd_laufzeit',$this->hd_laufzeit,true);
		$criteria->compare('hd_anzahl_filialen',$this->hd_anzahl_filialen);
		$criteria->compare('hd_status',$this->hd_status);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('longitude',$this->longitude);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealerLookup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
