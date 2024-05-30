$(document).ready(function(){
	    $.ajax({
		            url: '../Backend/PHP/getSes.php',
		            type: 'GET',
		            success: function(resp){
						if(resp.auth === 0){
									window.location.href = "Login.html";
								}
					},
					error: function(xhr, status, error){
							alert("Error: " + error);
					}
		        });
});
