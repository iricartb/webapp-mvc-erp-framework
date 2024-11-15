function expandCollapseChangeBgImage(id) {
   if ($(id).css('backgroundImage').search('btn_plus') >= 0) {
      $(id).css('backgroundImage', 'url(\'images/generic/24x24/btn_minus.png\')');      
   }
   else {
      $(id).css('backgroundImage', 'url(\'images/generic/24x24/btn_plus.png\')');   
   }   
} 

function expandCollapseChangeText(id, text1, text2) {
   if (document.getElementById(id).innerHTML == text1) document.getElementById(id).innerHTML = text2;
   else document.getElementById(id).innerHTML = text1;    
}

function refreshAllCGridViews() {
   $('.grid-view').each(function() {
      $.fn.yiiGridView.update(this.id);
   }); 
}

function showHideElement(id) {
   var oElement = document.getElementById(id);
    
   if (oElement.style.display === 'block') {
      oElement.style.display = 'none';
   }
   else {
      oElement.style.display = 'block'; 
   }
}