<?php
session_start();
	   $_SESSION['id']=$_GET['id'];
       $_SESSION['FirstName'] = $_GET['FirstName'];
	   $_SESSION['LastName'] = $_GET['LastName'];
       $_SESSION['username'] = $_GET['username'];
       $_SESSION['BranchID'] = $_GET['BranchID'];
	   $_SESSION['BranchNameTH'] = $_GET['BranchNameTH'];
	   $_SESSION['MenuName'] = $_GET['MenuName'];

echo $_SESSION['BranchID'];
?>