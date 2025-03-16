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
            margin: 5% 0 0 5%;
            border: 1px solid red;
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
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/chat.png);"></div>
                <a href="messages.php">Messages</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/settings.png);"></div>
                <a href="account.php">Account</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/switch.png);"></div>
                <a href="signout.php">Signout</a>
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
                        <div class="col-convo">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../assets/js/framework.js"></script>

<!-- 


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

                    // Open file explorer when attachment button is clicked
                    $("#attach").click(function() {
                        $("#fileInput").click();
                    });

                    // Handle file selection and display filename in input field
                    $("#fileInput").change(function() {
                        let file = this.files[0];
                        if (file) {
                            $("#message").val(file.name);
                        }
                    });
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
    </script> -->


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
            data: { ticket_id: selectedTicketId },
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
                }
            });
        } else {
            console.warn("No ticket selected.");
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

        // Open file explorer when attachment button is clicked
        $("#attach").click(function() {
            $("#fileInput").click();
        });

        // Display selected file name in message input field
        $("#fileInput").change(function() {
            let file = this.files[0];
            if (file) {
                $("#message").val(file.name);
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