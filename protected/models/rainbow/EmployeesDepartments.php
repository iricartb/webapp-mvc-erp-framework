<?php

/**
 * This is the model class for table "employees_departments".
 *
 * The followings are the available columns in table 'employees_departments':
 * @property integer $id
 * @property string $employee_identification
 * @property string $responsability
 * @property string $department
 * @property integer $main
 *
 * The followings are the available model relations:
 * @property Employees $employeeIdentification
 */
class EmployeesDepartments extends CActiveRecord {
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmployeesDepartments the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'employees_departments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_identification, department', 'required'),
			array('employee_identification', 'length', 'max'=>12),
			array('responsability', 'length', 'max'=>20),
			array('department', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, employee_identification, responsability, department', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'employeeIdentification' => array(self::BELONGS_TO, 'Employees', 'employee_identification'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'employee_identification' => 'Employee Identification',
			'responsability' => 'Responsability',
			'department' => 'Department',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('employee_identification', $this->employee_identification, true);
		$oCriteria->compare('responsability', $this->responsability, true);
		$oCriteria->compare('department', $this->department, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
   
   public static function getEmployeesDepartmentsByEmployeeIdentification($sEmployeeIdentification) {
      $oEmployeeDepartments = EmployeesDepartments::model()->findAll('employee_identification = \'' . $sEmployeeIdentification . '\'');
      
      return $oEmployeeDepartments;   
   }
   
   public static function getEmployeeMainDepartmentByEmployeeIdentification($sEmployeeIdentification) {
      $oEmployeeDepartment = EmployeesDepartments::model()->find('employee_identification = \'' . $sEmployeeIdentification . '\' AND main = 1');
      
      return $oEmployeeDepartment;   
   }
   
   public static function getEmployeesDepartmentsByDepartament($sResponsability, $sDepartment, $bStrict = false) {
      if (!FString::isNullOrEmpty($sResponsability)) {
         return EmployeesDepartments::model()->findAll('responsability = \'' . $sResponsability . '\' AND department = \'' . $sDepartment . '\'');         
      }
      else {
         if (!$bStrict) return EmployeesDepartments::model()->findAll('department = \'' . $sDepartment . '\'');   
         else return EmployeesDepartments::model()->findAll('responsability IS NULL AND department = \'' . $sDepartment . '\'');          
      }
   }
   
   public static function getEmployeeDepartmentConsumptionByYear($sDepartment, $nYear, $bComputeContractingProcedures = false) {
      $nConsumption = 0;
      
      $oPurchasesFormsPurchaseOrders = PurchasesFormsPurchaseOrders::getPurchasesFormsPurchaseOrders(null, null, $nYear, null, null, $sDepartment);
      foreach($oPurchasesFormsPurchaseOrders as $oPurchasesFormPurchaseOrder) {
         $oPurchasesFormRequestOffer = PurchasesFormsRequestOffers::getPurchasesFormRequestOffer($oPurchasesFormPurchaseOrder->id_form_request_offer);
         
         if (($bComputeContractingProcedures) || ((!$bComputeContractingProcedures) && (!is_null($oPurchasesFormRequestOffer)) && (!$oPurchasesFormRequestOffer->contracting_procedure))) {
            $nConsumption += PurchasesFormsPurchaseOrders::getPurchasesFormPurchaseOrderConsumption($oPurchasesFormPurchaseOrder->id);
         }
      }
        
      return $nConsumption;
   }
}