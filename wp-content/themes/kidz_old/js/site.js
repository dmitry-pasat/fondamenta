(function ($, root, undefined) {
	"use strict";

	$('.woocommerce-tabs .tabs li a').click(function () {
		var _ = $(this);
		var $tab = $(_.attr('href'));
		var $li = $(this).parent('li');
		if ($li.hasClass('active') && $(window).width() < 992 && $tab.hasClass('current')) {
			$li.parent('ul').toggleClass('expand');
		} else {
			$('.woocommerce-tabs .tabs li.active').removeClass('active');
			$li.addClass('active');
			$('.woocommerce-tabs .current').removeClass('current');
			setTimeout(function () {
				$tab.addClass('current');
			}, 100);
			$li.parent('ul').removeClass('expand');
		}
	});

	$(function () {

		$(document).on('click', ".product-categories > ul li.has-children > a, .product-categories > ul li.menu-item-has-children > a", function () {
			var $b = $('body');
			if ($(this).closest('.sub-menu .sub-menu').length > 0) {
				return true;
			}
			if ($(window).width() >= 992) {
				return true;
			}
			if ($b.hasClass('submenu-open')) {
				$b.addClass('sub-submenu-open');
				$('.product-categories > ul > li > ul > li.selected').removeClass('selected');
				$(this).closest('li').addClass('selected');
			} else {
				$b.addClass('submenu-open');
				$('.product-categories > ul > li.selected').removeClass('selected');
				$(this).closest('li').addClass('selected');
			}

			return false;
		});

		$('select.styled, .variations select').customSelect();

		$(".variations_form").on("woocommerce_variation_select_change", function () {
			$(".variations_form select").each(function () {
				$(this).next('span.customSelect').html($(this).find(':selected').html());
			});

			if (typeof $slick_product_single != 'undefined' && $slick_product_single.length) {
				setTimeout(function () {
					$slick_product_single.slick('slickGoTo', 0, false);
					var $fisrtSlide = $slick_product_single_slides.first().children('a');
					$("<img/>")
						.attr("src", $fisrtSlide.attr('href'))
						.load(function () {
							$fisrtSlide.attr('data-size', this.width + 'x' + this.height);
						});
				}, 500);
			}
		});

		$("#header .mobile-menu-back").click(function () {
			var b = $('body');
			if (b.hasClass("sub-submenu-open")) {
				b.removeClass("sub-submenu-open");
			} else if (b.hasClass("submenu-open")) {
				b.removeClass("submenu-open");
			}

			return false;
		});

		var ideaparkStickHeight = 0;
		var needUpdateIdeaparkStickHeight = false;
		var ideaparkStickyNavTimeout = null;
		var ideaparkFixLogoTimeout = null;
		var ideaparkSubmenuTimeout = null;
		var ideaparkBannersTimeout = null;
		var ideaparkMegamenuTimeout = null;
		var lastBannerIndex = 0;

		var ideapsrk_submenu_direction = function () {
			if ($(window).width() < 992) {
				return true;
			}
			var $nav = $('.product-categories > ul');
			if ($nav.length) {
				var nav_center = Math.round($nav.offset().left + $nav.width() / 2 - 40);
				$nav.children('li').each(function () {
					var _ = $(this);
					if (_.offset().left <= nav_center && !_.hasClass('ltr')) {
						_.removeClass('rtl');
						_.addClass('ltr');
					}
					if (_.offset().left > nav_center && !_.hasClass('rtl')) {
						_.removeClass('ltr');
						_.addClass('rtl');
					}
				});
			}

			ideaparkSubmenuTimeout = null;
		};

		ideapsrk_submenu_direction();

		var ideapark_megamenu = function () {
			var $w = $(window);
			if ($w.width() >= 992) {
				var $uls = $('.main-menu .product-categories > ul > li[class*="col-"] > ul');
				if ($uls.length) {
					var $container = $('.main-menu .container').first();
					var container_left = $container.offset().left;
					var container_right = container_left + $container.width();

					$uls.each(function () {
						var delta;
						var _ = $(this);

						if (!_.attr('data-left')) {
							_.attr('data-left', _.css('left'));
						} else {
							_.css({
								left: _.attr('data-left')
							});
						}

						var ul_left = _.offset().left;
						var ul_right = ul_left + _.width();

						if (ul_left < container_left) {
							delta = Math.round(parseInt(_.attr('data-left').replace('px', '')) + container_left - ul_left + 1);
							_.css({
								left: delta
							});
						}
						if (ul_right > container_right) {
							delta = Math.round(parseInt(_.attr('data-left').replace('px', '')) - ul_right + container_right - 1);
							_.css({
								left: delta
							});
						}
					});
				}
			}

			if ($w.width() > 600 && $w.width() < 992) {
				var max_height = 0;
				var count = 0;
				$('.custom-advantages-widget').each(function () {
					var height = $(this).outerHeight();
					if (height > max_height) {
						max_height = height;
					}
					count++;
				});

				if (max_height > 0) {
					$('.custom-advantages-widget').each(function () {
						var height = $(this).outerHeight();
						if (height < max_height) {
							$(this).css({
								height: max_height + '.px'
							}).addClass('set-height');
						}
						if (count == 2) {
							$(this).css({
								width: '50%'
							}).addClass('set-height');
						} else if (count == 1) {
							$(this).css({
								width: '100%'
							}).addClass('set-height');
						}
					});
				}
			} else {
				$('.custom-advantages-widget.set-height').each(function () {
					$(this).css({
						height: 'auto',
						width : ''
					}).removeClass('set-height');
				});
			}
			$('.custom-advantages-widget.inv').removeClass('inv');
			ideaparkMegamenuTimeout = null;
		};

		ideapark_megamenu();

		$(window).on('resize', function () {
			if (!ideaparkMegamenuTimeout) ideaparkMegamenuTimeout = setTimeout(ideapark_megamenu, 200);
		});

		if (ideapark_wp_vars.stickyMenu) {
			var ideapark_stickyNav = function () {
				if (ideaparkStickHeight) {
					var scrollTop = $(window).scrollTop();
					var $body = $("body");
					var is_modal_open = $body.hasClass('menu-open') || $body.hasClass('sidebar-open');

					if (scrollTop > ideaparkStickHeight && !$body.hasClass('sticky')) {
						$('#header').css({height: ideaparkStickHeight});

						if (!is_modal_open) {
							$('#header .main-menu').hide();
						}
						$body.addClass('sticky');
						if (!is_modal_open) {
							$('#header .main-menu').fadeTo(300, 1);
						}
					} else if (scrollTop <= ideaparkStickHeight && $body.hasClass('sticky')) {
						$body.removeClass('sticky');
						if (needUpdateIdeaparkStickHeight) {
							$('#header').css({height: 'inherit'});
							ideaparkStickHeight = $('#header').outerHeight();
							needUpdateIdeaparkStickHeight = false;
						}
					}
				}
				ideapark_megamenu();
				ideaparkStickyNavTimeout = null;
			};

			ideapark_stickyNav();

			$(window).on('scroll resize', function () {
				if (!ideaparkStickyNavTimeout) ideaparkStickyNavTimeout = setTimeout(ideapark_stickyNav, 100);
			});

			$('#header .logo').waitForImages().done(function () {
				ideaparkStickHeight = $('#header').outerHeight();
				ideapark_stickyNav();
			});
		}

		var ideapark_banners = function () {
			var $home_banners = $('#home-banners');
			var $w = $(window);

			if ($home_banners.length == 1 && $w.width() <= 991) {
				var wst = $w.scrollTop();
				var wh = $w.height();
				var bh = $('.banner', $home_banners).first().outerHeight();
				var bot = $home_banners.offset().top;
				var mmh = $('body').hasClass('sticky') ? $('.main-menu').outerHeight() + 50 : 0;
				var delta = (bot - mmh) - (bot + bh - wh);
				var index = Math.round((wst - (bot + bh - wh)) / delta * 4);

				if (wst < bot - mmh && wst >= bot + bh - wh || lastBannerIndex != index || wst < bot + bh - wh && lastBannerIndex != 1 || wst > bot - mmh && lastBannerIndex != 4) {
					if (index <= 0) {
						index = 1;
					} else if (index >= 4) {
						index = 4;
					}
					if (!$home_banners.hasClass('shift-' + index)) {
						$home_banners.removeClass();
						$home_banners.addClass('shift-' + index);
					}
					lastBannerIndex = index;
				}
			}

			ideaparkBannersTimeout = null;
		};

		ideapark_banners();

		$(window).on('scroll resize', function () {
			if (!ideaparkBannersTimeout) ideaparkBannersTimeout = setTimeout(ideapark_banners, 100);
		});

		var bgss = new bgsrcset();

		bgss.init('.bgimg');


		$(window).on('resize', function () {
			if (!ideaparkSubmenuTimeout) ideaparkSubmenuTimeout = setTimeout(ideapsrk_submenu_direction, 100);
			needUpdateIdeaparkStickHeight = true;
			$('#header').css({height: 'inherit'});
		});

		$(document).on('click', '.mobile-menu, .mobile-menu-close, .menu-open .menu-shadow', function () {
			$('body').toggleClass('menu-open');
			$('html').toggleClass('menu-open');
			return false;
		});

		$(document).on('click', '.mobile-sidebar, .mobile-sidebar-close', function () {
			$('body').toggleClass('sidebar-open');
			$('html').toggleClass('sidebar-open');
			return false;
		});

		$(document).on('click', ".collaterals .coupon .header a", function () {
			var $coupon = $(".collaterals .coupon");
			$coupon.toggleClass('opened');
			if ($coupon.hasClass('opened')) {
				setTimeout(function () {
					$coupon.find('input[type=text]').first().focus();
				}, 500);
			}
			return false;
		});

		$(document).on('click', ".collaterals .shipping-calculator .header a", function () {
			$(this).closest('.shipping-calculator').toggleClass('opened');
		});

		$(document).on('click', "#ip-checkout-apply-coupon", function () {
			var $form = $(this).closest('form');

			if ($form.is('.processing')) {
				return false;
			}

			$form.addClass('processing').block({
				message   : null,
				overlayCSS: {
					background: '#fff',
					opacity   : 0.6
				}
			});

			var data = {
				security   : wc_checkout_params.apply_coupon_nonce,
				coupon_code: $form.find('input[name="coupon_code"]').val()
			};

			$.ajax({
				type    : 'POST',
				url     : wc_checkout_params.wc_ajax_url.toString().replace('%%endpoint%%', 'apply_coupon'),
				data    : data,
				success : function (code) {
					$('.woocommerce-error, .woocommerce-message').remove();
					$form.removeClass('processing').unblock();

					if (code) {
						$form.before(code);
						$(".collaterals .coupon.opened").removeClass('opened');
						$(document.body).trigger('update_checkout', {update_shipping_method: false});
					}
				},
				dataType: 'html'
			});

			return false;
		});

		$('#customer_login .tab-header').click(function () {
			$('#customer_login .tab-header.active').removeClass('active');
			$(this).addClass('active');
			$('#customer_login .wrap li.active').removeClass('active');
			$('#customer_login .wrap li.' + $(this).data('tab-class')).addClass('active');
			return false;
		});

		$(".product-categories > ul").append('<li class="space-item"></li>');

		$('#header .top-menu .menu > li').each(function () {
			$(".product-categories > ul").append($(this).clone());
		});

		var ajaxScrollTop = 0;

		$(document).on('click', '#header .search, #header .mobile-search, #search-close', function () {
			if (!$('body').hasClass('search-open')) {
				ajaxScrollTop = $(window).scrollTop();
			}

			$('body').toggleClass('search-open');
			$('html').toggleClass('search-open');
			if (!$('body').hasClass('search-open')) {
				$('html,body').scrollTop(ajaxScrollTop);
			} else {
				$("#ajax-search-input").focus();
			}

			if (!$("#ajax-search-result").text() && $("#ajax-search-input").val().trim()) {
				ajaxSearchFunction();
			}
			return false;
		});

		$("#ip-wishlist-share-link").focus(function () {
			$(this).select();
		});

		$('.menu-item').click(function () {
			$(this).toggleClass('open');
		});

		var $tabs = $(".woocommerce-tabs .tabs li");
		var maxTabWidth;

		if ($tabs.length) {
			maxTabWidth = 0;
			$tabs.each(function () {
				var _ = $(this);
				if (_.outerWidth() > maxTabWidth) {
					maxTabWidth = _.outerWidth();
				}
			});

			$(".woocommerce-tabs .tabs").css({width: maxTabWidth + 10});
		}

		$tabs = $(".home-tabs li");
		if ($tabs.length) {
			maxTabWidth = 0;
			$tabs.each(function () {
				var _ = $(this);
				if (_.outerWidth() > maxTabWidth) {
					maxTabWidth = _.outerWidth();
				}
			});

			$(".home-tabs").css({width: maxTabWidth + 10});
		}

		if (ideapark_wp_vars.sliderEnable) {

			var $slick = $('.slick');

			var $first_slide = $('.slick .bgimg').first();
			if ($first_slide.length == 1) {
				var src = $first_slide.css('background-image');
				var url = src.match(/\((.*?)\)/)[1].replace(/('|")/g, '');

				var img = new Image();
				img.onload = function () {
					if ($slick.hasClass('preloading')) {
						$slick.on('init', function () {
							$('.slick .slick-slide.slick-current').addClass('slide-visible');
							$slick.removeClass('preloading');
						});

						$slick.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
							$('.slick .slick-slide.slide-visible').removeClass('slide-visible');
						});

						$slick.on('afterChange', function (event, slick, currentSlide) {
							$('.slick .slick-slide.slick-current').addClass('slide-visible');
						});

						$slick.on('transitionend webkitTransitionEnd oTransitionEnd', function () {
							$('.slick-preloader').hide();
						});

						$slick.slick({
							dots         : true,
							infinite     : true,
							speed        : ideapark_wp_vars.sliderSpeed,
							autoplay     : ideapark_wp_vars.sliderInterval > 0,
							autoplaySpeed: ideapark_wp_vars.sliderInterval,
							slidesToShow : 1,
							fade         : ideapark_wp_vars.sliderEffect == 'fade',
							prevArrow    : '<a class="slick-prev"><span><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-angle-left" /></svg></span></a>',
							nextArrow    : '<a class="slick-next"><span><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-angle-right" /></svg></span></a>'
						});
					}
				};
				img.src = url;
				if (img.complete) {
					img.onload();
				}
			}
		}

		if ($('.slick-brands').length) {
			$('.slick-brands').on('init', function () {
				$('.slick-brands.preloading').removeClass('preloading');
			});
			$('.slick-brands').slick({
				dots          : false,
				infinite      : false,
				slidesToShow  : 6,
				slidesToScroll: 6,
				prevArrow     : '<a class="slick-prev"><span><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-angle-left" /></svg></span></a>',
				nextArrow     : '<a class="slick-next"><span><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-angle-right" /></svg></span></a>',
				responsive    : [
					{
						breakpoint: 1200,
						settings  : {
							slidesToShow  : 5,
							slidesToScroll: 5
						}
					},
					{
						breakpoint: 992,
						settings  : {
							slidesToShow  : 4,
							slidesToScroll: 4
						}
					},
					{
						breakpoint: 690,
						settings  : {
							slidesToShow  : 3,
							slidesToScroll: 3,
							dots          : true
						}
					},
					{
						breakpoint: 480,
						settings  : {
							slidesToShow  : 2,
							slidesToScroll: 2,
							dots          : true
						}
					},
					{
						breakpoint: 320,
						settings  : {
							slidesToShow  : 1,
							slidesToScroll: 1,
							dots          : true
						}
					}
				]
			});
		}

		if ($('.slick-review').length) {
			$('.slick-review').on('init', function () {
				$('.slick-review.preloading').removeClass('preloading');
			});
			$('.slick-review').slick({
				dots          : false,
				infinite      : true,
				slidesToShow  : 1,
				adaptiveHeight: true,
				prevArrow     : '<a class="slick-prev"><span><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-angle-left" /></svg></span></a>',
				nextArrow     : '<a class="slick-next"><span><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-angle-right" /></svg></span></a>',
				responsive    : [
					{
						breakpoint: 480,
						settings  : {
							dots: true
						}
					}
				]
			});
		}

		var $slick_product_single = $('.slick-product-single');
		var $slick_product_single_slides = $('.slide', $slick_product_single);
		var product_thumbnails_click = false;

		if ($slick_product_single.length) {
			$slick_product_single.on('init', function () {
				$('.slick-product-single.preloading').removeClass('preloading');

				$slick_product_single_slides.bind('click', function (e) {
					if ($slick_product_single.hasClass('animating')) {
						return;
					}
					e.preventDefault();

					var index = $(this).index();
					if (ideapark_wp_vars.shopProductModal) {
						ideapark_open_photo_swipe(this, index);
					}
				});
			});
			$slick_product_single.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
				if (!product_thumbnails_click) {
					$slick_product_thumbnails_slides.eq(nextSlide).trigger('click');
				}
				product_thumbnails_click = false;

				$slick_product_single.addClass('animating');
			});
			$slick_product_single.on('afterChange', function () {
				$slick_product_single.removeClass('animating');
			});
			$slick_product_single.slick({
				dots          : false,
				infinite      : false,
				slidesToShow  : 1,
				slidesToScroll: 1,
				adaptiveHeight: true,
				prevArrow     : '<a class="slick-prev"><span><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-angle-left" /></svg></span></a>',
				nextArrow     : '<a class="slick-next"><span><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-angle-right" /></svg></span></a>'
			});
		}

		var $slick_product_thumbnails = $('.slick-product');
		var $slick_product_thumbnails_slides = $('.slide', $slick_product_thumbnails);
		if ($slick_product_thumbnails.length) {
			$slick_product_thumbnails.on('init', function () {
				$slick_product_thumbnails_slides.bind('click', function () {
					var _ = $(this);

					if ($slick_product_single.hasClass('animating') || _.hasClass('current')) {
						return;
					}

					product_thumbnails_click = true;

					$('.slide.current', $slick_product_thumbnails).removeClass('current');
					_.addClass('current');

					if (!_.next().hasClass('slick-active')) {
						$slick_product_thumbnails.slick('slickNext');
					} else if (!_.prev().hasClass('slick-active')) {
						$slick_product_thumbnails.slick('slickPrev');
					}

					$slick_product_single.slick('slickGoTo', _.index(), false);
				});
			});
			$slick_product_thumbnails.slick({
				dots          : false,
				arrows        : false,
				infinite      : false,
				slidesToShow  : 5,
				slidesToScroll: 1,
				adaptiveHeight: false,
				vertical      : true,
				focusOnSelect : false,
				draggable     : false,
				touchMove     : false
			});
		}

		var ideapark_open_photo_swipe = function (imageWrap, index) {
			var $this, $a, $img, items = [], size, item;
			$slick_product_single_slides.each(function () {
				$this = $(this);
				$a = $this.children('a');
				$img = $a.children('img');
				size = $a.data('size').split('x');

				item = {
					src : $a.attr('href'),
					w   : parseInt(size[0], 10),
					h   : parseInt(size[1], 10),
					msrc: $img.attr('src'),
					el  : $a[0]
				};

				items.push(item);
			});

			var options = {
				index              : index,
				showHideOpacity    : true,
				bgOpacity          : 1,
				loop               : false,
				closeOnVerticalDrag: false,
				mainClass          : ($slick_product_single_slides.length > 1) ? 'pswp--minimal--dark' : 'pswp--minimal--dark pswp--single--image',
				barsSize           : {top: 0, bottom: 0},
				captionEl          : false,
				fullscreenEl       : false,
				zoomEl             : false,
				shareE1            : false,
				counterEl          : false,
				tapToClose         : true,
				tapToToggleControls: false
			};

			var pswpElement = $('.pswp')[0];

			var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
			gallery.init();

			gallery.listen('initialZoomIn', function () {
				$(this).product_thumbnails_speed = $slick_product_thumbnails.slick('slickGetOption', 'speed');
				$slick_product_thumbnails.slick('slickSetOption', 'speed', 0);
			});

			var slide = index;
			gallery.listen('beforeChange', function (dirVal) {
				slide = slide + dirVal;
				$slick_product_single.slick('slickGoTo', slide, true);
			});
			gallery.listen('close', function () {
				$slick_product_thumbnails.slick('slickSetOption', 'speed', $(this).product_thumbnails_speed);
			});
		};

		if ($.fn.masonry) {
			var $grid = $('.grid.masonry');

			if ($grid.length) {
				$grid.masonry({
					itemSelector   : '.post, .page, .product',
					columnWidth    : '.post-sizer',
					percentPosition: true
				});

				$grid.imagesLoaded().progress(function () {
					$grid.masonry('layout');
				});

				$grid.imagesLoaded(function () {
					$grid.masonry('layout');
				});
			}
		}

		$(".container").fitVids();

		var ajaxSearchFunction = ideapark_debounce(function () {
			$.ajax({
				url    : ideapark_wp_vars.ajaxUrl,
				type   : 'POST',
				data   : {
					action: 'ideapark_ajax_search',
					s     : $("#ajax-search-input").val()
				},
				success: function (results) {
					$("#ajax-search-result").html(results);
				}
			});

		}, 250);

		$("#ajax-search-input").on('input', function () {
			var _ = $(this);
			if (_.val().trim()) {
				ajaxSearchFunction();
			} else {
				$("#ajax-search-result").html('');
			}

		}).on('keydown', function (event) {
			if (event.keyCode == 13) {
				event.preventDefault();
				if ($("#ajax-search-input").val().trim()) {
					$("#ajax-search form").submit();
				}
			} else if (event.keyCode == 27) {
				$('#mobilesearch-close').trigger('click');
			}
		});

		$("#ajax-search form").on('submit', function () {
			if (!$("#ajax-search-input").val().trim()) {
				return false;
			}
		});

		$('.home-tabs li a').click(function () {
			var _ = $(this);
			var $tab = $(_.attr('href'));
			var $li = $(this).parent('li');
			$tab.find('[data-src]').each(function(){
				var $this = $(this);
				$this.attr('srcset', $this.attr('data-srcset'));
				$this.attr('src', $this.attr('data-src'));
				$this.removeAttr('data-srcset');
				$this.removeAttr('data-src');
			});
			if ($li.hasClass('current')) {
				$li.parent('ul').toggleClass('expand');
				return false;
			}
			$('.home-tabs li.current').removeClass('current');
			$li.addClass('current');
			$('.home-tab.current').removeClass('current');
			$('.home-tab.visible').removeClass('visible');
			$tab.addClass('visible');
			setTimeout(function () {
				$tab.addClass('current');
			}, 100);
			$li.parent('ul').removeClass('expand');
			return false;
		});


		$('.ip-watch-video-btn').click(function () {

			var $body = $('body'),
				$container = $('#ip-quickview'),
				$video_code = $("#ip_hidden_product_video");

			if ($body.hasClass('quickview-open') || $video_code.length != 1) {
				return false;
			}

			var $shadow = $('<div id="ip-quickview-shadow" class="loading"><div class="ip-shop-loop-loading"><i></i><i></i><i></i></div></div>');
			$body.append($shadow);
			$body.addClass('quickview-open');

			$container.html($video_code.val());

			$container.fitVids();

			$.magnificPopup.open({
				mainClass   : 'ip-mfp-quickview ip-mfp-fade-in',
				closeMarkup : '<a class="mfp-close ip-mfp-close video"><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-close-light" /></svg></a>',
				removalDelay: 180,
				items       : {
					src : $container,
					type: 'inline'
				},
				callbacks   : {
					open       : function () {
						$shadow.removeClass('loading');
						$shadow.one('touchstart', function () {
							$.magnificPopup.close();
						});
					},
					beforeClose: function () {
						$shadow.addClass('mfp-removing');
					},
					close      : function () {
						$shadow.remove();
						$body.removeClass('quickview-open');
					}
				}
			});

			return false;
		});

		$('.ip-quickview-btn').click(function () {
			var $body = $('body'),
				$container = $('#ip-quickview'),
				ajaxUrl,
				productId = $(this).data('product_id'),
				data = {
					product_id: productId
				};

			if ($body.hasClass('quickview-open')) {
				return false;
			}

			if (productId) {
				var $shadow = $('<div id="ip-quickview-shadow" class="loading"><div class="ip-shop-loop-loading"><i></i><i></i><i></i></div></div>');
				$body.append($shadow);
				setTimeout(function () {
					$body.addClass('quickview-open');
				}, 100);

				if (typeof wc_add_to_cart_params !== 'undefined') {
					ajaxUrl = wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'ip_ajax_load_product');
				} else {
					ajaxUrl = ip_wp_vars.ajaxUrl;
					data.action = 'ip_ajax_load_product';
				}

				root.ip_quickview_get_product = $.ajax({
					type      : 'POST',
					url       : ajaxUrl,
					data      : data,
					dataType  : 'html',
					cache     : false,
					headers   : {'cache-control': 'no-cache'},
					beforeSend: function () {
						if (root.window.ip_quickview_get_product === 'object') {
							root.ip_quickview_get_product.abort();
						}
					},
					error     : function (XMLHttpRequest, textStatus, errorThrown) {
						$shadow.remove();
						$body.removeClass('quickview-open');
					},
					success   : function (data) {

						$container.html(data);


						$.magnificPopup.open({
							mainClass   : 'ip-mfp-quickview ip-mfp-fade-in',
							closeMarkup : '<a class="mfp-close ip-mfp-close"><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-close-light" /></svg></a>',
							removalDelay: 300,
							items       : {
								src : $container,
								type: 'inline'
							},
							callbacks   : {
								open       : function () {
									$shadow.removeClass('loading');
									$shadow.one('touchstart', function () {
										$.magnificPopup.close();
									});
									var $slick_product_qv = $('.slick-product-qv', $container);
									if ($slick_product_qv.length == 1) {
										$slick_product_qv.slick({
											dots          : false,
											arrows        : true,
											infinite      : false,
											slidesToShow  : 1,
											slidesToScroll: 1,
											adaptiveHeight: false,
											prevArrow     : '<a class="slick-prev"><span><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-angle-left" /></svg></span></a>',
											nextArrow     : '<a class="slick-next"><span><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-angle-right" /></svg></span></a>'
										});
									}

									$('select.styled, .variations select', $container).customSelect();

									var $currentContainer = $container.find('#product-' + productId),
										$productForm = $currentContainer.find('form.cart');

									$('.product-images', $container).waitForImages().done(function () {

										if ($currentContainer.hasClass('product-type-variable')) {

											$productForm.wc_variation_form().find('.variations select:eq(0)').change();

											$(".variations_form").on("woocommerce_variation_select_change", function () {
												$(".variations_form select").each(function () {
													$(this).next('span.customSelect').html($(this).find(':selected').html());
												});

												if (typeof $slick_product_single != 'undefined' && $slick_product_single.length) {
													setTimeout(function () {
														$slick_product_single.slick('slickGoTo', 0, false);
														var $fisrtSlide = $slick_product_single_slides.first().children('a');
														$("<img/>")
															.attr("src", $fisrtSlide.attr('href'))
															.load(function () {
																$fisrtSlide.attr('data-size', this.width + 'x' + this.height);
															});
													}, 500);
												}
											});
										}
									});
								},
								beforeClose: function () {
									$body.removeClass('quickview-open');
								},
								close      : function () {
									$shadow.remove();
								}
							}
						});
					}
				});
			}

			return false;
		});

		$('.entry-content a > img').each(
			function () {

				var $shadow, $body = $('body'), $a = $(this).closest('a');

				if ($a.attr('href').search(/\.(gif|jpg|png|jpeg)$/i) >= 0) {

					$a.magnificPopup({
						type               : 'image',
						closeOnContentClick: true,
						image              : {
							verticalFit: true
						},
						mainClass          : 'ip-mfp-quickview ip-mfp-fade-in',
						closeMarkup        : '<a class="mfp-close ip-mfp-close"><svg><use xlink:href="' + ideapark_wp_vars.svgUrl + '#svg-close-light" /></svg></a>',
						removalDelay       : 300,
						callbacks          : {
							beforeOpen: function () {
								$shadow = $('<div id="ip-quickview-shadow" class="loading"><div class="ip-shop-loop-loading"><i></i><i></i><i></i></div></div>');
								$body.append($shadow);

								$shadow.one('touchstart', function () {
									$.magnificPopup.close();
								});
							},

							open: function () {
								$body.addClass('quickview-open');
							},

							imageLoadComplete: function () {
								$shadow.removeClass('loading');
							},

							beforeClose: function () {
								$shadow.addClass('mfp-removing');
								$body.removeClass('quickview-open');
							},
							close      : function () {
								$shadow.remove();
							}
						}
					});
				}
			}
		);


		var ideaparkStickyCheckoutTimeout = null;
		var $ideaparkCheckout = $('.checkout-collaterals');
		var $ideaparkWoocommerce = $('.woocommerce');
		var ideaparkCheckoutTop = 0;
		var ideaparkCheckoutInTransition = false;

		if ($ideaparkCheckout.length) {
			$ideaparkCheckout.css('position', 'relative');
			$ideaparkCheckout.on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function (e) {
				ideaparkCheckoutInTransition = false;
			});
			var ideapark_stickyCheckout = function () {
				if ($(window).width() < 992) {
					if (ideaparkCheckoutTop > 0) {
						ideaparkCheckoutTop = 0;
						ideaparkCheckoutInTransition = true;
						setTimeout(function(){ideaparkCheckoutInTransition = false;}, 700);
						$ideaparkCheckout.css({top: ideaparkCheckoutTop});
					}
					ideaparkStickyCheckoutTimeout = null;
					return;
				}
				var $ideaparkPayment = $('#payment');
				var scrollTop = $(window).scrollTop();
				var scrollTopOrig = scrollTop;
				var payment_top = $ideaparkPayment.offset().top;

				if (ideapark_wp_vars.stickyMenu) {
					var $sticky_menu = $('body.sticky #header .main-menu');
					var $admin_menu = $('#wpadminbar');
					if ($sticky_menu.length) {
						scrollTop += $sticky_menu.height();
					}
					if ($admin_menu.length) {
						scrollTop += $admin_menu.height();
					}
				}
				var dif = scrollTop - payment_top;
				if ((ideaparkCheckoutTop > 0 || dif !== 0) && !ideaparkCheckoutInTransition) {
					if (dif > 0 || ideaparkCheckoutTop !== 0) {

						var checkout_bottom = $ideaparkCheckout.offset().top + $ideaparkCheckout.outerHeight();
						var overdif = dif + checkout_bottom - ($(window).height() + scrollTopOrig);
						if (overdif > 0 ) {
							dif -= overdif;
						}

						overdif = dif + checkout_bottom - ( $ideaparkWoocommerce.offset().top + $ideaparkWoocommerce.outerHeight() );
						if (overdif > 0 ) {
							dif -= overdif;
						}

						ideaparkCheckoutTop += dif;
						if (ideaparkCheckoutTop < 0) {
							ideaparkCheckoutTop = 0;
						}
						ideaparkCheckoutInTransition = true;
						setTimeout(function(){ideaparkCheckoutInTransition = false;}, 700);
						$ideaparkCheckout.css({top: ideaparkCheckoutTop});
					}
				}

				ideaparkStickyCheckoutTimeout = null;
			};

			ideapark_stickyCheckout();

			$(window).on('scroll resize', function () {
				if (!ideaparkStickyCheckoutTimeout) ideaparkStickyCheckoutTimeout = setTimeout(ideapark_stickyCheckout, 500);
			});
		}
	});

})(jQuery, this);

function ideapark_debounce(func, wait, immediate) {
	var timeout;
	return function () {
		var context = this, args = arguments;
		var later = function () {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
}