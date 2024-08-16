<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$host = '127.0.0.1'; // Database host
$dbName = 'justdigi_raj_jdg_portal'; // Database name
$username = 'justdigi_raj_jdg_portal_user'; // Database username
$password = 'UZ_N(IczA^nO'; // Database password // Database password

$conn = new mysqli($host, $username, $password, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$formattedDate = date('d-m-Y');
$currentMonth = date('n');
$currentYear = date('Y');

$users_q = "SELECT users.* FROM users 
            JOIN model_has_roles ON users.id = model_has_roles.model_id
            JOIN roles ON model_has_roles.role_id = roles.id
            WHERE users.status = 'Active' AND roles.name = 'user' OR roles.name = 'HR' OR roles.name = 'Management Team'";

$user_res = mysqli_query($conn, $users_q);

while ($row = mysqli_fetch_assoc($user_res)) {
    $user_id = $row['id'];

    $kpipoints = "INSERT INTO `kpipoints`(`user_id`, `ctm_points`, `month`, `year`, `created_at`, `updated_at`) VALUES ('$user_id', '0', '$currentMonth', '$currentYear', NOW(), NOW())";

    if (mysqli_query($conn, $kpipoints)) {
        echo "KPI Point Added succeessfully";
    } else {
        echo "KPI Point Added Not ";
    }
}
