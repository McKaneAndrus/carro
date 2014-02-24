<?php

/**
 * This is the model class for table "make".
 *
 * The followings are the available columns in table 'make':
 * @property integer $id_make
 * @property string $name
 * @property integer $image
 * @property integer $display_new
 * @property integer $display_used
 * @property integer $position
 * @property integer $active
 * @property integer $deleted
 * @property string $update_date
 *
 * The followings are the available model relations:
 * @property Model[] $models
 *
 * This is a lookup only model for the Make
 */
class MakeLookup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	 
	public function tableName()
	{
		return 'make';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	 
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('name, update_date', 'required'),
			//array('image, display_new, display_used, position, active, deleted', 'numerical', 'integerOnly'=>true),
			//array('name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_make, name, display_new, display_used, position, active, deleted, update_date', 'safe', 'on'=>'search'),
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
			//'models' => array(self::HAS_MANY, 'Model', 'id_model_make'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_make' => 'Id Make',
			'name' => 'Name',
			'image' => 'Image',
			'display_new' => 'Display New',
			'display_used' => 'Display Used',
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

		$criteria->compare('id_make',$this->id_make);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('display_new',$this->display_new);
		$criteria->compare('display_used',$this->display_used);
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
	 * @return MakeLookup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
