<?php
	session_start();
	require '../admin/connect.php';
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['postID']) && is_numeric($_GET['postID']) && is_numeric($_POST['newLikes'])) {
		$_GET['postID'] = @strip_tags(trim($_GET['postID']));
		$_POST['newLikes'] = @strip_tags(trim($_POST['newLikes']));
		$_SESSION['id'] = @strip_tags(trim($_SESSION['id']));
		$stmt = $connect->prepare('SELECT * FROM likes WHERE Post_ID = ? AND User_ID = ?');
		$stmt->execute(array($_GET['postID'],$_SESSION['id']));

		if ($stmt->rowCount() == 0) {
			$stmt = $connect->prepare('INSERT INTO likes(Post_ID,User_ID) VALUE(?,?)');
			$stmt->execute(array($_GET['postID'],$_SESSION['id']));

		} elseif ($stmt->rowCount() == 1) {

			$stmt = $connect->prepare('DELETE FROM likes WHERE Post_ID = ? AND User_ID = ?');
			$stmt->execute(array($_GET['postID'],$_SESSION['id']));
		}
		exit();
	} else {
		header('location: index.php');
		exit();
	}