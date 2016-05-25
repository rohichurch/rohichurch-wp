jQuery(document).ready(function($){
	// Assign a class to parent menu items
	$('.site-navigation').find('li:has(ul)').addClass('menu-parent-item');
	// Enable submenu to show on first touch of parent item
	if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/Android/i)) ) {
		var clicks = '';
		$('.main-navigation li.menu-parent-item a').live('click', function(e) {
			clicks++;
			if (clicks == 2){
			var el = $(this);
			var link = el.attr('href');
				window.location = link;
				} else {
				e.preventDefault();
				}
		});
	}  
});