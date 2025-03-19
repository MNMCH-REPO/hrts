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
        .content{
            display: flex;
            flex-direction: column;
            width: 80%;
            min-height: 90vh;
            margin: 5% 0 0 5%;
            align-self: center;
        }
        .plateRow {
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 0 0 32px 0;
        }
        .plate {
            width: 300px;
            height: 180px;
            background-color: var(--primary-300);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: 600;
            border-radius: 8px;
        }
        .tableContainer {
            display: flex;
            flex-direction: column;
            border: 1px solid var(--neutral-300);
            border-radius: 8px;
            overflow: hidden;
        }
        .tableRow {
            display: flex;
        }
        .tableHeader {
            background-color: var(--neutral-300);
            font-weight: bold;
        }
        .tableCell {
            flex: 1;
            padding: 12px;
            border-bottom: 1px solid var(--neutral-200);
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
                <a href="">Account</a>
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
            <div class="row plateRow">
                <div class="col plate" id="plate1">0</div>
                <div class="col plate" id="plate2">0</div>
                <div class="col plate" id="plate3">0</div>
                <div class="col plate" id="plate4">0</div>
            </div>
            <div class="tableContainer">
                <div class="tableRow tableHeader">
                    <div class="tableCell">Column 1</div>
                    <div class="tableCell">Column 2</div>
                    <div class="tableCell">Column 3</div>
                    <div class="tableCell">Column 4</div>
                    <div class="tableCell">Column 5</div>
                </div>
                <div class="tableRow">
                    <div class="tableCell">Data 1</div>
                    <div class="tableCell">Data 2</div>
                    <div class="tableCell">Data 3</div>
                    <div class="tableCell">Data 4</div>
                    <div class="tableCell">Data 5</div>
                </div>
                <div class="tableRow">
                    <div class="tableCell">Data 1</div>
                    <div class="tableCell">Data 2</div>
                    <div class="tableCell">Data 3</div>
                    <div class="tableCell">Data 4</div>
                    <div class="tableCell">Data 5</div>
                </div>
                <div class="tableRow">
                    <div class="tableCell">Data 1</div>
                    <div class="tableCell">Data 2</div>
                    <div class="tableCell">Data 3</div>
                    <div class="tableCell">Data 4</div>
                    <div class="tableCell">Data 5</div>
                </div>
                <div class="tableRow">
                    <div class="tableCell">Data 1</div>
                    <div class="tableCell">Data 2</div>
                    <div class="tableCell">Data 3</div>
                    <div class="tableCell">Data 4</div>
                    <div class="tableCell">Data 5</div>
                </div>
                <div class="tableRow">
                    <div class="tableCell">Data 1</div>
                    <div class="tableCell">Data 2</div>
                    <div class="tableCell">Data 3</div>
                    <div class="tableCell">Data 4</div>
                    <div class="tableCell">Data 5</div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../assets/js/framework.js"></script>
</body>
</html>