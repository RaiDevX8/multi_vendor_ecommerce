<?php
    // session_start();
    include_once("controller.php");

    if (isset($_POST['savePassword'])) {
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirmPassword = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));
        
        // Validate password and confirm password fields
        if ($password != $confirmPassword) {
            $errors['password_error'] = "Passwords do not match";
        }

        if (empty($errors)) {
            if (isset($_SESSION['email']) && isset($_SESSION['user_type'])) {
                $email = $_SESSION['email'];
                $userType = $_SESSION['user_type'];

                // Update the password in the respective table based on user type
                if ($userType === "customer") {
                    $updateQuery = "UPDATE client_list SET password = '$password' WHERE email = '$email' AND otp = '$_SESSION[OTP]'";
                } elseif ($userType === "vendor") {
                    $updateQuery = "UPDATE vendor_list SET password = '$password' WHERE email = '$email' AND otp = '$_SESSION[OTP]'";
                }

                if (isset($updateQuery) && mysqli_query($conn, $updateQuery)) {
                    // Password update successful, redirect to login page or display a success message
                    header('location: login.php');
                    exit();
                } else {
                    $errors['update_error'] = "Error updating password";
                }
            } else {
                $errors['session_error'] = "Invalid session data. Please try again.";
            }
        }
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .container {
            max-width: 400px;
            padding: 50px;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        
        form {
            text-align: center;
            
        }
        
        input[type="password"] {
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
        
        .alert {
            background-color: #f44336;
            color: #fff;
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="" method="POST">
            <?php
            if (isset($_SESSION['message'])) {
                ?>
                <div class="alert"><?php echo $_SESSION['message']; ?></div>
                <?php
            }

            if (isset($errors['password_error'])) {
                ?>
                <div class="alert"><?php echo $errors['password_error']; ?></div>
                <?php
            }

            if (isset($errors['update_error'])) {
                ?>
                <div class="alert"><?php echo $errors['update_error']; ?></div>
                <?php
            }

            if (isset($errors['session_error'])) {
                ?>
                <div class="alert"><?php echo $errors['session_error']; ?></div>
                <?php
            }
            ?>
            <input type="password" name="password" placeholder="New Password" required><br>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
            
            <input type="submit" name="savePassword" value="Save">
        </form>
    </div>
</body>
</html>
