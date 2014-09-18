$( document ).ready(function() {

	$("#link_upload_file").click(function(){
	
		elem = $(this).parent();
		$('.full-row div').removeClass('link-active');
		elem.addClass('link-active');

	});


$("#link_upload_data").click(function(){
	
		elem = $(this).parent();
		$('.full-row div').removeClass('link-active');
		elem.addClass('link-active');

	});


$("#link_view").click(function(){
	
		elem = $(this).parent();
		$('.full-row div').removeClass('link-active');
		elem.addClass('link-active');

	});

});

