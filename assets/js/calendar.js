$(document).ready(function() {
	$('#print').click(function() {
		var restorePage = $('body').html();
		var printContent = $('#printable').html();
		$('body').html(printContent);
		window.print();
		$('body').html(restorePage);
	});


	$('.cal-header a').click(function (event) {
		var id = $(this).prop('id');
		event.preventDefault();
		var action;

		if (id == 'left-arrow') {
			action = 'left';
		} else if (id == 'right-arrow') {
			action = 'right';
		} else {
			alert('Something wrong with the arrow keys you clicked. Reload page and try again.');
			return;
		}

		var currMonth = $('#month').text();

		$.post('/home/calendarArrow', { currMonth:currMonth, action:action }, function(data) {
			if (data.success == 'true') {
				$('#cal-title').text(data.title);
				$('#cal-content').html(data.content);
				$('#month').html(data.month);
			} else {
				alert('Something wrong. Reload page and try again.');
			}
		}, "json");
	});
})