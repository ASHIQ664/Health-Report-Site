<?php
session_start();
require '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name FROM users WHERE id =?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Dashboard - Badar Al Samma</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *{
            box-sizing: border-box;
        }
        body{
            font-family: 'Inter',  sans-serif;
            background-color:#f9fafb;
            margin: 0;
            padding: 0;
            color: #1a202c;
        }
        header{
            background-color: #1e3a8a;
            color: white;
            text-align: center;
            padding: 30px 0;
        }
        .dashboard-container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
        }
        h2{
            color: #1e3a8a;
            margin-bottom: 10px;
        }
        p {
            font-size: 16px;
            margin-bottom: 30px;
        }
        button, a.button-link {
            display: inline-block;
            padding: 12px 24px;
            background-color: #2563eb;
            color:rgb(243, 245, 252);
            font-weight: 600;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(37,99,235,0.2);
            transition: transform: 0.2s ease, box-shadow 0.2s ease;
            margin: 10px 0;
        }
        a.button-link:hover,button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37,99,235,0.3)
        }
    
        form {
            display: inline;
        }
        @keyframes fadeIn{
            from{ opacity: 0; transform: translateY(20px);}
            to{ opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <header>
        <h1> Patient Dashboard </h1>
    </header>
    <div class="dashboard-container">
    <h2>Welcome, <?= htmlspecialchars($user['name']) ?>!</h2>
    <p> You are logged in.</p>

    <a href="checkup_form.php" class="button-link">Start Self Checkup</a><br><br>
    <a href="my_records.php" class="button-link">View My Records</a><br><br>
    <form method = "POST" action="logout.php">
        <button type="submit">Logout</button>
</form>
    </div>
</body>
</html>