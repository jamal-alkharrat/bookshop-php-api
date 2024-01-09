<?php
// register.php
require_once '../../admin/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // The request is a preflight request. Respond successfully:
    header('Access-Control-Allow-Origin:'.BASE_URL.'/');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    exit;
}
// Import the db info and the secret key from config.php
require_once '../../admin/config.php';
include 'validation.php';
require 'generateToken.php';

// Start database connection
require 'connect.php';
$db = startDbConnection();
// Request data from client
$requestData = json_decode(file_get_contents('php://input'), true);

// Set variables from request data
$email = $requestData['email'];
$username = $requestData['username'];
$password = $requestData['password'];
//  Validate input
validateUsername($username);
validatePassword($password);
validateEmail($email);

// Check if user already exists
try {
    $query = $db->prepare('SELECT * FROM user WHERE username = :username or email = :email');
    $query->execute(['username' => $username, 'email' => $email]);
    $query->fetchAll();
    if ($query->rowCount() > 0) {
        http_response_code(400);
        echo json_encode(['error' => 'User already exists']);
        exit();
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit();
}

// All checks passed, create user
// Hash password so the password is not stored in plain text
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
// Add the user to the database
try {
    $query = $db->prepare('INSERT INTO user (email, username, password) VALUES (:email, :username, :password)');
    $query->execute(['email' => $email, 'username' => $username, 'password' => $passwordHash]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create user. Please try again']);
    exit();
}

// Success - User added to database

// Generate token
$token = generateToken(['username' => $username, 'email' => $email]);

// Get the userID from the database
try {
    $query = $db->prepare('SELECT * FROM user WHERE username = :username');
    $query->execute(['username' => $username]);
    $result = $query->fetchAll();
    $userID = $result[0]['id'];
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit();
} 

// Return userID, username, email and token to client
header('Content-Type: application/json');
echo json_encode(['token' => $token, 'username' => $username, 'email' => $email, 'userID' => $userID]);