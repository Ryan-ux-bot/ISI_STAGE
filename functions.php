<?php

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($page) {
    header("Location: $page");
    exit();
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>
