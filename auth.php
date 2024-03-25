<<<<<<< HEAD
<?php 
    session_start();

    $timeout_duration = 300;

    if (!isset($_SESSION['custID']) || (time() - $_SESSION['last_timestamp']) > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: register.php?session_expired=1");
        exit();
    } else {
        session_regenerate_id(true);
        $_SESSION['last_timestamp'] = time();
    }
?>
=======
<?php
    session_start();
    function is_user_logged_in(): bool{
        return isset($_SESSION['username']);
    }

    function require_login(): void{
        if(!is_user_logged_in())
            header('Location: login.php');
    }

    function logout(): void{
        echo"<script>console.log('logout')</script>";
        if(is_user_logged_in()){
            if(ini_get("session.use_cookies")){
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }

            $cookie_name = "user";
            setcookie($cookie_name, "", time()-3600, "/");

            unset($_SESSION['username']);
            session_destroy();
            header('Location: login.php');
        }
    }
?>

>>>>>>> b73693ce0c000470bbaf89532cad02143f7c8cbd
