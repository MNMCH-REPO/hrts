<?php
require_once '../../0/includes/employeeTicket.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/framework.css">
    <title>Tickets</title>
    <style>
        .content {
            display: flex;
            flex-direction: column;
            width: 80%;
            min-height: 90vh;
            margin: 5% 0 0 260px;
            align-self: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sideNav">
            <div class="sideNavLogo img-cover"></div>

            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/ticket.png);"></div>
                <a href="ticket.php">Tickets</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/leave.png);"></div>
                <a href="leave.php">Leave Management</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/chat.png);"></div>
                <a href="message.php">Messages</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/settings.png);"></div>
                <a href="account.php">Account</a>

            </div>

            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/switch.png);"></div>
                <a href="../../0/includes/signout.php">Signout</a>
            </div>
        </div>
        <div class="content">
            <div class="topNav">
                <div class="account">
                    <div class="accountName">John Doe</div>
                    <div class="accountIcon img-contain"></div>
                </div>
            </div>

            <style>
                .container-account {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    width: 80%;
                    min-height: 70vh;
                    margin: 5% auto;
                    border-radius: 10px;
                    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                    padding: 30px;
                    background: white;
                }

                .account-box {
                    width: 100%;
                    max-width: 600px;
                    background: #fff;
                    padding: 20px;
                    border-radius: 10px;
                    text-align: center;
                }

                .account-box-title {
                    font-size: 22px;
                    font-weight: bold;
                    margin-bottom: 10px;
                }

                .account-description {
                    font-size: 14px;
                    color: #555;
                    margin-bottom: 20px;
                }

                .account-box-content-row {
                    display: flex;
                    flex-direction: column;
                    margin-bottom: 15px;
                }

                .account-box-content-row-label {
                    font-size: 14px;
                    font-weight: 500;
                    margin-bottom: 5px;
                    text-align: left;
                }

                .account-input {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    font-size: 14px;
                    background: #f8f8f8;
                }

                .change-password-text {
                    font-size: 12px;
                    margin-top: 15px;
                    text-align: center;
                }

                .change-password-link {
                    color: blue;
                    font-weight: bold;
                    text-decoration: none;
                    cursor: pointer;
                }

                .btnDefault {
                    border-radius: 50px;
                }

                .btnDanger {
                    border-radius: 50px;
                    text-decoration: none;
                }
            </style>




            <div class="container-account">
                <div class="account-box">
                    <h2 class="account-box-title">Change Password</h2>
                    <p class="account-description">
                        The password must be alphanumeric and at least 8 characters long.
                    </p>

                    <form id="updatePasswordForm" method="POST">
                        <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($userId); ?>">
                        <div class="account-box-content">
                            <label class="account-box-content-row">
                                <span class="account-box-content-row-label">Old Password</span>
                                <input type="password" id="oldPassword" name="oldPassword" class="account-input" required>
                            </label>

                            <label class="account-box-content-row">
                                <span class="account-box-content-row-label">New Password</span>
                                <input type="password" id="newPassword" name="newPassword" class="account-input" required>
                            </label>

                            <label class="account-box-content-row">
                                <span class="account-box-content-row-label">Confirm Password</span>
                                <input type="password" id="confirmPassword" name="confirmPassword" class="account-input" required>
                            </label>

                            <div class="btnContainer">
                                <button type="submit" name="updatePassword" class="btnDefault">Save Changes</button>
                                <a href="account.php" class="btnDanger">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script src="../../assets/js/framework.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const updatePasswordForm = document.getElementById("updatePasswordForm");
            const submitButton = updatePasswordForm.querySelector('button[type="submit"]');

            updatePasswordForm.addEventListener("submit", async function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Collect form data
                const formData = new FormData(updatePasswordForm);

                // Client-side validation
                const oldPassword = formData.get("oldPassword");
                const newPassword = formData.get("newPassword");
                const confirmPassword = formData.get("confirmPassword");

                // Validate new password length and alphanumeric requirement
                if (newPassword.length < 8 || !/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]+$/.test(newPassword)) {
                    alert("New password must be at least 8 characters long, alphanumeric, and may include special characters.");
                    return;
                }

                // Validate new password and confirm password match
                if (newPassword !== confirmPassword) {
                    alert("New password and confirm password do not match.");
                    return;
                }

                try {
                    // Disable the submit button to prevent multiple submissions
                    submitButton.disabled = true;

                    // Send the form data to the backend using fetch
                    const response = await fetch("../../0/includes/changePassword.php", {
                        method: "POST",
                        body: formData,
                    });

                    // Check if the response is valid JSON
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.success) {
                        alert(data.message); // Show success message
                        window.location.href = "accountPassword.php"; // Redirect to account page
                    } else {
                        alert(data.message); // Show error message
                    }
                } catch (error) {
                    console.error("Error updating password:", error);
                    alert("An error occurred while updating the password. Please try again.");
                } finally {
                    // Re-enable the submit button
                    submitButton.disabled = false;
                }
            });
        });
    </script>
</body>

</html>