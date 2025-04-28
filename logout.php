<?php
session_start();
session_unset(); // очищает все данные сессии
session_destroy(); // уничтожает сессию
header('Location: login.php');
exit;
