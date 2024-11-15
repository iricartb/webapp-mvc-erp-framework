<?php Yii::import('application.extensions.UniqueAttributesValidator.UniqueAttributesValidator'); ?>
<?php Yii::import('application.extensions.YiiConditionalValidator.YiiConditionalValidator'); ?>
<?php Yii::import('application.extensions.Fancybox.EFancyBox'); ?>
<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker'); ?>
<?php Yii::import('application.extensions.Highcharts.HighchartsWidget'); ?>
<?php Yii::import('application.extensions.EExcelView.EExcelView'); ?>
<?php Yii::import('application.extensions.SColorPicker.SActiveColorPicker'); ?>

<?php Yii::import('application.components.PHPExcel.PHPExcel', true); ?>
<?php Yii::import('application.components.KloveraCalendar.KloveraCalendar', true); ?>
<?php Yii::import('application.components.PHPImageMagician.PHPImageMagician', true); ?>

<?php
require_once('protected/components/PHPMailer/class.smtp.php');
require_once('protected/components/PHPMailer/class.phpmailer.php');
require_once('protected/components/Mpdf/mpdf.php');
require_once('protected/components/ZipFile/zipfile.inc.php'); 
require_once('protected/functions/FAjax.class.php');
require_once('protected/functions/FApplication.class.php'); 
require_once('protected/functions/FArrayOrder.class.php');
require_once('protected/functions/FDate.class.php');
require_once('protected/functions/FDocument.class.php');
require_once('protected/functions/FExcelDocument.class.php');
require_once('protected/functions/FFile.class.php');
require_once('protected/functions/FFlash.class.php');
require_once('protected/functions/FForm.class.php');
require_once('protected/functions/FFormat.class.php');
require_once('protected/functions/FGrid.class.php');
require_once('protected/functions/FMail.class.php');
require_once('protected/functions/FModuleAccessControlManagement.class.php');
require_once('protected/functions/FModuleDigitalDiaryManagement.class.php');
require_once('protected/functions/FModulePlantMaintenanceManagement.class.php');
require_once('protected/functions/FModuleVisitorsManagement.class.php');
require_once('protected/functions/FModuleWorkingPartsManagement.class.php');
require_once('protected/functions/FModuleWarehouseManagement.class.php');
require_once('protected/functions/FModulePlantMonitoringManagement.class.php');
require_once('protected/functions/FModulePurchasesManagement.class.php');
require_once('protected/functions/FPOP3.class.php');
require_once('protected/functions/FRegEx.class.php');
require_once('protected/functions/FReportExcel.class.php');
require_once('protected/functions/FString.class.php');
require_once('protected/functions/FUrl.class.php');
require_once('protected/functions/FWidget.class.php');
require_once('protected/functions/FWidgetCalendar.class.php');
require_once('protected/functions/FZipDocument.class.php');
require_once('protected/functions/FSocket.class.php');

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/site',
	 * meaning using a single column layout. See 'protected/views/layouts/site.php'.
	 */
	public $layout='//layouts/site';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();
   
   /* Personalized vars */
   public $sJsOnLoad = null;
   public $sJsOnBeforeCss = null;
   public $sLoginUserName = FString::STRING_EMPTY; 
   
   public function init() {
      date_default_timezone_set(Yii::app()->params['timeZone']);

      if (Yii::app()->user->isGuest) {
          $oApplication = Application::getApplication();
          if (!is_null($oApplication)) Yii::app()->setLanguage($oApplication->language);   
      }
      else {         
          $oEmployee = Users::getEmployeeByIdUser(Yii::app()->user->id);
          if (!is_null($oEmployee)) $this->sLoginUserName = $oEmployee->full_name;
                 
          $oUser = Users::getUser(Yii::app()->user->id);
          if (!is_null($oUser)) {
             if (is_null($oEmployee)) $this->sLoginUserName = $oUser->full_name;  
             
             Yii::app()->setLanguage($oUser->language);
           
             // Check if user have a valid default application
             if (!Users::getIsValidDefApplication(Yii::app()->user->id)) {
                $sAvaliableModuleName = Users::getFirstAvaliableModuleForUser(Yii::app()->user->id);
                if (!is_null($sAvaliableModuleName)) {
                   $oUser->def_application = $sAvaliableModuleName;
                   $oUser->save();
                }
             }
          }   
      }
      
      parent::init(); 
   }
}