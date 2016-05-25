jQuery(document).ready(function($) {
	
	jQuery('.calsingleentryw:last').css('border-width' , '0px');
	
	var currentTallest = 0,
    currentRowStart = 0,
    rowDivs = new Array(),
    $el,
    topPosition = 0;
	
	jQuery('.intleftinner').each(function() {

   $el = jQuery(this);
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {

     // we just came to a new row.  Set all the heights on the completed row
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }

     // set the variables for the new row
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);

   } else {

     // another div on the current row.  Add it to the list and check if it's taller
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);

  }
  
  for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }

  
  });
  
  jQuery('a.wpfc_nextlink').click(function(){
  	nxtsol();
	return false;
  });
  
  
  jQuery('a.wpfc_prevlink').click(function(){
  	prvsol();
	return false;
  });
  
  function nxtsol(){
  	var sender = jQuery('a.wpfc_nextlink').attr('rel');
  	var data = { action: 'churchpack_get_ajaxdata', type: 'get_cal', senddata: sender};
	jQuery.post(ajax_url, data, function(response) {	
		jQuery('.calselect').html(response);
		jQuery('a.wpfc_nextlink').unbind('click').bind('click', nxtsol);
		jQuery('a.wpfc_prevlink').unbind('click').bind('click', prvsol);
	});
	
  }
  
   function prvsol(){
  	var sender = jQuery('.wpfc_prevlink').attr('rel');
  	var data = { action: 'churchpack_get_ajaxdata', type: 'get_cal', senddata: sender};
	jQuery.post(ajax_url, data, function(response) {	
		jQuery('.calselect').html(response);
		jQuery('a.wpfc_prevlink').unbind('click').bind('click', prvsol);
		jQuery('a.wpfc_nextlink').unbind('click').bind('click', nxtsol);
	});
  }
  	
});