<?php
	session_start();
	require('new-connection.php');
	date_default_timezone_set('America/Los_Angeles');

	if(isset($_POST['action']) && $_POST['action'] == 'register')
	{
		register_user($_POST);
	}

	if(isset($_POST['action']) && $_POST['action'] == 'add')
	{
		add_expense($_POST);
	}

	if(isset($_POST['action']) && $_POST['action'] == 'delete')
	{
		delete_expense($_POST);
	}

	else
	{
		header('location: register.php');
		exit();
	}

	function register_user($post)
	{
	//VALIDITY CHECKS
		if(strlen($post['name']) < 1) //if a name is not entered
		{
			$_SESSION['errors'][] = "You must enter a name";
		}
		if($post['budget'] < 0 || !is_numeric($post['budget'])) //if budget is blank, not an integer, or negative number
		{
			$_SESSION['errors'][] = "Please enter a positive integer for your budget";
		}

		if(isset($_SESSION['errors']))
		{
			header('location: register.php');
			exit();
		}
	//END OF VALIDITY CHECKS

		$budget = $post['budget'];
		$query = "INSERT INTO users (name, budget, created_at, updated_at) 
					 VALUES ('" . mysql_real_escape_string($post['name']) ."', {$budget}, NOW(), NOW())";
		$id = run_mysql_query($query);

		header('location: expenses.php?id=' . $id);
		exit();
	}

	function add_expense($post)
	{
		$amount_spent = $post['amount_spent'];
		$user_id = $post['user_id'];
		$query = "INSERT INTO expenses (users_id, particulars, amount_spent, created_at, updated_at)
					VALUES ({$user_id}, '" . mysql_real_escape_string($post['particulars']) ."', {$amount_spent}, NOW(), NOW())";
		run_mysql_query($query);

		header('location: expenses.php?id=' . $user_id);
		exit();
	}

	function delete_expense($post)
	{
		$user_id = $post['user_id'];
		$expense_id = $post['expense_id'];
		$query = "DELETE FROM expenses WHERE expenses.id = {$expense_id}";
		run_mysql_query($query);

		header('location: expenses.php?id=' . $user_id);
		exit();
	}
?>