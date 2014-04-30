//javascript document

$(document).ready(function() {
	$(document).keypress(function(e) {
		//numeric 1
		if (e.which == 49) {
			selectBtn(1);
		}
		//numeric 2
		else if (e.which == 50) {
			selectBtn(2);
		}
		//numeric 3
		else if (e.which == 51) {
			selectBtn(3);
		}
		//return key
		else if (e.which == 13) {
			$('#recordCat').submit();
		}
	})
	//click on radio button OR img to select
	$('.btnCat, .imgCat').click(function() {
		var id = $(this).attr('id');
		//eg id is btnCat2 or imgCat2 - extract the digit
		var regex = new RegExp(/\d/);
		var result = regex.exec(id);
		selectBtn(result[0]);
	})
	$('#recordCat').submit(function() {
		//check if the submit button is disabled
		//temporarily removing this check to test back-end code
		if ($('#catSubmit').prop('disabled')){
			//stop executing this funciton - send no data
			return false;
		}
		//prepare to send AJAX
		$('#catSubmit').prop('disabled', true);
		$('body').css('cursor', 'waiting');
		//eg form string currentCell=./DATA/CY4/captured layer 17-16- 3.jpg&category=class2
		var formString = 'currentCell=' + $('#currentCell').attr('src') + '&';
		formString += $(this).serialize();
		$.ajax({
			url: "./record_data.php",
			method: 'POST',
			data: formString,
			dataType: 'json',
			/*beforeSend: function() {
				
			},*/
			success: function(callbackJson){
				//msg will store any problems with db communication
				if (callbackJson.msg == 'end') {
					//redirect?
					alert('end of results reached');
				}
				else if (callbackJson.msg != '') {
					alert(callbackJson.msg)
				} else {	
					resetSelection();
					var src = callbackJson.new;
					//get new image
					$('#currentCell').attr('src', src);
					$('body').css('cursor', 'default');
				}
			},
			error: function(jqXHR, error){
				alert('AJAX error: '.error);
			}
		})
		return false;
	})
})

//
function resetSelection() {
	$('.imgCat').each(function() {
		$(this).css('border', 'none');
	})
	$('.btnCat').each(function() {
		$(this).prop('checked', false);
	})
}

function selectBtn(cat) {	
	resetSelection();
	$('#imgCat' + cat).css('border', '1px solid blue');
	$('#btnCat' + cat).prop('checked', true);
	//the submit button is disabled by default - enable it only
	//once a selection has been made
	//note there is an additional check on this in backend
	$('#catSubmit').prop('disabled', false);
}

