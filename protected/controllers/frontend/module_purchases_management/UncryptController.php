<?php

class UncryptController extends FrontendController {
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(    
            array('allow', // allow authenticated user and have valid module roles to perform actions
                'actions'=>array('viewOrdersDepartments', 'viewOrdersProviders', 'viewOrdersFinancialCosts'),
                'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_PURCHASES_MANAGEMENT)',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),                                                       
            ),
        );
    }
    
    
    public function actionViewOrdersDepartments() {
       $oPurchasesStatisticOrdersDepartmentsForm = new PurchasesStatisticOrdersDepartmentsForm();
       
       if (isset($_POST['PurchasesStatisticOrdersDepartmentsForm']['nYear'])) $oPurchasesStatisticOrdersDepartmentsForm->nYear = $_POST['PurchasesStatisticOrdersDepartmentsForm']['nYear'];
       else $oPurchasesStatisticOrdersDepartmentsForm->nYear = date('Y');
       
       if (isset($_POST['PurchasesStatisticOrdersDepartmentsForm']['sTypeHighchart'])) $oPurchasesStatisticOrdersDepartmentsForm->sTypeHighchart = $_POST['PurchasesStatisticOrdersDepartmentsForm']['sTypeHighchart'];
       else $oPurchasesStatisticOrdersDepartmentsForm->sTypeHighchart = FApplication::TYPE_HIGHCHART_GRAPHIC_CAKE; 
       
       $oPurchasesFormsPurchaseOrders = PurchasesFormsPurchaseOrders::getPurchasesFormsPurchaseOrders(null, null, $oPurchasesStatisticOrdersDepartmentsForm->nYear, null, null, null, null, null, null, 't.department', 't.department ASC');
       
       $this->render('viewOrdersDepartments', array('oModelForm'=>$oPurchasesFormsPurchaseOrders, 'oModelFormFilters'=>$oPurchasesStatisticOrdersDepartmentsForm));  
    }
    public function actionViewOrdersProviders() {
       $oPurchasesStatisticOrdersProvidersForm = new PurchasesStatisticOrdersProvidersForm();
       
       if (isset($_POST['PurchasesStatisticOrdersProvidersForm']['nYear'])) $oPurchasesStatisticOrdersProvidersForm->nYear = $_POST['PurchasesStatisticOrdersProvidersForm']['nYear'];
       else $oPurchasesStatisticOrdersProvidersForm->nYear = date('Y');
       
       if (isset($_POST['PurchasesStatisticOrdersProvidersForm']['sTypeHighchart'])) $oPurchasesStatisticOrdersProvidersForm->sTypeHighchart = $_POST['PurchasesStatisticOrdersProvidersForm']['sTypeHighchart'];
       else $oPurchasesStatisticOrdersProvidersForm->sTypeHighchart = FApplication::TYPE_HIGHCHART_GRAPHIC_BARS; 
       
       $oPurchasesFormsPurchaseOrders = PurchasesFormsPurchaseOrders::getPurchasesFormsPurchaseOrders(null, null, $oPurchasesStatisticOrdersProvidersForm->nYear, null, null, null, null, null, null, 'id_provider', 'provider.name ASC');
       
       $this->render('viewOrdersProviders', array('oModelForm'=>$oPurchasesFormsPurchaseOrders, 'oModelFormFilters'=>$oPurchasesStatisticOrdersProvidersForm));  
    }
    public function actionViewOrdersFinancialCosts() {
       $oPurchasesStatisticOrdersFinancialCostsForm = new PurchasesStatisticOrdersFinancialCostsForm();
       
       if (isset($_POST['PurchasesStatisticOrdersFinancialCostsForm']['nYear'])) $oPurchasesStatisticOrdersFinancialCostsForm->nYear = $_POST['PurchasesStatisticOrdersFinancialCostsForm']['nYear'];
       else $oPurchasesStatisticOrdersFinancialCostsForm->nYear = date('Y');
       
       if (isset($_POST['PurchasesStatisticOrdersFinancialCostsForm']['sTypeHighchart'])) $oPurchasesStatisticOrdersFinancialCostsForm->sTypeHighchart = $_POST['PurchasesStatisticOrdersFinancialCostsForm']['sTypeHighchart'];
       else $oPurchasesStatisticOrdersFinancialCostsForm->sTypeHighchart = FApplication::TYPE_HIGHCHART_GRAPHIC_CAKE; 
       
       $oPurchasesFormsPurchaseOrders = PurchasesFormsPurchaseOrders::getPurchasesFormsPurchaseOrders(null, null, $oPurchasesStatisticOrdersFinancialCostsForm->nYear, null, null, null, null, null, null, 't.id_financial_cost_line', 'financial_cost_line.group ASC, financial_cost_line.concept ASC');
       
       $this->render('viewOrdersFinancialCosts', array('oModelForm'=>$oPurchasesFormsPurchaseOrders, 'oModelFormFilters'=>$oPurchasesStatisticOrdersFinancialCostsForm)); 
    }
}