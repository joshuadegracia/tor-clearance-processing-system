<?php

function base_url($path = '') {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $base = $protocol . $host . str_replace(basename($script), '', $script);
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

function site_url($path = '') {
    return base_url($path);
}

function get_db_connection() {
    return mysqli_connect("localhost", "root", "", "tor_cps", "3306");
}

function get_sms_api_key() {
    return 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU0MjcwMDQ5NCwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjY0MzUyLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.7B6LgWanGsrr2tfVVRwqA0xUlncyhRE6CZOYKbf-oW0';
}

function get_admin_info(?string $id)
{
    $conn = get_db_connection();

    $sql = "SELECT admin_firstname, admin_lastname, admin_middlename FROM `admin` WHERE `admin_ID` = '" . mysqli_real_escape_string($conn, $id) . "'";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $fullname = trim($row['admin_firstname'] . ' ' . $row['admin_middlename'] . ' ' . $row['admin_lastname']);
        mysqli_free_result($res);
        mysqli_close($conn);
        return $fullname;
    } else {
        mysqli_close($conn);
        return null;
    }
}
?>
