$(document).ready(function() {
	buildSwitchList();
});

function buildSwitchList() {
	$.getJSON( "switch.php?f=fetchSwitchList", function( data ) {
	  for(var i=0;i<data.length;i++) {
	  	console.log("Found a switch");
	  	console.log(data[i]);
	  	var html = "";
	  	html += '<div data-id="' + data[i].id + '" class="switch">';
	  	html += '<img src="' + data[i].iconurl + '"/>';
	  	html += '<div class="state">' + data[i].state + '</div>';
	  	html += '</div>';
	  	$('#switchContainer').append(html);
	  }

	  buildControls();
	});
}

function buildControls() {
	$('.switch').click(function() {
		// call the json ajax, return the new state and update it.
		//alert($(this).find('.state').html());
		$.getJSON("switch.php?f=toggleSwitch&switch=" + $(this).data('id'), function(data) {
			/*console.log("State: " + data);
			console.log($(this));
			console.
			$(this).find('.state').text(data); */
			console.log(data[0].state);
			$('.switch[data-id="' + data[0].id + '"]').find('.state').text(data[0].state);
		});
	});
}