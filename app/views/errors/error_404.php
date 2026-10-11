<?php
http_response_code(404);
header('Content-Type: application/json; charset=UTF-8');
echo json_encode(['status' => false, 'error' => 'Route not found.']);
exit;
