<?php

/**
 * This is the model class for table "forms_work_requests".
 *
 * The followings are the available columns in table 'forms_work_requests':
 * @property integer $id
 * @property string $owner
 * @property string $priority
 * @property integer $priority_number
 * @property string $description
 * @property string $comments
 * @property string $status
 * @property string $visible_date
 * @property string $start_date
 * @property string $end_date
 * @property integer $id_user
 */
class FormsWorkRequests extends CExportedActiveRecord {
   public $sFilterStatusPending;
   public $sFilterStatusFinalized;
   public $bFilterVisibleDate;
   public $bFinalized;
      
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return FormsWorkRequests the static model class
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
		return 'forms_work_requests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id', 'numerical'),
         
         array('owner', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('priority', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('priority_number', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')), 
         array('description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('status', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('start_date', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_user', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('description', 'length', 'min'=>3, 'max'=>512, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('comments', 'length', 'min'=>3, 'max'=>512, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
                                 
         array('bFinalized', 'boolean'),
         
         array('bFinalized', 'YiiConditionalValidator',
            'if'=>array(
               array('bFinalized', 'compare', 'compareValue'=>true),
            ),
            'then'=>array(
               array('comments', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, owner, priority, priority_number, description, status, visible_date, start_date, end_date, id_user', 'safe', 'on'=>'search'),
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
			'owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_OWNER'),
			'priority'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_PRIORITY'),
			'priority_number'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_PRIORITYNUMBER'),
			'description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_DESCRIPTION'),
         'comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_COMMENTS'),
			'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_STATUS'),
         'visible_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_VISIBLEDATE'),   
			'start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_STARTDATE'),    
			'end_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_ENDDATE'),
         'bFinalized'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSWORKREQUESTS_FIELD_FINALIZED'),
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
	public function search($bFilterVisibleDate = null, $sFilterStatusPending = null, $sFilterStatusFinalized = null) {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('owner', $this->owner, true);
		$oCriteria->compare('priority', $this->priority, true);
		$oCriteria->compare('description', $this->description, true);
		$oCriteria->compare('status', $this->status, true);
		$oCriteria->compare('start_date', FDate::getEnglishDate($this->start_date), true);
		$oCriteria->compare('id_user', $this->id_user);

      if ((!is_null($this->bFilterVisibleDate)) || (!is_null($this->sFilterStatusPending)) || (!is_null($this->sFilterStatusFinalized)) || (!is_null($bFilterVisibleDate)) || (!is_null($sFilterStatusPending)) || (!is_null($sFilterStatusFinalized))) {
         $sStatusCondition = FString::STRING_EMPTY;
         if (((!is_null($this->sFilterStatusPending)) && ($this->sFilterStatusPending)) || ((!is_null($sFilterStatusPending)) && ($sFilterStatusPending))) $sStatusCondition = 'status = \'' . FModuleWorkingPartsManagement::STATUS_PENDING . '\'';
         
         if (((!is_null($this->sFilterStatusFinalized)) && ($this->sFilterStatusFinalized)) || ((!is_null($sFilterStatusFinalized)) && ($sFilterStatusFinalized))) {
            if (strlen($sStatusCondition) > 0) $sStatusCondition = '((status = \'' . FModuleWorkingPartsManagement::STATUS_PENDING . '\') OR (status = \'' . FModuleWorkingPartsManagement::STATUS_FINALIZED . '\'))'; 
            else $sStatusCondition = 'status = \'' . FModuleWorkingPartsManagement::STATUS_FINALIZED . '\'';
         }
         
         if (((!is_null($this->bFilterVisibleDate)) && ($this->bFilterVisibleDate)) || ((!is_null($bFilterVisibleDate)) && ($bFilterVisibleDate))) {
            if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' AND ((visible_date IS NULL) OR ((visible_date IS NOT NULL) AND (visible_date <= \'' . date('Y-m-d') . '\')))';
            else $sStatusCondition = '((visible_date IS NULL) OR ((visible_date IS NOT NULL) AND (visible_date <= \'' . date('Y-m-d') . '\')))';   
         }
         else if (((!is_null($this->bFilterVisibleDate)) && (!$this->bFilterVisibleDate)) || ((!is_null($bFilterVisibleDate)) && (!$bFilterVisibleDate))) {
            if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' AND ((visible_date IS NOT NULL) AND (visible_date > \'' . date('Y-m-d') . '\'))';
            else $sStatusCondition = '((visible_date IS NOT NULL) AND (visible_date > \'' . date('Y-m-d') . '\'))';   
         } 
         
         if ($sStatusCondition != FString::STRING_EMPTY) $oCriteria->addCondition($sStatusCondition);
         else $oCriteria->addCondition('false');
      }
         
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'start_date DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}

   public static function getFormWorkRequest($nId) {
      $oFormWorkRequest = FormsWorkRequests::model()->findByPk($nId);
      
      return $oFormWorkRequest;
   }
   
   public static function getFormsWorkRequests($bShowVisibleDate = null, $sStatus = null) {
      if ((is_null($sStatus)) && (is_null($bShowVisibleDate))) $sSentence = 'true ORDER BY start_date DESC';
      else $sSentence = 'ORDER BY start_date DESC';
      $bCondition = false;
      
      if (!is_null($bShowVisibleDate)) {
         if ($bShowVisibleDate) {
            $sSentence = 'visible_date IS NULL OR ((visible_date IS NOT NULL) AND (visible_date <= \'' . date('Y-m-d') . '\'))' . FString::STRING_SPACE . $sSentence;   
         }
         else {
            $sSentence = 'visible_date IS NULL OR ((visible_date IS NOT NULL) AND (visible_date > \'' . date('Y-m-d') . '\'))' . FString::STRING_SPACE . $sSentence; 
         }
         
         $bCondition = true;     
      }   
           
      if (!is_null($sStatus)) { 
         if ($bCondition) $sSentence = 'status = \'' . $sStatus . '\' AND ' . $sSentence;
         else $sSentence = 'status = \'' . $sStatus . '\'' . FString::STRING_SPACE . $sSentence;
         
         $bCondition = true;     
      }
      
      return FormsWorkRequests::model()->findAll($sSentence);            
   } 
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('visible_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('start_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][2] = array('end_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');

      $this->oExportSpecifications['columns'] = array('id', 'owner', 'description', 'priority', 'visible_date', 'start_date', 'end_date');
        
      return $this->oExportSpecifications; 
   }
}
