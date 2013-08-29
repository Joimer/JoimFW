/**
 * Midknights 3 home page (login) functions
 */
 // We attack the login function to the login button.
 $(document).ready(function(){
 	$('#button-login').click(function(){
 		$.post('/user/login', {user:$('#username').val(), password:$('#pass').val()}, function(data){
 			// Get the result in an object
 			data = $.parseJSON(data);

 		});
 	})
 });