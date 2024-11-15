<?php

class ManageController extends FrontendController {
    
   /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
   public function accessRules() {
       return array( 
           array('allow', // allow admin user to perform actions
               'actions'=>array('viewArticlesCategories', 'viewArticlesLocationsCategories', 'viewArticles', 'viewProviders', 'viewArticleBarcode', 'viewDetailArticleCategory', 'viewDetailArticleSubcategory', 'viewDetailArticleLocationCategory', 'viewDetailArticleLocationSubcategory', 'viewDetailArticle', 'viewDetailArticleProvider', 'viewDetailProvider', 'updateArticleCategory', 'updateArticleSubcategory', 'updateArticleLocationCategory', 'updateArticleLocationSubcategory', 'updateArticle', 'updateArticleProvider', 'updateProvider', 'deleteArticleCategory', 'deleteArticleLocationCategory', 'deleteArticleSubcategory', 'deleteArticleLocationSubcategory', 'deleteArticle', 'deleteArticleProvider', 'deleteProvider'),
               'expression'=>'((Users::getIsAvaliableModuleForUser(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) && (Users::getIsModuleAdmin(Yii::app()->user->id, FApplication::MODULE_WAREHOUSE_MANAGEMENT)))',
           ),
           array('deny',  // deny all users                                
               'users'=>array('*'),
           ),
       );
   }
   
                                
   public function actionViewArticlesCategories() {
      $oWarehouseArticleCategory = new WarehouseArticlesCategories();
      $oWarehouseArticleSubcategory = new WarehouseArticlesSubcategories();
      $oWarehouseArticleCategoryFilters = new WarehouseArticlesCategories();
      $oWarehouseArticleCategoryFilters->unsetAttributes();
      $oWarehouseArticleSubcategoryFilters = new WarehouseArticlesSubcategories();
      $oWarehouseArticleSubcategoryFilters->unsetAttributes();
       
      if (isset($_POST['WarehouseArticlesCategories'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('warehouse-article-category-form', $oWarehouseArticleCategory);
       
         $oWarehouseArticleCategory->attributes = $_POST['WarehouseArticlesCategories'];
         $oWarehouseArticleCategory->save();
      }
      else {    
         if (isset($_POST['WarehouseArticlesSubcategories'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('warehouse-article-subcategory-form', $oWarehouseArticleSubcategory);
             
            $oWarehouseArticleSubcategory->attributes = $_POST['WarehouseArticlesSubcategories'];
             
            $oWarehouseArticleSubcategory->save();
         }
         else {
            // Filters Grid Get Parameters
            if (isset($_GET['WarehouseArticlesCategories'])) $oWarehouseArticleCategoryFilters->attributes = $_GET['WarehouseArticlesCategories'];
               
            // Filters Grid Get Parameters
            if (isset($_GET['WarehouseArticlesSubcategories'])) $oWarehouseArticleSubcategoryFilters->attributes = $_GET['WarehouseArticlesSubcategories'];   
         }   
      }

      $oWarehouseArticleCategory->unsetAttributes();
      $oWarehouseArticleSubcategory->unsetAttributes();
      $this->render('viewArticlesCategories', array('oModelForm'=>$oWarehouseArticleCategory, 'oModelFormFilters'=>$oWarehouseArticleCategoryFilters, 'oModelFormAssociation'=>$oWarehouseArticleSubcategory, 'oModelFormAssociationFilters'=>$oWarehouseArticleSubcategoryFilters)); 
   }
   public function actionViewArticlesLocationsCategories() {
      $oWarehouseArticleLocationCategory = new WarehouseArticlesLocationsCategories();
      $oWarehouseArticleLocationSubcategory = new WarehouseArticlesLocationsSubcategories();
      $oWarehouseArticleLocationCategoryFilters = new WarehouseArticlesLocationsCategories();
      $oWarehouseArticleLocationCategoryFilters->unsetAttributes();
      $oWarehouseArticleLocationSubcategoryFilters = new WarehouseArticlesLocationsSubcategories();
      $oWarehouseArticleLocationSubcategoryFilters->unsetAttributes();
       
      if (isset($_POST['WarehouseArticlesLocationsCategories'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('warehouse-article-location-category-form', $oWarehouseArticleLocationCategory);
       
         $oWarehouseArticleLocationCategory->attributes = $_POST['WarehouseArticlesLocationsCategories'];
         $oWarehouseArticleLocationCategory->save();
      }
      else {    
         if (isset($_POST['WarehouseArticlesLocationsSubcategories'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('warehouse-article-location-subcategory-form', $oWarehouseArticleLocationSubcategory);
             
            $oWarehouseArticleLocationSubcategory->attributes = $_POST['WarehouseArticlesLocationsSubcategories'];
             
            $oWarehouseArticleLocationSubcategory->save();
         }
         else {
            // Filters Grid Get Parameters
            if (isset($_GET['WarehouseArticlesLocationsCategories'])) $oWarehouseArticleLocationCategoryFilters->attributes = $_GET['WarehouseArticlesLocationsCategories'];
               
            // Filters Grid Get Parameters
            if (isset($_GET['WarehouseArticlesLocationsSubcategories'])) $oWarehouseArticleLocationSubcategoryFilters->attributes = $_GET['WarehouseArticlesLocationsSubcategories'];   
         }   
      }

      $oWarehouseArticleLocationCategory->unsetAttributes();
      $oWarehouseArticleLocationSubcategory->unsetAttributes();
      $this->render('viewArticlesLocationsCategories', array('oModelForm'=>$oWarehouseArticleLocationCategory, 'oModelFormFilters'=>$oWarehouseArticleLocationCategoryFilters, 'oModelFormAssociation'=>$oWarehouseArticleLocationSubcategory, 'oModelFormAssociationFilters'=>$oWarehouseArticleLocationSubcategoryFilters)); 
   }
   public function actionViewArticles() {
      $oApplication = Application::getApplication();
      $oArticle = new Articles();
      $oArticleFilters = new Articles();
      $oArticleFilters->unsetAttributes();
      
      if (!is_null($oApplication)) { 
         if (isset($_POST['Articles'])) {
            // Ajax validation request=>Unique validator
            FForm::validateAjaxForm('article-form', $oArticle);
         
            $oArticle->attributes = $_POST['Articles'];
            
            if ((isset($_POST['Articles']['description'])) && (!FString::isNullOrEmpty($_POST['Articles']['description']))) $oArticle->description = $_POST['Articles']['description'];
            if (isset($_POST['Articles']['id_related_article'])) $oArticle->id_related_article = $_POST['Articles']['id_related_article'];
            if (isset($_POST['Articles']['id_equivalent_article'])) $oArticle->id_equivalent_article = $_POST['Articles']['id_equivalent_article'];
            
            $oFile = CUploadedFile::getInstanceByName('Articles[image]');
            if ($oFile) {
               $sOriginalFilename = sha1_file($oFile->tempName);
               $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
               $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                  
               if (FFile::isCommonImageFromFileType($oFile->extensionName)) {  
                  $sPath = FApplication::FOLDER_IMAGES_MODULE_WAREHOUSE_ARTICLES;
                  $sOriginalFileUrl = $sPath . $sOriginalFile;
                           
                  if ($oFile->saveAs($sOriginalFileUrl)) {
                     $oArticle->image = $sOriginalFile;
                  }  
               }
            }
                  
            if ($oArticle->save()) {
               // Generate automatic barcode
               $oArticle->code_barcode = $oApplication->business_nif . '-' . str_pad($oArticle->id, 5, '0', STR_PAD_LEFT);   
               
               $oArticle->save();  
            }
         }
         else {    
            // Filters Grid Get Parameters
            if (isset($_GET['Articles'])) { 
               $oArticleFilters->attributes = $_GET['Articles'];
               
               $oArticleFilters->id = $_GET['Articles']['id'];
            } 
         }

         $oArticle->unsetAttributes();
         $oArticle->quantity_min = 0;
         $oArticle->weight = 0;
         $oArticle->volume = 0;
         
         $this->render('viewArticles', array('oModelForm'=>$oArticle, 'oModelFormFilters'=>$oArticleFilters));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));         
   }
   public function actionViewProviders() {
      $oProvider = new Providers();
      $oProviderFilters = new Providers();
      $oProviderFilters->unsetAttributes();
      
      if (isset($_POST['Providers'])) {
         // Ajax validation request=>Unique validator
         FForm::validateAjaxForm('provider-form', $oProvider);
      
         $oProvider->attributes = $_POST['Providers'];
         $oProvider->module = FApplication::MODULE_WAREHOUSE_MANAGEMENT;
         
         $oProvider->save();
      }
      else {    
         // Filters Grid Get Parameters
         if (isset($_GET['Providers'])) $oProviderFilters->attributes = $_GET['Providers'];   
      }

      $oProvider->unsetAttributes();
      $this->render('viewProviders', array('oModelForm'=>$oProvider, 'oModelFormFilters'=>$oProviderFilters));    
   }
   public function actionViewArticleBarcode($nIdForm) {
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/main/viewArticleBarcode', array('nIdForm'=>$nIdForm)));        
   }
   
   
   public function actionViewDetailArticleCategory($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oWarehouseArticleCategory = WarehouseArticlesCategories::getWarehouseArticleCategory($nIdForm);
       
      if (!is_null($oWarehouseArticleCategory)) $this->render('viewDetailArticleCategory', array('oModelForm'=>$oWarehouseArticleCategory));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailArticleSubcategory($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($nIdForm);
            
      if (!is_null($oWarehouseArticleSubcategory)) $this->render('viewDetailArticleSubcategory', array('oModelForm'=>$oWarehouseArticleSubcategory));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailArticleLocationCategory($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oWarehouseArticleLocationCategory = WarehouseArticlesLocationsCategories::getWarehouseArticleLocationCategory($nIdForm);
       
      if (!is_null($oWarehouseArticleLocationCategory)) $this->render('viewDetailArticleLocationCategory', array('oModelForm'=>$oWarehouseArticleLocationCategory));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailArticleLocationSubcategory($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oWarehouseArticleLocationSubcategory = WarehouseArticlesLocationsSubcategories::getWarehouseArticleLocationSubcategory($nIdForm);
            
      if (!is_null($oWarehouseArticleLocationSubcategory)) $this->render('viewDetailArticleLocationSubcategory', array('oModelForm'=>$oWarehouseArticleLocationSubcategory));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailArticle($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oArticle = Articles::getArticle($nIdForm);
       
      if (!is_null($oArticle)) $this->render('viewDetailArticle', array('oModelForm'=>$oArticle));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailArticleProvider($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oWarehouseArticleProvier = WarehouseArticlesProviders::getWarehouseArticleProvider($nIdForm);
       
      if (!is_null($oWarehouseArticleProvier)) $this->render('viewDetailArticleProvider', array('oModelForm'=>$oWarehouseArticleProvier));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   public function actionViewDetailProvider($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oProvider = Providers::getProvider($nIdForm);
       
      if (!is_null($oProvider)) $this->render('viewDetailProvider', array('oModelForm'=>$oProvider));
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));     
   }
   
   
   public function actionUpdateArticleCategory($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oWarehouseArticleCategory = WarehouseArticlesCategories::getWarehouseArticleCategory($nIdForm);
                               
      if (!is_null($oWarehouseArticleCategory)) {
         FForm::validateAjaxForm('warehouse-article-category-form', $oWarehouseArticleCategory);
      
         if (isset($_POST['WarehouseArticlesCategories'])) {
            $oWarehouseArticleCategory->attributes = $_POST['WarehouseArticlesCategories'];

            $oWarehouseArticleCategory->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewDetailArticleCategory', array('nIdForm'=>$oWarehouseArticleCategory->id)));
         }
         else $this->render('updateArticleCategory', array('oModelForm'=>$oWarehouseArticleCategory));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateArticleSubcategory($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($nIdForm);
                               
      if (!is_null($oWarehouseArticleSubcategory)) {
         FForm::validateAjaxForm('warehouse-article-subcategory-form', $oWarehouseArticleSubcategory);
      
         if (isset($_POST['WarehouseArticlesSubcategories'])) {
            $oWarehouseArticleSubcategory->attributes = $_POST['WarehouseArticlesSubcategories'];

            $oWarehouseArticleSubcategory->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewDetailArticleSubcategory', array('nIdForm'=>$oWarehouseArticleSubcategory->id)));
         }
         else $this->render('updateArticleSubcategory', array('oModelForm'=>$oWarehouseArticleSubcategory));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateArticleLocationCategory($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oWarehouseArticleLocationCategory = WarehouseArticlesLocationsCategories::getWarehouseArticleLocationCategory($nIdForm);
                               
      if (!is_null($oWarehouseArticleLocationCategory)) {
         FForm::validateAjaxForm('warehouse-article-location-category-form', $oWarehouseArticleLocationCategory);
      
         if (isset($_POST['WarehouseArticlesLocationsCategories'])) {
            $oWarehouseArticleLocationCategory->attributes = $_POST['WarehouseArticlesLocationsCategories'];

            $oWarehouseArticleLocationCategory->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewDetailArticleLocationCategory', array('nIdForm'=>$oWarehouseArticleLocationCategory->id)));
         }
         else $this->render('updateArticleLocationCategory', array('oModelForm'=>$oWarehouseArticleLocationCategory));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateArticleLocationSubcategory($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oWarehouseArticleLocationSubcategory = WarehouseArticlesLocationsSubcategories::getWarehouseArticleLocationSubcategory($nIdForm);
                               
      if (!is_null($oWarehouseArticleLocationSubcategory)) {
         FForm::validateAjaxForm('warehouse-article-location-subcategory-form', $oWarehouseArticleLocationSubcategory);
      
         if (isset($_POST['WarehouseArticlesLocationsSubcategories'])) {
            $oWarehouseArticleLocationSubcategory->attributes = $_POST['WarehouseArticlesLocationsSubcategories'];

            $oWarehouseArticleLocationSubcategory->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewDetailArticleLocationSubcategory', array('nIdForm'=>$oWarehouseArticleLocationSubcategory->id)));
         }
         else $this->render('updateArticleLocationSubcategory', array('oModelForm'=>$oWarehouseArticleLocationSubcategory));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateArticle($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oArticle = Articles::getArticle($nIdForm);
                               
      if (!is_null($oArticle)) {
         FForm::validateAjaxForm('article-form', $oArticle);
      
         if (isset($_POST['Articles'])) {
            $oArticle->attributes = $_POST['Articles'];
  
            if ((isset($_POST['Articles']['description'])) && (!FString::isNullOrEmpty($_POST['Articles']['description']))) $oArticle->description = $_POST['Articles']['description'];
            if (isset($_POST['Articles']['id_related_article'])) $oArticle->id_related_article = $_POST['Articles']['id_related_article'];
            if (isset($_POST['Articles']['id_equivalent_article'])) $oArticle->id_equivalent_article = $_POST['Articles']['id_equivalent_article'];
         
            $oFile = CUploadedFile::getInstanceByName('Articles[image]');
            if ($oFile) {
               $sOriginalFilename = sha1_file($oFile->tempName);
               $sOriginalFileExtension = FFile::getExtensionFromFileType($oFile->extensionName);
               $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
                  
               if (FFile::isCommonImageFromFileType($oFile->extensionName)) {  
                  $sPath = FApplication::FOLDER_IMAGES_MODULE_WAREHOUSE_ARTICLES;
                  $sOriginalFileUrl = $sPath . $sOriginalFile;
                           
                  if ($oFile->saveAs($sOriginalFileUrl)) {
                     $oArticle->image = $sOriginalFile;
                  }  
               }
            }
         
            $oArticle->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewDetailArticle', array('nIdForm'=>$oArticle->id)));
         }
         else $this->render('updateArticle', array('oModelForm'=>$oArticle));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateArticleProvider($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oWarehouseArticleProvider = WarehouseArticlesProviders::getWarehouseArticleProvider($nIdForm);
                               
      if (!is_null($oWarehouseArticleProvider)) {
         FForm::validateAjaxForm('warehouse-article-provider-form', $oWarehouseArticleProvider);
      
         if (isset($_POST['WarehouseArticlesProviders'])) {
            $oWarehouseArticleProvider->attributes = $_POST['WarehouseArticlesProviders'];
  
            $oWarehouseArticleProvider->save();
              
            $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewDetailArticleProvider', array('nIdForm'=>$oWarehouseArticleProvider->id)));
         }
         else $this->render('updateArticleProvider', array('oModelForm'=>$oWarehouseArticleProvider));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   public function actionUpdateProvider($nIdForm) {
      $this->layout = FApplication::LAYOUT_POPUP;
      $oProvider = Providers::getProvider($nIdForm);
                               
      if (!is_null($oProvider)) {
         if (FApplication::canUpdateDeleteProvider($nIdForm, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) {
            FForm::validateAjaxForm('provider-form', $oProvider);
         
            if (isset($_POST['Providers'])) {
               $oProvider->attributes = $_POST['Providers'];

               $oProvider->save();
                 
               $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewDetailProvider', array('nIdForm'=>$oProvider->id)));
            }
            else $this->render('updateProvider', array('oModelForm'=>$oProvider));
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));
      }
      else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_RECORD_NOT_EXIST')));
   }
   
   
   public function actionDeleteArticleCategory($nIdForm) {
      $oWarehouseArticleCategory = WarehouseArticlesCategories::getWarehouseArticleCategory($nIdForm);
      if (!is_null($oWarehouseArticleCategory)) {
         $oWarehouseArticleCategory->delete();
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewArticlesCategories'));
   }
   public function actionDeleteArticleSubcategory($nIdForm) {
      $oWarehouseArticleSubcategory = WarehouseArticlesSubcategories::getWarehouseArticleSubcategory($nIdForm);
      if (!is_null($oWarehouseArticleSubcategory)) {
         $oWarehouseArticleSubcategory->delete();
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewArticlesCategories'));
   }
   public function actionDeleteArticleLocationCategory($nIdForm) {
      $oWarehouseArticleLocationCategory = WarehouseArticlesLocationsCategories::getWarehouseArticleLocationCategory($nIdForm);
      if (!is_null($oWarehouseArticleLocationCategory)) {
         $oWarehouseArticleLocationCategory->delete();
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewArticlesLocationsCategories'));
   }
   public function actionDeleteArticleLocationSubcategory($nIdForm) {
      $oWarehouseArticleLocationSubcategory = WarehouseArticlesLocationsSubcategories::getWarehouseArticleLocationSubcategory($nIdForm);
      if (!is_null($oWarehouseArticleLocationSubcategory)) {
         $oWarehouseArticleLocationSubcategory->delete();
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewArticlesLocationsCategories'));
   }
   public function actionDeleteArticle($nIdForm) {
      $oArticle = Articles::getArticle($nIdForm);
      if (!is_null($oArticle)) {
         if (FModuleWarehouseManagement::allowDeleteArticle($oArticle->id)) {
            $oArticle->delete();
         }
         else FFlash::addError(Yii::t('frontend_' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT), 'PAGE_VIEWARTICLES_FORM_DELETE_ERROR'));
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewArticles'));
   }
   public function actionDeleteArticleProvider($nIdForm) {
      $oWarehouseArticleProvider = WarehouseArticlesProviders::getWarehouseArticleProvider($nIdForm);
      if (!is_null($oWarehouseArticleProvider)) {
         $oWarehouseArticleProvider->delete();
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewArticles'));
   }
   public function actionDeleteProvider($nIdForm) {
      $oProvider = Providers::getProvider($nIdForm);
      if (!is_null($oProvider)) {
         if (FApplication::canUpdateDeleteProvider($nIdForm, FApplication::MODULE_WAREHOUSE_MANAGEMENT)) {
            $oProvider->delete();
         }
         else $this->redirect($this->createUrl(Yii::app()->params['errorUrl'], array('sErrTextKey'=>'ERROR_ACTION_NOT_ALLOWED')));  
      }
      
      $this->redirect($this->createUrl('frontend/' . strtolower(FApplication::MODULE_WAREHOUSE_MANAGEMENT) . '/manage/viewProviders'));
   }
}