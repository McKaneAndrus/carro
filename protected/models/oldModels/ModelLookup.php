<?php

/**
 * This is the model class for table "model".
 *
 * The followings are the available columns in table 'model':
 * @property integer $id_model
 * @property integer $id_model_make
 * @property string $name
 * @property integer $image
 * @property integer $display_new
 * @property integer $display_old
 * @property integer $position
 * @property integer $active
 * @property integer $deleted
 * @property string $update_date
 *
 * The followings are the available model relations:
 * @property Make $idModelMake
 * @property Trim[] $trims
 */
 
class ModelLookup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	 
	public function tableName()
	{
		return 'model';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	 
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id_model_make, name, update_date', 'required'),
			//array('id_model_make, image, display_new, display_old, position, active, deleted', 'numerical', 'integerOnly'=>true),
			//array('name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_model, id_model_make, name, image, display_new, display_old, position, active, deleted, update_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	 
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		// sjg - May not be needed for the readonly lookup 
		
		return array(
			//'idModelMake' => array(self::BELONGS_TO, 'Make', 'id_model_make'),
			//'trims' => array(self::HAS_MANY, 'Trim', 'id_trim_model'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_model' => 'Id Model',
			'id_model_make' => 'Id Model Make',
			'name' => 'Name',
			'image' => 'Image',
			'display_new' => 'Display New',
			'display_old' => 'Display Old',
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

		$criteria->compare('id_model',$this->id_model);
		$criteria->compare('id_model_make',$this->id_model_make);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('display_new',$this->display_new);
		$criteria->compare('display_old',$this->display_old);
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
	 * @return ModelLookup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
