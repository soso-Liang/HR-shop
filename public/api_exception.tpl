<?php 
header('Content-Type:application/json; charset=utf-8');
$result['msg'] = $message;
$result['status'] = 0;
$result['code'] = $code;
exit(json_encode($result));
?>