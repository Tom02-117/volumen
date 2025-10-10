<?php

header('Content-Type: application/json');

$response = [
    'status' => 'success',
    'message' => '¡Ping exitoso! El backend está respondiendo.',
    'timestamp' => date('Y-m-d H:i:s')
];

echo json_encode($response);
?>