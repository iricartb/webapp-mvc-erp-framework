/* Simple Animation Background Color */
function jquerySimpleAnimationBgColor(oElements, nRed, nGreen, nBlue, nAlpha, nDuration) {
   $(oElements).animate({backgroundColor: 'rgba(' + nRed + ',' + nGreen + ',' + nBlue + ',' + nAlpha + ')'}, nDuration);   
}
/* End Simple Animation Background Color */


/* Simple Animation Fade */
function jquerySimpleAnimationFade(oElements, nFade, nDuration) {
   $(oElements).fadeTo(nDuration, nFade);               
}                                                          

function jquerySimpleAnimationFadeAppear(oElements, nFade, nDuration) {
   $(oElements).hide().fadeTo(nDuration, nFade);
}

function jquerySimpleAnimationFadeDisappear(oElements, nDuration) {
   $(oElements).fadeTo(nDuration, 0.0);
}

function jquerySimpleAnimationFadeAppearDisappearTableCell(oElements, bAppear, nFade, nDuration) {
   $(oElements).clearQueue();
    
   if (bAppear == true) {
      if ($(oElements).css('display') == 'none') {
         $(oElements).hide().fadeTo(nDuration, nFade, function onCompleteHandler() {
            $(oElements).css('display', 'table-cell');   
         });
      }
   }
   else {
      if (($(oElements).css('display') == 'block') || ($(oElements).css('display') == 'table-cell'))  {
         $(oElements).fadeTo(nDuration, 0.0, function onCompleteHandler() { 
            $(oElements).css('display', 'none');
         });
      }
   }  
}

function jquerySimpleAnimationFadeAppearDisappearBlock(oElements, bAppear, nFade, nDuration) {
   $(oElements).clearQueue();
    
   if (bAppear == true) {
      if ($(oElements).css('display') == 'none') {
         $(oElements).hide().fadeTo(nDuration, nFade, function onCompleteHandler() {
            $(oElements).css('display', 'block');   
         });
      }
   }
   else {
      if ($(oElements).css('display') == 'block')  {
         $(oElements).fadeTo(nDuration, 0.0, function onCompleteHandler() { 
            $(oElements).css('display', 'none');
         });
      }
   }  
}        
/* End Simple Animation Fade */

/* Simple Animation Change All Content */
function jquerySimpleAnimationChangeAllContent(sUrl, oSerializedData, sIdSourceLayer, sTypeMethodContentDecoration, nTypeMethodContentDecorationDuration) {
   aj(sUrl, oSerializedData, sIdSourceLayer, null, null, null, null, 'TYPE_METHOD_CONTENT_REPLACE_ALL', sTypeMethodContentDecoration, nTypeMethodContentDecorationDuration, true, true);    
}
/* End Simple Animation Change All Content */


/* Simple Animation Expand Collapse */
function jquerySimpleAnimationExpandCollapse(oElements, sSpeed) {
   if ((sSpeed === undefined) || (sSpeed === null)) sSpeed = 'slow';
   
   $(oElements).slideToggle(sSpeed);  
}
/* End Simple Animation Expand Collapse */


