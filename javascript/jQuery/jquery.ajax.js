function ajUpdateFields(sUrl, sData, sAfterActionJsSentence) {
   _ajCallGetRequest(sUrl, sData, sAfterActionJsSentence, null);
}

function aj(sUrl, oSerializedData, sIdSourceLayer, sIdFilterDataLayer, sBeforeActionConfirmationMessage, sAfterActionJsSentence, sAfterActionJsSentenceAlternative, sTypeMethodContentReplaceOrAppend, sTypeMethodContentDecoration, nTypeMethodContentDecorationDuration, bProcessData, bAsynchronousCall, bShowLoading) { 
   var bBeforeActionConfirmationOK;
   
   bBeforeActionConfirmationOK = true;
   
   if (bShowLoading != true) bShowLoading = false;

   if ((sBeforeActionConfirmationMessage !== undefined) && (sBeforeActionConfirmationMessage !== null)) bBeforeActionConfirmationOK = confirm(sBeforeActionConfirmationMessage);   
   
   if ((sTypeMethodContentReplaceOrAppend != 'TYPE_METHOD_CONTENT_REPLACE_NONE') && (sTypeMethodContentReplaceOrAppend != 'TYPE_METHOD_CONTENT_REPLACE') && (sTypeMethodContentReplaceOrAppend != 'TYPE_METHOD_CONTENT_APPEND_ABOVE') && (sTypeMethodContentReplaceOrAppend != 'TYPE_METHOD_CONTENT_APPEND_BELOW') && (sTypeMethodContentReplaceOrAppend != 'TYPE_METHOD_CONTENT_REPLACE_ALL')) sTypeMethodContentReplaceOrAppend = 'TYPE_METHOD_CONTENT_REPLACE';
   
   if ((sTypeMethodContentDecoration != 'TYPE_METHOD_CONTENT_DECORATION_NONE') && (sTypeMethodContentDecoration != 'TYPE_METHOD_CONTENT_DECORATION_FADE') && (sTypeMethodContentDecoration != 'TYPE_METHOD_CONTENT_DECORATION_ROLL')) sTypeMethodContentDecoration = 'TYPE_METHOD_CONTENT_DECORATION_NONE';
    
   if ((nTypeMethodContentDecorationDuration === undefined) || (nTypeMethodContentDecorationDuration === null)) nTypeMethodContentDecorationDuration = 0; 
   
   if (bProcessData != true) bProcessData = false;   
   if (bAsynchronousCall != false) bAsynchronousCall = true;

   if (bBeforeActionConfirmationOK) {  
      _ajCall(sUrl, oSerializedData, sIdSourceLayer, sIdFilterDataLayer, sAfterActionJsSentence, sAfterActionJsSentenceAlternative, sTypeMethodContentReplaceOrAppend, sTypeMethodContentDecoration, nTypeMethodContentDecorationDuration, bProcessData, bAsynchronousCall, bShowLoading);
   }
}

function ajShowLoading(bShowLoading) {
   if (bShowLoading) $("#aj_loading").show(); 
   else $("#aj_loading").hide();    
}

