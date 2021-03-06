(function ($) {

	'use strict';

	var IP_Wishlist = {

		init: function () {
			var wishlistAjax = false;

			if ($.fn.cookie || typeof(Cookies) !== 'undefined') {

				var wishlistCookieCount = 0;
				var wishlistCookie = $.fn.cookie ? $.cookie(ip_wishlist_vars.cookieName) : Cookies.get(ip_wishlist_vars.cookieName);
				if (wishlistCookie) {
					wishlistCookie = JSON.parse(wishlistCookie);

					for (var id in wishlistCookie) {
						if (wishlistCookie.hasOwnProperty(id)) {
							$('.ip-wishlist-item-' + wishlistCookie[id] + '-btn').addClass('added');
							console.log('.ip-wishlist-item-' + wishlistCookie[id] + '-btn');
						}
					}

					wishlistCookieCount = wishlistCookie.length;
				}

				if (wishlistCookieCount > 0) {
					$('#header .wishlist, #header .mobile-wishlist.added').removeClass('added');
					$('#header .wishlist, #header .mobile-wishlist').addClass('added');
				} else {
					$('#header .wishlist, #header .mobile-wishlist').removeClass('added');
				}
			}

			$(document).on('click', '.ip-wishlist-btn', function (e) {
				e.preventDefault();

				if (wishlistAjax) {
					return;
				}

				var productId = $(this).data('product-id'),
					$buttons = $('.ip-wishlist-item-' + productId + '-btn');

				$buttons.toggleClass('added');

				wishlistAjax = $.ajax({
					type    : 'POST',
					url     : ideapark_wp_vars.ajaxUrl,
					data    : {
						action    : 'ip_wishlist_toggle',
						product_id: productId
					},
					dataType: 'json',
					cache   : false,
					headers : {'cache-control': 'no-cache'},
					complete: function () {
						wishlistAjax = false;
					},
					success : function (json) {
						if (json.status === '1') {
							$('body').trigger('wishlist_added_item');
							$buttons.attr('title', ip_wishlist_vars.titleRemove);
						} else {
							$('body').trigger('wishlist_removed_item');
							$buttons.attr('title', ip_wishlist_vars.titleAdd);
						}

						if (json.count > 0) {
							$('#header .wishlist, #header .mobile-wishlist').addClass('added');
						} else {
							$('#header .wishlist, #header .mobile-wishlist').removeClass('added');
						}
					}
				});
			});


			var $wishlistTable = $('#ip-wishlist-table');


			if ($wishlistTable.length) {

				var _wishlistRemoveItem = function ($this) {
					var $thisTr = $this.closest('tr'),
						productId = $thisTr.data('product-id');

					$thisTr.addClass('loading');

					$.ajax({
						type    : 'POST',
						url     : ideapark_wp_vars.ajaxUrl,
						data    : {
							action    : 'ip_wishlist_toggle',
							product_id: productId
						},
						dataType: 'json',
						cache   : false,
						headers : {'cache-control': 'no-cache'},
						success : function (json) {
							var $share_link = $('#ip-wishlist-share-link');
							$('body').trigger('wishlist_removed_item');
							if ($share_link.length === 1 && typeof json.share_link !== 'undefined') {
								$share_link.val(json.share_link);
							}
							if (json.count > 0) {
								$('#header .wishlist, #header .mobile-wishlist').addClass('added');
							} else {
								$('#header .wishlist, #header .mobile-wishlist').removeClass('added');
								$('#ip-wishlist').css('display', 'none');
								$('#ip-wishlist-empty').removeClass('hidden');
							}
							$thisTr.fadeOut(150, function () {
								$(this).remove();
							});
						}

					}).fail(function() {
						$thisTr.removeClass('loading');
					});

				};


				$wishlistTable.on('click', '.ip-wishlist-remove', function (e) {
					e.preventDefault();

					var $this = $(this);

					if ($this.hasClass('clicked')) {
						return;
					}

					$this.addClass('clicked');

					_wishlistRemoveItem($this);
				});
			}
		}
	};

	$(document).ready(function () {
		IP_Wishlist.init();
	});

})(jQuery);