/* Event MouseOver/MouseOut Animation Background Color */
function jqueryEventAnimationBgColorOnMouseOverOut(oElements, sTypeMethodAnimationChangeElements, nRedMouseOver, nGreenMouseOver, nBlueMouseOver, nAlphaMouseOver, nDurationMouseOver, nRedMouseOut, nGreenMouseOut, nBlueMouseOut, nAlphaMouseOut, nDurationMouseOut, bHandleMouseOver, bHandleMouseOut, bSetInitColor, nRed, nGreen, nBlue, nAlpha, nDuration) {
   if (bSetInitColor != true) bSetInitColor = false;   
   if (bHandleMouseOver != false) bHandleMouseOver = true;   
   if (bHandleMouseOut != false) bHandleMouseOut = true;  
   if ((sTypeMethodAnimationChangeElements != 'TYPE_METHOD_ANIMATION_CHANGE_ALL_ELEMENTS') && (sTypeMethodAnimationChangeElements != 'TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS') && (sTypeMethodAnimationChangeElements != 'TYPE_METHOD_ANIMATION_CHANGE_OTHER_ELEMENTS')) sTypeMethodAnimationChangeElements = 'TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS';
   
   $(oElements).each(function() {
      if (bSetInitColor) {
         jquerySimpleAnimationBgColor(this, nRed, nGreen, nBlue, nAlpha, nDuration);   
      }
      
      if (bHandleMouseOver) {
         $(this).mouseover(function() {
            if (sTypeMethodAnimationChangeElements == 'TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS') {
               $(this).clearQueue();
               jquerySimpleAnimationBgColor(this, nRedMouseOver, nGreenMouseOver, nBlueMouseOver, nAlphaMouseOver, nDurationMouseOver);                
            }
            else if (sTypeMethodAnimationChangeElements == 'TYPE_METHOD_ANIMATION_CHANGE_ALL_ELEMENTS') {           
               $(oElements).clearQueue();
               jquerySimpleAnimationBgColor(oElements, nRedMouseOver, nGreenMouseOver, nBlueMouseOver, nAlphaMouseOver, nDurationMouseOver);                 
            }
            else if (sTypeMethodAnimationChangeElements == 'TYPE_METHOD_ANIMATION_CHANGE_OTHER_ELEMENTS') {
               for (var i = 0; i < $(oElements).length; i++) {
                  var oElement = $(oElements)[i];
                  $(oElement).clearQueue();
                 
                  if (oElement != this) jquerySimpleAnimationBgColor(oElement, nRedMouseOver, nGreenMouseOver, nBlueMouseOver, nAlphaMouseOver, nDurationMouseOver);
               }
            }
         });
      }
      
      if (bHandleMouseOut) {
         $(this).mouseout(function() {
            if (sTypeMethodAnimationChangeElements == 'TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS') {
               $(this).clearQueue();
               jquerySimpleAnimationBgColor(this, nRedMouseOut, nGreenMouseOut, nBlueMouseOut, nAlphaMouseOut, nDurationMouseOut);                  
            }
            else if (sTypeMethodAnimationChangeElements == 'TYPE_METHOD_ANIMATION_CHANGE_ALL_ELEMENTS') {
               $(oElements).clearQueue();
               jquerySimpleAnimationBgColor(oElements, nRedMouseOut, nGreenMouseOut, nBlueMouseOut, nAlphaMouseOut, nDurationMouseOut);                
            }
            else if (sTypeMethodAnimationChangeElements == 'TYPE_METHOD_ANIMATION_CHANGE_OTHER_ELEMENTS') {
               for (var i = 0; i < $(oElements).length; i++) {
                  var oElement = $(oElements)[i];
                  $(oElement).clearQueue();
                 
                  if (oElement != this) jquerySimpleAnimationBgColor(oElement, nRedMouseOut, nGreenMouseOut, nBlueMouseOut, nAlphaMouseOut, nDurationMouseOut);
               }
            }
         }); 
      }
   });    
}
/* End Event MouseOver/MouseOut Animation Background Color */


/* Event MouseOver/MouseOut Animation Fade */
function jqueryEventAnimationFadeOnMouseOverOut(oElements, sTypeMethodAnimationChangeElements, nFadeMouseOver, nDurationMouseOver, nFadeMouseOut, nDurationMouseOut, bHandleMouseOver, bHandleMouseOut, bSetInitFade, nFade, nDuration) {
   if (bSetInitFade != true) bSetInitFade = false;   
   if (bHandleMouseOver != false) bHandleMouseOver = true;   
   if (bHandleMouseOut != false) bHandleMouseOut = true;  
   if ((sTypeMethodAnimationChangeElements != 'TYPE_METHOD_ANIMATION_CHANGE_ALL_ELEMENTS') && (sTypeMethodAnimationChangeElements != 'TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS') && (sTypeMethodAnimationChangeElements != 'TYPE_METHOD_ANIMATION_CHANGE_OTHER_ELEMENTS')) sTypeMethodAnimationChangeElements = 'TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS';
   
   $(oElements).each(function() {
      if (bSetInitFade) {
         jquerySimpleAnimationFade(this, nFade, nDuration);   
      }
      
      if (bHandleMouseOver) {
         $(this).mouseover(function() {
            if (sTypeMethodAnimationChangeElements == 'TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS') {
               $(this).clearQueue();
               jquerySimpleAnimationFade(this, nFadeMouseOver, nDurationMouseOver);   
            }
            else if (sTypeMethodAnimationChangeElements == 'TYPE_METHOD_ANIMATION_CHANGE_ALL_ELEMENTS') {
               $(oElements).clearQueue();
               jquerySimpleAnimationFade(oElements, nFadeMouseOver, nDurationMouseOver);                
            }
            else if (sTypeMethodAnimationChangeElements == 'TYPE_METHOD_ANIMATION_CHANGE_OTHER_ELEMENTS') {
               for (var i = 0; i < $(oElements).length; i++) {
                  var oElement = $(oElements)[i];
                  $(oElement).clearQueue();
                 
                  if (oElement != this) jquerySimpleAnimationFade(oElement, nFadeMouseOver, nDurationMouseOver);
               }
            }
         });
      }
      
      if (bHandleMouseOut) {
         $(this).mouseout(function() {
            if (sTypeMethodAnimationChangeElements == 'TYPE_METHOD_ANIMATION_CHANGE_SELECTED_ELEMENTS') {
               $(this).clearQueue();
               jquerySimpleAnimationFade(this, nFadeMouseOut, nDurationMouseOut);
            }
            else if (sTypeMethodAnimationChangeElements == 'TYPE_METHOD_ANIMATION_CHANGE_ALL_ELEMENTS') {
               $(oElements).clearQueue();
               jquerySimpleAnimationFade(oElements, nFadeMouseOut, nDurationMouseOut);                
            }
            else if (sTypeMethodAnimationChangeElements == 'TYPE_METHOD_ANIMATION_CHANGE_OTHER_ELEMENTS') {
               for (var i = 0; i < $(oElements).length; i++) {
                  var oElement = $(oElements)[i];
                  $(oElement).clearQueue(); 
                                         
                  if (oElement != this) jquerySimpleAnimationFade(oElement, nFadeMouseOut, nDurationMouseOut);
               }
            }
         });
      }
   });    
}
/* End Event MouseOver/MouseOut Animation Fade */


