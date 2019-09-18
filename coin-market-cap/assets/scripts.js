function calculation() {
	var amount = jQuery('#convert-amount').val(),
		leftSelected = jQuery('#convert-left option:selected'),
		rightSelected = jQuery('#convert-right option:selected');
	
	jQuery('#convert-result').val((parseFloat(amount) * leftSelected.data('price') / rightSelected.data('price')).toFixed(4));

	if (rightSelected.val() != leftSelected.val()) {
		history(leftSelected, rightSelected);
	}
}

function history(leftSelected, rightSelected) {

	var rightValue = (typeof rightSelected == 'undefined') ? '' : rightSelected.val();
	var leftValue = (typeof leftSelected == 'undefined') ? '' : leftSelected.val();
	
	jQuery.ajax({
		url: cmc_parameters.request_url,
		type: "POST",
		data: {
			action : 'cmc_update_history',
			left : leftValue,
			right : rightValue
		},
		dataType: "json",
		cache: false,
		success: function(data) {
			html = '';
			for(i = 0; i < data.length; i++) {
				html += '<a href="#" class="history" data-left="' + data[i].left + '" data-right="' + data[i].right + '">' + data[i].left + ' - ' + data[i].right + '</a>';
			}
			jQuery('.convert-history').html(html);
		}
	});
}

jQuery(function(){
	jQuery('#convert-left').select2({
		'width' : 'style'
	});
	jQuery('#convert-right').select2({
		'width' : 'style'
	});

	calculation();
	history();
	
	jQuery('#convert-left').change(function(){
		calculation();
	})

	jQuery('#convert-right').change(function(){
		calculation();
	});

	jQuery('body').on('click', '.switch a', function(e) {
		e.preventDefault();
		leftElement = jQuery('#convert-left option:selected');
		rightElement = jQuery('#convert-right option:selected');

		jQuery('#convert-right').val(leftElement.val()).trigger('change');
		jQuery('#convert-left').val(rightElement.val()).trigger('change');
	})
	jQuery('body').on('click', '.history a', function(e) {
		e.preventDefault();

		leftValue = jQuery(this).data('left');
		rightValue = jQuery(this).data('right');

		jQuery('#convert-right').val(rightValue).trigger('change');
		jQuery('#convert-left').val(leftValue).trigger('change');
	});
})