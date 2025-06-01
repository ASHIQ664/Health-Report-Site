#Hosptial Self-Checkup System
## Description
A PHP-based web application that allows patients to submit their health checkup details and lets doctors provide feedback, send emails,
and download reports.
## Technologies Used
- PHP &MySQL(XAMPP)
- HTML/CSS
- PHPMailer (for email)
- DomPDF (for PDF export)
## How to Run Locally
1. Install [XAMPP](https://www.apachefriends.org/index.html)
2. Start **Apache** and **MySQL**
3. Place this folder in: C:/xampp/htdocs/Hosptial
4. Open your browser and go to: http://localhost/Hospital/
5. Import the database:
- Go to 'http://localhost/phpadmin'
- Create a new DB named: 'hospital_checkup'
- Import the file: 'database/hospital_checkup.sql'
6. Set your database credentials inside:
'config/db.php'
##Login Roles
- **Doctors** can log in  and give feedback.
- **Patients** can register and submit checkups.
##Features
- Role-based login (Doctor/Patient)
- Patient Checkup history
- Doctor feedback + email alerts
- PDF report export
- Animated and modern UI