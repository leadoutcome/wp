jQuery(document).ready(function($) {







	var search_val = $('.searchinput').val();



	$('.searchinput').focus(function(){



		$(this).closest('#dedicated-search').addClass('searchfoucs');



		if($(this).val() == search_val) $(this).val("");



	}).blur(function(){



		$(this).closest('#dedicated-search').removeClass('searchfoucs');



		if($(this).val() === "") { $(this).val(search_val); }



	});







	$('ul.menu-primary li a').append('<span class="bar"></span>');







	$('.menu-primary').after(function(){



		return $('<div id="dedicated-mobile"><a class="trigger" href="#">Navigation<span></span></a></div>').hide();



	});







	$('ul.menu-primary:first').clone().attr('id', 'dedicated-mobilemenu').removeAttr('class').hide().appendTo('#dedicated-mobile');



	$('#dedicated-mobile a.trigger').addClass('close');



	$('#dedicated-mobile a.trigger').click(function(e){
	e.preventDefault();


		$this = $(this);



		if($this.hasClass('close')){



			$this.removeClass('close').addClass('open');



			$this.parent().find('#dedicated-mobilemenu').slideDown();



		} else {



			$this.removeClass('open').addClass('close');



			$this.parent().find('#dedicated-mobilemenu').slideUp();



		}



	});







	$('#dedicated-social a').tipsy({



		gravity : 's',



		fade    : true,



		offset  : 3



	});







	$('.flexslider').flexslider({

		selector          : '.slides > li',

		animation         : 'fade',

		easing            : 'swing',

		direction         : 'horizontal',

		animationLoop     : true,

		smoothHeight       : true,

		startAt           : 0,

		slideshow         : true,

		slideshowSpeed    : 7000,

		animationSpeed    : 600,

		controlNav: false,

        directionNav: false,

		initDelay         : 0,

		pauseOnAction     : false,

		pauseOnHover      : true

	});

	var vimeoPlayers = jQuery('.flexslider1').find('iframe'), player;

		for (var i = 0, length = vimeoPlayers.length; i < length; i++) {

				player = vimeoPlayers[i];

				$f(player).addEvent('ready', ready);

		}



		function addEvent(element, eventName, callback) {

			if (element.addEventListener) {

				element.addEventListener(eventName, callback, false)

			} else {

				element.attachEvent(eventName, callback, false);

			}

		}

		function ready(player_id) {

			var froogaloop = $f(player_id);

			froogaloop.addEvent('play', function(data) {

				jQuery('.flexslider1').flexslider("pause");

			});

			froogaloop.addEvent('pause', function(data) {

				jQuery('.flexslider1').flexslider("play");

			});

		}



		jQuery(".flexslider1")

		.fitVids()

		.flexslider({

			animation: "slide",

			animationLoop: true,

			smoothHeight: true,
			
			slideshow  : false,
			
			useCSS: false,

			controlNav: false,

        	directionNav: true,

			pauseOnHover: true,

			before: function(slider){

				if (slider.slides.eq(slider.currentSlide).find('iframe').length !== 0)

				      $f( slider.slides.eq(slider.currentSlide).find('iframe').attr('id') ).api('pause');

			}

		});

	



	$('body').fitVids();







	$('.dedicated-thumb a').each(function() {



		$(this).fancybox({



			openEffect  : 'fade',



			closeEffect : 'elastic',



			helpers: {



				title : {



					type : 'float'



				}



			},



			overlay : {



				speedIn : 500,



				opacity : 0.90



			}



		});



	});

	

	$('input[name="DOB"]').datepicker();







});