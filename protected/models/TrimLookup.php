<?php

/**
 * This is the model class for table "ausstattung".
 *
 * The followings are the available columns in table 'ausstattung':
 * @property integer $aus_id
 * @property integer $aus_modell
 * @property string $aus_bez
 * @property integer $aus_sitze
 * @property integer $aus_bezug
 * @property integer $aus_motorart
 * @property integer $aus_hubraum
 * @property integer $aus_leistung
 * @property integer $aus_antrieb
 * @property integer $aus_zylinder
 * @property integer $aus_schaltung
 * @property string $aus_verbrauch_stadt
 * @property string $aus_verbrauch_land
 * @property string $aus_verbrauch_bab
 * @property string $aus_verbrauch_mix
 * @property integer $aus_emissionen
 * @property string $aus_beschleunigung
 * @property integer $aus_drehmoment
 * @property integer $aus_drehmoment_drehzahl
 * @property integer $aus_abs
 * @property integer $aus_esp
 * @property integer $aus_airbags
 * @property integer $aus_klimaanlage
 * @property integer $aus_hoehe
 * @property integer $aus_breite
 * @property integer $aus_laenge
 * @property integer $aus_leergewicht
 * @property integer $aus_zuladung
 * @property integer $aus_gepaeckraum
 * @property integer $aus_tank
 * @property integer $aus_navi
 * @property integer $aus_klimaautomatik
 * @property integer $aus_schiebedach
 * @property integer $aus_tempomat
 * @property integer $aus_einparkhilfe
 * @property integer $aus_lederausstattung
 * @property integer $aus_leichtmetallfelgen
 * @property integer $aus_sitzheizung
 * @property integer $aus_standheizung
 * @property integer $aus_xenonlicht
 * @property integer $aus_haengerkupplung
 * @property string $aus_listenpreis
 * @property string $aus_kennziffer
 * @property integer $aus_klasse
 * @property string $aus_anlage
 * @property integer $aus_picks
 * @property string $aus_lastpick
 * @property string $aus_aenderdatum
 * @property string $aus_anlage_user
 * @property string $aus_aender_user
 * @property integer $aus_status
 *
 *
 * German to Engish Field Translation
 *
 * aus_id => record id 
 * aus_modell => model id 
 * aus_bez => description
 * seats id => (table x_.._sitze)
 * aus_bezug => seat cover id (table x_.._bezug) 
 * aus_motorart => engine type id (table x_.._motorart)
 * aus_hubraum => cubic capacity
 * aus_leistung => Power
 * aus_antrieb => drive id (table x_.._antrieb) 
 * aus_zylinder => cylinder id (table x_.._zylinder) 
 * aus_schaltung => gear shift id (table x_.._schaltung) 
 * aus_verbrauch_stadt => fuel consumption city 
 * aus_verbrauch_land => fuel consumption country 
 * aus_verbrauch_bab => fuel consumption highway 
 * aus_verbrauch_mix => fuel consumption mix
 * aus_emissionen => emission id (table x_.._emission) 
 * aus_beschleunigung => acceleration 
 * aus_drehmoment => torque
 * aus_drehmoment_drehzahl => torque-speed
 * aus_esp => esp 
 * aus_airbags => airbags
 * aus_klimaanlage => air conditioning
 * aus_hoehe => height (cm)
 * aus_breite => width (cm)
 * aus_laenge length (cm)
 * aus_leergewicht => tare
 * aus_zuladung => additional load
 * aus_gepaeckraum luggage compartment
 * aus_tank => tank capacity
 * aus_navi => navigation system
 * aus_klimaautomatik => automatic climate control
 * aus_schiebedach => sunroof 
 * aus_tempomat => cruise control
 * aus_einparkhilfe => parking aid 
 * aus_lederausstattung => leather seats 
 * aus_leichtmetallfelgen => alloy rims 
 * aus_sitzheizung => heated seats
 * aus_standheizung => stand-heating 
 * aus_xenonlicht => xenon lights
 * aus_haengerkupplung => trailer hitch 
 * aus_listenpreis => list price
 * aus_kennziffer => code number (intern)
 * aus_klasse => class
 * aus_anlage => creation date
 * aus_picks => number of clicks
 * aus_lastpick => date of last click
 * aus_aenderdatum => Update Date
 * aus_anlage_user => creation user 
 * aus_aender_user update user 
 * aus_status => Status (1 = record is locked) smallint(1)
 */

