<!DOCTYPE html>
<html>
<head>
    <title>New User Registration Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #2196F3;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
        }
        .user-info {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New User Registration</h1>
        </div>
        <div class="content">
            <p>Hello {{ $admin->name }},</p>
            <p>A new user has registered on the platform. Here are their details:</p>
            
            <div class="user-info">
                <p><strong>Name:</strong> {{ $newUser->name }}</p>
                <p><strong>Email:</strong> {{ $newUser->email }}</p>
                <p><strong>Registration Date:</strong> {{ $newUser->created_at->format('F j, Y H:i:s') }}</p>
            </div>

            <p>You can view the user's profile by clicking the button below:</p>
            <a href="{{ url('/admin/users/' . $newUser->id) }}" class="button">View User Profile</a>

            <p>Please review this new registration at your earliest convenience.</p>
            <p>Best regards,<br>The System</p>
        </div>
        <div class="footer">
            <p>This is an automated message, please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html> 