function _ajCall(sUrl, oSerializedData, sIdSourceLayer, sIdFilterDataLayer, sAfterActionJsSentence, sAfterActionJsSentenceAlternative, sTypeMethodContentReplaceOrAppend, sTypeMethodContentDecoration, nTypeMethodContentDecorationDuration, bProcessData, bAsynchronousCall, bShowLoading) {
   var sSourceLayer;
   
   if ((sIdSourceLayer === undefined) || (sIdSourceLayer === null)) sSourceLayer = 'html';
   else sSourceLayer = '#' + sIdSourceLayer;
   
   ajShowLoading(bShowLoading);
   
   $.ajax({
      url: sUrl,
      data: oSerializedData,          
      type: "POST", 
      cache: false,
      processData: bProcessData,
      async: bAsynchronousCall,

      success: function(sAjData) {
         ajShowLoading(false);
         if (sAjData.search('<div id="aj:no_replace_no_afteraction_no_afteraction_alternative" />') == -1) {
            if (sAjData.search('<div id="aj:no_replace_no_afteraction_yes_afteraction_alternative" />') == -1) {
               if (sAjData.search('<div id="aj:no_replace_yes_afteraction" />') == -1) {
                  
                  if (sTypeMethodContentDecoration != 'TYPE_METHOD_CONTENT_DECORATION_NONE') {
                     if (sTypeMethodContentDecoration == 'TYPE_METHOD_CONTENT_DECORATION_FADE') {      
                        $(sSourceLayer).animate({
                           opacity: 0.0
                        }, nTypeMethodContentDecorationDuration, function onCompleteHandler() {
                           _ajMethodContentReplace(sAjData, sIdSourceLayer, sIdFilterDataLayer, sTypeMethodContentReplaceOrAppend);
                           
                           $(sSourceLayer).animate({ opacity: 1.0 }, nTypeMethodContentDecorationDuration);
                        });
                     }
                     else if (sTypeMethodContentDecoration == 'TYPE_METHOD_CONTENT_DECORATION_ROLL') {      
                        var nOrigHeightLayer = $(sSourceLayer).height();
                       
                        $(sSourceLayer).animate({
                           opacity: 0.0,    
                           height: 0.0
                        }, nTypeMethodContentDecorationDuration, function onCompleteHandler() {
                           _ajMethodContentReplace(sAjData, sIdSourceLayer, sIdFilterDataLayer, sTypeMethodContentReplaceOrAppend);
                             
                           if (sTypeMethodContentReplaceOrAppend == 'TYPE_METHOD_CONTENT_REPLACE_ALL') {
                              nOrigHeightLayer = '100%';
                              $(sSourceLayer).css({ opacity: 0.0 });
                              $(sSourceLayer).css({ height: 0.0 });
                           }
                           else if ($(sSourceLayer).height() > nOrigHeightLayer) nOrigHeightLayer = $(sSourceLayer).height();
                                          
                           $(sSourceLayer).animate({ opacity: 1.0, height: nOrigHeightLayer }, nTypeMethodContentDecorationDuration, function onCompleteHandler() {
                              $(sSourceLayer).css({ height: nOrigHeightLayer });   
                           });
                        });
                     }
                  }
                  else {
                     _ajMethodContentReplace(sAjData, sIdSourceLayer, sIdFilterDataLayer, sTypeMethodContentReplaceOrAppend);      
                  }
                  
                  if (sAjData.search('<div id="aj:yes_replace_no_afteraction" />') == -1) {
                     if ((sAfterActionJsSentence !== undefined) && (sAfterActionJsSentence !== null)) eval(sAfterActionJsSentence);   
                  } 
               }
               else if ((sAfterActionJsSentence !== undefined) && (sAfterActionJsSentence !== null)) {
                  eval(sAfterActionJsSentence);
               }
            }
            else if ((sAfterActionJsSentenceAlternative !== undefined) && (sAfterActionJsSentenceAlternative !== null)) {
               eval(sAfterActionJsSentenceAlternative);
            }
         }
      },
      error: function(oXhr, oAjaxOptions, oThrownError) {
         ajShowLoading(false);
         alert('<aj:error> call _ajCall function. Url:' + sUrl + 'Err Number ' + xhr.status + ': ' + xhr.responseText);
      }
   });
}

function _ajMethodContentReplace(sAjData, sIdSourceLayer, sIdFilterDataLayer, sTypeMethodContentReplaceOrAppend) {
   var sdata;

   if ((sIdFilterDataLayer != null) && (sTypeMethodContentReplaceOrAppend != 'TYPE_METHOD_CONTENT_REPLACE_ALL')) {
      sdata = $('<div/>').html(sAjData).find('#' + sIdFilterDataLayer).html();
   } 
   else sdata = sAjData;
           
   if (sTypeMethodContentReplaceOrAppend == 'TYPE_METHOD_CONTENT_REPLACE_ALL') {
       var sdata_head = sAjData.replace('<head', '<head><div id="head"').replace('</head>','</div></head>');
       var nHeadStartContent = sdata_head.indexOf('>', sdata_head.indexOf('<div id="head"')) + 1;
       var nHeadEndContent = sdata_head.indexOf('</div></head>') - 1;
                                   
       var sdata_body = sAjData.replace('<body', '<body><div id="body"').replace('</body>','</div></body>');
       var nBodyStartContent = sdata_body.indexOf('>', sdata_body.indexOf('<div id="body"')) + 1;
       var nBodyEndContent = sdata_body.indexOf('</div></body>') - 1;
                      
       $('head').html(sdata_head.substring(nHeadStartContent, nHeadEndContent));   
       $('body').html(sdata_body.substring(nBodyStartContent, nBodyEndContent));    
   }
   else if (sTypeMethodContentReplaceOrAppend == 'TYPE_METHOD_CONTENT_REPLACE') { $('#' + sIdSourceLayer).html(sdata); }
   else if (sTypeMethodContentReplaceOrAppend == 'TYPE_METHOD_CONTENT_APPEND_ABOVE') $('#' + sIdSourceLayer).prepend(sdata);
   else if (sTypeMethodContentReplaceOrAppend == 'TYPE_METHOD_CONTENT_APPEND_BELOW') $('#' + sIdSourceLayer).append(sdata);   
}

function _ajCallGetRequest(sUrl, sData, sAfterActionJsSentence, sAfterActionJsSentenceError) {
   $.ajax({
      url: sUrl,
      data: sData,          
      type: "GET", 
      cache: false,
      processData: true,
      async: false,

      success: function(sAjData) { 
         if (sAjData.search('<div id="aj:error" />') == -1) {
            eval(sAfterActionJsSentence);   
         }
         else {
            if (sAfterActionJsSentenceError != null) eval(sAfterActionJsSentenceError); 
         }
      },
      error: function(oXhr, oAjaxOptions, oThrownError) {  
         alert('<aj:error> call _ajCall function. Err Number ' + oXhr.status + ': ' + oXhr.responseText);
      }
   });
}