<?php
session_start();
require '../config/db.php';

if(!isset($_SESSION['user_id'])) {
    header("Location:../login.php");
    exit();
}

$errors =[];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $full_name = trim($_POST["full_name"]);
    $phone = trim($_POST["phone"]);
    $temperature = $_POST["temperature"];
    $blood_pressure = $_POST["blood_pressure"];
    $sugar_level = $_POST["sugar_level"];
    $pain_level = $_POST["pain_level"];
    $medicines = $_POST["medicines"];
    $feeling = $_POST["feeling"];

    if(empty($full_name) || empty($phone)){
        $errors[] = "Full name and phone number are required.";
    } 
    if(empty($errors)) {
        $_SESSION['checkup_data'] =[
            'full_name' => $full_name,
            'phone' => $phone,
            'temperature' => $temperature,
            'blood_pressure' => $blood_pressure,
            'sugar_level' => $sugar_level,
            'pain_level' => $pain_level,
            'medicines' => $medicines,
            'feeling' => $feeling
        ];

        header("Location: payment.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Self Checkup form </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *{
            box-sizing: border-box;
        }
        body{
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header{
           background-color: #1e3a8a;
           color: white;
           padding: 20px;
           text-align: center;
        }
        header h2{
            margin: 0;
            font-size: 24px;
            color:white;
        }
        .container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn{
            from{
                opacity: 0; transform: translateY(20px);
            }
            to{
                opacity: 1; transform: translateY(0);
            }
        }
        h2{
            text-align: center;
            color: #1e3a8a;
            margin-bottom: 30px;
        }
        .progress-bar {
            width: 100%;
            background-color: #e6f2ff;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 30px;
            height: 16px;
        }
        .progress-bar-fill {
            width: 50%;
            background-color: #2563eb;
            height: 100%;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        input[type="text"],
        textarea{
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }
        textarea{
            resize: vertical;
        }
        .button, button {
            width: 100%;
            padding: 14px;
            background-color: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(37,99,235,0.25);
            transition: background-color 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 20px;
        }
        .button:hover,button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(37,99,235,0.35);
        }
        .error-list {
            background-color: #ffe6e6;
            padding: 15px;
            border: 1px solid #ff5c5c;
            border-radius: 6px;
            margin-bottom: 20px;
            color: #b30000;
        }
        .error-list li {
            margin-bottom: 6px;
        }
    </style>
</head>
<body>
<header>
    <h2>Self checkup Form</h2>
    </header>
    <div class = "container">
    <div style = "display:flex; justify-content: flex-start; margin-bottom: 20px;">
        <a href = "dashboard.php" class = "button" style="width:auto;">&larr; Back to Dashboard</a>
    </div>
<div class = "progress-bar">
    <div class = "progress-bar-fill"></div>
    </div>
<?php if($errors): ?>
    <ul class="error-list">
        <?php foreach ($errors as $e): ?>
            <li style="color:red"><?= htmlspecialchars($e) ?> </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<h3 style = "text-align: center; color: #1e3a8a; margin-bottom: 20px;">Self Checkup Form</h3>
<form method="POST">
    <label>Full name: <input type="text" name="full_name" required></label>
    <label>Phone: <input type="text" name="phone" required></label>
    <label>Temperature: <input type="text" name="temperature"></label>
    <label>Blood Pressure: <input type="text" name="blood_pressure"></label>
    <label>Sugar Level: <input type="text" name="sugar_level" required></label>
    <label>Pain/Discomfort Level: <input type="text" name="pain_level" required></label>
    <label>Medicines You're currently taking:<br>
        <textarea name="medicines" rows="3" cols="40"></textarea>
        </label><br><br>
    <label>How are you feeling?<br>
    <textarea name="feeling" rows="3" cols="40"></textarea>
        </label>
    <button type="submit">Proceed to Payment</button>
</form>
</div>
</body>
</html>

