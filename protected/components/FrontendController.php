<?php

/**
 * FrontendController is the customized controller class.
 * All frontend controller classes for this application should extend from this base class.
 */
class FrontendController extends Controller {
   public $layout = FApplication::LAYOUT_FRONTEND;
   public $bShowSubgroupActions = true;
   
   /**
    * @return array action filters
    */
   public function filters() {
      return array('accessControl', 'postOnly + delete');
   }
}