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
    </style>
</head>

<body>
    <div class="container">
        <div class="sideNav">
            <div class="sideNavLogo img-cover"></div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/ticket.png);"></div>
                <a href="order.php">Tickets</a>
            </div>

            <div class="navBtn currentPage">
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


            <?php
            require_once '../../0/includes/db.php'; // Include your database connection file

            // Fetch user data from the database
            $userId = $_SESSION['user_id']; // Assuming the user ID is stored in the session

            try {
                $stmt = $pdo->prepare("SELECT name, email, role, department FROM users WHERE id = :id");
                $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$user) {
                    die("User not found.");
                }
            } catch (PDOException $e) {
                die("Database error: " . $e->getMessage());
            }
            ?>

            <div class="container-account">
                <div class="account-box">
                    <form action="" id="editAccountForm" method="POST">
                        <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($userId); ?>">
                        <h2 class="account-box-title">Account Information</h2>
                        <p class="account-description">
                            Account information will display your current details such as name, email, role, and department.
                        </p>

                        <div class="account-box-content">
                            <label class="account-box-content-row">
                                <span class="account-box-content-row-label">Full Name</span>
                                <input type="text" id="fullName" name="employeeName" value="<?php echo htmlspecialchars($user['name']); ?>" class="account-input" readonly>
                            </label>

                            <label class="account-box-content-row">
                                <span class="account-box-content-row-label">Email</span>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="account-input" readonly>
                            </label>

                            <label class="account-box-content-row">
                                <span class="account-box-content-row-label">Role</span>
                                <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($user['role']); ?>" class="account-input" readonly>
                            </label>

                            <label class="account-box-content-row">
                                <span class="account-box-content-row-label">Department</span>
                                <input type="text" id="department" name="department" value="<?php echo htmlspecialchars($user['department']); ?>" class="account-input" readonly>
                            </label>

                            <p class="change-password-text">
                                IF YOU WANT TO CHANGE YOUR PASSWORD <a href="accountPassword.php" class="change-password-link">CLICK THIS</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../../assets/js/framework.js"></script>

    <script>
        // JavaScript to handle form submission and AJAX request

        document.addEventListener("DOMContentLoaded", function() {
            const editAccountForm = document.getElementById("editAccountForm");

            editAccountForm.addEventListener("submit", async function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Collect form data
                const formData = new FormData(editAccountForm);

                try {
                    // Send the form data to the backend using fetch
                    const response = await fetch("../../0/includes/editProfile.php", {
                        method: "POST",
                        body: formData,
                    });

                    const data = await response.json();

                    if (data.success) {
                        alert(data.message); // Show success message
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert(data.message); // Show error message
                    }
                } catch (error) {
                    console.error("Error submitting the form:", error);
                    alert("An error occurred while updating the account.");
                }
            });
        });
    </script>
</body>

</html>