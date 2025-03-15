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
    <link rel="stylesheet" href="../../assets/css/message.css">
</head>

<body>



    <div class="cards-container">
        <?php
        try {
            // Fetch all tickets from the tickets table
            $stmt = $pdo->prepare("SELECT id FROM tickets");
            $stmt->execute();
            $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($tickets) {
                foreach ($tickets as $index => $ticket) {
                    echo '<div class="card card-' . (($index % 4) + 1) . '" 
                        onclick="loadMessages(' . htmlspecialchars($ticket['id']) . ')">';
                    echo '<h1>Ticket ID: ' . htmlspecialchars($ticket['id']) . '</h1>';
                    echo '</div>';
                }
            } else {
                echo '<p>No tickets found.</p>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>


    <h1>Chat with HR/Admin</h1>

    <div class="chat-container" id="chatbox">
        <!-- Messages will be loaded here dynamically -->
    </div>


    <div class="input-area">
        <div class="attach" id="attach">Atttachment📎</div>
        <input type="text" id="message" placeholder="Type a message...">
        <button id="sendmesageBtn">Send</button>
    </div>




    <script>
        let selectedTicketId = null; // Store the selected ticket ID

        function loadMessages(ticketId = null) {
            if (ticketId) {
                selectedTicketId = ticketId;
            }

            if (!selectedTicketId) {
                console.error("No ticket selected.");
                return;
            }

            $.ajax({
                url: "../../0/includes/load_messages.php",
                type: "GET",
                data: {
                    ticket_id: selectedTicketId
                },
                success: function(response) {
                    let chatbox = $("#chatbox");
                    chatbox.html(response);
                    chatbox.scrollTop(chatbox[0].scrollHeight); // Auto-scroll to latest message
                }
            });
        }

        function sendMessage(event) {
            if (event) event.preventDefault();

            let messageText = $("#message").val().trim();

            if (messageText !== "" && selectedTicketId) {
                $.ajax({
                    url: "../../0/includes/send_message.php",
                    type: "POST",
                    data: {
                        message: messageText,
                        ticket_id: selectedTicketId
                    },
                    success: function(response) {
                        console.log(response);
                        $("#message").val(""); // Clear input field
                        loadMessages(); // Refresh messages
                    },
                    error: function(xhr, status, error) {
                        console.error("Error sending message:", error);
                    }
                });
            } else {
                console.warn("No ticket selected or message is empty.");
            }
        }

        $(document).ready(function() {
            $(".card").click(function() {
                let ticketId = $(this).attr("onclick").match(/\d+/)[0]; // Extract ticket ID
                loadMessages(ticketId);
            });

            $("#sendmesageBtn").click(function(event) {
                sendMessage(event);
            });

            $("#message").keypress(function(event) {
                if (event.which == 13) {
                    sendMessage(event);
                }
            });

            // Auto-refresh messages every second
            setInterval(() => {
                if (selectedTicketId) {
                    loadMessages();
                }
            }, 1000);
        });
    </script>

</body>

</html>