<?php
	require ('new-connection.php');
	date_default_timezone_set('America/Los_Angeles');

	function list_expenses()
	{
		$user_id = $_GET['id'];
		$query = "SELECT expenses.id, expenses.created_at, expenses.particulars, expenses.amount_spent FROM expenses
				LEFT JOIN users ON expenses.users_id = users.id
				WHERE users.id = {$user_id}";
		$data = fetch_all($query);
		foreach($data as $expense)
		{
			$phpdate = strtotime($expense['created_at']);
			$date = date("F j, Y", $phpdate);
			echo "<tr>
					<td>{$date}</td>
					<td>{$expense['particulars']}</td>
					<td>{$expense['amount_spent']}</td>
					<td>
						<form action='process.php' method='post'>
							<input type='hidden' name='action' value='delete'>
							<input type='hidden' name='user_id' value='{$user_id}'>
							<input type='hidden' name='expense_id' value='{$expense['id']}'>
							<input type='submit' value='Delete'>
						</form>
				</tr>";
		}
	}
?>

<html>
<head>
	<title>Expenses Tracker</title>
	<style type='text/css'>
		body{
			text-align: center;
			background-color: rgb(100,100,100);
			font-family: lucida;
		}
		td{
			width: 200px;
			text-align: center;
		}
		#container{
			margin-top: 2%;
			width: 830px;
			display: inline-block;
			text-align: left;
			padding: 100px;
			background-color: white;
		}
		textarea{
			width: 90%;
		}
		#budget{
			margin-left: 50%;
		}
		span{
			color: red;
		}
	</style>
</head>
<body>
	<div id='container'>
		<h3 id='budget'>You have 
<?php 
	//Subtract expenses from budget
		//fetch budget
		$user_id = $_GET['id'];
		$query = "SELECT users.budget FROM users WHERE users.id = {$user_id}";
		$budget_data = fetch_record($query);
		$budget = $budget_data['budget'];
		//fetch expenses
		$query = "SELECT expenses.amount_spent FROM expenses WHERE expenses.users_id = {$user_id}";
		$expense_data = fetch_all($query);
		$sum = 0;
		foreach($expense_data as $expense)
		{
			$sum += $expense['amount_spent'];
		}
		//total amount left to spend
		$total = $budget-$sum;
		if($total < 0) //if under budget
		{
			$amount = $total*-1;
			echo "<span>-$" . $amount . "</span>";
		}
		else
		{
			echo "$" . $total;
		}
	?> left for your savings!</h3>
		<h2>Welcome Kevin!</h2>

		<h3>List of Expenses</h3>
		<table>
			<thead>
				<tr>
					<th>Date</th>
					<th>Particulars</th>
					<th>Amount Spent ($)</th>
					<th>Action</th>
				</tr>
			<tbody>
	<?php
				list_expenses();
	?>
			</tbody>
		</table>

		<h3>Add Expenses</h3>
		<form action='process.php' method='post'>
			<input type='hidden' name='action' value='add'>
			<input type='hidden' name='user_id' value='<?php echo $_GET['id']; ?>'>
			<label>
				<p>Particulars:</p>
				<textarea name='particulars'></textarea>
			</label>
			<label>
				<p>Amount (Dollars):</p>
				<input type='text' name='amount_spent'>
			</label>
			<input type='submit' value='Add'>
		</form>
	</div>
</body>
</html>