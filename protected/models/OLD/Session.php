<?php

/**
 * This is the model class for table "{{session}}".
 *
 * The followings are the available columns in table '{{session}}':
 * @property string $sess_id
 * @property integer $sess_int_id
 * @property integer $sess_fab_id
 * @property integer $sess_mod_id
 * @property integer $sess_ba_id
 * @property integer $sess_aus_id
 * @property integer $sess_farb_id
 * @property integer $sess_hd_id
 * @property string $sess_datum
 * @property integer $sess_kampagne
 * @property integer $sess_suchmaschine
 * @property integer $sess_suchwort
 * @property integer $sess_alternative1
 * @property integer $sess_alternative2
 * @property integer $sess_step4
 * @property string $sess_url
 * @property integer $sess_status
 */
class Session extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{session}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sess_int_id, sess_fab_id, sess_mod_id, sess_ba_id, sess_aus_id, sess_farb_id, sess_hd_id, sess_kampagne, sess_suchmaschine, sess_suchwort, sess_alternative1, sess_alternative2, sess_step4, sess_status', 'numerical', 'integerOnly'=>true),
			array('sess_id', 'length', 'max'=>32),
			array('sess_url', 'length', 'max'=>255),
			array('sess_datum', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sess_id, sess_status ', 'safe', 'on'=>'search'),
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
			'sess_id' => 'Sess',
			'sess_int_id' => 'Sess Int',
			'sess_fab_id' => 'Sess Fab',
			'sess_mod_id' => 'Sess Mod',
			'sess_ba_id' => 'Sess Ba',
			'sess_aus_id' => 'Sess Aus',
			'sess_farb_id' => 'Sess Farb',
			'sess_hd_id' => 'Sess Hd',
			'sess_datum' => 'Sess Datum',
			'sess_kampagne' => 'Sess Kampagne',
			'sess_suchmaschine' => 'Sess Suchmaschine',
			'sess_suchwort' => 'Sess Suchwort',
			'sess_alternative1' => 'Sess Alternative1',
			'sess_alternative2' => 'Sess Alternative2',
			'sess_step4' => 'Sess Step4',
			'sess_url' => 'Sess Url',
			'sess_status' => 'Sess Status',
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

		$criteria->compare('sess_id',$this->sess_id,true);
	/*		
		$criteria->compare('sess_int_id',$this->sess_int_id);
		$criteria->compare('sess_fab_id',$this->sess_fab_id);
		$criteria->compare('sess_mod_id',$this->sess_mod_id);
		$criteria->compare('sess_ba_id',$this->sess_ba_id);
		$criteria->compare('sess_aus_id',$this->sess_aus_id);
		$criteria->compare('sess_farb_id',$this->sess_farb_id);
		$criteria->compare('sess_hd_id',$this->sess_hd_id);
		$criteria->compare('sess_datum',$this->sess_datum,true);
		$criteria->compare('sess_kampagne',$this->sess_kampagne);
		$criteria->compare('sess_suchmaschine',$this->sess_suchmaschine);
		$criteria->compare('sess_suchwort',$this->sess_suchwort);
		$criteria->compare('sess_alternative1',$this->sess_alternative1);
		$criteria->compare('sess_alternative2',$this->sess_alternative2);
		$criteria->compare('sess_step4',$this->sess_step4);
		$criteria->compare('sess_url',$this->sess_url,true); 
		
	*/
		
		$criteria->compare('sess_status',$this->sess_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Session the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
