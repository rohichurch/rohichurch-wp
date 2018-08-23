jQuery(document).ready(function($)
{
	// figure out what page we are on and load what we need
	if ($('body').hasClass("toplevel_page_cvg-lp-connect"))
	{
		cvg_lp_connect_load_page();
	}
	else if ($('body').hasClass("cv-outreach_page_cvg-lp-connect_logs"))
	{
		$('#cvg_page_loader').addClass('cvg_hide');
	}
});

function cvg_lp_connect_save_page()
{
	if (!jQuery('#_cvg_lp_connect_site_name').val())
	{
		cvg_lp_connect_err(objectL10n_cvg.enter_site_name);
		return false;
	}

	if ((!jQuery('#_cvg_lp_connect_page_slug').val()) && (jQuery('#_cvg_lp_connect_page_page_id').val() == 0))
	{
		cvg_lp_connect_err(objectL10n_cvg.slug_or_page);
		return false;
	}

	if ((jQuery('#_cvg_lp_connect_page_slug').val()) && (jQuery('#_cvg_lp_connect_page_page_id').val() > 0))
	{
		cvg_lp_connect_err(objectL10n_cvg.slug_page_not_both);
		return false;
	}

	if (jQuery('#cvg_lp_connect_existing_page').val() > 0)
	{
		if ((jQuery('#_cvg_lp_connect_page_slug').val()) || (jQuery('#cvg_lp_connect_existing_page').val() != jQuery('#_cvg_lp_connect_page_page_id').val()))
		{
			cvg_lp_connect_confirm(objectL10n_cvg.page_change, function()
			{
				jQuery('#cvg_lp_connect_existing_page').val(0);
				jQuery('#_cvg_lp_connect_submit').click();
			});

			return false;
		}
	}

	return true;
}

