<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
/* Default comment here */ 

function copied() {
  /* Get the text field */
  var copyText = document.getElementsByClassName("copy-and-attribute-text");
  var copiedSuccessfully = document.getElementsByClassName("copied-successfully");
   /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText[0].textContent);
  copiedSuccessfully[0].style.visibility = 'visible';
  copiedSuccessfully[0].style.opacity = '1';
  setTimeout(function(){	
 	copiedSuccessfully[0].style.visibility = 'hidden';
	copiedSuccessfully[0].style.opacity = '0';
	
}, 2000);
  
}</script>
<!-- end Simple Custom CSS and JS -->
