<?php
require_once '../../0/includes/employeeTicket.php';
require_once '../../0/includes/adminTableQuery.php'; // Include the query file
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
    <link rel="stylesheet" href="../../assets/css/message.css">
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
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/dashboard.png);"></div>
                <a href="dashboard.php">Dashboard</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/ticket.png);"></div>
                <a href="ticket.php">Tickets</a>
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
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/management.png);"></div>
                <a href="management.php">Management</a>
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
            <div class="main-convo">
                <div class="container-convo">

                    <div class="chat-container" id="chatbox">
                        <!-- Messages will be loaded here -->

                    </div>

                    <div class="cards-container">
                        <?php
                        require_once '../../0/includes/db.php';

                        if (!isset($_SESSION['user_id'])) {
                            exit('User not logged in.');
                        }

                        $admin_ID = $_SESSION['user_id'];

                        try {
                            // Fetch all tickets
                            $stmt = $pdo->prepare("
            SELECT 
                t.id, 
                t.subject, 
                u2.department, -- Fetch the department from the user who created the ticket
                t.description, 
                t.priority, 
                t.status,
                t.created_at,
                COALESCE(u1.name, 'Unassigned') AS assigned_name, -- Assigned to
                u2.name AS employee_name -- Employee who created the ticket
            FROM tickets t
            LEFT JOIN users u1 ON t.assigned_to = u1.id -- Join to get the assigned user's name
            LEFT JOIN users u2 ON t.employee_id = u2.id -- Join to get the employee's name and department
            ORDER BY t.updated_at DESC; -- Sort by newest update
        ");
                            $stmt->execute();
                            $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if ($tickets) {
                                foreach ($tickets as $index => $ticket) {
                                    echo '<div class="card card-' . (($index % 4) + 1) . '" 
                      data-ticket-id="' . htmlspecialchars($ticket['id']) . '">';
                                    echo '<h1>Ticket ID: ' . htmlspecialchars($ticket['id']) . '</h1>';
                                    echo '<h1>Employee Name: ' . htmlspecialchars($ticket['employee_name'] ?? 'N/A') . '</h1>';
                                    echo '<h1>Department: ' . htmlspecialchars($ticket['department'] ?? 'N/A') . '</h1>';
                                    echo '<h1>Subject: ' . htmlspecialchars($ticket['subject'] ?? 'N/A') . '</h1>';
                                    echo '<h1>Assigned Name: ' . htmlspecialchars($ticket['assigned_name'] ?? 'Unassigned') . '</h1>';
                                    echo '<h1>Priority: ' . htmlspecialchars($ticket['priority'] ?? 'N/A') . '</h1>';
                                    echo '<h1>Status: ' . htmlspecialchars($ticket['status'] ?? 'N/A') . '</h1>';
                                    echo '<h1>Created At: ' . htmlspecialchars($ticket['created_at'] ?? 'N/A') . '</h1>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>No tickets found.</p>';
                            }
                        } catch (PDOException $e) {
                            echo 'Error fetching tickets: ' . $e->getMessage();
                        }
                        ?>
                    </div>



                    <div class="input-area" id="inputAreaID">
                        <input type="file" name="file" id="fileInput" style="display: none;"> <!-- Hidden file input -->
                        <div class="attach" id="attach">Attachment📎</div>
                        <input type="text" id="message" placeholder="Type a message...">
                        <button id="sendmesageBtn">Send</button>
                    </div>


                    <br><br>
                    <div class="footer" style="text-align: center;">
                        <p>All rights reserved ©</p>
                    </div>

                </div>

            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../../assets/js/framework.js"></script>




        <script>
            $(document).ready(function() {
                // Handle card click to load messages
                $(document).on("click", ".card", function() {
                    const ticketId = $(this).data("ticket-id");
                    if (ticketId) {
                        loadMessages(ticketId);
                    } else {
                        console.warn("No ticket ID found for this card.");
                    }
                });

                // Function to load messages for a specific ticket
                function loadMessages(ticketId) {
                    $.ajax({
                        url: "../../0/includes/load_messages.php",
                        type: "GET",
                        data: {
                            ticket_id: ticketId
                        },
                        success: function(response) {
                            $("#chatbox").html(response); // Load messages into the chatbox
                        },
                        error: function(xhr, status, error) {
                            console.error("Error loading messages:", error);
                            $("#chatbox").html("<p>Error loading messages.</p>");
                        },
                    });
                }
            });
        </script>


















        <script>
           

function uploadFile(fileInput, ticketId, callback) {
  let formData = new FormData();
  formData.append("ticket_id", ticketId);
  formData.append("file", fileInput);

  $.ajax({
    url: "../../0/includes/upload_file.php", // New backend file for file uploads
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      console.log("File uploaded successfully:", response);
      if (response.success) {
        if (callback) callback(response); // Call the callback function after file upload
      } else {
        console.error("File upload failed:", response.message);
        alert(response.message); // Show error message to the user
      }
    },
    error: function (xhr, status, error) {
      console.error("Error uploading file:", error);
      alert("An error occurred while uploading the file.");
    },
  });
}

function sendMessage(event) {
  if (event) event.preventDefault();

  let messageText = $("#message").val().trim();
  let fileInput = $("#fileInput")[0].files[0];

  if (!selectedTicketId) {
    console.warn("No ticket selected.");
    alert("Please select a ticket before sending a message.");
    return;
  }

  if (fileInput) {
    // Upload the file first, then send the message
    uploadFile(fileInput, selectedTicketId, function (fileResponse) {
      // After file upload, send the message
      sendTextMessage(messageText);
    });
  } else {
    // If no file, just send the message
    sendTextMessage(messageText);
  }
}

function sendTextMessage(messageText) {
  if (!messageText) {
    console.warn("No message to send.");
    alert("Please enter a message before sending.");
    return;
  }

  let formData = new FormData();
  formData.append("ticket_id", selectedTicketId);
  formData.append("message", messageText);

  $.ajax({
    url: "../../0/includes/send_message.php", // Existing backend for sending messages
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      console.log("Message sent successfully:", response);
      if (response.success) {
        $("#message").val(""); // Clear message input
        loadMessages(); // Refresh messages
      } else {
        console.error("Message sending failed:", response.message);
        alert(response.message); // Show error message to the user
      }
    },
    error: function (xhr, status, error) {
      console.error("Error sending message:", error);
      alert("An error occurred while sending the message.");
    },
  });
}

$(document).ready(function () {
  // Handle file attachment
  $("#attach").click(function () {
    $("#fileInput").click(); // Trigger the hidden file input
  });

  // Display selected file name inside the message input field
  $("#fileInput").change(function () {
    let file = this.files[0];
    if (file) {
      $("#message").val(`${file.name}`); // Set the file name in the message input
    } else {
      $("#message").val(""); // Clear the message input if no file is selected
    }
  });

  // Handle send button click
  $("#sendmesageBtn").click(function (event) {
    sendMessage(event);
  });

  // Handle Enter key press in the message input
  $("#message").keypress(function (event) {
    if (event.which == 13) {
      sendMessage(event);
    }
  });
});
        </script>

</body>

</html>