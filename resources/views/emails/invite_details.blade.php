<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Invitation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .email-header {
            background: #007bff;
            color: #ffffff;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .email-header img {
            max-width: 50px;
            margin-right: 10px;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 1.5em;
        }
        .email-body {
            padding: 20px;
        }
        .email-body p {
            margin: 1em 0;
            line-height: 1.5;
        }
        .email-footer {
            background: #f4f4f4;
            padding: 10px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ asset('images/favicon.png') }}" alt="Company Logo">
            <h1>Scrumbled</h1>
        </div>
        <div class="email-body">
            <p>Hello {{$user->full_name}},</p>
            <p>User {{ $inviter->username }} invited you to join {{ $project->title }}!</p>
            <p>Click here to view the invitation:</p>
            <a href="{{ $url }}" class="btn">View Invitation</a>
            <p>Thank you,<br>Scrumbled Team</p>
        </div>
        <div class="email-footer">
            <p>&copy; 2024 Scrumbled. All rights reserved.</p>
        </div>
    </div>
</body>
</html>