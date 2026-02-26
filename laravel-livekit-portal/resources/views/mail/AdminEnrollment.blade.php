<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $data['subject'] ?? 'New Student Enrollement' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 0;
            margin: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #0d6efd;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 10px 0;
        }
        .details {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #0d6efd;
        }
        .details p {
            margin: 5px 0;
        }
        .footer {
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #777;
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            Enrollment Confirmation
        </div>
        <div class="content">
            <p>Dear Admin </p>
            <p>A NewStudent Enrolled ! </p>

            <div class="details">
                <p><strong>Student Name:</strong> {{ $data['student_name'] }}</p>
                <p><strong>Phone Number:</strong> {{ $data['phone'] }}</p>
                <p><strong>Course Name:</strong> {{ $data['course_name'] }}</p>
                <p><strong>Total Price:</strong> ${{ $data['course_price'] }}</p>
            </div>

            <p>{{ $data['message'] ?? 'Check this Student As Soon As Possible' }}</p>
            @isset($data["Score"])
                    <p><strong>Score:</strong> {{ $data["Score"] }}%</p>
                @endisset


            <p>Best regards,<br>Laravel Academy</p>
        </div>
        <div class="footer">
            © {{ date('Y') }} Laravel Academy. All rights reserved.
        </div>
    </div>
</body>
</html>
