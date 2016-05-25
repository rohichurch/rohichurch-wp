jQuery(document).ready(function(){

	var quote_meta = jQuery('#post_meta4');
	var quote_radio = jQuery('#post-format-quote');
	quote_meta.css('display', 'none');

                
	var image_meta = jQuery('#postimagediv');
	var image_radio = jQuery('#post-format-image');
                
	var standard_meta = jQuery('#postimagediv');
	var standard_radio = jQuery('#post-format-0');

	var link_meta = jQuery('#post_meta5');
	var link_radio = jQuery('#post-format-link');
	link_meta.css('display', 'none');

	var audio_meta = jQuery('#post_meta3');
	var audio_radio = jQuery('#post-format-audio');
	audio_meta.css('display', 'none');

	var gallery_meta = jQuery('#post_meta2');
	var gallery_radio = jQuery('#post-format-gallery');
	gallery_meta.css('display', 'none');

	var video_meta = jQuery('#post_meta1');
	var video_radio = jQuery('#post-format-video');
	video_meta.css('display', 'none');

	var group = jQuery('#post-formats-select input');
	
	group.change( function() {
		
		if(jQuery(this).val() == 'quote') {
			quote_meta.css('display', 'block');
			hide_metabox(quote_meta);
			
		} else if(jQuery(this).val() == '0') {
			standard_meta.css('display', 'block');
			hide_metabox(standard_meta);
                        
		} else if(jQuery(this).val() == 'gallery') {
			gallery_meta.css('display', 'block');
			hide_metabox(gallery_meta);
                        
		} else if(jQuery(this).val() == 'link') {
			link_meta.css('display', 'block');
			hide_metabox(link_meta);
			
		} else if(jQuery(this).val() == 'audio') {
			audio_meta.css('display', 'block');
			hide_metabox(audio_meta);
			
		} else if(jQuery(this).val() == 'video') {
			video_meta.css('display', 'block');
			hide_metabox(video_meta);
			
		} else if(jQuery(this).val() == 'image') {
			image_meta.css('display', 'block');
			hide_metabox(image_meta);
			
		} else {
			quote_meta.css('display', 'none');
			video_meta.css('display', 'none');
			link_meta.css('display', 'none');
			audio_meta.css('display', 'none');
			image_meta.css('display', 'none');
		}
		
	});
	
	if(gallery_radio.is(':checked'))
		gallery_meta.css('display', 'block');
	
	if(quote_radio.is(':checked'))
		quote_meta.css('display', 'block');
		
	if(link_radio.is(':checked'))
		link_meta.css('display', 'block');
		
	if(audio_radio.is(':checked'))
		audio_meta.css('display', 'block');
		
	if(video_radio.is(':checked'))
		video_meta.css('display', 'block');
		
	if(image_radio.is(':checked'))
		image_meta.css('display', 'block');
		
	function hide_metabox(current) {
		video_meta.css('display', 'none');
		quote_meta.css('display', 'none');
		link_meta.css('display', 'none');
		audio_meta.css('display', 'none');
		image_meta.css('display', 'none');
		gallery_meta.css('display', 'none');
		current.css('display', 'block');
	}

                var post_type = jQuery('#post_type').val();
                if(post_type == 'gallery'){
                    jQuery('#post-format-aside').css('display', 'none');
                    jQuery('#post-format-aside').next().css('display', 'none');
                    jQuery('#post-format-aside').next().next().css('display', 'none');
                    jQuery('#post-format-audio').css('display', 'none');
                    jQuery('#post-format-audio').next().css('display', 'none');
                    jQuery('#post-format-audio').next().next().css('display', 'none');
                    jQuery('#post-format-link').css('display', 'none');
                    jQuery('#post-format-link').next().css('display', 'none');
                    jQuery('#post-format-link').next().next().css('display', 'none');
                    jQuery('#post-format-quote').css('display', 'none');
                    jQuery('#post-format-quote').next().css('display', 'none');
                    jQuery('#post-format-quote').next().next().css('display', 'none');
                    jQuery('#post-format-image').css('display', 'none');
                    jQuery('#post-format-image').next().css('display', 'none');
                    jQuery('#post-format-image').next().next().css('display', 'none');
                }



});