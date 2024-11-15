<?php

/**
 * This is the model class for table "visits_destiny_vehicle".
 *
 * The followings are the available columns in table 'visits_destiny_vehicle':
 * @property integer $id
 * @property string $name
 * @property integer $num
 */
class VisitorsDestinyVehicle extends CActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TypeDestinyVehicle the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_visitorsmanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'visitors_destiny_vehicle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('num', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, num', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>'ID',
			'name'=>'Name',
			'num'=>'Num',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('num',$this->num);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
   
   public function getCbDescription() {
      return Yii::t('frontend_' . strtolower(FApplication::MODULE_VISITORS_MANAGEMENT), 'MODEL_VISITORSDESTINYCAR_FIELD_NAME_VALUE_' . $this->name, array('{1}'=>$this->num));
   }
   
   public function getCbIndexDescription() {
      return $this->name . '_' . $this->num;   
   }
   
   public static function getVisitorsDestinyVehicle($nId) {
      $oVisitorsDestinyVehicle = VisitorsDestinyVehicle::model()->findByPk($nId);
        
      return $oVisitorsDestinyVehicle;
   }
   
   public static function getVisitorsDestiniesVehicle() {
      return VisitorsDestinyVehicle::model()->findAll(array('order'=>'name ASC, num ASC'));   
   }
}