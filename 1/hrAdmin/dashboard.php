<?php
require_once '../../0/includes/employeeTicket.php';
require_once '../../0/includes/adminTableQuery.php';
require_once '../../0/includes/adminDashboardTables.php';
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
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <title>HRTS</title>

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
        <d class="content">
            <div class="topNav">
                <div class="account">
                    <div class="accountName">John Doe</div>
                    <div class="accountIcon img-contain"></div>
                </div>
            </div>

            <div class="row plateRow">
                <div class="col plate" id="plate1" data-status="Open">
    <div class="plateIcon" style="background-image: url(../../assets/images/icons/time-left.png);"></div>
    <div class="plateContent" data-status="Open">
        <div class="plateTitle">Open</div>
        <div class="plateValue"><?= htmlspecialchars($statusCounts['Open']) ?></div>
    </div>
</div>

<div class="col plate" id="plate2" data-status="In Progress">
    <div class="plateIcon" style="background-image: url(../../assets/images/icons/hourglass.png);"></div>
    <div class="plateContent" data-status="In Progress">
        <div class="plateTitle">In Progress</div>
        <div class="plateValue"><?= htmlspecialchars($statusCounts['In Progress']) ?></div>
    </div>
</div>

<div class="col plate" id="plate3" data-status="Resolved">
    <div class="plateIcon" style="background-image: url(../../assets/images/icons/ethics.png);"></div>
    <div class="plateContent">
        <div class="plateTitle">Resolved</div>
        <div class="plateValue"><?= htmlspecialchars($statusCounts['Resolved']) ?></div>
    </div>
</div>

<!-- Plates 4 and 5 don't need data-status because they aren't used for ticket filtering -->
<div class="col plate" id="plate4">
    <div class="plateIcon" style="background-image: url(../../assets/images/icons/team.png);"></div>
    <div class="plateContent">
        <div class="plateTitle">HR Representative</div>
        <div class="plateValue"><?= htmlspecialchars($roleCounts['HR']) ?></div>
    </div>
</div>

