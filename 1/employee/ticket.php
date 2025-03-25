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


        /* table */

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

        /* search container */

        .search-wrapper {
            display: flex;
            justify-content: flex-end;
            /* Moves search container to the right */
            width: 100%;
            padding-bottom: 10px;
            /* Adjust spacing if needed */
        }

        .search-container {
            display: flex;
            align-items: center;
            background: #D3D3D3;
            /* Adjust to match exact gray shade */
            border-radius: 30px;
            padding: 5px;
            width: 320px;
            /* Adjust width */
        }


        .search-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px;
            border-radius: 30px;
            outline: none;
            font-size: 14px;
        }

        .search-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
        }

        .search-icon img {
            width: 16px;
            height: 16px;
        }

        .filter-btn {
            display: flex;
            align-items: center;
            background: transparent;
            border: none;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            border-left: 1px solid #888;
            /* Divider line between search and filter */
        }

        .filter-btn img {
            width: 16px;
            height: 16px;
            margin-left: 5px;
        }



        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding-bottom: 10px;
        }

        .pagination {
            display: flex;
            gap: 5px;
        }

        .pagination a {
            text-decoration: none;
            padding: 6px 12px;
            border: 1px solid var(--neutral-300);
            border-radius: 4px;
            color: var(--primary-500);
            background: var(--neutral-100);
        }

        .pagination a.active {
            background: var(--primary-500);
            color: white;
        }

        .pagination a:hover {
            background: var(--primary-400);
            color: white;
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


            <div class="main-ticket">
                <div class="container-ticket">
                    <div class="row plateRow">
                        <div class="col plate" id="plate1">
                            <span class="plate-label">OPEN</span>
                            <?= $statusCounts['Open'] ?>
                        </div>
                        <div class="col plate" id="plate2">
                            <span class="plate-label">IN PROGRESS</span>
                            <?= $statusCounts['In Progress'] ?>
                        </div>
                        <div class="col plate" id="plate3">
                            <span class="plate-label">ADD</span>

                        </div>
                    </div>
                </div>


                <div class="pagination-wrapper">
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>" class="prev">Previous</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>" class="next">Next</a>
                        <?php endif; ?>
                    </div>

                    <div class="search-container">
                        <input type="text" placeholder="SEARCH..." class="search-input">
                        <div class="search-icon">
                            <img src="../../assets/images/icons/search.png" alt="Search">
                        </div>
                        <button class="filter-btn">
                            <img src="../../assets/images/icons/filter.png" alt="Filter"> FILTER
                        </button>
                    </div>
                </div>



                <div class="tableContainer">
                    <table>
                        <thead>
                            <tr>
                                <th>ID <i class="fas fa-sort"></i></th>
                                <th>Employee Name <i class="fas fa-sort"></i></th>
                                <th>Subject <i class="fas fa-sort"></i></th>
                                <th>Description <i class="fas fa-sort"></i></th>
                                <th>Status <i class="fas fa-sort"></i></th>
                                <th>Priority <i class="fas fa-sort"></i></th>
                                <th>Category ID <i class="fas fa-sort"></i></th>
                                <th>Assigned To <i class="fas fa-sort"></i></th>
                                <th>Created At <i class="fas fa-sort"></i></th>
                                <th>Updated At <i class="fas fa-sort"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tickets)): ?>
                                <?php foreach ($tickets as $ticket): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($ticket['id']) ?></td>
                                        <td><?= htmlspecialchars($ticket['employee_name']) ?></td>
                                        <td><?= htmlspecialchars($ticket['subject']) ?></td>
                                        <td><?= htmlspecialchars($ticket['description']) ?></td>
                                        <td><?= htmlspecialchars($ticket['status']) ?></td>
                                        <td><?= htmlspecialchars($ticket['priority']) ?></td>
                                        <td><?= htmlspecialchars($ticket['category_name']) ?></td>
                                        <td><?= htmlspecialchars($ticket['assigned_to_name']) ?></td>
                                        <td><?= htmlspecialchars($ticket['created_at']) ?></td>
                                        <td><?= htmlspecialchars($ticket['updated_at']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10">No tickets found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

            </div>

        </div>

    </div>
    <footer class="footer-messages">
        <p>All rights reserved to Metro North Medical Center and Hospital, Inc.</p>
    </footer>
    <script src="../../assets/js/framework.js"></script>
</body>

</html>