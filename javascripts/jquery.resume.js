
jQuery(function($) {

	$('.portfolio_upload_image_button').on('click', function() {
		// console.log("Upload Image Clicked")
		formfield = $(this).siblings('.portfolio_upload_image');
		preview = $(this).siblings('.portfolio_preview_image');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		window.send_to_editor = function(html) {
			imgurl = $('img',html).attr('src');
			classes = $('img', html).attr('class');
			id = classes.replace(/(.*?)wp-image-/, '');
			formfield.val(id);
			preview.attr('src', imgurl);
			tb_remove();
		}
		return false;
	});

	$('.portfolio_clear_image_button').on('click', function() {
		// console.log("Clear Image Clicked")
		var defaultImage = $(this).parent().siblings('.portfolio_default_image').text();
		$(this).parent().siblings('.portfolio_upload_image').val('');
		$(this).parent().siblings('.portfolio_preview_image').attr('src', defaultImage);
		return false;
	});



	$('.repeatable-add').on('click', function() {
		// console.log("Repeatable Add Clicked")
		field = $(this).closest('td').find('.image_repeatable li:last').clone(true);
		fieldLocation = $(this).closest('td').find('.image_repeatable li:last');
		$('input.portfolio_upload_image', field).val('').attr('name', function(index, name) {
			console.log($(this).attr('name'));
			return name.replace(/(\d+)/, function(fullMatch, n) {
				return Number(n) + 1;
			});
		});
		field.insertAfter(fieldLocation, $(this).closest('td'))
		return false;
	});

	$('.repeatable-remove').on('click', function(){
		$this = $(this);
		if ( $this.parent().not(':first-child').length ) {
			$this.parent().remove();
		};
		return false;
	});

	$('.image_repeatable').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.sort'
	});

});