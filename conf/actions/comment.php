<?php
	session_start();
    require '../admin/connect.php';
    if (isset($_POST['theComment']) && is_string($_POST['theComment']) && isset($_GET['postID']) && is_numeric($_GET['postID']) && is_numeric($_SESSION['id']) && !empty($_POST['theComment']) && isset($_POST['addComment']) && $_POST['addComment'] === 'yes') {
    	$comment = strip_tags($_POST['theComment']);
    	$postID = strip_tags(trim($_GET['postID']));
    	$userID = strip_tags(trim($_SESSION['id']));
    	$stmt = $connect->prepare('INSERT INTO comments(Comment,Post_ID,User_ID) VALUE(?,?,?)');
    	$stmt->execute(array($comment,$postID,$userID));
    	exit();
    } elseif (isset($_GET['postID']) && is_numeric($_GET['postID']) && isset($_GET['getComment']) && $_GET['getComment'] === 'yes') {
    	$stmt = $connect->prepare('SELECT Comment FROM comments WHERE Post_ID = ? ORDER BY ID DESC');
    	$stmt->execute(array($_GET['postID']));
    	$rows = $stmt->fetchAll();
    	foreach ($rows as $row) {
    		echo "<h6>". $row['Comment'] ."</h6>";
    	}
        exit();
    } else {
    	echo '<div style="display: none;" class="alert alert-danger container alertForm" role="alert">من فضلك اكتب شيئا في التعليق</div>';
    	exit();
    }