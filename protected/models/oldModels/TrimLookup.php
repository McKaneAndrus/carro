<?php

/**
 * This is the model class for table "trim".
 *
 * The followings are the available columns in table 'trim':
 * @property integer $id_trim
 * @property integer $id_trim_model
 * @property string $name
 * @property integer $image
 * @property integer $position
 * @property integer $active
 * @property integer $deleted
 * @property string $update_date
 *
 * The followings are the available model relations:
 * @property Color[] $colors
 * @property Model $idTrimModel
 */
class TrimLookup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'trim';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_trim_model, name, update_date', 'required'),
			array('id_trim_model, image, position, active, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_trim, id_trim_model, name, image, position, active, deleted, update_date', 'safe', 'on'=>'search'),
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
			//'colors' => array(self::HAS_MANY, 'Color', 'id_color_trim'),
			//'idTrimModel' => array(self::BELONGS_TO, 'Model', 'id_trim_model'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_trim' => 'Id Trim',
			'id_trim_model' => 'Id Trim Model',
			'name' => 'Name',
			'image' => 'Image',
			'position' => 'Position',
			'active' => 'Active',
			'deleted' => 'Deleted',
			'update_date' => 'Update Date',
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

		$criteria->compare('id_trim',$this->id_trim);
		$criteria->compare('id_trim_model',$this->id_trim_model);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('active',$this->active);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('update_date',$this->update_date,true);

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
