<?php
session_set_cookie_params(0);
session_start();
session_destroy();

header("location: http://127.0.0.1:5500/pages/sign-in.html");
exit();
?>
