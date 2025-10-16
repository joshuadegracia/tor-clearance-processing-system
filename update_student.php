<?php
// update_student.php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.
require 'config.php'; // adjust path if needed

$con = get_db_connection();

/*
// helper to return JSON and exit
function json_resp($status, $message) {
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// get POST values safely (preserve names expected by your AJAX)
$sid_post   = isset($_POST['sid'])   ? trim($_POST['sid'])   : '';
$last_post  = isset($_POST['last'])  ? trim($_POST['last'])  : '';
$first_post = isset($_POST['first']) ? trim($_POST['first']) : '';
$mid_post   = isset($_POST['mid'])   ? trim($_POST['mid'])   : '';
$corss_post = isset($_POST['corss']) ? trim($_POST['corss']) : '';

// original id: prefer 'stid' if provided; otherwise fall back to 'sid'
$stid = isset($_POST['stid']) ? trim($_POST['stid']) : $sid_post;

if ($stid === '') {
    json_resp('error', 'Missing student identifier (stid or sid).');
}

// basic validation
if ($last_post === '' || $first_post === '') {
    json_resp('error', 'First name and last name are required.');
}

// sanitize for SQL
$stid_safe   = mysqli_real_escape_string($con, $stid);
$last_safe   = mysqli_real_escape_string($con, strtoupper($last_post));
$first_safe  = mysqli_real_escape_string($con, strtoupper($first_post));
$mid_safe    = mysqli_real_escape_string($con, strtoupper($mid_post));
$corss_safe  = mysqli_real_escape_string($con, $corss_post);

// IMPORTANT: Do NOT change student_ID to avoid duplicate primary key issues.
// Update only the non-PK fields.
$sql = "
    UPDATE student_list
    SET lastname = '{$last_safe}',
        firstname = '{$first_safe}',
        middlename = '{$mid_safe}',
        course = '{$corss_safe}'
    WHERE student_ID = '{$stid_safe}'
";

$res = mysqli_query($con, $sql);

if ($res) {
    json_resp('success', 'Student updated successfully.');
} else {
    // return DB error for debugging (you can hide this in production)
    $err = mysqli_error($con);
    json_resp('error', 'Database error: ' . $err);
}
*/
echo json_encode($_POST);
