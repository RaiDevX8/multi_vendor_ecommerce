<?php
    include_once("config.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require ('PHPmailer/Exception.php');
    require ('PHPmailer/SMTP.php');
    require ('PHPmailer/PHPMailer.php');
    $errors = [];
   

    // Check if the forgot password form is submitted
    if (isset($_POST['forgot_password'])) {
        $email = $_POST['email'];

        // Check if the email exists in the client_list table
        $customerQuery = "SELECT * FROM client_list WHERE email = '$email'";
        $customerResult = mysqli_query($conn, $customerQuery);

        // Check if the email exists in the vendor_list table
        $vendorQuery = "SELECT * FROM vendor_list WHERE email = '$email'";
        $vendorResult = mysqli_query($conn, $vendorQuery);

        if (mysqli_num_rows($customerResult) > 0 || mysqli_num_rows($vendorResult) > 0) {
            $otp = rand(100000, 999999);
            
            // Store the OTP in the respective user's table
            if (mysqli_num_rows($customerResult) > 0) {
                $updateQuery = "UPDATE client_list SET otp = $otp WHERE email = '$email'";
            } else {
                $updateQuery = "UPDATE vendor_list SET otp = $otp WHERE email = '$email'";
            }

            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                $mail = new PHPMailer();

                 $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'charanrai193@gmail.com'; // Your email address
                $mail->Password = 'qmxnybzyykcxtkci'; // Your email password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
            
                // Sender and recipient information
                $mail->setFrom('charanrai193@gmail.com', 'Sculpture Center');
                $mail->addAddress($email);
            
                // Email subject and body
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset OTP Verification';
                $mail->Body = "Your OTP for password reset is: $otp<br>Please enter this OTP in the verification form.";

                if ($mail->send()) {
                    // Email sent successfully, redirect to the verification form
                    $_SESSION['email'] = $email;
                    header('location: verifyEmail.php');
                } else {
                    $errors['email_error'] = "Failed to send verification email.";
                }
            } else {
                $errors['db_errors'] = "Failed while updating OTP in the database!";
            }
        } else {
            $errors['invalidEmail'] = "Invalid Email Address";
        }
    }

    // ...
?>