class TrimLookup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ausstattung}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('aus_modell, aus_sitze, aus_bezug, aus_motorart, aus_hubraum, aus_leistung, aus_antrieb, aus_zylinder, aus_schaltung, aus_emissionen, aus_drehmoment, aus_drehmoment_drehzahl, aus_abs, aus_esp, aus_airbags, aus_klimaanlage, aus_hoehe, aus_breite, aus_laenge, aus_leergewicht, aus_zuladung, aus_gepaeckraum, aus_tank, aus_navi, aus_klimaautomatik, aus_schiebedach, aus_tempomat, aus_einparkhilfe, aus_lederausstattung, aus_leichtmetallfelgen, aus_sitzheizung, aus_standheizung, aus_xenonlicht, aus_haengerkupplung, aus_klasse, aus_picks, aus_status', 'numerical', 'integerOnly'=>true),
			array('aus_bez', 'length', 'max'=>40),
			array('aus_verbrauch_stadt, aus_verbrauch_land, aus_verbrauch_bab, aus_verbrauch_mix', 'length', 'max'=>5),
			array('aus_beschleunigung', 'length', 'max'=>4),
			array('aus_listenpreis, aus_kennziffer', 'length', 'max'=>11),
			array('aus_anlage_user, aus_aender_user', 'length', 'max'=>12),
			array('aus_anlage, aus_lastpick, aus_aenderdatum', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('aus_id, aus_modell, aus_bez, aus_sitze, aus_bezug, aus_motorart, aus_hubraum, aus_leistung, aus_antrieb, aus_zylinder, aus_schaltung, aus_verbrauch_stadt, aus_verbrauch_land, aus_verbrauch_bab, aus_verbrauch_mix, aus_emissionen, aus_beschleunigung, aus_drehmoment, aus_drehmoment_drehzahl, aus_abs, aus_esp, aus_airbags, aus_klimaanlage, aus_hoehe, aus_breite, aus_laenge, aus_leergewicht, aus_zuladung, aus_gepaeckraum, aus_tank, aus_navi, aus_klimaautomatik, aus_schiebedach, aus_tempomat, aus_einparkhilfe, aus_lederausstattung, aus_leichtmetallfelgen, aus_sitzheizung, aus_standheizung, aus_xenonlicht, aus_haengerkupplung, aus_listenpreis, aus_kennziffer, aus_klasse, aus_anlage, aus_picks, aus_lastpick, aus_aenderdatum, aus_anlage_user, aus_aender_user, aus_status', 'safe', 'on'=>'search'),
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
			'aus_id' => 'Aus',
			'aus_modell' => 'Aus Modell',
			'aus_bez' => 'Aus Bez',
			'aus_sitze' => 'Aus Sitze',
			'aus_bezug' => 'Aus Bezug',
			'aus_motorart' => 'Aus Motorart',
			'aus_hubraum' => 'Aus Hubraum',
			'aus_leistung' => 'Aus Leistung',
			'aus_antrieb' => 'Aus Antrieb',
			'aus_zylinder' => 'Aus Zylinder',
			'aus_schaltung' => 'Aus Schaltung',
			'aus_verbrauch_stadt' => 'Aus Verbrauch Stadt',
			'aus_verbrauch_land' => 'Aus Verbrauch Land',
			'aus_verbrauch_bab' => 'Aus Verbrauch Bab',
			'aus_verbrauch_mix' => 'Aus Verbrauch Mix',
			'aus_emissionen' => 'Aus Emissionen',
			'aus_beschleunigung' => 'Aus Beschleunigung',
			'aus_drehmoment' => 'Aus Drehmoment',
			'aus_drehmoment_drehzahl' => 'Aus Drehmoment Drehzahl',
			'aus_abs' => 'Aus Abs',
			'aus_esp' => 'Aus Esp',
			'aus_airbags' => 'Aus Airbags',
			'aus_klimaanlage' => 'Aus Klimaanlage',
			'aus_hoehe' => 'Aus Hoehe',
			'aus_breite' => 'Aus Breite',
			'aus_laenge' => 'Aus Laenge',
			'aus_leergewicht' => 'Aus Leergewicht',
			'aus_zuladung' => 'Aus Zuladung',
			'aus_gepaeckraum' => 'Aus Gepaeckraum',
			'aus_tank' => 'Aus Tank',
			'aus_navi' => 'Aus Navi',
			'aus_klimaautomatik' => 'Aus Klimaautomatik',
			'aus_schiebedach' => 'Aus Schiebedach',
			'aus_tempomat' => 'Aus Tempomat',
			'aus_einparkhilfe' => 'Aus Einparkhilfe',
			'aus_lederausstattung' => 'Aus Lederausstattung',
			'aus_leichtmetallfelgen' => 'Aus Leichtmetallfelgen',
			'aus_sitzheizung' => 'Aus Sitzheizung',
			'aus_standheizung' => 'Aus Standheizung',
			'aus_xenonlicht' => 'Aus Xenonlicht',
			'aus_haengerkupplung' => 'Aus Haengerkupplung',
			'aus_listenpreis' => 'Aus Listenpreis',
			'aus_kennziffer' => 'Aus Kennziffer',
			'aus_klasse' => 'Aus Klasse',
			'aus_anlage' => 'Aus Anlage',
			'aus_picks' => 'Aus Picks',
			'aus_lastpick' => 'Aus Lastpick',
			'aus_aenderdatum' => 'Aus Aenderdatum',
			'aus_anlage_user' => 'Aus Anlage User',
			'aus_aender_user' => 'Aus Aender User',
			'aus_status' => 'Aus Status',
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

		$criteria->compare('aus_id',$this->aus_id);
		$criteria->compare('aus_modell',$this->aus_modell);
		$criteria->compare('aus_bez',$this->aus_bez,true);
		$criteria->compare('aus_sitze',$this->aus_sitze);
		$criteria->compare('aus_bezug',$this->aus_bezug);
		$criteria->compare('aus_motorart',$this->aus_motorart);
		$criteria->compare('aus_hubraum',$this->aus_hubraum);
		$criteria->compare('aus_leistung',$this->aus_leistung);
		$criteria->compare('aus_antrieb',$this->aus_antrieb);
		$criteria->compare('aus_zylinder',$this->aus_zylinder);
		$criteria->compare('aus_schaltung',$this->aus_schaltung);
		$criteria->compare('aus_verbrauch_stadt',$this->aus_verbrauch_stadt,true);
		$criteria->compare('aus_verbrauch_land',$this->aus_verbrauch_land,true);
		$criteria->compare('aus_verbrauch_bab',$this->aus_verbrauch_bab,true);
		$criteria->compare('aus_verbrauch_mix',$this->aus_verbrauch_mix,true);
		$criteria->compare('aus_emissionen',$this->aus_emissionen);
		$criteria->compare('aus_beschleunigung',$this->aus_beschleunigung,true);
		$criteria->compare('aus_drehmoment',$this->aus_drehmoment);
		$criteria->compare('aus_drehmoment_drehzahl',$this->aus_drehmoment_drehzahl);
		$criteria->compare('aus_abs',$this->aus_abs);
		$criteria->compare('aus_esp',$this->aus_esp);
		$criteria->compare('aus_airbags',$this->aus_airbags);
		$criteria->compare('aus_klimaanlage',$this->aus_klimaanlage);
		$criteria->compare('aus_hoehe',$this->aus_hoehe);
		$criteria->compare('aus_breite',$this->aus_breite);
		$criteria->compare('aus_laenge',$this->aus_laenge);
		$criteria->compare('aus_leergewicht',$this->aus_leergewicht);
		$criteria->compare('aus_zuladung',$this->aus_zuladung);
		$criteria->compare('aus_gepaeckraum',$this->aus_gepaeckraum);
		$criteria->compare('aus_tank',$this->aus_tank);
		$criteria->compare('aus_navi',$this->aus_navi);
		$criteria->compare('aus_klimaautomatik',$this->aus_klimaautomatik);
		$criteria->compare('aus_schiebedach',$this->aus_schiebedach);
		$criteria->compare('aus_tempomat',$this->aus_tempomat);
		$criteria->compare('aus_einparkhilfe',$this->aus_einparkhilfe);
		$criteria->compare('aus_lederausstattung',$this->aus_lederausstattung);
		$criteria->compare('aus_leichtmetallfelgen',$this->aus_leichtmetallfelgen);
		$criteria->compare('aus_sitzheizung',$this->aus_sitzheizung);
		$criteria->compare('aus_standheizung',$this->aus_standheizung);
		$criteria->compare('aus_xenonlicht',$this->aus_xenonlicht);
		$criteria->compare('aus_haengerkupplung',$this->aus_haengerkupplung);
		$criteria->compare('aus_listenpreis',$this->aus_listenpreis,true);
		$criteria->compare('aus_kennziffer',$this->aus_kennziffer,true);
		$criteria->compare('aus_klasse',$this->aus_klasse);
		$criteria->compare('aus_anlage',$this->aus_anlage,true);
		$criteria->compare('aus_picks',$this->aus_picks);
		$criteria->compare('aus_lastpick',$this->aus_lastpick,true);
		$criteria->compare('aus_aenderdatum',$this->aus_aenderdatum,true);
		$criteria->compare('aus_anlage_user',$this->aus_anlage_user,true);
		$criteria->compare('aus_aender_user',$this->aus_aender_user,true);
		$criteria->compare('aus_status',$this->aus_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TrimLookup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
