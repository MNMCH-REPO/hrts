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
            cursor: pointer;
        }

        .plateIcon {
            position: absolute;
            top: 26%;
            left: -12%;
            width: 55%;
            aspect-ratio: 1/1;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .plateContent {
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

        .plateTitle {
            font-size: 24px;
            font-weight: 500;
            width: 100%;
            min-height: 32px;
        }

        .plateValue {
            font-size: 48px;
            font-weight: 600;
            width: 100%;
            min-height: 32px;
            text-align: end;
            padding: 8px;
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
            background-color: var(--primary-100);
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


        .footer-messages {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f4f4f4;
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sideNav">
            <div class="sideNavLogo img-cover"></div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/ticket.png);"></div>
                <a href="order.php">Oders</a>
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
                <a href="">Signout</a>
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
                        <div class="plateValue"><?= htmlspecialchars($statusCounts['Open']) ?></div>
                    </div>
                </div>
                <div class="col plate" id="plate2">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/hourglass.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">In Progress</div>
                        <div class="plateValue"><?= htmlspecialchars($statusCounts['In Progress']) ?></div>
                    </div>
                </div>
                <div class="col plate" id="plate3">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/ethics.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Resolved</div>
                        <div class="plateValue"><?= htmlspecialchars($statusCounts['Resolved']) ?></div>
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
                                <td colspan="10" style="text-align: center;">No tickets found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>



        </div>


        <!-- Modal -->
        <div id="editStatusModal" class="modal">
        <div class="modal-content">
            <h1 class="modal-title">ASSIGN TICKET</h1>

            <form id="editStatusForm" method="POST">
                <div class="input-container">
                    <h1><strong>Ticket ID:</strong></h1>
                    <p class="center-text" id="editTicketID" name="editticketID" value="<?= htmlspecialchars($ticket['id']) ?>"></p>
                </div>

                <div class="input-container">
                    <h1><strong>Employee Name:</strong></h1>
                    <p class="center-text" id="editemployeeID" value="<?= htmlspecialchars($ticket['employee_name']) ?>">John Doe</p>
                </div>

                <div class="input-container">
                    <h1><strong>Department:</strong></h1>
                    <p class="center-text" id="editdepartmentID" value="<?= htmlspecialchars($ticket['department']) ?>">Accounting and Finance</p>
                </div>

                <div class="input-container">
                    <h1><strong>Subject:</strong></h1>
                    <p class="center-text" id="editsubjectID" value="<?= htmlspecialchars($ticket['subject']) ?>">Paycheck Calculation</p>
                </div>

                <div class="input-container">
                    <h1><strong>Category:</strong></h1>
                    <p class="center-text" id="editcategoryID" value="<?= htmlspecialchars($ticket['category']) ?>">Paycheck</p>
                </div>

                <div class="input-container">
                    <h1><strong>Description:</strong></h1>
                    <p class="center-text" id="editdescriptionID" value="<?= htmlspecialchars($ticket['description']) ?>">Paycheck miscalculation</p>
                </div>

                <div class="input-container">
                    <h1><strong>Priority:</strong></h1>
                    <p class="center-text" id="editpriorityID" value="<?= htmlspecialchars($ticket['priority']) ?>">Paycheck miscalculation</p>
                    </select>
                </div>

                <div class="input-container">
                    <h1><strong>Assigned To:</strong></h1>
                    <p class="center-text" id="editassignedID" value="<?= htmlspecialchars($ticket['assigned_to_name']) ?>">Paycheck miscalculation</p>
                    </select>
                </div>

                    
                <div class="input-container">
                    <h1><strong>Status:</strong></h1>
                    <p class="center-text" id="statusID" value="<?= htmlspecialchars($ticket['status']) ?>">Paycheck miscalculation</p>
                    </select>
                </div>

                <br>

                <div class="input-container">
                    <select name="statusEdit" id="statusEditID" required>
                        <!-- Loop through all statuses and set the selected option -->
                        <?php foreach ($ticketStatus as $status): ?>
                            <option value="<?= htmlspecialchars($status['status']) ?>"
                                <?= ($status['status'] == $currentStatus) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($status['status']) ?>
                            </option>
                        <?php endforeach; ?>

                        <!-- Add 'Resolved' option only if it's not already in $ticketStatus -->
                        <?php if (!in_array('Resolved', array_column($ticketStatus, 'status'))): ?>
                            <option value="Resolved" <?= ('Resolved' == $currentStatus) ? 'selected' : '' ?>>Resolved</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="btnContainer">
                    <button type="submit" name="editStatusID" id="editStatusID" class="btnDefault">SUBMIT</button>
                    <button type="button" class="btnDanger" onclick="closeModal()">BACK</button>
                </div>
            </form>
        </div>
    </div>

        



    </div>
    <script src="../../assets/js/framework.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get all plates
            const plates = document.querySelectorAll(".plate");
            const tableRows = document.querySelectorAll("tbody tr");

            plates.forEach(plate => {
                plate.addEventListener("click", function() {
                    // Get the status from the clicked plate and normalize it
                    const status = this.querySelector(".plateTitle").textContent.trim().toLowerCase();

                    // Debugging: Log the clicked plate's status
                    console.log("Filtering by status:", status);

                    tableRows.forEach(row => {
                        // Find the status column dynamically
                        const statusCell = row.querySelector("[data-column='status']");
                        if (!statusCell) {
                            console.error("Status column not found in row:", row);
                            return;
                        }

                        const rowStatus = statusCell.textContent.trim().toLowerCase();

                        // Debugging: Log the status of each row
                        console.log("Row status:", rowStatus);

                        // Show only matching rows
                        if (rowStatus === status || status === "all") {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    });
                });
            });
        });






        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-input');
            const filterButton = document.querySelector('.filter-btn');
            const tableBody = document.querySelector('table tbody');

            // Function to fetch and update tickets
            function fetchTickets(search = '', filterColumn = '', filterValue = '') {
                const url = new URL('../../0/includes/hrSearch.php', window.location.origin);
                url.searchParams.append('search', search);
                if (filterColumn && filterValue) {
                    url.searchParams.append('filterColumn', filterColumn);
                    url.searchParams.append('filterValue', filterValue);
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        // Clear the table body
                        tableBody.innerHTML = '';

                        if (data.error) {
                            console.error(data.error);
                            tableBody.innerHTML = '<tr><td colspan="10" style="text-align: center;">Error fetching tickets</td></tr>';
                            return;
                        }

                        if (data.length === 0) {
                            tableBody.innerHTML = '<tr><td colspan="10" style="text-align: center;">No tickets found</td></tr>';
                            return;
                        }

                        // Populate the table with the fetched tickets
                        data.forEach(ticket => {
                            const row = `
                        <tr>
                            <td>${ticket.id}</td>
                            <td>${ticket.employee_name}</td>
                            <td>${ticket.subject}</td>
                            <td>${ticket.description}</td>
                            <td>${ticket.status}</td>
                            <td>${ticket.priority}</td>
                            <td>${ticket.category_name}</td>
                            <td>${ticket.assigned_to_name}</td>
                            <td>${ticket.created_at}</td>
                            <td>${ticket.updated_at}</td>
                        </tr>
                    `;
                            tableBody.insertAdjacentHTML('beforeend', row);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching tickets:', error);
                        tableBody.innerHTML = '<tr><td colspan="10"style="text-align: center;" >Error fetching tickets</td></tr>';
                    });
            }

            // Event listener for search input
            searchInput.addEventListener('input', function() {
                const search = searchInput.value.trim();
                fetchTickets(search);
            });

            // Event listener for filter button
            filterButton.addEventListener('click', function() {
                const filterColumn = prompt('Enter the column to filter (e.g., status, priority):');
                const filterValue = prompt('Enter the value to filter by:');
                if (filterColumn && filterValue) {
                    fetchTickets('', filterColumn, filterValue);
                }
            });
        });
    </script>
</body>

</html>