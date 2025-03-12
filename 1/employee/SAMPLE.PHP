<?php
session_start(); // Start session to access user ID

require '../../0/includes/db.php'; // Include database connection (using PDO)

require '../../0/includes/accessControl.php'; // Include session functions

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../0/includes/index.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user ID

try {
    // Prepare and execute query using PDO
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If user not found, redirect
    if (!$user) {
        header('Location: ../../0/includes/index.php');
        exit();
    }
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>smaple convo</title>
</head>

<body>

    <h1>This is a smaple conversation</h1>



    <?php

    // Check if the user is an employee
    if ($user['role'] === 'Employee') {
        echo '<p>Welcome, </p>' . $user['role']  . '<br>';
        echo $users_id = $user['id'] . '<br>';
        echo $user['name'];
    } else {
        echo '<p>Access denied. You are not an employee.</p>';
    }


    ?>


    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="conversation">
                        <div class="box-bottom">
                            <div class="box">
                                <div class="box-top">
                                    <div class="box-top-left">
                                        <div class="box-top-left-img">
                                            <img src="assets/img/1.jpg" alt="">
                                        </div>
                                        <?php
                                        require '../../0/includes/load_messages.php';
                                        require '../../0/includes/send_message.php';


                                        ?>
                                        
                                        "here will be displayed the conversation between the employee and the admin or hr dependin on their role and id if the id of the employee match after they logged in and redirect here thier reply or sent messages will be displayedd at the right and if not the other reply of the conversation will be displayed at the left side note that the converation will look like the messenger but not the design can you do it using the ajax with this code"
                                        <script>
        function loadMessages() {
            $.ajax({
                url: "0/includes/load_messages.php",
                type: "GET",
                success: function(response) {
                    let chatbox = $("#chatbox");
                    let prevScrollHeight = chatbox[0].scrollHeight;

                    let newMessages = $(response).html();
                    if (chatbox.html() !== newMessages) {
                        chatbox.html(response);
                        chatbox.scrollTop(chatbox[0].scrollHeight);
                    }
                }
            });
        }

        function sendMessage() {
            var messageText = $("#message").val().trim();

            if (messageText !== "") {
                $.ajax({
                    url: "0/includes/send_message.php",
                    type: "POST",
                    data: { message: messageText },
                    success: function(response) {
                        console.log(response); // Debugging response
                        $("#message").val(""); // Clear input field
                        loadMessages(); // Refresh messages after sending
                    }
                });
            }
        }

        $(document).ready(function() {
            loadMessages();
            setInterval(loadMessages, 1000);

            $("#sendBtn").click(function() {
                sendMessage();
            });

            $("#message").keypress(function(event) {
                if (event.which == 13) { // Enter key
                    sendMessage();
                }
            });
        });
    </script>

                                    </div>
                                    
                                </div>
                                <div class="box-bottom">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>















</body>

</html>