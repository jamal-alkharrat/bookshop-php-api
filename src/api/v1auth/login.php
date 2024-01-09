<?php
require_once '../../admin/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // The request is a preflight request. Respond successfully:
    header('Access-Control-Allow-Origin:'.BASE_URL.'/');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    exit;
}
// Import the db info and the secret key from admin/config.php
require_once '../../admin/config.php';
include 'validation.php';
require 'generateToken.php';

// Start database connection
require 'connect.php';
$db = startDbConnection();
// Request data from client
$requestData = json_decode(file_get_contents('php://input'), true);

// Validate email
$email = $requestData['email'];
validateEmail($email);

// Validate password
$password = $requestData['password'];
validatePassword($password);


try {
    $query = $db->prepare('SELECT * FROM user WHERE email = :email');
    $query->execute(['email' => $email]);
    $result = $query->fetchAll();
    if ($query->rowCount() == 0) {
        http_response_code(400);
        echo json_encode(['error' => 'User does not exist']);
        exit();
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit();
}

// Get the hashed password and username from the database
$hashedPassword = $result[0]['password'];
$username = $result[0]['username'];

// Verify the password
if (password_verify($password, $hashedPassword)) {
    // The password is correct, generate the token
    $token = generateToken(['username' => $username, 'email' => $email]);

    // Fetch userID from the data base to return it alongside the token and other user data
    try {
        $query = $db->prepare('SELECT id FROM user WHERE email = :email');
        $query->execute(['email' => $email]);
        $result = $query->fetchAll();
        $userID = $result[0]['id'];
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        exit();
    }

    header('Content-Type: application/json');
    echo json_encode(['token' => $token, 'username' => $username, 'email' => $email, 'userID' => $userID]);
} else {
    // The password is incorrect
    http_response_code(401);
    echo json_encode(['error' => 'Invalid password']);
    exit();
}
