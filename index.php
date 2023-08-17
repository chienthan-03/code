<?php
session_start();
// Include the database connection file
require_once("dbConnection.php");

// Fetch data in descending order (lastest entry first)
$result = mysqli_query($mysqli, "SELECT * FROM users ORDER BY id DESC");
?>

<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Responsive HTML Table With Pure CSS - Web Design/UI Design</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<main class="table">
		<section class="table__header">
			<?php
			if (isset($_SESSION['username'])) {
				echo "<a href='add.php'>
					<button class='btn btn__primary'>Add new user</button>
				</a>
				";
			} else {
				echo "<a href='login.php'>
				<button class='btn btn__primary'>Login</button>
			</a>";
			}
			?>
			<div class="group-right">
				<div class="input-group">
					<input type="search" placeholder="Search Data...">
					<img src="images/search.png" alt="">
				</div>
				<?php
				if (isset($_SESSION['username'])) {
					echo '<div class="btn__logout">
						<a href="logout.php">
						<img src="./images/logout-transparent-png.svg" alt="SVG Image">
				</a>
				</div>
				';
				} else {
					echo "<div></div>";
				}
				?>

			</div>
		</section>
		<section class="table__body">
			<table>
				<thead>
					<tr>
						<th> Name</th>
						<th> Age</th>
						<th> Email</th>
						<?php
						if (isset($_SESSION['username'])) {
							echo "<th> Action</th>";
						} else {
							echo "";
						}
						?>

					</tr>
				</thead>
				<tbody>
					<?php
					// Fetch the next row of a result set as an associative array
					while ($res = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>" . $res['name'] . "</td>";
						echo "<td>" . $res['age'] . "</td>";
						echo "<td>" . $res['email'] . "</td>";
						if (isset($_SESSION['username'])) {
							echo '
						<td>
							<a href=edit.php?id=' . $res['id'] . '>
								<button type="button" class="btn btn__primary">Edit</button>
							</a>
							<a href=delete.php?id=' . $res['id'] . ' onClick="return confirm(\'Bạn có muốn xóa user?\')">
								<button type="button" class="btn btn__danger">Delete</button>
							</a>
						</td>';
						} else {
							echo "";
						}

						echo "</tr>";
					}
					?>
				</tbody>
			</table>
			<section class="table__body">
	</main>
	<script>
		const search = document.querySelector('.input-group input'),
			table_rows = document.querySelectorAll('tbody tr');
		console.log(table_rows)
		// 1. Searching for specific data of HTML table
		search.addEventListener('input', searchTable);

		function searchTable() {
			table_rows.forEach((row, i) => {
				let table_data = row.textContent.toLowerCase(),
					search_data = search.value.toLowerCase();

				row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
				row.style.setProperty('--delay', i / 25 + 's');
			})

			document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
				visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
			});
		}
	</script>
</body>

</html>