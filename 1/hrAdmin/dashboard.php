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

        .plateRow {
            flex-wrap: wrap;
            justify-content: space-evenly;
            gap: 8px;
            margin: 0 0 32px 0;
        }

        .plate {
            position: relative;
            width: 300px;
            height: 180px;
            background-color: var(--primary-300);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: 600;
            border-radius: 8px;
            overflow: hidden;
        }
        .plateIcon{
            position: absolute;
            top: 26%;
            left: -12%;
            width: 55%;
            aspect-ratio: 1/1;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .plateContent{
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: white;
            width: 60%;
            height: 100%;
            align-self: flex-end;
            padding: 5% 0;
        }
        .plateTitle{
            font-size: 24px;
            font-weight: 500;
            width: 100%;
            min-height: 32px;
        }
        .plateValue{
            font-size: 48px;
            font-weight: 600;
            width: 100%;
            min-height: 32px;
            text-align: end;
            padding: 8px;
        }
        .tableContainer {
            display: flex;
            flex-direction: column;
            border: 1px solid var(--neutral-300);
            border-radius: 8px;
            overflow: hidden;
        }

        .tableContainer {
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--neutral-300);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--neutral-200);
        }

        th {
            background-color: var(--neutral-300);
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: var(--neutral-100);
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
                <div class="col plate" id="plate1">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/time-left.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Open</div>
                        <div class="plateValue">123</div>
                    </div>
                </div>
                <div class="col plate" id="plate2">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/hourglass.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">In Progress</div>
                        <div class="plateValue">123</div>
                    </div>
                </div>
                <div class="col plate" id="plate3">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/ethics.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Resolved</div>
                        <div class="plateValue">123</div>
                    </div>
                </div>
                
                <div class="col plate" id="plate4">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/team.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Staffs</div>
                        <div class="plateValue">123</div>
                    </div>
                </div>
                <div class="col plate" id="plate5">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/groups.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Employee</div>
                        <div class="plateValue">123</div>
                    </div>
                </div>
                <div class="col plate" id="plate6">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/folder.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Download</div>
                        <div class="plateValue"></div>
                    </div>
                </div>
                
            </div>
            <div class="table-container">
                <div class="tableContainer">
                    <table>
                        <thead>
                            <tr>
                                <th>TICKET ID</th>
                                <th>SUBJECT</th>
                                <th>CATEGORY</th>
                                <th>STATUS</th>
                                <th>PRIORITY</th>
                                <th>ASSIGNED TO</th>
                                <th>DATE AND TIME</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <script src="../../assets/js/framework.js"></script>
</body>

</html>c