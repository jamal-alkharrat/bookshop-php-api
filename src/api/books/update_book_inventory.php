<?php
require_once '../../admin/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // The request is a preflight request. Respond successfully:
    header('Access-Control-Allow-Origin:'.BASE_URL.'/');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    exit;
}
// Start database connection
require 'connect.php';
$db = startDbConnection();

// Get input data from request body
$input = json_decode(file_get_contents('php://input'), true);

$produktID = $input['ProduktID'];
$lagerbestand = $input['Lagerbestand'];

try {
    $query = $db->prepare('UPDATE buecher SET lagerbestand = :lagerbestand WHERE produktID = :produktID');
    $query->execute(['lagerbestand' => $lagerbestand, 'produktID' => $produktID]);
    $rowsAffected = $query->rowCount();
    header('Content-Type: application/json');
    if ($rowsAffected > 0) {
        echo json_encode(['message' => 'Update successful', 'rowsAffected' => $rowsAffected]);
    } else {
        echo json_encode(['message' => 'No rows updated']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit();
}