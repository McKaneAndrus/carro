<?php

/**
 * This is the model class for table "{{modellfarben}}".
 *
 * The followings are the available columns in table '{{modellfarben}}':
 * @property integer $mf_fabrikat
 * @property integer $mf_modell
 * @property string $mf_trim
 * @property integer $mf_farbe
 * @property integer $mf_schalter
 * @property integer $mf_status
 */
class TrimToColor extends CActiveRecord
{
	
	public $color;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{modellfarben}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mf_fabrikat, mf_modell, mf_farbe, mf_schalter, mf_status', 'numerical', 'integerOnly'=>true),
			array('mf_trim', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mf_fabrikat, mf_modell, mf_trim, mf_farbe, mf_schalter, mf_status', 'safe', 'on'=>'search'),
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
		
				
		//'color'=>array(self::BELONGS_TO, 'ColorLookup', 'color_id'),
		
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mf_fabrikat' => 'Mf Fabrikat',
			'mf_modell' => 'Mf Modell',
			'mf_trim' => 'Mf Trim',
			'mf_farbe' => 'Mf Farbe',
			'mf_schalter' => 'Mf Schalter',
			'mf_status' => 'Mf Status',
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

		$criteria->compare('mf_fabrikat',$this->mf_fabrikat);
		$criteria->compare('mf_modell',$this->mf_modell);
		$criteria->compare('mf_trim',$this->mf_trim,true);
		$criteria->compare('mf_farbe',$this->mf_farbe);
		$criteria->compare('mf_schalter',$this->mf_schalter);
		$criteria->compare('mf_status',$this->mf_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TrimToColor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
