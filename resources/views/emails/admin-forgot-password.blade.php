<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: black;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header img {
            max-width: 100px;
            margin-bottom: 10px;
        }

        .content {
            padding: 20px;
        }

        .content h1 {
            color: #007bff;
            font-size: 24px;
            margin-top: 0;
        }

        .content p {
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .content .password {
            display: inline-block;
            font-size: 18px;
            background-color: #f1f1f1;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .content .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .content .cta-button:hover {
            background-color: #0056b3;
        }

        .footer {
            background-color: #f4f4f4;
            padding: 10px 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://app.gocoompany.com/logo.png" alt="Company Logo">
            <h2>GoTap</h2>
        </div>
        <div class="content">
            <h1>Hello, {{ $admin->name }}</h1>

            <a href="{{route('admin.password.reset', [$admin->remember_token])}}">
                Reset Password
            </a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} GoTap. All rights reserved. <br>
        </div>
    </div>
</body>

</html>
