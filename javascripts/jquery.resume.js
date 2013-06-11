
jQuery(function($) {

	$('.repeatable-add').on('click', function() {
		// console.log("Repeatable Add Clicked")
		field = $(this).closest('td').find('.resume_experience_repeatable li:last').clone(true);
		fieldLocation = $(this).closest('td').find('.resume_experience_repeatable li:last');
		$('input, textarea', field).val('').attr('name', function(index, name) {
			console.log($(this).attr('name'));
			return name.replace(/(\d+)/, function(fullMatch, n) {
				return Number(n) + 1;
			});
		});
		$('input, textarea', field).val('').attr('id', function(index, id) {
			console.log($(this).attr('id'));
			return id.replace(/(\d+)/, function(fullMatch, n) {
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

	$('.resume_experience_repeatable').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.sort'
	});

});