<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            color: #333333;
            margin-top: 0;
        }
        p {
            color: #555555;
            margin: 10px 0;
        }
        .highlight {
            color: #007bff;
            font-weight: bold;
        }
        .details {
            background-color: #f7f7f7;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .details p {
            margin: 8px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer p {
            color: #777777;
            font-size: 14px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Leave Application</h1>
        <p>Hello there!</p>
        <p>Your leave application details:</p>
        <div class="details">
            <p><span class="highlight">User Name:</span> {{ $user_name }}</p>
            <p><span class="highlight">Leave Heading:</span> {{ $leaveData->leave_heading }}</p>
            <p><span class="highlight">Leave Reason:</span> {!! $leaveData->leave_reason !!}</p>
            <p><span class="highlight">Total Day(s):</span> {{ $leaveData->total_day }}</p>
            <p><span class="highlight">Start Leave Date:</span> {{ $leaveData->start_leave_date }}</p>
            @if ($leaveData->end_leave_date)
                <p><span class="highlight">End Leave Date:</span> {{ $leaveData->end_leave_date }}</p>
            @endif
        </div>
        <div class="footer">
            <p>Thank you.</p>
        </div>
    </div>
</body>
</html>
