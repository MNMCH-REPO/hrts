<?php
    require_once '0/includes/signin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" type="image/jpg" href="assets/images/icons/logo.jpg">
    <title>Sign in</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/index.css" />
</head>
<body>
    <div class="container">
        <div class="logo-panel">
            <img src="assets/images/icons/logo.jpg" alt="METRONORTH Logo" class="logo-img">
            <div class="logo-text">
                <span class="metro">METRO</span><span class="north">NORTH</span>
                <h5>MEDICAL CENTER AND HOSPITAL, INC.</h5>
            </div>
        </div>

        <div class="form-panel">
            <div class="text-title">Welcome to MNMCH HRTS</div>
            <form method="post">
                <div class="textInputContainer">
                    <input 
                        type="text" 
                        class="textInput <?= !empty($emailError) ? 'error' : '' ?>" 
                        name="email" 
                        id="employeeID" 
                        autocomplete="off"
                        placeholder=" "
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    >
                    <label class="textInputLabel">Email</label>
                    <?php if (!empty($emailError)): ?>
                        <small class="error-message"><?= $emailError ?></small>
                    <?php endif; ?>
                </div>

                <div class="textInputContainer">
                    <input 
                        type="password" 
                        class="textInput <?= !empty($passwordError) ? 'error' : '' ?>" 
                        name="password" 
                        id="password" 
                        autocomplete="off"
                        placeholder=" "
                    >
                    <label class="textInputLabel">Password</label>
                    <?php if (!empty($passwordError)): ?>
                        <small class="error-message"><?= $passwordError ?></small>
                    <?php endif; ?>
                </div>
                <div class="btnContainer">
                    <input type="submit" class="btnDefault" value="Sign in">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
