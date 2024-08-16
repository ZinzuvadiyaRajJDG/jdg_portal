<?php


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



$salary = "SELECT * FROM salaries";
$salary_res = mysqli_query($conn, $salary);

$users_id = [];
while($row = mysqli_fetch_assoc($salary_res))
{
    $users_id[] = $row['user_id'];    
}

$unique_users_id = array_unique($users_id);

foreach ($unique_users_id as $user_id) {

    $user_status_query = "SELECT status FROM users WHERE id = '$user_id'";
    $user_status_res = mysqli_query($conn, $user_status_query);
    $user_status_row = mysqli_fetch_assoc($user_status_res);

    if ($user_status_row['status'] == 'Active') {

        $q = "SELECT * FROM salaries WHERE `user_id` = '$user_id' ORDER BY year DESC,month DESC LIMIT 1";
        $res = mysqli_query($conn, $q);

        $roww = mysqli_fetch_assoc($res);
        if($roww['month'] != $currentMonth && $roww['year'] != $currentMonth)
        {

            $roww_salary = $roww['salary'];
            $daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

            $roww_perday = $roww_salary/$daysInCurrentMonth;
            $insert_salary = "INSERT INTO `salaries`(`user_id`, `salary`, `status`,`created_at`, `updated_at`, `perday`, `month`, `year`) VALUES ('$user_id', '$roww_salary','unpaid', NOW(), NOW(),'$roww_perday', '$currentMonth', '$currentYear')";

            if(mysqli_query($conn, $insert_salary))
            {
                echo "successfull | ";
            }
        }

    }

}
