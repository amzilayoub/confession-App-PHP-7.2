<?php
    session_start();
    require '../admin/connect.php';
    require '../includes/function/function.php';
    $category = array('dream','fantasy','firstExperience','regret','pain','randomFel','real','hardExp','other');
    if (isset($_GET['cat']) && !empty($_GET['cat']) && in_array($_GET['cat'], $category) && isset($_GET['time']) && is_numeric($_GET['time'])) {
        getPost('WHERE Category = ?', array(strip_tags(trim($_GET['cat']))),$_GET['time']);
        exit();
    } elseif(isset($_GET['time']) && is_numeric($_GET['time'])) {
        getPost("", array(), $_GET['time']);
        exit();
    }
     else {
        header('location: index.php');
        exit();
    }
?>