function cvg_lp_connect_load_page()
{
	var site_id = '';
	var q = cvg_lp_connect_query_params();

	if (typeof q.site_id != "undefined")
	{
		site_id = '?site_id='+q.site_id;
	}

	// we rely on this because some enviroments don't allow wp_remote_get calls
	// this should always work not matter what environment
 	jQuery.ajax(
 	{
 		type: "GET",
 		url: objectL10n_cvg.cfg_rest_url+'site'+site_id,
 		data: { }
 	}).done(function( rtn )
 	{
 		if (rtn.status > 0)
 		{
			// if we have multiple sites
			// add list to select which site needs to be worked on
			if (rtn.sites.length > 1)
			{
				var html = '';

				jQuery.each(rtn.sites, function(i, v)
				{
					html += '<li><a href="admin.php?page=cvg-lp-connect&site_id='+v.site_id+'">'+v.name+'</a>';
				});

				if (!jQuery('#cvg_error').html())
					jQuery('#cvg_error').addClass('cvg_hide');

				jQuery('#cvg_site_selector_list').html('<ul>'+html+'</ul>');
				jQuery('#cvg_site_selector').removeClass('cvg_hide');
				jQuery('#cvg_page_loader').addClass('cvg_hide');
			}
			// if we have one site
			// redirect to that site
			else if (rtn.sites.length == 1)
			{
				if (!jQuery('#cvg_error').html())
					jQuery('#cvg_error').addClass('cvg_hide');

				window.location.href = 'admin.php?page=cvg-lp-connect&site_id='+rtn.sites[0].site_id;
			}
			else
			{
				if (!jQuery('#cvg_error').html())
					jQuery('#cvg_error').addClass('cvg_hide');

				jQuery('#_cvg_lp_connect_site_id').val(rtn.site_id);
				jQuery('#cvg_lp_connect_site_name').html('('+rtn.name+')');
				jQuery('#_cvg_lp_connect_endpoint_name').val(rtn.name);

				jQuery('#cvg_site_form').removeClass('cvg_hide');
				jQuery('#_cvg_lp_connect_submit').on('click', function()
				{
					return cvg_lp_connect_save_page();
				});
				jQuery('.color-rgba').colorpicker({ format: 'rgba' });
				jQuery('.color-hex').colorpicker({ format: 'hex' });
				jQuery('.cvg-slider').bootstrapSlider(
				{
					formatter: function(value)
					{
						return 'Current value: ' + value;
					}
				});

				jQuery('input').on('change', function()
				{
					jQuery('#_cvg_lp_connect_preview_disable').removeClass('cvg_hide');
				});

				// this set tmpl based on which tab is active
				jQuery('.tab-tmpls a').click(function()
				{
					jQuery('#_cvg_lp_connect_tmpl').val(jQuery(this).attr('data-tmpl-id'));
					jQuery('#_cvg_lp_connect_preview_disable').removeClass('cvg_hide');
				});

				// this sets image uploader
				jQuery('.cvg-media').on('click', function()
				{
					var media_input = jQuery(this);

					// If the media frame already exists, reopen it.
					if (media_input.cvg_file_frame)
					{
						media_input.cvg_file_frame.open();
						return;
					}

					// Create the media frame.
					media_input.cvg_file_frame = wp.media.frames.file_frame = wp.media(
					{
						title: jQuery("label[for='"+media_input.attr("id")+"']").html(),
						multiple: false
					});

					// When an image is selected, run a callback.
					media_input.cvg_file_frame.on('select', function()
					{
						var attachment = media_input.cvg_file_frame.state().get('selection').first().toJSON();
						media_input.val(attachment.url).trigger('change');
					});

					media_input.cvg_file_frame.open();
				});

				// this sets default image selector
				jQuery('.default-images').on('click', function(e)
				{
					e.preventDefault();
					var img_urls = objectL10n_cvg.cfg_js_url+'connect/v'+jQuery(this).attr('data-plugin-version')+'/'+jQuery(this).attr('data-tmpl-folder')+'/';
					var img_input = jQuery("input[name='"+jQuery(this).attr('data-input')+"']");

					jQuery('#modal_default_images').find('.modal-body').html(objectL10n_cvg.loading_imgs);
					jQuery('#modal_default_images').modal('show');

					jQuery.ajax(
					{
						type: "GET",
						url: img_urls,
						jsonp: true
					}).done(function( rtn )
					{
						var imgs = '';

						jQuery.each(rtn, function(i, v)
						{
							if (v.indexOf('_thumb') >= 0)
								imgs += '<img src="'+img_urls+v+'" class="default-image" data-source="'+img_urls+v.replace('_thumb','')+'" />';
						});

						jQuery('#modal_default_images').find('.modal-body').html(imgs);

						jQuery('.default-image').on('click', function(e)
						{
							img_input.val(jQuery(this).attr('data-source'));
							jQuery('#modal_default_images').modal('hide');
						})

					}).fail(function(jqXHR, textStatus, errorThrow)
					{
						jQuery('#modal_default_images').find('.modal-body').html(objectL10n_cvg.unable_to_connect);
					});
				});

				// set click for page previews
				jQuery('.cvg-page-preview').on('click', function(e)
				{
					var page_id = jQuery(this).attr('id').replace("_cvg_lp_connect_page_id_", "");

					// set all links to standard
					jQuery('.cvg-page-preview').removeClass('selected-page');

					// set selected link
					jQuery(this).addClass('selected-page');
				});

				jQuery('#cvg_page_loader').addClass('cvg_hide');
			}
 		}
 		else if (rtn.status == -1)
 		{
			jQuery('#cvg_error').html(objectL10n_cvg.multiple_sites);
			jQuery('#cvg_page_loader').addClass('cvg_hide');
 		}
 		else
 		{
			jQuery('#cvg_error').html(objectL10n_cvg.not_set_before + rtn.host + objectL10n_cvg.not_set_end);
			jQuery('#cvg_page_loader').addClass('cvg_hide');
		}
 	}).error(function( rtn )
 	{
		jQuery('#cvg_error').html(objectL10n_cvg.unable_to_connect);
		jQuery('#cvg_page_loader').addClass('cvg_hide');
 	});
}

function cvg_lp_connect_confirm(msg, callback)
{
	jQuery('#modal_confirm').find('.modal-body').html(msg);

	jQuery('#myModalConfirm_no').click(function()
	{
		jQuery('#modal_confirm').modal('hide');
	});

	jQuery('#myModalConfirm_yes').click(function()
	{
		jQuery('#modal_confirm').modal('hide');

		if(callback && typeof callback == "function")
			callback();
	});

	jQuery('#modal_confirm').modal('show');
}

function cvg_lp_connect_err(err)
{
	jQuery('#modal_error').find('.modal-body').html(err);
	jQuery('#modal_error').modal('show');
}

function cvg_lp_connect_load_script(url, callback)
{
	var script = document.createElement( "script" )
	script.type = "text/javascript";

	if(script.readyState)
	{  //IE
		script.onreadystatechange = function()
		{
			if ( script.readyState === "loaded" || script.readyState === "complete" )
			{
				script.onreadystatechange = null;
				callback();
			}
		};
	}
	else
	{  //Others
		script.onload = function()
		{
			callback();
		};
	}

	script.src = url;
	document.getElementsByTagName( "head" )[0].appendChild( script );
}

/* returns query parameters from the URL */
function cvg_lp_connect_query_params()
{
	var qs = document.location.search.split('+').join(' ');

	var params = {},
		tokens,
		re = /[?&]?([^=]+)=([^&]*)/g;

	while (tokens = re.exec(qs))
	{
		params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
	}

	return params;
}
