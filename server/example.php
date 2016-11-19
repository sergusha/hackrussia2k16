<?php
	include("db.inc");
?>


<html>
	<head>
		<title>
			База
		</title>
		<style type='text/css'>
		
		</style>
	</head>
	<body>
	
	<div id='department_form'>
		<form method='post' action='add_department.php'>
			<input type='text' name='department_name' id='department_name_form'>
			<input type='submit' id='department_name_submit'>
		</form>
	</div>
	<div id='scrubs_form'>
		<form method='post' action='add_scrubs.php'>
			<input type='text' name='scrubs_name' id='scrubs_name_form'>
			<input type='submit' id='scrubs_name_submit'>
		</form>
	</div>
	
	<div id='department_detail_form'>
		<form method='post' action='add_department_detail.php'>
			<select id='choose_department' name='choose_department'>
			<?php
				
				$sql = mysql_query("SELECT * FROM department_table");
				while ($row = mysql_fetch_object($sql))
				{
					echo "<option value=' $row->id '>$row->name</option>";
				}
			
			?>
			</select>
			<select id='choose_scrubs' name='choose_scrubs'>
			<?php
				
				$sql = mysql_query("SELECT * FROM scrubs_table");
				while ($row = mysql_fetch_object($sql))
				{
					echo "<option value=' $row->id '>$row->name</option>";
				}
			
			?>
			</select>
			<input type='text' name='num_of_place' id='num_of_place'>
			<input type='submit' id='department_detail_submit'>
		</form>
	</div>
	<div id='scrubs_detail_form'>
		<form method='post' action='add_scrubs_detail_form.php'>
			<select id='choose_scrubs' name='choose_scrubs'>
			<?php
				
				$sql = mysql_query("SELECT * FROM scrubs_table");
				while ($row = mysql_fetch_object($sql))
				{
					echo "<option value=' $row->id '>$row->name</option>";
				}
			
			?>
			</select>
			<input type='text' name='x_coord' id='x_coord'>
			<input type='text' name='y_coord' id='y_coord'>
			<input type='submit' id='scrubs_detail_submit'>
		</form>
	</div>
	<div id='call_form'>
		<form method='post' action='add_call.php'>
			<input type='text' name='call_address' id='call_address'>
			<input type='submit' id='submit_call'>
		</form>
	</div>
	
	</body>
</html>