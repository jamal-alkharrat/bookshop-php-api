<?php
// validation.php

function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid email format']);
        exit();
    }
}

function validatePassword($password) {
    // Check length
    if (strlen($password) < 8 || strlen($password) > 64) {
        http_response_code(400);
        echo json_encode(['error' => 'Password must be between 8 and 64 characters']);
        exit();
    }

    // Check character types
    if (!preg_match('/^[a-zA-Z0-9_\-\.@$?!]+$/', $password)) {
        http_response_code(400);
        echo json_encode(['error' => 'Password can only contain letters, numbers, underscores, hyphens, periods, dollar signs, at signs, question marks, and exclamation points']);
        exit();
    }
}

function validateUsername($username) {
    // Check length
    if (strlen($username) < 3 || strlen($username) > 20) {
        http_response_code(400);
        echo json_encode(['error' => 'Username must be between 3 and 20 characters']);
        exit();
    }

    // Check character types
    if (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $username)) {
        http_response_code(400);
        echo json_encode(['error' => 'Username can only contain letters, numbers, underscores, periods and hyphens']);
        exit();
    }
}