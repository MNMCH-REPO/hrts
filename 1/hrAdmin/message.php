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

                    <div class="chat-container" id="chatbox">
                        <!-- Messages will be loaded here -->

                    </div>

                    <div class="cards-container">
                        <?php
                        require_once '../../0/includes/db.php';
                        if (!isset($_SESSION['user_id'])) {
                            exit('User not logged in.');
                        }

                        $user_id = $_SESSION['user_id'];
                        $canReply = false; // Default to false
                        try {
                            // Fetch the role of the current user
                            $roleStmt = $pdo->prepare("SELECT role FROM users WHERE id = :user_id");
                            $roleStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                            $roleStmt->execute();
                            $userRole = $roleStmt->fetchColumn();

                            if (!$userRole) {
                                exit("Error: Unable to determine user role.");
                            }

                            // Fetch tickets assigned to the logged-in user or all tickets if Admin
                            if ($userRole === 'Admin') {
                                // Admin can view all tickets
                                $stmt = $pdo->prepare("
                SELECT 
                    t.id, 
                    t.subject, 
                    u2.department, 
                    t.description, 
                    t.priority, 
                    t.status,
                    t.created_at,
                    COALESCE(u1.name, 'Unassigned') AS assigned_name, -- Assigned to
                    u2.name AS employee_name -- Employee who created the ticket
                FROM tickets t
                LEFT JOIN users u1 ON t.assigned_to = u1.id -- Join to get the assigned user's name
                LEFT JOIN users u2 ON t.employee_id = u2.id -- Join to get the employee's name and department
            ");
                            } else {
                                // Non-Admin users can only view tickets assigned to or submitted by them
                                $stmt = $pdo->prepare("
                SELECT 
                    t.id, 
                    t.subject, 
                    u2.department, 
                    t.description, 
                    t.priority, 
                    t.status,
                    t.created_at,
                    COALESCE(u1.name, 'Unassigned') AS assigned_name, -- Assigned to
                    u2.name AS employee_name -- Employee who created the ticket
                FROM tickets t
                LEFT JOIN users u1 ON t.assigned_to = u1.id -- Join to get the assigned user's name
                LEFT JOIN users u2 ON t.employee_id = u2.id -- Join to get the employee's name and department
                WHERE t.assigned_to = :user_id OR t.employee_id = :user_id
            ");
                                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                            }

                            $stmt->execute();
                            $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if ($tickets) {
                                foreach ($tickets as $index => $ticket) {
                                    // Determine if the user can reply to the ticket
                                    if ($userRole === 'Admin') {
                                        // Admin can reply only if the ticket is assigned to or submitted by them
                                        if ($ticket['assigned_name'] === $user_id || $ticket['employee_name'] === $user_id) {
                                            $canReply = true;
                                        }
                                    } else {
                                        // Non-Admin users can reply only to tickets assigned to or submitted by them
                                        $canReply = true;
                                    }

                                    echo '<div class="card card-' . (($index % 4) + 1) . '" 
                      onclick="loadMessages(' . htmlspecialchars($ticket['id']) . ', \'' . htmlspecialchars($ticket['assigned_name']) . '\')">';
                                    echo '<h1>Ticket ID: ' . htmlspecialchars($ticket['id']) . '</h1>';
                                    echo '<h1>Employee Name: ' . htmlspecialchars($ticket['employee_name']) . '</h1>';
                                    echo '<h1>Department: ' . htmlspecialchars($ticket['department']) . '</h1>';
                                    echo '<h1>Subject: ' . htmlspecialchars($ticket['subject']) . '</h1>';
                                    echo '<h1>Assigned Name: ' . htmlspecialchars($ticket['assigned_name']) . '</h1>';
                                    echo '<h1>Priority: ' . htmlspecialchars($ticket['priority']) . '</h1>';
                                    echo '<h1>Status: ' . htmlspecialchars($ticket['status']) . '</h1>';
                                    echo '<h1>Created At: ' . htmlspecialchars($ticket['created_at']) . '</h1>';
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

                    <!-- Reply Input Area -->
                    <div class="input-area">
                        <?php
                        // Display the reply input area only if the user can reply
                        if ($canReply) {
                            echo '<input type="file" id="fileInput" style="display: none;"> <!-- Hidden file input -->';
                            echo '<div class="attach" id="attach">Attachment📎</div>';
                            echo '<input type="text" id="message" placeholder="Type a message...">';
                            echo '<button id="sendmesageBtn">Send</button>';
                        } else {
                            echo "<p class=\"above-footer\" style=\"text-align: center;\">You can view this conversation but cannot reply to it.</p>";

                        }
                        ?>
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
            let selectedTicketId = null;
            let refreshInterval = null; // Store interval reference

            function loadMessages(ticketId = null, assignedName = null) {
                if (ticketId && ticketId !== selectedTicketId) {
                    selectedTicketId = ticketId;

                    // ✅ Clear previous interval before setting a new one
                    if (refreshInterval) {
                        clearInterval(refreshInterval);
                    }

                    // ✅ Start a new interval for auto-refresh
                    refreshInterval = setInterval(() => {
                        loadMessages();
                    }, 6000);
                }

                if (!selectedTicketId) {
                    console.error("No ticket selected.");
                    return;
                }

                if (assignedName) {
                    $("#assignedName").text(
                        "You are now having a conversation with: " + assignedName
                    );
                }

                $.ajax({
                    url: "../../0/includes/load_messages.php",
                    type: "GET",
                    data: {
                        ticket_id: selectedTicketId,
                    },
                    success: function(response) {
                        let chatbox = $("#chatbox");
                        chatbox.html(response);
                        chatbox.scrollTop(chatbox[0].scrollHeight);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading messages:", error);
                    },
                });
            }

            function sendMessage(event) {
                if (event) event.preventDefault();

                let messageText = $("#message").val().trim();
                let fileInput = $("#fileInput")[0].files[0];
                let formData = new FormData();

                if (selectedTicketId) {
                    formData.append("ticket_id", selectedTicketId);
                    if (fileInput) {
                        formData.append("file", fileInput);
                    } else if (messageText !== "") {
                        formData.append("message", messageText);
                    } else {
                        console.warn("No message or file selected.");
                        return;
                    }

                    $.ajax({
                        url: "../../0/includes/send_message.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
                            $("#message").val(""); // Clear message input
                            $("#fileInput").val(""); // Clear file input
                            loadMessages(); // Refresh messages
                        },
                        error: function(xhr, status, error) {
                            console.error("Error sending message:", error);
                        },
                    });
                } else {
                    console.warn("No ticket selected.");
                }
            }

            $(document).ready(function() {
                $(document).on("click", ".card", function() {
                    let ticketId = parseInt($(this).attr("onclick").match(/\d+/)[0]);
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

                $("#attach").click(function() {
                    $("#fileInput").click();
                });

                $("#fileInput").change(function() {
                    let file = this.files[0];
                    if (file) {
                        $("#message").val(file.name);
                    }
                });
            });
        </script>

</body>

</html>