<?php
session_start();
?>
<!Doctype html>
<html>
    <head>
        <title> About us </title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f9fafb;
                padding: 40px;
                color: #1a202c;
                animation: fadeSlideIn 0.6s;
            }
            h1{
                color: #1e3a8a;
                font-size: 32px;
                margin-bottom: 20px;
            }
            p{
                font-size: 16px;
                line-height: 1.7;
                color: #2d3748;
                margin-bottom: 20px;
            }
            .button-link{
                display: inline-block;
                padding: 10px 20px;
                background: linear-gradient(to right, #2563eb, #1d4ed8);
                color: white;
                font-weight: 600;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                text-decoration: none;
                box-shadow: 0 4px 12px rgba(37,99,235,0.2);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                margin-top: 30px;
            }
            .button-link:hover {
                transform: translateY(-2px);
                box=shadow: 0 6px 16px rgba(37,99,235,0.3);
            }
            @keyframe fadeSlideIn{
                from{
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            </style>
            </head>
            <body>
                <h1>About Us </h1>
                <p> Welcome to our Badar Al Samma Hospital Self-Checkup Portal - a digital platform designed to empower patients and
                    improve doctor efficiency.</p>
                <p>Patients can submit their health checkup details from the comfort of their home, while doctors can provide
                    feedback, track history and  manage records seamlessly.</p>
                <p>This system ensures a faster, paperless experience with instant notification, secure storage, and easy communication 
                    between doctor and patient </p>
                <p>Built as part of the diploma project, this system uses PHP,MySQL, HTML/CSS, PHPMailer, and XAMPP to create a robust,
                    easy-to-use health care interface</p>
                <h1> Team </h2>
                <p> Ashiq Ambi Das - 23f24053 </p>
                <p> Abdullah Nabil Al-Balushi - 21s21183 </p>
                <p> Mohammad Abdullah AlZarafi - 21F22078 </p>
                <p> Yasir Khalid Rahim Dad Al Bulushi - 21F21917 </p>
                <a href = "index.html" class = "button-link">Back to HomePage</a>
        
        </body>
</html>