<?php
require_once '0/includes/signin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/framework.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <title>Sign in</title>
</head>

<body>
    <div class="container">
        <form method="post">
            <div>Login Form</div>
            <div class="textInputContainer">
                <input type="text" class="textInput" placeholder=" " autocomplete="off">
                <label class="textInputLabel">User Name</label>
            </div>
            <div class="col-md-6">
                <div class="form-container">
                    <div class="h1">Welcome to MNMCH HRTS</div>
                    <div class="form">
                        <form action="0/includes/signin.php" method="post">
                            <div class="textInputContainer">
                                <input type="text" class="textInput" placeholder=" " name="employeeID" id="employeeID" autocomplete="off">
                                <label class="textInputLabel">Employee ID</label>
                            </div>
                            <div class="textInputContainer">
                                <input type="password" class="textInput" placeholder=" " name="password" id="password" autocomplete="off">
                                <label class="textInputLabel">Password</label>
                            </div>
                            <button class="btnDefault" name="loginBtn" id="loginBtn">Login</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <script src="assets/js/framework.js"></script>
        <script>
        if(errorMessage){Toastify({
            text: errorMessage,
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "center",
            stopOnFocus: true,
            style: {
                background: "var(--danger)",
            },
            onClick: function(){}
        }).showToast();}
    </script>
</body>

</html>