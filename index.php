<html>

	
	<head>

		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
		<script src='myApp.js'></script>
		<script src='myController.js'></script>
	</head>	


	<body>
		<div id='wrapper' class='col-xs-10' ng-app='myApp' ng-controller='myController'>

<!--		!!!!!!!!!!!!!			LOGGED IN 				!!!!!!!!!!!!!!!!!!!!!!!!							-->
			<div ng-show='logged'>

				<button ng-click='logout()'>Logout</button>

				<form  ng-submit='insert_data(username,form.name,form.description)'>
					<input type='text' ng-model='form.name' placeholder='Name'>
					<input type='text' ng-model='form.description' placeholder='description'>
					<input type='submit' value='submit'>
				</form>

				<button ng-click='load_data(username)'>Load Content</button>

				<div ng-repeat="value in name_array track by $index">
					<span>{{ name_array[$index] }}</span>
					<span> - </span>
					<span>{{ description_array[$index] }}</span>
					<button ng-click='delete_data(name_array[$index])' class='delete'>Delete</button>

					<button ng-click='show_update_array[$index] = true' class='update'>Update</button>

					<form ng-show='show_update_array[$index]' ng-submit='update_data(username,name_array[$index],description_array[$index],update.name,update.description,$index)'>
						<input ng-model='update.name' type='text' placeholder='new name'>
						<input ng-model='update.description' type='text' placeholder='new description'>
						<button type='submit'>Update Content</button>
					</form>

				</div>

			</div>



<!--		!!!!!!!!!!!!!			LOGGED OUT 				!!!!!!!!!!!!!!!!!!!!!!!!							-->
			<div ng-show='!logged'>

				<div id='login_container'>
					<h3>Login</h3>
					<form  ng-submit='login(login.username,login.password)'>
						<input type='text' ng-model='login.username' placeholder='Username'> 
						<input type='password' ng-model='login.password' placeholder='Password'>
						<input type='submit' value='submit'>
					</form>				
				</div>


				<div id='register_container'>
					<h3>Register</h3>
					<form  ng-submit='register(register.username,register.password,register.repeat_password)'>
						<input type='text' ng-model='register.username' placeholder='Username'> 
						<input type='password' ng-model='register.password' placeholder='Password'>
						<input type='password' ng-model='register.repeat_password' placeholder='Reapeat Password'>
						<input type='submit' value='submit'>
					</form>				
				</div>

			</div>
		</div>


	</body>

</html>