<?php

/**
* This is the model class for table "color".
*
* The followings are the available columns in table 'color':
* @property integer $id_color
* @property integer $id_color_trim
* @property string $name
* @property integer $image
* @property integer $position
* @property integer $active
* @property integer $deleted
* @property string $update_date
*
* The followings are the available model relations:
* @property Trim $idColorTrim
*
* This is a lookup only model for the trim colors
*/
 
class ColorLookup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public function tableName()
	{
		return 'color';
	}

	/**
	 * @return array validation rules for model attributes.
	 */

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		
		return array(
			//array('id_color_trim, name, update_date', 'required'),
			//array('id_color_trim, image, position, active, deleted', 'numerical', 'integerOnly'=>true),
			//array('name', 'length', 'max'=>100),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_color, id_color_trim, name, position, active, deleted, update_date', 'safe', 'on'=>'search'),
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
			//'idColorTrim' => array(self::BELONGS_TO, 'Trim', 'id_color_trim'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_color' => 'Id Color',
			'id_color_trim' => 'Id Color Trim',
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

		$criteria->compare('id_color',$this->id_color);
		$criteria->compare('id_color_trim',$this->id_color_trim);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array('criteria'=>$criteria, ));
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
