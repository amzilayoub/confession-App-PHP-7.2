<?php
	require '../admin/connect.php';
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_numeric($_POST['postID'])) {
		$_POST['postID'] = strip_tags(trim($_POST['postID']));
		$stmt = $connect->prepare('SELECT Post FROM posts WHERE ID = ?');
		$stmt->execute(array($_POST['postID']));
		$row = $stmt->fetch();
		if ($stmt->rowCount() > 0) {
			echo $row['Post'];
		}
	} else {
		header('location: index.php');
		exit();
	}