<?php
include '../config/database.php';

	header("Access-Control-Allow-Origin: http://localhost/test_backend/api/users/signup/");
	header("Content-type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	$username = '';
	$email = '';
	$password = '';
	$phone = '';
	$address = '';
	$city = '';
	$country = '';
	$name = '';
	$postcode = '';

	$conn = null;

	$databaseService = new DatabaseService();
	$conn = $databaseService->getConnection();
	$data = json_decode(file_get_contents("php://input"));
	$username = $data->username;
	$email = $data->email;
	$password = $data->password;
	$phone = $data->phone;
	$address = $data->address;
	$city = $data->city;
	$country = $data->country;
	$name = $data->name;
	$postcode = $data->postcode;

	$table_name = "users";

	$query = "INSERT INTO " . $table_name . "
		 			SET username = :username,
						email = :email,
						password = :password,
						phone = :phone,
						address = :address,
						city = :city,
						country = :country,
						name = :name,
						postcode = :postcode";

	$stmt = $conn->prepare ($query);


	$stmt->bindParam(':username', $this->username);
	$stmt->bindParam(':email', $this->email);

	$password_hash = password_hash($this->password, PASSWORD_BCYRPT);
	$stmt->bindParam(':password', $password_hash);
	$stmt->bindParam(':phone', $this->phone);
	$stmt->bindParam(':address', $this->address);
	$stmt->bindParam(':city', $this->city);
	$stmt->bindParam(':country', $this->country);
	$stmt->bindParam(':name', $this->name);
	$stmt->bindParam(':postcode', $this->postcode);

	if($stmt->execute()){
		http_response_code(200);
		echo json_encode(array("message"=>"user was created"));
	}else{
		http_response_code(400);
		echo json_encode(array("message"=>"error"));
	}
?>