<?php 

	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db = 'angularjs';

	$conn = new mysqli($host,$user,$pass,$db);

	header('Content-Type: application/json');

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$action = $request->action;

	switch($action){

		case 'update':

			$username = $request->username;

			$name = $request->name;
			$description = $request->description;

			$update_name = $request->update_name;
			$update_description = $request->update_description;

			$query = "SELECT id FROM posts WHERE user='".$username."' AND name='".$name."' AND description='".$description."'";

			$result = $conn->query($query);

			$row = $result->fetch_row();

			$id = $row[0];

			$query = "UPDATE posts SET name='".$update_name."',description='".$update_description."' WHERE id='".$id."'";

			$conn->query($query);

			break;

		case 'delete':
			$name = $request->name;

			$query = "DELETE FROM posts WHERE name='".$name."'";

			$conn->query($query);

			break;

		case 'check': 
			$username = $request->username;

			$query = "SELECT * FROM users WHERE username='".$username."'";

			$result = $conn->query($query);

			if($result->num_rows){
				echo json_encode('[{"result" : "0"}]');
			}else{

				echo json_encode('[{"result" : "1"}]');
			}
			break;



		case 'register':

			$username = $request->username;
			$password = $request->password;

			$query = "INSERT INTO users(username,password,admin) VALUES('" .$username. "','". $password ."','0')";	
			$result = $conn->query($query);	

			if($result){
				echo json_encode('[{"result" : "1"}]');
			}else{
				echo json_encode('[{"result" : "0"}]');
			}
			break;	



		case 'login':
			$username = $request->username;
			$password = $request->password;

			$query = "SELECT * FROM users WHERE username='".$username."' AND password='".$password."'";
			$result = $conn->query($query);

			if($result->num_rows){
				echo json_encode('[{"result" : "1"}]');
			}else{
				echo json_encode('[{"result" : "0"}]');
			}
			break;



		case 'logout':

			session_destroy();
			break;








		case 'insert':

			$username = $request->username;

			$name = $request->name;
			$description = $request->description;

			$query = "INSERT INTO posts(user,name,description) VALUES('".$username."','".$name."','".$description."')";
			$result = $conn->query($query);

			if($result){

				echo json_encode('[{"result" : "1"}]');
			}else{

				echo json_encode('[{"result" : "0"}]');
			}

			break;







		case 'load':

			$username = $request->username;

			$query = "SELECT name,description FROM posts WHERE user='".$username."' ORDER BY id DESC";	
			$result = $conn->query($query);
			$count = 0;

			if($result){
				$result_rows = $result->num_rows;
	
				echo '[';

				while($row = $result->fetch_row()){
					
					echo '{"name":"'.$row[0].'","description":"'.$row[1].'"}';
					$count ++;
					if($count<$result_rows){
						echo ',';
					}

				}

				echo ']';


			}
			break;

	}


?>