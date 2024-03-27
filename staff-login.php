<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Login</title>
</head>

<body>
    <div class="login-container">

        <?php
        require('./config/constant.php');
        session_start();

        if (isset($_SESSION['error'])) {
            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']); 
        }
        ?>

        <form action="staff.php" method="post">
            <input type="hidden" name="action" value="login">
            <div>
                <label for="staffname">Staff Name:</label>
                <input type="text" id="staffname" name="staffname" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>