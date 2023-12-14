<?php
	session_start();

	require_once 'config.php';

	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
                $audit_userid = $_SESSION['user_id'];
                $audit_name = $_SESSION['user_nameaudit'];
                $audit_action = "Logged Out";
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}

	$_SESSION = array();
	session_destroy();
	header("Location: ../index.php");
	exit();
?>