<div class="col plate" id="plate5">
    <div class="plateIcon" style="background-image: url(../../assets/images/icons/groups.png);"></div>
    <div class="plateContent">
        <div class="plateTitle">Employee</div>
        <div class="plateValue"><?= htmlspecialchars($roleCounts['Employee']) ?></div>
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

            <div class="pagination-wrapper">
                <div class="pagination">
                <div id="paginationControls" class="mt-3"></div>
                </div>

                <div class="search-container">
                    <input type="text" placeholder="SEARCH..." class="search-input">
                    <div class="search-icon">
                        <img src="../../assets/images/icons/search.png" alt="Search">
                    </div>
                    <button class="filter-btn">
                        <img src="../../assets/images/icons/sort.png" alt="Filter"> FILTER
                    </button>
                </div>
            </div>

            <div class="tableContainer" id="tableContainerTicketID">
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
                                <tr data-id="<?= htmlspecialchars($user['id']) ?>">
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

            <br><br>



            <style>
                /* Highlight rows with Inactive status */
                .inactive-row {
                    background-color: var(--danger-highlight) !important;
                    color: white;
                }
            </style>

            <div class="pagination-wrapper">
                <div class="pagination">
                <div id="paginationControls" class="mt-3"></div>
                </div>

                <div class="search-container">
                    <input type="text" placeholder="SEARCH..." id="searchInput" class="search-input">
                    <div class="search-icon">
                        <img src="../../assets/images/icons/search.png" alt="Search">
                    </div>
                    <button class="filter-btn">
                        <img src="../../assets/images/icons/sort.png" alt="Filter"> FILTER
                    </button>
                </div>
            </div>

            <div class="tableContainer" id="tableContainerUserID">
                <table class="ticketTable">
                    <thead>
                        <tr>
                            <th>ID <i class="fas fa-sort"></i></th>
                            <th>Employee Name <i class="fas fa-sort"></i></th>
                            <th>Email <i class="fas fa-sort"></i></th>
                            <th>Department <i class="fas fa-sort"></i></th>
                            <th>Role <i class="fas fa-sort"></i></th>
                            <th>Status <i class="fas fa-sort"></i></th>
                            <th>Created At <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                
                                <tr class="<?= $user['status'] === 'Inactive' ? 'inactive-row' : '' ?>">  
                                    <td><?= htmlspecialchars($user['id'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($user['name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($user['email'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($user['department'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($user['role'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($user['status'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($user['created_at'] ?? 'N/A') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>


            <br><br>


            <div class="tableContainer" id="tableContainerDepartment">
                <table>
                    <h1 style="text-align: center; margin-top: 20px;">Total Orders</h1>
                    <h1 style="text-align: center; margin-top: 20px;">
                        Top 5 Departments: <?= htmlspecialchars($totalTickets ?? 0) ?>
                    </h1>
                    <br>

                    <thead>
                        <tr>
                            <th>Department <i class="fas fa-sort"></i></th>
                            <th>Total Orders <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($totalDepartments)): ?>
                            <?php foreach ($totalDepartments as $department): ?>
                                <tr>
                                    <td><?= htmlspecialchars($department['department'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($department['totalDepartmentCounts'] ?? 0) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" style="text-align: center;">No Department found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <br><br>

            <div class="tableContainer" id="tableContainerCategory">
                <table>
                    <h1 style="text-align: center; margin-top: 20px;">Orders by Category</h1>
                    <h1 style="text-align: center; margin-top: 20px;">
                        Total Categories: <?= htmlspecialchars($totalCategory ?? 0) ?>
                    </h1>
                    <br>

                    <thead>
                        <tr>
                            <th>Category <i class="fas fa-sort"></i></th>
                            <th>Total Orders <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($totalCategories)): ?>
                            <?php foreach ($totalCategories as $category): ?>
                                <tr>
                                    <td><?= htmlspecialchars($category['category'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($category['totalCategoryCounts'] ?? 0) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" style="text-align: center;">No Category found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>


            <br><br>

            <div class="tableContainer" id="tableContainerCategory">
    <table>
        <h1 style="text-align: center; margin-top: 20px;">Top 10 Longest Orders</h1>
        <br>

        <thead>
            <tr>
                <th>Order ID <i class="fas fa-sort"></i></th>
                <th>Category <i class="fas fa-sort"></i></th>
                <th>Order Details <i class="fas fa-sort"></i></th>
                <th>Duration <i class="fas fa-sort"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($longestOrders)): ?>
                <?php foreach ($longestOrders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['ticket_id'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($order['category'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($order['order_details'] ?? 'N/A') ?></td>
                        <td>
                            <?php
                                // Convert duration from seconds to hours, minutes, and seconds
                                $hours = floor($order['duration_seconds'] / 3600);
                                $minutes = floor(($order['duration_seconds'] % 3600) / 60);
                                $seconds = $order['duration_seconds'] % 60;
                                echo sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No Orders found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>




            <br><br><br><br>

    </div>




    <div id="reportModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Generate Report</h2>
            <div class="time-options">
                <button class="time-btn">Today</button>
                <button class="time-btn">This week</button>
                <button class="time-btn">This month</button>
                <button class="time-btn">Custom</button>
            </div>

            <div class="date-range">
                <label>From: <input type="date" id="startDate"></label>
                <label>To: <input type="date" id="endDate"></label>
            </div>

            <div class="report-options">
                <div class="report-card">
                    <h3>Generate Overall Tickets</h3>
                    <p>This will generate sample rows ("Open, In Progress, Resolved").</p>
                </div>

                <div class="report-card">
                    <h3>Generate Tickets per Employee</h3>
                    <label>Type:
                        <select>
                            <option>Please select a category</option>
                        </select>
                    </label>
                    <label>Name: <input type="text" placeholder="Enter Name"></label>
                </div>

                <div class="report-card">
                    <h3>Generate Tickets per Department</h3>
                    <label>Type:
                        <select>
                            <option>Please select a category</option>
                        </select>
                    </label>
                </div>
            </div>

            <button id="downloadReport">Download Report</button>
        </div>
    </div>




    <footer class="footer-messages">
        <p>All rights reserved to Metro North Medical Center and Hospital, Inc.</p>
    </footer>
    <script src="../../assets/js/framework.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    <script></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const allRows = Array.from(document.querySelectorAll("#tableContainerTicketID tbody tr"));
        const tbody = document.querySelector("#tableContainerTicketID tbody");
        const paginationContainer = document.getElementById("paginationControls");
        const rowsPerPage = 5;
        let currentPage = 1;
        let currentFilter = "";
        function getRowStatus(row) {
            return row.children[4].textContent.trim();
        }
        function renderTable(filter = "") {
            const filteredRows = filter ? allRows.filter(row => getRowStatus(row) === filter) : allRows;
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            currentPage = Math.min(currentPage, totalPages || 1);
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            tbody.innerHTML = "";
            filteredRows.slice(start, end).forEach(row => tbody.appendChild(row));
            renderPaginationButtons(totalPages);
        }
        function renderPaginationButtons(totalPages) {
            paginationContainer.innerHTML = "";
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement("button");
                btn.textContent = i;
                btn.className = i === currentPage ? "active" : "";
                btn.style.margin = "0 5px";
                btn.addEventListener("click", () => {
                    currentPage = i;
                    renderTable(currentFilter);
                });
                paginationContainer.appendChild(btn);
            }
        }
        const plateIDs = ["plate1", "plate2", "plate3", "plate4"];
        plateIDs.forEach(id => {
            const plate = document.getElementById(id);
            if (plate) {
                plate.addEventListener("click", function () {
                    currentFilter = this.getAttribute("data-status") || "";
                    currentPage = 1;
                    renderTable(currentFilter);
                });
            }
        });
        renderTable();
    });
// document.addEventListener("DOMContentLoaded", function () {
//     const rowsPerPage = 5;
//     const table = document.querySelector("#tableContainerTicketID table");
//     const tbody = table.querySelector("tbody");
//     const rows = Array.from(tbody.querySelectorAll("tr"));
//     const paginationContainer = document.getElementById("paginationControls");

//     function displayPage(page) {
//         const start = (page - 1) * rowsPerPage;
//         const end = start + rowsPerPage;

//         rows.forEach((row, index) => {
//             row.style.display = (index >= start && index < end) ? "" : "none";
//         });

//         renderPaginationButtons(page);
//     }

//     function renderPaginationButtons(activePage) {
//         const totalPages = Math.ceil(rows.length / rowsPerPage);
//         paginationContainer.innerHTML = "";

//         for (let i = 1; i <= totalPages; i++) {
//             const btn = document.createElement("button");
//             btn.textContent = i;
//             btn.className = (i === activePage) ? "active-page-btn" : "";
//             btn.style.margin = "0 5px";
//             btn.style.padding = "5px 10px";
//             btn.addEventListener("click", () => displayPage(i));
//             paginationContainer.appendChild(btn);
//         }
//     }

//     // Only paginate if there are rows
//     if (rows.length > 0) {
//         displayPage(1);
//     }
// });
</script>



   

</body>

</html>