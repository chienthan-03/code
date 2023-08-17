<?php
// kết nối cơ sở dữ liệu
require_once("dbConnection.php");

// Khởi tạo biến
$error_name = $error_age = $error_email = '';
$old_id = $old_name = $old_age = $old_email = '';

// Truy xuất dữ liệu nếu ID được cung cấp
if (isset($_GET['id'])) {
	$old_id = $_GET['id'];
	$result = mysqli_query($mysqli, "SELECT * FROM users WHERE id = $old_id");
	$resultData = mysqli_fetch_assoc($result);

	$old_name = $resultData['name'];
	$old_age = $resultData['age'];
	$old_email = $resultData['email'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// Store form values
	$old_name = $_POST['name'] ?? '';
	$old_age = $_POST['age'] ?? '';
	$old_email = $_POST['email'] ?? '';

	$id = mysqli_real_escape_string($mysqli, $_POST['id']);
	$name = mysqli_real_escape_string($mysqli, $_POST['name']);
	$age = mysqli_real_escape_string($mysqli, $_POST['age']);
	$email = mysqli_real_escape_string($mysqli, $_POST['email']);

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

	// If all fields are valid, update data
	if (empty($error_name) && empty($error_age) && empty($error_email)) {
		$result = mysqli_query($mysqli, "UPDATE users SET `name` = '$name', `age` = '$age', `email` = '$email' WHERE `id` = $id");
		header('location: ./index.php');
	}
}
?>

<html>

<head>
	<title>Edit Data</title>
	<link rel="stylesheet" href="./style.css">
</head>

<body>
	<main class="table">
		<section class="table__header">
			<a href="index.php">
				<button class="btn btn__primary">Home</button>
			</a>
		</section>
		<section class="table__body">
			<form name="edit" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
				<div class="input__control">
					<label for="name">Name:</label> <br />
					<input type="text" name="name" class="input__basic" value="<?php echo htmlspecialchars($old_name); ?>">
					<p class="text__error"><?php echo $error_name; ?></p>
				</div>
				<div class="input__control">
					<label for="age">Age:</label> <br />
					<input type="text" name="age" class="input__basic" value="<?php echo htmlspecialchars($old_age); ?>">
					<p class="text__error"><?php echo $error_age; ?></p>
				</div>
				<div class="input__control">
					<label for="email">Email:</label> <br />
					<input type="text" name="email" class="input__basic" value="<?php echo htmlspecialchars($old_email); ?>">
					<p class="text__error"><?php echo $error_email; ?></p>
				</div>
				<div class="input__control right">
					<input type="hidden" name="id" value="<?php echo htmlspecialchars($old_id); ?>">
					<input type="submit" name="update" class="btn btn__primary" value="Update">
				</div>
			</form>
		</section>
	</main>
</body>

</html>