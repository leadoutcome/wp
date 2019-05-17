jQuery(document).ready(function(){
	
	var form = jQuery("#overplay_main_form").show();
     
    form.steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        enableAllSteps: ((jQuery("#name").val().length>0)?true:false),
		showFinishButtonAlways: ((jQuery("#name").val().length>0)?true:false),
        onInit: function (event, currentIndex, newIndex)
        {
			if(getUrlParameter('tab')>0)
			{
				var tab = getUrlParameter('tab');
				var count = (tab-currentIndex);
				while(count>0)
				{
					count--;
					form.steps("next");
				}
					
				
				//jQuery("#overplay_main_form").steps("getStep",{index:getUrlParameter('tab')});
				//jQuery("#overplay_main_form").getStep(getUrlParameter('tab'));
			}
			
			jQuery(".step_selector").each(function(){
				if(jQuery(this).is(":checked"))
				{
					form.steps("add", {
							   title: jQuery("#"+jQuery(this).attr("step_index")+" h3").text(),
							   content: jQuery("#"+jQuery(this).attr("step_index")+" section").html()
							});
					jQuery("#"+jQuery(this).attr("step_index")+" section").html(" ");		
				}
			});
		},
        onStepChanging: function (event, currentIndex, newIndex)
        {
			// Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex)
            {
                return true;
            }
            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex)
            {
                // To remove error styles
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex)
        {
			
            // Used to skip the "Warning" step if the user is old enough.
            resizeJquerySteps();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            form.submit();
        }
    }).validate({
        errorPlacement: function errorPlacement(error, element) { element.after(error); },
        rules: {
            confirm: {
                equalTo: "#password-2"
            }
        }
    });
	
	jQuery('.wizard .content').animate({ height: jQuery('.body.current').outerHeight() }, "slow");
	jQuery('.backlink, .nextlink, .finishlink').show();

	jQuery(".nextlink").click(function (){
		jQuery("#overplay_main_form").steps("next");
	});
	jQuery(".finishlink").click(function (){
		jQuery("#overplay_main_form").steps("finish");
	});
	jQuery(".backlink").click(function (){
		jQuery("#overplay_main_form").steps("previous");
	});
	
	function resizeJquerySteps() {
                jQuery('.wizard .content').animate({ height: jQuery('.body.current').outerHeight() }, "slow");
	}
	
	//media uploader starts
	
	if (jQuery('.vop_media_buttons').length > 0) {
		if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
			jQuery('body').on("click",".vop_media_buttons",function(e) {
				e.preventDefault();
				var button = jQuery(this);
				var id = button.prev(".image_upload");
				var image = wp.media({ 
					title: 'Upload Image',
					// mutiple: true if you want to upload multiple files at once
					multiple: false
				}).open()
				.on('select', function(e){
					// This will return the selected image from the Media Uploader, the result is an object
					var uploaded_image = image.state().get('selection').first();
					// We convert uploaded_image to a JSON object to make accessing it easier
					// Output to the console uploaded_image
					//console.log(uploaded_image);
					var image_url = uploaded_image.toJSON().url;
					// Let's assign the url value to the input field
					id.val(image_url);
				});
				
				
			});
		}
	};
	//media uploader ends
	
	//http://www.webmaster-source.com/2010/01/08/using-the-wordpress-uploader-in-your-plugin-or-theme/
	
	//color picker
	
	
	jQuery(".vop_hideme").hide();
	
	jQuery(".vop_hideme").hide();
	
	jQuery("body").on("click",".ar_radio",function (){
		jQuery(".vop_hideme").hide();
		jQuery(".vop_hideme2").hide();
		//console.log(jQuery(this).attr('data'));
		if(jQuery(this).attr('data').length>0)
		{
			if(jQuery(this).is(':checked'))
				jQuery("#"+jQuery(this).attr('data')).show();
			else
				jQuery("#"+jQuery(this).attr('data')).hide();
		}	
		resizeJquerySteps();
	});
	
	function getUrlParameter(sParam)
	{
		var sPageURL = window.location.search.substring(1);
		var sURLVariables = sPageURL.split('&');
		for (var i = 0; i < sURLVariables.length; i++) 
		{
			var sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] == sParam) 
			{
				return sParameterName[1];
			}
		}
	}
	
	jQuery(".step_selector").change(function(){
		if(jQuery(this).is(":checked"))
		{
			form.steps("add", {
					   title: jQuery("#"+jQuery(this).attr("step_index")+" h3").text(),
					   content: jQuery("#"+jQuery(this).attr("step_index")+" section").html()
					});
			jQuery("#"+jQuery(this).attr("step_index")+" section").html(" ");
			
			
		}
		else
		{
			var title = jQuery("#"+jQuery(this).attr("step_index")+" h3").text();
			for (i = 0; i < 10; i++) {
				if(form.steps("getStep", i).title == title)
				{
					//console.log(jQuery("#"+jQuery(this).attr("step_index")+" section").html());
					jQuery("#"+jQuery(this).attr("step_index")+" section").html(form.steps("getStep", i).content)
					//console.log(jQuery("#"+jQuery(this).attr("step_index")+" section").html());
					form.steps("remove", i);
				}
			}
			
		}
		jQuery(".video_viewer").colorbox({iframe:true, innerWidth:665, innerHeight:400});
	});
	// Color Picker
	
	jQuery('body').on("click",".pickcolor",function(e) {
       colorPicker = jQuery(this).next('span');
       input = jQuery(this).prev('input');
       jQuery(colorPicker).farbtastic(input);
       colorPicker.show();
	   console.log('test');
       e.preventDefault();
       jQuery(document).mousedown( function() {
           jQuery(colorPicker).hide();
		   resizeJquerySteps();
       });
   });
   
   jQuery('body').on("keyup",".color-input",function() {
   			var _hex = jQuery(this).val(), hex = _hex;
   			if ( hex.charAt(0) != '#' )
   				hex = '#' + hex;
   			hex = hex.replace(/[^#a-fA-F0-9]+/, '');
   			if ( hex != _hex )
   				jQuery(this).val(hex);
   			if ( hex.length == 4 || hex.length == 7 )
   				jQuery(this).css('background-color', hex );
   			else
      			jQuery(this).css('background-color', '');
   		});
	
	jQuery('body').on("click","document, .colorpicker, .wp-color-result, .pickcolor",function (){
		resizeJquerySteps();
	});
	
	jQuery(".color-input").each(function(){
		jQuery(this).css('background-color', jQuery(this).val() );
	});
	
	jQuery("body").on("click",".animation_show",function(){
		div = colorPicker = jQuery(this).next('div');
		div.toggle();
		resizeJquerySteps();
	})
	jQuery("body").on("click",".animation_show2",function(){
		div = colorPicker = jQuery(this).next('span');
		div.toggle();
		resizeJquerySteps();
	})
	
});

