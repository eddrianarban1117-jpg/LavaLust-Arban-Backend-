<?php
$status = http_response_code();
if (!$status || $status < 400) {
    $status = 500;
    http_response_code($status);
}
header('Content-Type: application/json; charset=UTF-8');
echo json_encode(['status' => false, 'error' => 'The request could not be completed.']);
exit;
