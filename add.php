<html>

<head>
	<title>Add Data</title>
	<link rel="stylesheet" href="./style.css">
</head>

<body>
	<?php
	$error_name = $error_age = $error_email = '';
	$name = $age = $email = '';
	// Include the database connection file
	require_once("dbConnection.php");
	if (isset($_POST['submit'])) {
		// Escape special characters in string for use in SQL statement	
		$name = mysqli_real_escape_string($mysqli, $_POST['name']);
		$age = mysqli_real_escape_string($mysqli, $_POST['age']);
		$email = mysqli_real_escape_string($mysqli, $_POST['email']);

		// Check for empty fields
		if (empty($name) || empty($age) || empty($email)) {
			// Validate form data
			if (empty($name)) {
				$error_name = "Vui lòng nhập tên của user";
			}

			if (empty($age)) {
				$error_age = "Vui lòng nhập tuổi của user";
			}

			if (empty($email)) {
				$error_email = "Vui lòng nhập email của user";
			}
		} else {

			// Insert data into database
			$result = mysqli_query($mysqli, "INSERT INTO users (`name`, `age`, `email`) VALUES ('$name', '$age', '$email')");

			// Display success message
			header('location: ./index.php');
		}
	}
	?>
	<main class="table">
		<section class="table__header">
			<a href="index.php">
				<button class="btn btn__primary">Home</button>
			</a>
		</section>
		<section class="table__body">
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="add">
				<div class="input__control">
					<label for="name">Name:</label> <br />
					<input type="text" name="name" class="input__basic" value="<?php echo $name ?>">
					<p class="text__error"><?php echo $error_name; ?></p>
				</div>
				<div class="input__control">
					<label for="age">Age:</label> <br />
					<input type="text" name="age" class="input__basic" value="<?php echo $age ?>">
					<p class="text__error"><?php echo $error_age; ?></p>
				</div>
				<div class="input__control">
					<label for="email">Email:</label> <br />
					<input type="text" name="email" class="input__basic" value="<?php echo $email ?>">
					<p class="text__error"><?php echo $error_email; ?></p>
				</div>
				<div class="input__control right">
					<input type="submit" name="submit" class="btn btn__primary" value="Add">
				</div>
			</form>
		</section>
	</main>
</body>

</html>