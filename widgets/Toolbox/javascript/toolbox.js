function toolbox_align(header_element, submenu_element, inverse) {
   if (inverse) {
      document.getElementById(submenu_element).style.left = document.getElementById(header_element).offsetLeft - 200 + document.getElementById(header_element).offsetWidth + 'px';   
   }
   else {
      document.getElementById(submenu_element).style.left = document.getElementById(header_element).offsetLeft + 'px';
   }   
}