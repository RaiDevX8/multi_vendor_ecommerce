<?php
    include_once("controller.php");


    if (isset($_POST['verifyEmail'])) {
        $OTPverify = mysqli_real_escape_string($conn, $_POST['OTPverify']);

        // Check if the OTP exists in the client_list table
        $customerVerifyQuery = "SELECT * FROM client_list WHERE otp = '$OTPverify'";
        $customerVerifyResult = mysqli_query($conn, $customerVerifyQuery);

        // Check if the OTP exists in the vendor_list table
        $vendorVerifyQuery = "SELECT * FROM vendor_list WHERE otp = '$OTPverify'";
        $vendorVerifyResult = mysqli_query($conn, $vendorVerifyQuery);

        if (mysqli_num_rows($customerVerifyResult) > 0) {
            $user = mysqli_fetch_assoc($customerVerifyResult);
            $email = $user['email'];
            $userType = 'customer';
        } elseif (mysqli_num_rows($vendorVerifyResult) > 0) {
            $user = mysqli_fetch_assoc($vendorVerifyResult);
            $email = $user['email'];
            $userType = 'vendor';
        } else {
            $errors['verification_error'] = "Invalid Verification otp";
        }

        if (isset($email) && isset($userType)) {
            $_SESSION['email'] = $email;
            $_SESSION['user_type'] = $userType;
            $_SESSION['OTP'] = $OTPverify;
            header('location: newPassword.php');
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification Form</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }
        
        #container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }
        
        p {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }
        
        input[type="number"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }
        
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        @media (max-width: 600px) {
            #container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div id="container">
        <h2>Email</h2>
        <p>It's quick and easy.</p>
        <div id="line"></div>
        <form action="" method="POST" autocomplete="off">
            <?php
            if(isset($_SESSION['message'])){
                ?>
                <div id="alert"><?php echo $_SESSION['message']; ?></div>
                <?php
            }
            ?>

            <input type="number" name="OTPverify" placeholder="Verification code" required><br>
            <input type="submit" name="verifyEmail" value="Verify">
        </form>
    </div>
</body>
</html>
