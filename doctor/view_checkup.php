<?php
session_start();
require '../config/db.php';
require '../config/mailer.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'doctor'){
    header("Location:..//login.php");
    exit();
}
if(!isset($_GET['id'])){
    echo "Checkup ID not provided.";
    exit();
}

$checkup_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT c.*, u.name AS patient_name, u.email AS 
patient_email FROM checkups c JOIN users u ON c.user_id = u.id WHERE c.id =?");
$stmt->execute([$checkup_id]);
$checkup = $stmt->fetch();
$patient_id = $checkup['user_id'];
$historyStmt = $pdo->prepare("SELECT * FROM checkups WHERE user_id = ? and id != ? ORDER BY created_at DESC");
$historyStmt->execute([$patient_id,$checkup_id]);
$history = $historyStmt->fetchAll();

$feedbackStmt = $pdo->prepare("SELECT f.feedback, f.created_at, d.name, c.created_at AS checkup_date
FROM doctor_feedback f JOIN users d ON f.doctor_id = d.id JOIN checkups c ON f.checkup_id = c.id
WHERE c.user_id = ? ORDER BY f.created_at DESC");
$feedbackStmt->execute([$patient_id]);
$feedbackHistory = $feedbackStmt->fetchAll();

if(!$checkup){
    echo "Checkup record not found";
    exit();
}
$errors = [];
$success ="";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $feedback = trim($_POST['feedback']);

    if(empty($feedback)){
        $errors[]= "feedback cannot be empty";
    }
    else{
        $stmt = $pdo->prepare("INSERT INTO doctor_feedback (checkup_id, doctor_id, feedback, created_at)
        VALUES (?,?,?,NOW())");
        $stmt->execute([$checkup_id, $_SESSION['user_id'], $feedback]);

        $to = $checkup['patient_email'];
        $subject = "Doctor feedback to Your Check up";
        $body = "Dear" . $checkup['full_name'] . ",\n\nHere is your feedback from the doctor:\n\n" . $feedback;

        if(sendMail($to, $subject, $body)){
            $sucess = "Feedback submitted and email sent to the patient";
        }
        else{
            $errors[]= "Feedback saved but failed to send email";
        }
    }
} 
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Checkup </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            padding: 40px;
            color: #1a202c;
        }
        h2, h3{
            color: #1e3a8a;
        }
        p{
            margin: 6px 0;
        }
        a.button-link, button {
            display:inline-block;
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
            margin-right: 10px;
            margin-bottom: 20px;
        }
        a.button-link:hover, button:hover {
           transform: translateY(-2px);
           box-shadow: 0 6px 16px rgba(37,99,235,0.3);
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
            borer-radius: 8px 8px 0 0;
            font-size: 14px;
        }

        td {
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
                opacity: 0;
                transform: translateY(15px);  
                }
            to{
                opacity: 1;
                transform: translateY(0);
            }
        }
        textarea{
            width: 100%;
            max-width: 600px;
            padding: 10px;
            font-size: 15px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
        }
        hr {
            margin: 40px 0 20px;
            border: none;
            border-top: 1px solid #e2e8f0;
        }
        .back-link{
            background: #e2e8f0;
            color: #1e3a8a;
        }
        .back-link:hover {
            background-color: #cbd5e1;
        }
        ul {
            color:red;
        }
        .success{
            color:green;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <a href ="export_pdf.php?id=<?= $checkup['id'] ?>" class="button-link" target="_blank">
        <button type="button">Download PDF Report</button>
</a>
    <h2>Checkup Details for <?= htmlspecialchars($checkup['full_name']) ?></h2>
    <p><strong>Phone:</strong><?= htmlspecialchars($checkup['phone']) ?></p>
    <p><strong>Temperature:</strong><?= htmlspecialchars($checkup['temperature']) ?></p>
    <p><strong>BloodPressure:</strong><?= htmlspecialchars($checkup['blood_pressure']) ?></p>
    <p><strong>SugarLevel:</strong><?= htmlspecialchars($checkup['sugar_level']) ?></p>
    <p><strong>PainLevel:</strong><?= htmlspecialchars($checkup['pain_level']) ?></p>
    <p><strong>Medicines currently taking:</strong><?= nl2br(htmlspecialchars($checkup['medicines'])) ?></p>
    <p><strong>Feeling:</strong><?= nl2br(htmlspecialchars($checkup['feeling'])) ?></p>

    <hr>
    <h3>Write Feedback</h3>
    <?php if($errors): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if($success): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <form method="POST">
        <textarea name="feedback" rows="5" cols="50" placeholder="Write Your feedback here..."></textarea><br><br>
        <button type="submit">Send Feedback</button>
    </form>
    <br>
    <a href="dashboard.php" class="button-link back-link">Back to Dashboard</a>
<?php if($history): ?>
    <hr>
    <h3> Previous Check up History </h3>
    <table>
        <tr>
            <th>Date</th>
            <th>Temperature</th>
            <th>Blood Pressure</th>
            <th>Sugar Level</th>
            <th>Pain level</th>
            <th>Medicines</th>
            <th>Feeling</th>
</tr>
<?php foreach($history as $h): ?>
    <tr>
        <td><?= htmlspecialchars($h['created_at']) ?></td>
        <td><?= htmlspecialchars($h['temperature']) ?></td>
        <td><?= htmlspecialchars($h['blood_pressure']) ?></td>
        <td><?= htmlspecialchars($h['sugar_level']) ?></td>
        <td><?= htmlspecialchars($h['pain_level']) ?></td>
        <td><?= nl2br(htmlspecialchars($h['medicines'])) ?></td>
        <td><?= nl2br(htmlspecialchars($h['feeling'])) ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
<?php if ($feedbackHistory): ?>
    <hr>
    <h3>Doctor Feedback History</h3>
    <table>
        <tr>
            <th>Date</th>
            <th>Doctor</th>
            <th>Feedback</th>
            <th>Checkup Date</th>
        </tr>
        <?php foreach ($feedbackHistory as $fb): ?>
            <tr>
                <td><?= htmlspecialchars($fb['created_at']) ?></td>
                <td><?= htmlspecialchars($fb['name']) ?></td>
                <td><?= nl2br(htmlspecialchars($fb['feedback'])) ?></td>
                <td><?= htmlspecialchars($fb['checkup_date']) ?></td>
        </tr>
        <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p>No feedback history available.</p>
        <?php endif; ?>
    </body>
    </html>