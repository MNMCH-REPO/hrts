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
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/ticket.png);"></div>
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
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/settings.png);"></div>
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
                    <div class="row-convo">
                        
                        <div class="cards-container">
                                <?php
                                require_once '../../0/includes/db.php';

                                if (!isset($_SESSION['user_id'])) {
                                    exit('User not logged in.');
                                }

                                $stmt = $pdo->prepare("SELECT t.id, u.name AS assigned_name 
                       FROM tickets t 
                       JOIN users u ON t.assigned_to = u.id
                       WHERE t.employee_id = :employee_id");
                                $stmt->bindParam(':employee_id', $_SESSION['user_id'], PDO::PARAM_INT);
                                $stmt->execute();
                                $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                if ($tickets) {
                                    foreach ($tickets as $index => $ticket) {
                                        echo '<div class="card card-' . (($index % 4) + 1) . '" 
                                              onclick="loadMessages(' . htmlspecialchars($ticket['id']) . ', \'' . htmlspecialchars($ticket['assigned_name']) . '\')">';
                                        echo '<h1>Ticket ID: ' . htmlspecialchars($ticket['id']) . '</h1>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>No tickets assigned to you.</p>';
                                }
                                ?>

                            </div>


                           
                            <div class="col-convo">
                            <div class="chat-container" id="chatbox">
                                <!-- Messages will be loaded here -->

                            </div>


                            <div class="input-area">
                                <input type="file" id="fileInput" style="display: none;"> <!-- Hidden file input -->
                                <div class="attach" id="attach">Attachment📎</div>
                                <input type="text" id="message" placeholder="Type a message...">
                                <button id="sendmesageBtn">Send</button>
                            </div>



                        </div>


                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer-messages">
        <p>All rights reserved to Metro North Medical Center and Hospital, Inc.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../assets/js/framework.js"></script>

    <script>



        let selectedTicketId = null;
let refreshInterval = null;
let socket = null; // Declare socket globally

function loadMessages(ticketId = null, assignedName = null) {
  if (ticketId && ticketId !== selectedTicketId) {
    selectedTicketId = ticketId;

    $("#message").val("");       // Clear message input
    $("#fileInput").val("");     // Clear file input

    // Clear existing interval
    if (refreshInterval) clearInterval(refreshInterval);

    // Auto-refresh messages every second
    refreshInterval = setInterval(() => {
      loadMessages(); // Refresh only if same ticket is still selected
    }, 1000);
  }

  if (!selectedTicketId) {
    console.error("No ticket selected.");
    return;
  }

  if (assignedName) {
    $("#assignedName").text("You are now having a conversation with: " + assignedName);
  }

  // Load messages via AJAX
  $.ajax({
    url: "../../0/includes/load_messages.php",
    type: "GET",
    data: { ticket_id: selectedTicketId },
    success: function (response) {
      let chatbox = $("#chatbox");
      chatbox.html(response);
      chatbox.scrollTop(chatbox[0].scrollHeight);
    },
    error: function (xhr, status, error) {
      console.error("Error loading messages:", error);
    }
  });
}

function connectWebSocket() {
  socket = new WebSocket("ws://your-websocket-server-url");

  socket.onopen = function () {
    console.log("WebSocket connection established.");
  };

  socket.onmessage = function (event) {
    const data = JSON.parse(event.data);

    if (data.ticket_id === selectedTicketId) {
      updateChatbox(data.message);
    }
  };

  socket.onerror = function (error) {
    console.error("WebSocket error:", error);
  };

  socket.onclose = function () {
    console.log("WebSocket closed. Reconnecting...");
    setTimeout(connectWebSocket, 5000);
  };
}

function updateChatbox(message) {
  const chatbox = $("#chatbox");
  const messageDiv = `
    <div class="message">
      <p><strong>${message.sender}:</strong> ${message.text}</p>
      <small>${message.time}</small>
    </div>
  `;
  chatbox.append(messageDiv);
  chatbox.scrollTop(chatbox[0].scrollHeight);
}

function selectTicket(ticketId) {
  selectedTicketId = ticketId;

  if (socket && socket.readyState === WebSocket.OPEN) {
    socket.send(JSON.stringify({ action: "select_ticket", ticket_id: ticketId }));
  }

  loadMessages(ticketId);
}





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