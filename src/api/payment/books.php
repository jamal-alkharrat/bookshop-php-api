<?php
// Start database connection
require 'connectDB.php';
$db = startDbConnection();

// Fetch all orders and return them as JSON
try {
    $query = $db->prepare('SELECT * FROM buecher');
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit();
}

$books = [];
foreach ($result as $book) {
    $books[] = [
        'price_data' => [
            'currency' => 'eur',
            'unit_amount' => $book['PreisBrutto'] * 100, // Convert to cents
            'product_data' => [
                'name' => $book['Produkttitel'],
                'description' => $book['Kurzinhalt'],
            ],
        ],
        'quantity' => 0,
    ];
}
?>
