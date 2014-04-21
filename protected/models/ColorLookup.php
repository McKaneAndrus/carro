<?php

/**
 * This is the model class for table "{{farben}}".
 *
 * The followings are the available columns in table '{{farben}}':
 * @property integer $farb_id
 * @property integer $farb_fabrikat
 * @property integer $farb_modell
 * @property string $farb_nr
 * @property string $farb_bez
 * @property integer $farb_picks
 * @property string $farb_lastpick
 * @property string $farb_anlage
 * @property string $farb_anlage_user
 * @property string $farb_aenderung
 * @property string $farb_aender_user
 * @property integer $farb_status
 */
class ColorLookup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{farben}}';	// using table prefix from main.php
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('farb_fabrikat, farb_modell, farb_picks, farb_status', 'numerical', 'integerOnly'=>true),
			array('farb_nr', 'length', 'max'=>20),
			array('farb_bez', 'length', 'max'=>30),
			array('farb_anlage_user, farb_aender_user', 'length', 'max'=>12),
			array('farb_lastpick, farb_anlage, farb_aenderung', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('farb_id, farb_fabrikat, farb_modell, farb_nr, farb_bez, farb_picks, farb_lastpick, farb_anlage, farb_anlage_user, farb_aenderung, farb_aender_user, farb_status', 'safe', 'on'=>'search'),
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
			'farb_id' => 'Farb',
			'farb_fabrikat' => 'Farb Fabrikat',
			'farb_modell' => 'Farb Modell',
			'farb_nr' => 'Farb Nr',
			'farb_bez' => 'Farb Bez',
			'farb_picks' => 'Farb Picks',
			'farb_lastpick' => 'Farb Lastpick',
			'farb_anlage' => 'Farb Anlage',
			'farb_anlage_user' => 'Farb Anlage User',
			'farb_aenderung' => 'Farb Aenderung',
			'farb_aender_user' => 'Farb Aender User',
			'farb_status' => 'Farb Status',
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

		$criteria->compare('farb_id',$this->farb_id);
		$criteria->compare('farb_fabrikat',$this->farb_fabrikat);
		$criteria->compare('farb_modell',$this->farb_modell);
		$criteria->compare('farb_nr',$this->farb_nr,true);
		$criteria->compare('farb_bez',$this->farb_bez,true);
		$criteria->compare('farb_picks',$this->farb_picks);
		$criteria->compare('farb_lastpick',$this->farb_lastpick,true);
		$criteria->compare('farb_anlage',$this->farb_anlage,true);
		$criteria->compare('farb_anlage_user',$this->farb_anlage_user,true);
		$criteria->compare('farb_aenderung',$this->farb_aenderung,true);
		$criteria->compare('farb_aender_user',$this->farb_aender_user,true);
		$criteria->compare('farb_status',$this->farb_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ColorLookup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
