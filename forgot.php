<?php include_once ("controller.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg'); /* Replace 'background.jpg' with your desired image */
            background-size: cover;
           /* Adjust the blur intensity as needed */
        }
        
        #container {
            background-color: rgba(255, 255, 255, 0.8); /* Blurred white background */
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 400px;
            margin: 0 auto;
            padding: 40px;
            margin-top: 100px;
        }
        
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        p {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
        }
        
        #line {
            height: 2px;
            background-color: #333;
            margin-bottom: 30px;
        }
        
        form {
            text-align: center;
        }
        
        input[type="email"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }
        
        input[type="submit"] {
            background-color: #c0392b;
            color: #fff;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        input[type="submit"]:hover {
            background-color: #a93226;
        }
        
        #alert {
            background-color: #e74c3c;
            color: #fff;
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <div id="container">
        <h2>Email Check</h2>
        <p>It's quick and easy.</p>
        <div id="line"></div>
        <form action="forgot.php" method="POST" autocomplete="off">
            <?php
            if ($errors > 0) {
                foreach ($errors as $displayErrors) {
            ?>
                    <div id="alert"><?php echo $displayErrors; ?></div>
            <?php
                }
            }
            ?>
            <input type="email" name="email" placeholder="Email"><br>
            <input type="submit" name="forgot_password" value="Check">
        </form>
    </div>
</body>

</html>
