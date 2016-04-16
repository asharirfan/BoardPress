;(function($){
	"use strict";
	function _ready(){
		$('form.purchase-course').submit(function(){
			var $button = $('button.purchase-button', this),
				$view_cart = $('.view-cart-button', this);
			$button.removeClass('added').addClass('loading');
			$.ajax({
				url: $('input[name="_wp_http_referer"]', this).val() + '?lp-ajax=add-to-cart',
				data: $(this).serialize(),
				error: function(){
					$button.removeClass('loading');
				},
				dataType: 'html',
				success: function(response){
					$button.addClass('added').removeClass('loading');
					$view_cart.removeClass('hide-if-js');
				}
			});
			return false;
		});
	}
	$(document).ready(_ready);
})(jQuery);