<?php
session_start();
if (!isset($_SESSION['user'])) { http_response_code(401); echo json_encode(['success'=>false,'message'=>'Neautorizat']); exit; }
require 'php/functions.php';
$input = json_decode(file_get_contents('php://input'), true);
if ($input && isset($input['weekly_plan'])) { saveUserMeals($_SESSION['user']['id'], $input); echo json_encode(['success'=>true]); }
else echo json_encode(['success'=>false]);
?>