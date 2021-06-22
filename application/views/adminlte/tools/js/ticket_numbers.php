//<script><?php restricted(''); ?>

$(document).ready(function() {
	var start_from = $('#start-from').bootstrapSlider({});
	
	
	$('#btn-generate-ticket-numbers').on('click', function() {
		var form = document.createElement("form");
		form.action = '/ticket/card-numbers/pdf';
		form.method = 'post';
		form.target = '_blank'|| "_self";
		
		var input = document.createElement("input");
		input.name = 'start';
		input.value = start_from.bootstrapSlider('getValue');
		
	
		
		form.appendChild(input);
		form.style.display = 'none';
		document.body.appendChild(form);
		form.submit();
		form.parentNode.removeChild(form);
		form = null;
	});
});