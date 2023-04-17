<?php
class Token {
    public static function generate() {
        $_SESSION['_csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
        return $_SESSION['_csrf_token'];
    }
}
?>