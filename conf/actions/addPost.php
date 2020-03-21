<?php
	session_start();
	require '../admin/connect.php';
	$errors = '';
	$category = array('dream','fantasy','firstExperience','regret','pain','randomFel','real','hardExp','other');
    if (isset($_POST['paraCategory']) && isset($_POST['paragraph']) && is_string($_POST['paraCategory']) && is_string($_POST['paragraph'])) {
	    if (!empty($_POST['paraCategory']) && !empty($_POST['paragraph'])) {
	    	if (strlen($_POST['paragraph']) >= 100) {
	    		if (in_array($_POST['paraCategory'], $category)) {
		            $_POST['paraCategory'] = strip_tags($_POST['paraCategory']);
		            $_POST['paragraph'] = strip_tags($_POST['paragraph']);
		            $stmt = $connect->prepare('INSERT INTO posts(Post,Category) VALUE(?,?)');
		            $stmt->execute(array($_POST['paragraph'],$_POST['paraCategory']));
	        	} else {
	            	$errors = 'من فضلك اختر الصنف';
	        	}
	    	} else {
	    		$errors = 'يجب ان يكون الاعتراف اكثر من 100 حرف';
	    	}
	    } else {
	    		$errors = 'من فضلك املأ الحقول';
	    }

	}
	print_r($errors);