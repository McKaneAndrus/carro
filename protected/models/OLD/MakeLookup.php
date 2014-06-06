<?php

/**
 * This is the model class for table "fabrikate".
 *
 * The followings are the available columns in table 'fabrikate':
 * @property integer $fab_id 
 * @property string $fab_bez
 * @property integer $fab_picks
 * @property string $fab_lastpick
 * @property integer $fab_prioritaet
 * @property string $fab_anlage
 * @property string $fab_anlage_user
 * @property string $fab_aenderung
 * @property string $fab_aender_user
 * @property integer $fab_status
 * 
 * German to English Mapping 
 *
 * fab_id => make id
 * fab_bez => description
 * fab_picks => number of clicks
 * fab_lastpick => date of last click
 * fab_prioritaet => priority
 * fab_anlage => creation date
 * fab_anlage_user => creation user
 * fab_aenderung => update date
 * fab_aender_user => update user
 * fab_status => status (1 = record is locked)
 */
 
class MakeLookup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{fabrikate}}'; 	// this should use the table prefix from the config.php
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fab_picks, fab_prioritaet, fab_status', 'numerical', 'integerOnly'=>true),
			array('fab_bez', 'length', 'max'=>30),
			array('fab_anlage_user, fab_aender_user', 'length', 'max'=>12),
			array('fab_lastpick, fab_anlage, fab_aenderung', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fab_id, fab_bez, fab_picks, fab_lastpick, fab_prioritaet, fab_anlage, fab_anlage_user, fab_aenderung, fab_aender_user, fab_status', 'safe', 'on'=>'search'),
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
			'fab_id' => 'Fab',
			'fab_bez' => 'Fab Bez',
			'fab_picks' => 'Fab Picks',
			'fab_lastpick' => 'Fab Lastpick',
			'fab_prioritaet' => 'Fab Prioritaet',
			'fab_anlage' => 'Fab Anlage',
			'fab_anlage_user' => 'Fab Anlage User',
			'fab_aenderung' => 'Fab Aenderung',
			'fab_aender_user' => 'Fab Aender User',
			'fab_status' => 'Fab Status',
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

		$criteria->compare('fab_id',$this->fab_id);
		$criteria->compare('fab_bez',$this->fab_bez,true);
		$criteria->compare('fab_picks',$this->fab_picks);
		$criteria->compare('fab_lastpick',$this->fab_lastpick,true);
		$criteria->compare('fab_prioritaet',$this->fab_prioritaet);
		$criteria->compare('fab_anlage',$this->fab_anlage,true);
		$criteria->compare('fab_anlage_user',$this->fab_anlage_user,true);
		$criteria->compare('fab_aenderung',$this->fab_aenderung,true);
		$criteria->compare('fab_aender_user',$this->fab_aender_user,true);
		$criteria->compare('fab_status',$this->fab_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MakeLookup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
