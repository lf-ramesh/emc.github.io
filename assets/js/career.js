$(function () {

	var cf = $('#career-form');

    cf.validator();

    cf.on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            var url = "career.php";
			
			var myForm = document.getElementById('career-form');
			$.ajax({
				url: "career.php", 
				type: "POST",             
				data: new FormData(myForm),
				contentType: false,       
				cache: false,             
				processData:false, 
				success: function(data) {
                    
					
					var messageAlert = 'alert-' + data.type;
                    var messageText = data.message;

                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
                    if (messageAlert && messageText) {
                        cf.find('.messages').html(alertBox);
                        if ( messageAlert == 'success' )
							cf[0].reset();
					}
					
				}
			});
			
			/*
            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function (data)
                {
					
                    var messageAlert = 'alert-' + data.type;
                    var messageText = data.message;

                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
                    if (messageAlert && messageText) {
                        cf.find('.messages').html(alertBox);
                        cf[0].reset();
                    }
                },
				error:function(){
					cf.find('.messages').html('<div class="alert alert-danger">Sorry !! your form submission is failed</div>');
					// alert("Sorry !! your form submission is failed")
				}
            });
			*/
			
            return false;
			
        }
    })
});