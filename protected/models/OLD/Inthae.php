<?php

/**
 * This is the model class for table "{{inthae}}".
 *
 * The followings are the available columns in table '{{inthae}}':
 * @property integer $ih_prospect_id
 * @property integer $ih_dealer_id
 * @property integer $ih_status
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
			array('ih_prospect_id, ih_dealer_id, ih_status', 'required'),
			array('ih_prospect_id, ih_dealer_id, ih_status', 'numerical', 'integerOnly'=>true),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ih_prospect_id, ih_dealer_id, ih_status', 'safe', 'on'=>'search'),
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

			 'leadgen'=>array(self::BELONGS_TO, 'LeadGen', 'ih_prospect_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ih_prospect_id' => 'Ih Prospect',
			'ih_dealer_id' => 'Ih Dealer',
			'ih_status' => 'Ih Status',
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

		$criteria->compare('ih_prospect_id',$this->ih_prospect_id);
		$criteria->compare('ih_dealer_id',$this->ih_dealer_id);
		$criteria->compare('ih_status',$this->ih_status);

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
