<?php
// generateToken.php
require_once '../../admin/config.php';

function generateToken($payload) {
    $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
    $payload = base64_encode(json_encode($payload));
    $signature = base64_encode(hash_hmac('sha256', "$header.$payload", SECRET_KEY, true));
    return "$header.$payload.$signature";
}