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
            margin: 5% 0 0 5%;
            border: 1px solid red;
            align-self: center;
        }
        .container-convo {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }
        .main-convo {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            position: relative;
        }
        .row-convo {
            display: flex;
            flex-direction: row;
            width: 100%;
            height: 100%;
        }
        .col-convo {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }
        .bottom-box {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background: white;
            border-top: 1px solid var(--black);
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            padding: 0;
            z-index: 1000;
        }
        .attachment {
            display: flex;
            flex-direction: column;
            width: 10%;
            height: 50%;
            border: 1px solid var(--black);
        }
        .text-attachment {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }
        .input-box {
            
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            width: 70%;
            height: 50%;
            margin-left: 10px;
            border: 1px solid var(--black);
            border-radius: 50px
        }
        .input-text {
            align-self: center;
            display: flex;
            flex-direction: column;
            width: 80%;
            height: 70%;
        }
        .textInput {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }
        .button-send {
            display: flex;
            flex-direction: column;
            margin-left: 10px;
            width: 20%;
            height: 100%;
            border: 1px solid var(--black);
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
                <a href="message.php">Messages</a>
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
                            <div class="chat-container">
                                <div class="chat-box" id="chatbox">
                                </div>
                                <div class="bottom-box">
                                    <div class="attachment">
                                        <div class="text-attachment">Attachment</div>
                                    </div>
                                    <div class="input-box">
                                        <div class="input-text">
                                            <input type="text" class="textInput" placeholder="Type a message" name="message" id="message" autocomplete="off">
                                        </div>
                                        <div class="button-send">
                                            <button class="btnDefault" type="button" name="sendBtn" id="sendBtn">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../assets/js/framework.js"></script>
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
</body>
</html>