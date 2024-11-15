<div class="form">   
   <div class="form_content" style="height:270px">
      <div class="item-header">                                                                                                                                                                                                                                                                                            
         <div class="item-header-text" style="padding-top:0px">
            <?php echo FString::castStrToUpper(Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDUREENDSTEP_HEADER', array('{1}'=>FDate::getTimeZoneFormattedDate($oModelForm->start_date), '{2}'=>$oModelForm->owner))); ?>
         </div>          
      </div>
      <p style="height:130px;">
         <?php echo Yii::t('frontend_' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT), 'PAGE_UPDATEFORMCONTRACTINGPROCEDUREENDSTEP_DESCRIPTION', array('{1}'=>$oModelForm->contracting_procedure_expedient)); ?>
      </p>
      
      <br/><hr>
      <div style="text-align:right">
         <?php echo CHtml::submitButton(Yii::t('system', 'SYS_FORM_BUTTON_FINALIZE'), array('class'=>'form_button_submit', 'style'=>'background-color:#007a9b; color:white; border-width:0px; padding:7px;', 'onmouseover'=>'this.style.backgroundColor = \'#008aab\'', 'onmouseout'=>'this.style.backgroundColor = \'#007a9b\'', 'onclick'=>'parent.window.location = \'' . $this->createUrl('frontend/' . strtolower(FApplication::MODULE_PURCHASES_MANAGEMENT) . '/main/updateFormContractingProcedure', array('nIdForm'=>$oModelForm->id)) . '\'')); ?> 
      </div>
   </div>
</div>