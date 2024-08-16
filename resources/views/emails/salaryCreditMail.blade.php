<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Credited Information</title>
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
            color: #007f00;
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
        <pre>
            <p>{{ $salary_message }}</p>
        </pre>
    </div>
</body>
</html>
