app.controller('myController',function($scope,$http){


	$scope.username = '';
	$scope.logged = false;

	$scope.name_array = [];
	$scope.description_array = [];
	$scope.show_update_array = [];


	$scope.update_data = function(username,name,description,update_name,update_description,index){


		var data = {'action' : 'update' ,'username' : username , 'name' : name , 'description' : description , 'update_name' : update_name , 'update_description' : update_description};

		send_ajax(data,
			function(response){
				$scope.show_update_array[index] = false;
				alert('Updated');
			},
			function(error){
				alert(error);
				//alert('A problem occured');
			}
		);
	}

	$scope.delete_data = function(name){
		var data = {'action' : 'delete' , 'name' : name};

		send_ajax(data,
			function(response){
				alert('Deleted');
			},
			function(error){
				alert(error);
				//alert('A problem occured');
			}
		);
	};

	$scope.insert_data = function(username,name,description){		
		var data = { 'action' : 'insert' , 'username' : username , 'name' : name , 'description' : description };

		send_ajax(data,
			function success(response){

				var result_data = JSON.parse(response.data);

				if(result_data[0].result == 0){
					alert('A problem Occured In the PHP Function');
					alert(error);
				}else{
					alert('Good to Go');
				}
			},
			function error(error){

				alert('A problem Occured in the HTTP request');

				alert(error);
			}
		);
	};


	$scope.load_data = function(username){	
		var data = {'action' : 'load' , 'username' : username};
		send_ajax(data,
			function success(response){

				var stringified_data = JSON.stringify(response.data);

				var result_data = JSON.parse(stringified_data);

				var count = 0;
				
				$scope.name_array = [];
				$scope.description_array = [];
				$scope.show_update_array = [];

				for(data of result_data){
					$scope.name_array[count] = data.name;
					$scope.description_array[count] = data.description;
					$scope.show_update_array[count] = false;
					count++;
				}

			},function error(error){
				alert('A problem Occured in the HTTP request');
				alert(error);
			}
		);
	};





	$scope.logout = function(){
		$scope.logged = false;

	}

	$scope.login = function(username,password){
		var data = {'action' : 'login' , 'username' : username , 'password' : password};

		$scope.username = username;

		send_ajax(data,
			function success(response){

				var result_data = JSON.parse(response.data);

				if(result_data[0].result == 0){
					alert('Wrong Username or Password');
				}else{
					$scope.logged = true;
				}	

			},	
			function error(error){
				alert('A problem Occured In the PHP Function');
			}
		);
	};





	$scope.register = function(username,password,password_repeat){
		var data = {'action' : 'register' , 'username' : username , 'password' : password , 'password_repeat' : password_repeat};

		if(username && password && password_repeat){

			if(password===password_repeat){

				send_ajax({'action' : 'check','username' : username},
					function success(response){

						var result_data = JSON.parse(response.data);

						if(result_data[0].result == 0){
							alert('Username already exists');
						}else{
							send_ajax(data,
								function success(response){
									alert('Successfully Registered');
								},
								function error(error){
									alert('A problem Occured In the PHP Function(Register)');
									alert(error);
								}
							);
						}	

					},	
					function error(error){
						alert('A problem Occured In the PHP Function(Check)');
						alert(error);
					}
				);

			}else{

				alert('Password do not match');

			}
			
		}else{

			alert('Fill all Fields');

		}

	};






	function send_ajax(sending_data,success_callback,error_callback){
		$http({
			method: 'POST',
			url: 'process.php',	
			data: sending_data	
		}).then(function(response){
			success_callback(response);
		},function(error){
			error_callback(error);
		});	
	};


});