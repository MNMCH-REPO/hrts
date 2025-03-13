<?php
session_start(); // Start session to access user ID
require '../../0/includes/db.php'; // Include database connection (using PDO)
require '../../0/includes/accessControl.php'; // Include session functions

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User session not found.");
}
echo "User ID from session: " . $_SESSION['user_id'];


$user_id = $_SESSION['user_id']; // Get the logged-in user ID

try {
    // Fetch user details
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <title>Chat Conversation</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .chat-container {
            width: 50%;
            margin: auto;
            border: 1px solid #ccc;
            padding: 10px;
            height: 500px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            background-color: #f9f9f9;
        }
        .message {
            padding: 10px;
            border-radius: 10px;
            margin: 5px 0;
            max-width: 60%;
            word-wrap: break-word;
        }
        .sent {
            background-color: #dcf8c6;
            align-self: flex-end;
            text-align: right;
        }
        .received {
            background-color: #f1f0f0;
            align-self: flex-start;
            text-align: left;
        }
        .input-area {
            display: flex;
            margin-top: 10px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>Chat with HR/Admin</h1>

<div class="chat-container" id="chatbox">
    <!-- Messages will be loaded here dynamically -->
</div>

<div class="input-area">
    <input type="text" id="message" placeholder="Type a message...">
    <button id="sendBtn">Send</button>
</div>

<script>
// function loadMessages() {
//     $.ajax({
//         url: "../../0/includes/load_messages.php",
//         type: "GET",
//         success: function(response) {
//             let chatbox = $("#chatbox");
//             let prevScrollHeight = chatbox[0].scrollHeight;
            
//             chatbox.html(response);
            
//             // Scroll to bottom if new messages are added
//             if (chatbox[0].scrollHeight > prevScrollHeight) {
//                 chatbox.scrollTop(chatbox[0].scrollHeight);
//             }
//         }
//     });
// }

// function sendMessage() {
//     var messageText = $("#message").val().trim();

//     if (messageText !== "") {
//         $.ajax({
//             url: "../../0/includes/send_message.php",
//             type: "POST",
//             data: { message: messageText },
//             success: function(response) {
//                 console.log(response); // Debugging response
//                 $("#message").val(""); // Clear input field
//                 loadMessages(); // Refresh messages after sending
//             }
//         });
//     }
// }

// $(document).ready(function() {
//     loadMessages();
//     setInterval(loadMessages, 1000); // Auto-refresh messages every second

//     $("#sendBtn").click(function() {
//         sendMessage();
//     });

//     $("#message").keypress(function(event) {
//         if (event.which == 13) { // Enter key
//             sendMessage();
//         }
//     });
// });



function loadMessages() {
    $.ajax({
        url: "../../0/includes/load_messages.php",
        type: "GET",
        success: function(response) {
            let chatbox = $("#chatbox");
            let prevScrollHeight = chatbox[0].scrollHeight;
            
            chatbox.html(response);
            
            // Scroll to bottom if new messages are added
            if (chatbox[0].scrollHeight > prevScrollHeight) {
                chatbox.scrollTop(chatbox[0].scrollHeight);
            }
        }
    });
}

function sendMessage() {
    var messageText = $("#message").val().trim();

    if (messageText !== "") {
        $.ajax({
            url: "../../0/includes/send_message.php",
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
    setInterval(loadMessages, 1000); // Auto-refresh messages every second

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

</body>
</html>
