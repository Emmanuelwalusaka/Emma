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
        $mail->Password = 'izom sdlj xphu gqto';

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

        header("Location: contact.php?status=success");
exit();

    } catch (Exception $e) {

        header("Location: contact.php?status=emailerror");
exit();

    }

} else {

   header("Location: contact.php?status=dberror");
exit();

}
}
?><?php
if($message!=""){
    echo "<div class='success'>$message</div>";
}
?>
<?php
if ($message != "") {
    echo "<p style='color:green;'><b>$message</b></p>";
}
?>
<?php
if(isset($_GET['status'])){

    if($_GET['status']=="success"){
        echo "<div class='success'>
        Your branding request has been sent successfully.
        </div>";
    }

    if($_GET['status']=="emailerror"){
        echo "<div style='color:red'>
        Email could not be sent.
        </div>";
    }

    if($_GET['status']=="dberror"){
        echo "<div style='color:red'>
        Database error occurred.
        </div>";
    }

}
?>