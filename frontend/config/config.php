<?php



define('BASE_URL', 'http://localhost:8080/laundry/frontend');
define('API_URL_USERS', 'http://localhost:8000');
define('API_URL_SERVICES', 'http://localhost:8001');

function cekLogin()
{
    if (isset($_SESSION['name']) && isset($_SESSION['email']) || isset($_SESSION['token'])) {
        return true;
    } else {
        header('Location:login.php');
    }
}
