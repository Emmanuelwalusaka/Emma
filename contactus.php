<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$message = "";

$conn = mysqli_connect("localhost", "root", "", "increme");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $service = mysqli_real_escape_string($conn, $_POST['service']);
    $request = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO branding_requests
            (fullname,email,phone,service,message)
            VALUES
            ('$name','$email','$phone','$service','$request')";
if (mysqli_query($conn, $sql)) {

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // Your Gmail account
        $mail->Username = 'walusakaemmanuel@gmail.com';

        // Replace this with your Gmail App Password
        $mail->Password = 'lxzd vfmu qsfz tcve';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('walusakaemmanuel@gmail.com', 'Increme Creation');

        // Email to receive requests
        $mail->addAddress('walusakaemmanuel@gmail.com');

        $mail->Subject = 'New Branding Request';

        $mail->Body = "
Name: $name

Email: $email

Phone: $phone

Service: $service

Message:
$request
";

        $mail->send();

        $message = "Your branding request has been sent successfully and emailed.";

    } catch (Exception $e) {

        $message = "Saved to database, but email failed: " . $mail->ErrorInfo;

    }

} else {

    $message = "Failed: " . mysqli_error($conn);

}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Increme Creation Contact</title>

<style>

body{
    font-family:Arial, sans-serif;
    background:blue;
    margin:0;
}

.container{
    width:600px;
    margin:30px auto;
    background-color:aqua ;
    padding:20px;
    border-radius:10px;
}

h1{
    text-align:center;
    color:blue;
}

input,select,textarea{
    width: 550px;;
    padding:10px;
    margin-top:8px;
    margin-bottom:12px;
}

button{
    width: 250px;;
    padding:12px;
    background:green;
    color:white;
    border:none;
    font-size:18px;
    cursor:pointer;
    align-content: center;
}

button:hover{
    background:darkgreen;
}

.success{
    background:#d4edda;
    color:green;
    padding:10px;
    margin-bottom:15px;
}

.info{
    background:#f2f2f2;
    padding:10px;
    margin-bottom:20px;
}

a{
    text-decoration:none;
    color:blue;
}

</style>

</head>

<body>

<div class="container">

<h1>Contact Increme Creations</h1>

<div class="info">
<b>Email:</b> walusakaemmanuel@gmail.com<br><br>

<b>Phone:</b> 0720436246</div>

<?php
if ($message != "") {
    echo "<div class='success'>" .
         htmlspecialchars($message, ENT_QUOTES, 'UTF-8') .
         "</div>";
}
?>
<form method="POST" action="" >

<input type="text" name="name" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email Address" required>

<input type="text" name="phone" placeholder="Phone Number" required>

<select name="service" required>
    <option value="">Select Service</option>
    <option>3D Signs</option>
    <option>Road Signs</option>
    <option>Car Branding</option>
    <option>Banners</option>
</select>
<label for="message"><b>Describe Your Branding Request</b></label>

<textarea
    id="message"
    name="message"
    rows="6"
    placeholder="Describe your branding request here..."
    required></textarea>

<button type="submit">
Send Branding Request
</button>

</form>

<br>

<a href="Home.html">Back Home</a>

</div>

</body>
</html>