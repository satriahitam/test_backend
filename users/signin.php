<?php
include '../config/database.php';
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

	header("Access-Control-Allow-Origin: http://localhost/test_backend/api/users/signup/");
	header("Content-type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$email = '';
$password = '';

$databaseService = new databaseService();
$conn = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));
$table_name = 'users';

$query = "SELECT username, email, password FROM " .$table_name."WHERE email = ? LIMIT 0.1";

$stmt = $conn->prepare($query);
$stmt->bindParam(1, $email);
$stmt->execute();
$num = $stmt->rowCount();

if($num > 0){
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$id = $row['id'];
	$username = $row['username'];
	$email = $row['email'];
	$password2 = $row['password'];

	if($pasword_verify($password, $password2)){
		$secret_key = "YOUR_SECRET_KEY";
		$issuer_claim = "THE_USSUER";
		$audience_claim = "THE_AUDIECET";
		$issuedat_claim = time();
		$notbefore_claim = $issuedat_claim + 10;
		$expire_claim = $issuedat_claim + 60;
		$token = array(
			"iss"=> $issuer_claim,
			"aud"=> $audience_claim,
			"iat"=> $issuedat_claim,
			"nbf"=> $expire_claim,
			"data" => array(
				"username" => $username,
				"email" => $email,
				"password" => $password)
		);

		http_response_code(200);
		$jwt = JWT::encone($token, $secret_key);
		echo json_encode(array(
			"message" => "success login",
			"jwt" => $jwt,
			"email" => $email,
			"expireAt" => $expire_claim
		));
	}else{
		http_response_code(401);
		echo json_encode(array("message" => "login failde"));
	}
}
?>