<?php
http_response_code(500);
header('Content-Type: application/json; charset=UTF-8');
echo json_encode(['status' => false, 'error' => 'Database request failed.']);
exit;
