<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location:../login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>Thank You</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Inter', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container{
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
        }
        h2{
            color: #1e3a8a;
            margin-bottom: 20px;
        }
        p {
            color: #444;
            margin-bottom: 15px;

        }
        a, button{
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 12px 20px;
            margin: 10px 5px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(37,99,235,0.2);
            transition: all 0.2s ease;
        }
        a:hover, button:hover {
            background-color: #1e40af;
            transform: translateY(-2px);
        }
        form {
            display:inline;
        }
        @keyframes popIn{
            0%{
                transform: scale(0);
                opacity: 0;
            }
            80%{
                transform: scale(1.1);
                opacity: 1;
            }
            100%{
                transform: scale(1);
            }
        }
        .success-icon{
            font-size: 48px;
            color: #22c55e;
            margin-bottom: 15px;
            animation: popIn 0.6s ease-out;
        }
    </style>
</head>
<body>
<div class = "container">
    <div class="success-icon">✅</div>
    <h2>Thank You for Completing the checkup!!</h2>
    <p>Your Checkup Record has been submitted sucessfully.</p>
    <p>You may return to your dashboard or log out below.</p>

    <a href = "dashboard.php"><button>Back to dashboard</button></a><br><br>
    <form method="POST" action="logout.php">
        <button type="submit">Logout</button>
    </div>
</form>
</body>
</html>