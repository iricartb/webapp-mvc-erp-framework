function dropzone_remove_element(oElements, sJsSentence) {
   $(oElements).fadeOut('slow', function() {  
      var oRegexAscii39 = new RegExp('%ascii_39', 'g');
      var oRegexAscii34 = new RegExp('%ascii_34', 'g');
      
      $(oElements).remove();
      
      eval(sJsSentence.replace(oRegexAscii39, '\'').replace(oRegexAscii34, '"'));
   });   
}