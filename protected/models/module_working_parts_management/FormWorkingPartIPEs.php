<?php

/**
 * This is the model class for table "form_working_part_ipes".
 *
 * The followings are the available columns in table 'form_working_part_ipes':
 * @property integer $id
 * @property string $name
 * @property integer $id_form_working_part
 *
 * The followings are the available model relations:
 * @property FormsWorkingParts $idFormWorkingPart
 */
class FormWorkingPartIPEs extends CActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormWorkingPartIPEs the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_workingpartsmanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'form_working_part_ipes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_form_working_part', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('name', 'length', 'min'=>3, 'max'=>64, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('name', 'UniqueAttributesValidator', 'with'=>'id_form_working_part', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
   
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, id_form_working_part', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'form_working_part'=>array(self::BELONGS_TO, 'FormsWorkingParts', 'id_form_working_part'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),   
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMWORKINGPARTIPES_FIELD_NAME'),
			'id_form_working_part'=>Yii::t('system', 'SYS_MODEL_FIELD_FK'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($nIdFormFK = null) {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$oCriteria = new CDbCriteria;

      $oCriteria->compare('name', $this->name, true);
      if (!is_null($nIdFormFK)) $oCriteria->compare('id_form_working_part', $nIdFormFK);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getFormWorkingPartIPE($nId) {
      $oFormWorkingPartIPE = FormWorkingPartIPEs::model()->findByPk($nId);
      
      return $oFormWorkingPartIPE;
   }
   
   public static function getFormWorkingPartIPEsByIdFormFK($nIdFormFK) {
      return FormWorkingPartIPEs::model()->findAll('id_form_working_part = ' . $nIdFormFK . ' ORDER BY name ASC');   
   }
}