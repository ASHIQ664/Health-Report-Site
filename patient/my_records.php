<?php
session_start();
require '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location:../login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("Select c.*, f.feedback FROM checkups c LEFT JOIN doctor_feedback f on c.id = f.checkup_id WHERE c.user_id = ?
ORDER BY c.created_at DESC");
$stmt->execute([$user_id]);
$records = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Check up Records </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            padding: 40px;
            color: #1a202c;
        }
        h2{
            color: #1e3a8a;
            margin-bottom: 20px;
        }
        a.button-link, button{
            display: inline-block;
            padding: 10px 20px;
            background-color:  #2563eb;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(37,99,235,0.2);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 20px;
        }
        a.button-link:hover, button:hover{
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37,99,235,0.3)
        }
        table{
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            animation: fadeSlideIn 0.6s;
        }
        th {
            background-color: #1e40af;
            color: white;
            text-align: left;
            padding: 12px 16px;
            border-radius: 8px 8px 0 0;
            font-size: 14px;
        }
        td{
            background-color: white;
            padding: 14px 16px;
            color: #2d3748;
            font-size: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: background 0.3s ease;
        }
        tr:hover td{
            background-color: #f1f5f9;
        }
        @keyframes fadeSlideIn{
            from{
                opacity:0;
                transform: translateY(15px);
            }
            to{
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <h2>My Checkup Records. </h2>
    <a href="dashboard.php" class ="button-link">Back to dashboard</a><br><br>

    <?php if($records): ?>
        <table  cellpadding="8">
            <tr>
                <th>Date</th>
                <th>Temperature</th>
                <th>Blood Pressure</th>
                <th>Sugar Level</th>
                <th>Pain Level</th>
                <th>Medicines</th>
                <th>Feeling</th>
                <th>Feedback</th>
            </tr>
            <?php foreach ($records as $rec): ?>
                <tr>
                    <td><?= htmlspecialchars($rec['created_at']) ?></td>
                    <td><?= htmlspecialchars($rec['temperature']) ?></td>
                    <td><?= htmlspecialchars($rec['blood_pressure']) ?></td>
                    <td><?= htmlspecialchars($rec['sugar_level']) ?></td>
                    <td><?= htmlspecialchars($rec['pain_level']) ?></td>
                    <td><?= nl2br(htmlspecialchars($rec['medicines'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($rec['feeling'])) ?></td>
                    <td><?= $rec['feedback'] ? nl2br(htmlspecialchars($rec['feedback'])): 'No feedback yet' ?></td>
               </tr>
               <?php endforeach; ?>
            </table>
            <?php else: ?>
                <p>No records Found.</p>
            <?php endif; ?>
            </body>
            </html>
