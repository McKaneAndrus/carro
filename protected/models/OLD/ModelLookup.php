<?php

/**
 * This is the model class for table "{{modelle}}".
 *
 * The followings are the available columns in table '{{modelle}}':
 * @property integer $mod_id
 * @property string $mod_bez
 * @property integer $mod_fabrikat
 * @property string $mod_path
 * @property integer $mod_bauart
 * @property string $mod_text
 * @property integer $mod_picks
 * @property string $mod_lastpick
 * @property string $mod_foto
 * @property string $mod_listenpreis
 * @property string $mod_anlage
 * @property string $mod_anlage_user
 * @property string $mod_aenderung
 * @property string $mod_aender_user
 * @property integer $mod_status
 */
class ModelLookup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{modelle}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mod_path', 'required'),
			array('mod_fabrikat, mod_bauart, mod_picks, mod_status', 'numerical', 'integerOnly'=>true),
			array('mod_bez, mod_path', 'length', 'max'=>40),
			array('mod_text', 'length', 'max'=>60),
			array('mod_foto', 'length', 'max'=>64),
			array('mod_listenpreis', 'length', 'max'=>11),
			array('mod_anlage_user, mod_aender_user', 'length', 'max'=>12),
			array('mod_lastpick, mod_anlage, mod_aenderung', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mod_id, mod_bez, mod_fabrikat, mod_path, mod_bauart, mod_text, mod_picks, mod_lastpick, mod_foto, mod_listenpreis, mod_anlage, mod_anlage_user, mod_aenderung, mod_aender_user, mod_status', 'safe', 'on'=>'search'),
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
			'mod_id' => 'Mod',
			'mod_bez' => 'Mod Bez',
			'mod_fabrikat' => 'Mod Fabrikat',
			'mod_path' => 'Mod Path',
			'mod_bauart' => 'Mod Bauart',
			'mod_text' => 'Mod Text',
			'mod_picks' => 'Mod Picks',
			'mod_lastpick' => 'Mod Lastpick',
			'mod_foto' => 'Mod Foto',
			'mod_listenpreis' => 'Mod Listenpreis',
			'mod_anlage' => 'Mod Anlage',
			'mod_anlage_user' => 'Mod Anlage User',
			'mod_aenderung' => 'Mod Aenderung',
			'mod_aender_user' => 'Mod Aender User',
			'mod_status' => 'Mod Status',
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

		$criteria->compare('mod_id',$this->mod_id);
		$criteria->compare('mod_bez',$this->mod_bez,true);
		$criteria->compare('mod_fabrikat',$this->mod_fabrikat);
		$criteria->compare('mod_path',$this->mod_path,true);
		$criteria->compare('mod_bauart',$this->mod_bauart);
		$criteria->compare('mod_text',$this->mod_text,true);
		$criteria->compare('mod_picks',$this->mod_picks);
		$criteria->compare('mod_lastpick',$this->mod_lastpick,true);
		$criteria->compare('mod_foto',$this->mod_foto,true);
		$criteria->compare('mod_listenpreis',$this->mod_listenpreis,true);
		$criteria->compare('mod_anlage',$this->mod_anlage,true);
		$criteria->compare('mod_anlage_user',$this->mod_anlage_user,true);
		$criteria->compare('mod_aenderung',$this->mod_aenderung,true);
		$criteria->compare('mod_aender_user',$this->mod_aender_user,true);
		$criteria->compare('mod_status',$this->mod_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModelLookup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
