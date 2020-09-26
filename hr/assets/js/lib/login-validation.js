$(document).ready(function(){
    /***************************************/
    /* Form validation */
    /***************************************/
    $( '#sign-in' ).on('click', function (e) {
    	if(!isValidate()){
    		return false;
		}else {
            e.preventDefault();
    		var form = $("#forms-login");
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.status == true) {
                        window.location.replace(base_url + res.url);
                    } else {
                        $('.response').addClass('text-danger');
                        $('.response').html(res.message);
                    }
                }
            });
        }

	});
    /***************************************/
    /* end form validation */
    /***************************************/
});

function isValidate() {
	$('.response').html('');
	if($('#login').val().length < 1){
		$('.response').addClass('text-danger');
		$('.response').html('Please fill Username or Email');
		$('#login').focus();
		return false;
	}
	if($('#password').val().length < 1){
		$('.response').addClass('text-danger');
		$('.response').html('Please fill password');
		$('#password').focus();
		return false;
	}
	return true;
}
