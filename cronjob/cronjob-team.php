<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = '127.0.0.1'; // Database host
$dbName = 'justdigi_raj_jdg_portal'; // Database name
$username = 'justdigi_raj_jdg_portal_user'; // Database username
$password = 'UZ_N(IczA^nO'; // Database password

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
            WHERE users.status = 'Active' AND roles.name = 'Management Team'";



$user_res = mysqli_query($conn, $users_q);
// echo "<pre>";
// var_dump(mysqli_fetch_array($user_res));
// exit();
while ($row = mysqli_fetch_assoc($user_res)) {

    $user_id = $row['id'];
    $dayOfWeek = date('w');

    $holiday_q = "SELECT * FROM holidays";
    $holiday_res = mysqli_query($conn, $holiday_q);

    while ($holiday = mysqli_fetch_assoc($holiday_res)) {

        if (isset($holiday['end_date'])) {

            $dates = getBetweenDates($holiday['date'], $holiday['end_date']);
            foreach ($dates as $date) {
                // echo $date. " | ".  $formattedDate;
                if ($date == $formattedDate) {
                    $status = 'paid holiday';
                    $day = 'full day';
                    break;
                } else {
                    $leave = "SELECT * FROM leaves WHERE `user_id` = '$user_id' AND (`day` = 'paid holiday' OR `day` = 'casual leave') AND (`start_leave_date` = '$formattedDate' OR `end_leave_date` = '$formattedDate') AND `status` = 'approved' ";
                    $leave_res = mysqli_query($conn, $leave);
                    $leaveRowCount = mysqli_num_rows($leave_res);
                    if ($leaveRowCount >= 1) {
                        $day = 'paid holiday';
                        $status = 'paid holiday';
                        break;
                    } else {
                        if ($dayOfWeek === '0') {
                            $status = 'paid holiday';
                            $day = 'full day';
                        } else {
                            $day = 'paid holiday';
                            $status = 'present';
                        }
                    }
                }
            }
        } else {

            if ($holiday['date'] == $formattedDate) {
                $status = 'paid holiday';
                $day = 'full day';
            } else {
                $leave = "SELECT * FROM leaves WHERE `user_id` = '$user_id' AND (`day` = 'paid holiday' OR `day` = 'casual leave') AND (`start_leave_date` = '$formattedDate' OR `end_leave_date` = '$formattedDate') AND `status` = 'approved' ";
                $leave_res = mysqli_query($conn, $leave);
                $leaveRowCount = mysqli_num_rows($leave_res);
                if ($leaveRowCount >= 1) {
                    $day = 'paid holiday';
                    $status = 'paid holiday';
                } else {
                    if ($dayOfWeek === '0') {
                        $status = 'paid holiday';
                        $day = 'full day';
                    } else {
                        $day = 'full day';
                        $status = 'present';
                    }
                }
            }
        }

    }

    // exit();

    $attendance = "INSERT INTO `attendances`(`user_id`, `date`, `status`, `day`, `late`, `month`, `year`) VALUES ('$user_id', '$formattedDate', '$status', '$day', '0', '$currentMonth', '$currentYear')";
    // echo $attendance . "<br>";
    if (mysqli_query($conn, $attendance)) {
        echo "Attendance Added succeessfully";
    } else {
        echo "Attendance Added Not ";
    }


}

function getBetweenDates($startDate, $endDate)
{
    // echo "<pre>" . print_r($holiday_data, true) . "</pre>";

    $rangArray = [];

    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
        $date = date('d-m-Y', $currentDate);
        $rangArray[] = $date;
    }

    return $rangArray;
}
?>