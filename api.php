<?php

header('Content-Type: application/json');

if(isset($_GET['theme'])) {
	session_start();
	if('default' == $_GET['theme'])
		unset($_SESSION['theme']);
	else
		$_SESSION['theme'] = substr($_GET['theme'], 0, 10);
	
	$data = array(
		'success' => 1,
	);
}
else if(isset($_GET['offline'])) {
	$data = array(
		'data' => 'You are offline',
		'success' => 0,
	);
}
else {
	$data = array(
		'data' => 'Some fetched data '.time(),
	);
}

echo json_encode($data);
exit;
