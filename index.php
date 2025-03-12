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
    <style>
        .container{
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            align-self: center;
            width: clamp(200px, 70%, 900px);
            height: 480px;
            border: 1px solid var(--black);
            border-radius: 8px;
            margin: 12% 0 0 0;
        }
        .container > div:nth-child(1){
            display: flex;
            flex-direction: column;
            width: 60%;
            border: 1px solid var(--black);
            border-radius: 8px;
            height: 100%;
        }
        .container > div:nth-child(2){
            display: flex;
            flex-direction: column;
            width: 40%;
            height: 100%;
            padding: 48px 24px;
        }
        .container > div:nth-child(2) > div:nth-child(1){
            text-align: center;
            padding: 0 16px;
        }
    </style>
</head>
<body>
    <div class="container row">
        <div>
            logo
        </div>
        <div>
            <div class="text-title">Welcome to MNMCH HRTS</div>
            <form method="post">
                <div class="textInputContainer">
                    <input type="text" class="textInput" placeholder=" " name="email" id="employeeID" autocomplete="off">
                    <label class="textInputLabel">Email</label>
                </div>
                <div class="textInputContainer">
                    <input type="password" class="textInput" placeholder=" " name="password" id="password" autocomplete="off">
                    <label class="textInputLabel">Password</label>
                </div>
                <input type="submit" class="btnDefault" value="Sign in">
            </form>
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