/* Event Window Load Simple Animation Background Color */
function jqueryEventSimpleAnimationBgColorOnWindowLoad(oElements, nRed, nGreen, nBlue, nAlpha, nDuration) {
   $(window).load(function() {
      jquerySimpleAnimationBgColor(oElements, nRed, nGreen, nBlue, nAlpha, nDuration);
   });   
}
/* End Event Window Load Simple Animation Background Color */


/* Event Window Load Simple Animation Fade */
function jqueryEventSimpleAnimationFadeOnWindowLoad(oElements, nFade, nDuration) {
   $(window).load(function() {
      jquerySimpleAnimationFade(oElements, nFade, nDuration);
   });   
}

function jqueryEventSimpleAnimationFadeAppearOnWindowLoad(oElements, nFade, nDuration) {
   $(window).load(function() {
      jquerySimpleAnimationFadeAppear(oElements, nFade, nDuration);
   });   
}

function jqueryEventSimpleAnimationFadeDisappearOnWindowLoad(oElements, nFade, nDuration) {
   $(window).load(function() {
      jquerySimpleAnimationFadeDisappear(oElements, nFade, nDuration);
   });   
}

function jqueryEventSimpleAnimationFadeAppearDisappearTableCellOnWindowLoad(oElements, bAppear, nFade, nDuration) {
   $(window).load(function() {
      jquerySimpleAnimationFadeAppearDisappearTableCell(oElements, bAppear, nFade, nDuration);
   });
}

function jqueryEventSimpleAnimationFadeAppearDisappearBlockOnWindowLoad(oElements, bAppear, nFade, nDuration) {
   $(window).load(function() {
      jquerySimpleAnimationFadeAppearDisappearBlock(oElements, bAppear, nFade, nDuration);
   });
}
/* End Event Window Load Simple Animation Fade */


/* Event Window Load Event MouseOver/MouseOut Animation Background Color */
function jqueryEventEventAnimationBgColorOnMouseOverOutOnWindowLoad(oElements, sTypeMethodAnimationChangeElements, nRedMouseOver, nGreenMouseOver, nBlueMouseOver, nAlphaMouseOver, nDurationMouseOver, nRedMouseOut, nGreenMouseOut, nBlueMouseOut, nAlphaMouseOut, nDurationMouseOut, bHandleMouseOver, bHandleMouseOut, bSetInitColor, nRed, nGreen, nBlue, nAlpha, nDuration) {
   $(window).load(function() {
      jqueryEventAnimationBgColorOnMouseOverOut(oElements, sTypeMethodAnimationChangeElements, nRedMouseOver, nGreenMouseOver, nBlueMouseOver, nAlphaMouseOver, nDurationMouseOver, nRedMouseOut, nGreenMouseOut, nBlueMouseOut, nAlphaMouseOut, nDurationMouseOut, bHandleMouseOver, bHandleMouseOut, bSetInitColor, nRed, nGreen, nBlue, nAlpha, nDuration);
   });
}
/* End Event Window Load Event MouseOver/MouseOut Animation Background Color */


