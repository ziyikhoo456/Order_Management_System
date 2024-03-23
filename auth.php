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

