<?php

/**
 * This is the model class for table "methods".
 *
 * The followings are the available columns in table 'methods':
 * @property integer $id
 * @property string $code
 * @property string $description
 * @property integer $visible_working_part
 * @property integer $visible_special_working_part
 * @property integer $visible_maintenance_working_part
 * @property integer $undefined
 */
class Methods extends CExportedActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return Methods the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_workingpartsmanagement;
   }
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'methods';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('code', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('code', 'length', 'min'=>3, 'max'=>7, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('description', 'length', 'min'=>3, 'max'=>160, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('code', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
			array('visible_working_part, visible_special_working_part, visible_maintenance_working_part, undefined', 'boolean'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('code, description, visible_working_part, visible_special_working_part, visible_maintenance_working_part, undefined', 'safe', 'on'=>'search'),
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
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),
			'code'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODS_FIELD_CODE'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODS_FIELD_DESCRIPTION'),
			'visible_working_part'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODS_FIELD_VISIBLEWORKINGPART'),
			'visible_special_working_part'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODS_FIELD_VISIBLESPECIALWORKINGPART'),
			'visible_maintenance_working_part'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_METHODS_FIELD_VISIBLEMAINTENANCEWORKINGPART'),
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
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('code', $this->code, true);
		$oCriteria->compare('description', $this->description, true);
		$oCriteria->compare('visible_working_part', $this->visible_working_part);
		$oCriteria->compare('visible_special_working_part', $this->visible_special_working_part);
		$oCriteria->compare('visible_maintenance_working_part', $this->visible_maintenance_working_part);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'code ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getMethod($nId) {
      $oMethod = Methods::model()->findByPk($nId);
      
      return $oMethod;
   }
   
   public static function getMethodByCode($sCode) {
      $oMethod = Methods::model()->find('code = \'' . $sCode . '\'');
      
      return $oMethod;
   }
   
   public static function getMethods($bVisibleWorkingPart = null, $bVisibleMaintenanceWorkingPart = null, $bVisibleSpecialWorkingPart = null) {
      if ((is_null($bVisibleWorkingPart)) && (is_null($bVisibleMaintenanceWorkingPart)) && (is_null($bVisibleSpecialWorkingPart))) $sSentence = 'true ORDER BY code ASC'; 
      else $sSentence = 'ORDER BY code ASC';
      $bCondition = false;
      
      if (!is_null($bVisibleWorkingPart)) {
         if ($bVisibleWorkingPart) $sSentence = 'visible_working_part = 1 ' . $sSentence;   
         else $sSentence = 'visible_working_part = 0 ' . $sSentence;
         
         $bCondition = true;   
      }
      
      if (!is_null($bVisibleMaintenanceWorkingPart)) {
         if (!$bCondition) {
            if ($bVisibleMaintenanceWorkingPart) $sSentence = 'visible_maintenance_working_part = 1 ' . $sSentence;   
            else $sSentence = 'visible_maintenance_working_part = 0 ' . $sSentence;   
         }
         else {
            if ($bVisibleMaintenanceWorkingPart) $sSentence = 'visible_maintenance_working_part = 1 AND ' . $sSentence;   
            else $sSentence = 'visible_maintenance_working_part = 0 AND ' . $sSentence;  
         }
         
         $bCondition = true;
      }
      
      if (!is_null($bVisibleSpecialWorkingPart)) {
         if (!$bCondition) {
            if ($bVisibleSpecialWorkingPart) $sSentence = 'visible_special_working_part = 1 ' . $sSentence;   
            else $sSentence = 'visible_special_working_part = 0 ' . $sSentence;   
         }
         else {
            if ($bVisibleSpecialWorkingPart) $sSentence = 'visible_special_working_part = 1 AND ' . $sSentence;   
            else $sSentence = 'visible_special_working_part = 0 AND ' . $sSentence;  
         }
         
         $bCondition = true;
      }
       
      return Methods::model()->findAll($sSentence);      
   }
   
   public function getCbDescription() {
       return $this->code . ' - ' . FString::getAbbreviationSentence($this->description, 110);   
   }
   
   public static function getMethodName($nId) {
      $oMethod = Methods::getMethod($nId);
      if (!is_null($oMethod)) {
         return $oMethod->getCbDescription();      
      }  
      return FString::STRING_EMPTY;
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('visible_working_part', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');                                                            
      $this->oExportSpecifications['data'][1] = array('visible_special_working_part', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');                                              
      $this->oExportSpecifications['data'][2] = array('visible_maintenance_working_part', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_BIT, 'Yii::t(\'system\', \'SYS_YES\')', 'Yii::t(\'system\', \'SYS_NO\')', 'Yii::t(\'system\', \'SYS_NO\')');                                              

      $this->oExportSpecifications['columns'] = array('code', 'description', 'visible_working_part', 'visible_maintenance_working_part', 'visible_special_working_part');
                                                                           
      return $this->oExportSpecifications; 
   }
}
