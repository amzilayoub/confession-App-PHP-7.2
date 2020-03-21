<?php
	require 'connect.php';
	require 'includes/templates/header.php';
	include 'includes/templates/navbar.php';
	include 'includes/function/function.php';
	$alpha = '1234567890ABCDEFGHIJKLMNOPQRSUVWXYZabcdefghijklmnopqrstuvwxys';
	if (!isset($_COOKIE['user']) && !isset($_COOKIE['password'])) {
        $user = substr(uniqid(sha1(str_shuffle($alpha))), 5,20);
        $password = substr(sha1(str_shuffle($alpha)), 0,10);
        setcookie('user',$user,time() + (86400 * 30 * 12),'/');
        setcookie('password',$password,time() + (86400 * 30 * 12),'/');
        $stmt = $connect->prepare('INSERT INTO users(Username,Password) VALUE(?,?)');
        $stmt->execute(array($user,$password));
        $_SESSION['user'] = $user;
        $_SESSION['password'] = $password;
    } elseif(!isset($_SESSION['user'])) {
        $_SESSION['user'] = $_COOKIE['user'];
        $_SESSION['password'] = $_COOKIE['password'];
    }