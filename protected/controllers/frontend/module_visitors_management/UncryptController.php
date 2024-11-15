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
                'actions'=>array('viewNumVisits'),
                'expression'=>'Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_VISITORS_MANAGEMENT)',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    
    
    public function actionViewNumVisits($filterTypeVisit = FString::STRING_EMPTY, $filterVisitor = FString::STRING_EMPTY, $filterVisitorBusiness = FString::STRING_EMPTY, $typeStatistic = FModuleVisitorsManagement::STATISTIC_TYPE_BUSINESS, $typePeriod = FModuleVisitorsManagement::STATISTIC_TYPE_PERIOD_DAY) {
       $oStatisticVisit = new VisitorsStatisticVisits();
       $sVField = FString::STRING_EMPTY;
       $sGField = FString::STRING_EMPTY;
       $sYiit = FString::STRING_EMPTY;
       
       $oStatisticVisit->type = $filterTypeVisit;
       $oStatisticVisit->visitor_full_name = $filterVisitor;
       $oStatisticVisit->visitor_business = $filterVisitorBusiness;
       $oStatisticVisit->typePeriod = $typePeriod;
       $oStatisticVisit->typeStatistic = $typeStatistic;
       
       if ($typeStatistic == FModuleVisitorsManagement::STATISTIC_TYPE_VISIT) { $sVField = 'type'; $sGField = 'type'; $sYiit = 'MODEL_VISITORSVISITS_FIELD_TYPE_VALUE_'; }
       else if ($typeStatistic == FModuleVisitorsManagement::STATISTIC_TYPE_VISITOR) { $sVField = 'visitor_full_name'; $sGField = 'visitor_identification'; } 
       else { $sVField = 'visitor_business'; $sGField = 'visitor_business'; } 
         
       if ($typePeriod == FModuleVisitorsManagement::STATISTIC_TYPE_PERIOD_DAY) $oStatisticVisit->setStatisticNumVisitsFromMonthYear($sVField, $sGField, date('m'), date('Y'), $filterTypeVisit, $filterVisitor, $filterVisitorBusiness, $sYiit);
       else if ($typePeriod == FModuleVisitorsManagement::STATISTIC_TYPE_PERIOD_MONTH) $oStatisticVisit->setStatisticNumVisitsFromYear($sVField, $sGField, date('Y'), $filterTypeVisit, $filterVisitor, $filterVisitorBusiness, $sYiit);
       else $oStatisticVisit->setStatisticNumVisits($sVField, $sGField, date('Y') - 9, date('Y'), $filterTypeVisit, $filterVisitor, $filterVisitorBusiness, $sYiit);  
       
       $this->render('viewNumVisits', array('oModelForm'=>$oStatisticVisit));  
    }
}