/* Event Window Load Event MouseOver/MouseOut Animation Fade */
function jqueryEventEventAnimationFadeOnMouseOverOutOnWindowLoad(oElements, sTypeMethodAnimationChangeElements, nFadeMouseOver, nDurationMouseOver, nFadeMouseOut, nDurationMouseOut, bHandleMouseOver, bHandleMouseOut, bSetInitFade, nFade, nDuration) {
   $(window).load(function() {
      jqueryEventAnimationFadeOnMouseOverOut(oElements, sTypeMethodAnimationChangeElements, nFadeMouseOver, nDurationMouseOver, nFadeMouseOut, nDurationMouseOut, bHandleMouseOver, bHandleMouseOut, bSetInitFade, nFade, nDuration);
   });
}
/* End Event Window Load Event MouseOver/MouseOut Animation Fade */


/* Event Document Ready Simple Animation Background Color */
function jqueryEventSimpleAnimationBgColorOnDocumentReady(oElements, nRed, nGreen, nBlue, nAlpha, nDuration) {
   $(document).ready(function() {
      jquerySimpleAnimationBgColor(oElements, nRed, nGreen, nBlue, nAlpha, nDuration);
   });   
}
/* End Event Document Ready Simple Animation Background Color */


/* Event Document Ready Simple Animation Fade */
function jqueryEventSimpleAnimationFadeOnDocumentReady(oElements, nFade, nDuration) {
   $(document).ready(function() {
      jquerySimpleAnimationFade(oElements, nFade, nDuration);
   });   
}

function jqueryEventSimpleAnimationFadeAppearOnDocumentReady(oElements, nFade, nDuration) {
   $(document).ready(function() {
      jquerySimpleAnimationFadeAppear(oElements, nFade, nDuration);
   });   
}

function jqueryEventSimpleAnimationFadeDisappearOnDocumentReady(oElements, nFade, nDuration) {
   $(document).ready(function() {
      jquerySimpleAnimationFadeDisappear(oElements, nFade, nDuration);
   });   
}

function jqueryEventSimpleAnimationFadeAppearDisappearTableCellOnDocumentReady(oElements, bAppear, nFade, nDuration) {
   $(document).ready(function() {
      jquerySimpleAnimationFadeAppearDisappearTableCell(oElements, bAppear, nFade, nDuration);
   });
}

function jqueryEventSimpleAnimationFadeAppearDisappearBlockOnDocumentReady(oElements, bAppear, nFade, nDuration) {
   $(document).ready(function() {
      jquerySimpleAnimationFadeAppearDisappearBlock(oElements, bAppear, nFade, nDuration);
   });
}
/* End Event Document Ready Simple Animation Fade */


/* Event Document Ready Event MouseOver/MouseOut Animation Background Color */
function jqueryEventEventAnimationBgColorOnMouseOverOutOnDocumentReady(oElements, sTypeMethodAnimationChangeElements, nRedMouseOver, nGreenMouseOver, nBlueMouseOver, nAlphaMouseOver, nDurationMouseOver, nRedMouseOut, nGreenMouseOut, nBlueMouseOut, nAlphaMouseOut, nDurationMouseOut, bHandleMouseOver, bHandleMouseOut, bSetInitColor, nRed, nGreen, nBlue, nAlpha, nDuration) {
   $(document).ready(function() {
      jqueryEventAnimationBgColorOnMouseOverOut(oElements, sTypeMethodAnimationChangeElements, nRedMouseOver, nGreenMouseOver, nBlueMouseOver, nAlphaMouseOver, nDurationMouseOver, nRedMouseOut, nGreenMouseOut, nBlueMouseOut, nAlphaMouseOut, nDurationMouseOut, bHandleMouseOver, bHandleMouseOut, bSetInitColor, nRed, nGreen, nBlue, nAlpha, nDuration);
   });
}
/* End Event Document Ready Event MouseOver/MouseOut Animation Background Color */


/* Event Document Ready Event MouseOver/MouseOut Animation Fade */
function jqueryEventEventAnimationFadeOnMouseOverOutOnDocumentReady(oElements, sTypeMethodAnimationChangeElements, nFadeMouseOver, nDurationMouseOver, nFadeMouseOut, nDurationMouseOut, bHandleMouseOver, bHandleMouseOut, bSetInitFade, nFade, nDuration) {
   $(document).ready(function() {
      jqueryEventAnimationFadeOnMouseOverOut(oElements, sTypeMethodAnimationChangeElements, nFadeMouseOver, nDurationMouseOver, nFadeMouseOut, nDurationMouseOut, bHandleMouseOver, bHandleMouseOut, bSetInitFade, nFade, nDuration);
   });
}
/* End Event Document Ready Event MouseOver/MouseOut Animation Fade */