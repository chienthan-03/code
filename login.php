<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <?php
    require_once("dbConnection.php");
    session_start();
    $error_username = $error_password = $error_access = '';
    $result = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM admin"));
    if (isset($_POST['submit'])) {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = mysqli_real_escape_string($mysqli, $_POST['password']);
        if (empty($username) || empty($password)) {
            // Validate form data
            if (empty($username)) {
                $error_username = "Vui lòng nhập username";
            }

            if (empty($password)) {
                $error_password = "Vui lòng nhập password";
            }
        } else {
            if (
                $username == $result['username']
                && $password == $result['password']
            ) {
                $_SESSION['username'] = $_POST['username'];
                header('location: index.php');
            } else {
                $error_access = "tài khoản không phải admin";
            }
        }
    }
    ?>
    <main class="table">
        <section class="table__header">
            <h2 style="margin-left: 26px">Account management</h2>
        </section>
        <section class="table__body">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="add">
                <div class="input__control">
                    <label for="username">Username:</label> <br />
                    <input type="text" name="username" class="input__basic" value="">
                    <p class="text__error"><?php echo $error_username; ?></p>
                </div>
                <div class="input__control">
                    <label for="password">Password:</label> <br />
                    <input type="password" name="password" class="input__basic" value="">
                    <p class="text__error"><?php echo $error_password; ?></p>
                </div>
                <div class="input__control right">
                    <input type="submit" name="submit" class="btn btn__primary" value="Login">
                </div>
                <p class="text__error" style="margin-left: 26px;"><?php echo  $error_access ? $error_access . '*' : ''; ?></p>
            </form>
        </section>
    </main>
</body>

</html>