<?php

/**
 * This is the model class for table "{{inthae}}".
 *
 * The followings are the available columns in table '{{inthae}}':
 * @property integer $inthae_id
 * @property integer $inthae_interessenten
 * @property integer $inthae_haendler
 * @property string $inthae_created
 */
class Inthae extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{inthae}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inthae_interessenten, inthae_haendler, inthae_created', 'required'),
			array('inthae_interessenten, inthae_haendler', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('inthae_id, inthae_interessenten, inthae_haendler, inthae_created', 'safe', 'on'=>'search'),
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
							// variable => Relationship, Class name, foriegn_key
			 'leadgen'=>array(self::BELONGS_TO, 'LeadGen', 'inthae_interessenten'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'inthae_id' => 'Inthae',
			'inthae_interessenten' => 'Inthae Interessenten',
			'inthae_haendler' => 'Inthae Haendler',
			'inthae_created' => 'Inthae Created',
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

		$criteria->compare('inthae_id',$this->inthae_id);
		$criteria->compare('inthae_interessenten',$this->inthae_interessenten);
		$criteria->compare('inthae_haendler',$this->inthae_haendler);
		$criteria->compare('inthae_created',$this->inthae_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inthae the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
