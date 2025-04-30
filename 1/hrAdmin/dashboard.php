<?php
require_once '../../0/includes/employeeTicket.php';
require_once '../../0/includes/adminTableQuery.php';
require_once '../../0/includes/adminDashboardTables.php';
require_once '../../0/includes/reportGenerator.php';
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

    <style>
        .time-btn {
            padding: 8px 16px;
            border: 1px solid var(--neutral-300);
            background-color: var(--white);
            color: var(--black);
            border-radius: 4px;
            cursor: pointer;
            transition: var(--fast);
        }
        .time-btn:hover {
            background-color: var(--neutral-200);
        }
        .time-btn.active {
            background-color: var(--primary-500);
            color: var(--white);
            border-color: var(--primary-500);
        }
        .report-card {
            padding: 16px;
            border: 3px solid var(--neutral-300);
            border-radius: 8px;
            background-color: var(--white);
            cursor: pointer;
            transition: var(--fast);
            margin-bottom: 12px;
        }
        .report-card:hover {
            background-color: var(--neutral-200);
        }
        .report-card.selected {
            color: var(--white);
            border-color: var(--primary-500);
        }
        .suggestion-box {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            max-height: 150px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        .suggestion-box div {
            padding: 8px;
            cursor: pointer;
        }
        .suggestion-box div:hover {
            background-color: #f0f0f0;
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
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/leave.png);"></div>
                <a href="leaveManagement.php">Leave Management</a>
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
        <form class="modal-content" method="post">
            <input type="hidden" name="reportType" value="standard">
            <span class="close">&times;</span>
            <h2>Generate Report</h2>
            <div class="time-options">
                <div class="time-btn">Today</div>
                <div class="time-btn">This week</div>
                <div class="time-btn">This month</div>
                <div class="time-btn">Custom</div>
            </div>
            <div class="date-range">
                <label>From: <input type="date" id="startDate" name="startDate"></label>
                <label>To: <input type="date" id="endDate" name="endDate"></label>
            </div>
            <div class="report-options">
                <div class="report-card">
                    <h3>Standard Report</h3>
                    <br>
                    <p>This will generate basic report about tickets and employees</p>
                </div>
                <div class="report-card">
                    <h3>Tickets of the Employee</h3>
                    <br>
                    <div class="textInputContainer">
                        <input type="text" class="textInput" placeholder=" " id="employeeNameInput" name="employeeName">
                        <label class="textInputLabel">Name</label>
                        <div class="suggestion-box" id="employeeSuggestionBox"></div>
                    </div>
                </div>
                <div class="report-card">
                    <h3>Tickets on a Department</h3>
                    <br>
                    <div class="textInputContainer">
                        <input type="text" class="textInput" placeholder=" " id="departmentNameInput" name="departmentName">
                        <label class="textInputLabel">Department</label>
                        <div class="suggestion-box" id="departmentSuggestionBox"></div>
                    </div>
                </div>
            </div>
            <div class="btnContainer">
                <button type="submit" name="downloadReport" id="downloadReport" class="btnDefault">Download Report</button>
            </div>
        </form>
    </div>




    <footer class="footer-messages">
        <p>All rights reserved to Metro North Medical Center and Hospital, Inc.</p>
    </footer>
    <script src="../../assets/js/framework.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
            let paginationStart = 1; // Tracks which set of pages we're viewing

            function renderPaginationButtons(totalPages) {
                paginationContainer.innerHTML = "";

                const maxVisible = 10;
                const paginationEnd = Math.min(paginationStart + maxVisible - 1, totalPages);

                // Left arrow (go back 10 pages)
                if (paginationStart > 1) {
                    const leftArrow = document.createElement("button");
                    leftArrow.textContent = "←";
                    leftArrow.addEventListener("click", () => {
                        paginationStart = Math.max(1, paginationStart - maxVisible);
                        renderPaginationButtons(totalPages);
                    });
                    paginationContainer.appendChild(leftArrow);
                }

                // Page number buttons
                for (let i = paginationStart; i <= paginationEnd; i++) {
                    const btn = document.createElement("button");
                    btn.textContent = i;
                    btn.className = i === currentPage ? "active" : "";
                    btn.style.margin = "0 5px";
                    btn.style.minWidth = "22px";
                    btn.addEventListener("click", () => {
                        currentPage = i;
                        renderTable(currentFilter);
                    });
                    paginationContainer.appendChild(btn);
                }

                // Right arrow (go forward 10 pages)
                if (paginationEnd < totalPages) {
                    const rightArrow = document.createElement("button");
                    rightArrow.textContent = "→";
                    rightArrow.addEventListener("click", () => {
                        paginationStart = paginationStart + maxVisible;
                        renderPaginationButtons(totalPages);
                    });
                    paginationContainer.appendChild(rightArrow);
                }
            }

            const plateIDs = ["plate1", "plate2", "plate3", "plate4", "plate5"];
            plateIDs.forEach(id => {
                const plate = document.getElementById(id);
                if (plate) {
                    plate.addEventListener("click", function() {
                        currentFilter = this.getAttribute("data-status") || "";
                        currentPage = 1;
                        paginationStart = 1; // ✅ Reset pagination to start from 1
                        renderTable(currentFilter);

                    });
                }
            });
            renderTable();
        });

        //open modal
        document.addEventListener("DOMContentLoaded", function() {
            let modal = document.getElementById("reportModal");
            let downloadPlate = document.getElementById("plate6");
            let closeModal = document.querySelector(".close");

            // Show modal when clicking the download plate
            downloadPlate.addEventListener("click", function() {
                modal.style.display = "block";
            });

            // Close modal when clicking the close button
            closeModal.addEventListener("click", function() {
                modal.style.display = "none";
            });

            // Close modal when clicking outside the content
            window.addEventListener("click", function(event) {
                if (event.target === modal && !event.target.classList.contains("time-btn")) {
                    modal.style.display = "none";
                }
            });
        });



        
        document.addEventListener("DOMContentLoaded", function () {
            const timeButtons = document.querySelectorAll(".time-btn");
            const startDateInput = document.getElementById("startDate");
            const endDateInput = document.getElementById("endDate");
            const reportCards = document.querySelectorAll(".report-card");
            function setTodayRange() {
                const today = new Date();
                const formattedDate = today.toISOString().split("T")[0]; // Format as YYYY-MM-DD
                startDateInput.value = formattedDate;
                endDateInput.value = formattedDate;
            }
            const defaultTimeButton = document.querySelector(".time-btn:nth-child(1)");
            defaultTimeButton.classList.add("active");
            setTodayRange();

            // Add click event listeners to time buttons
            timeButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    // Remove active class from all buttons
                    timeButtons.forEach((btn) => btn.classList.remove("active"));

                    // Add active class to the clicked button
                    this.classList.add("active");

                    // Set date range based on the selected button
                    if (this.textContent === "Today") {
                        setTodayRange();
                    } else if (this.textContent === "This week") {
                        const today = new Date();
                        const firstDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                        const lastDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay() + 6));
                        startDateInput.value = firstDayOfWeek.toISOString().split("T")[0];
                        endDateInput.value = lastDayOfWeek.toISOString().split("T")[0];
                    } else if (this.textContent === "This month") {
                        const today = new Date();
                        const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                        const lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                        startDateInput.value = firstDayOfMonth.toISOString().split("T")[0];
                        endDateInput.value = lastDayOfMonth.toISOString().split("T")[0];
                    } else if (this.textContent === "Custom") {
                        startDateInput.value = "";
                        endDateInput.value = "";
                    }
                });
            });

            // Set default selected report card
            const defaultReportCard = document.querySelector(".report-card:nth-child(1)");
            defaultReportCard.classList.add("selected");

            // Add click event listeners to report cards
            reportCards.forEach((card) => {
                card.addEventListener("click", function () {
                    // Remove selected class from all report cards
                    reportCards.forEach((c) => c.classList.remove("selected"));

                    // Add selected class to the clicked card
                    this.classList.add("selected");
                });
            });
        });
    </script>
    <?php 
        require_once '../../0/includes/employeeList.php';
        require_once '../../0/includes/departmentList.php';
    ?>
    <script>
            document.addEventListener("DOMContentLoaded", function () {
            const employeeInput = document.getElementById("employeeNameInput");
            const employeeSuggestionBox = document.getElementById("employeeSuggestionBox");
            const departmentInput = document.getElementById("departmentNameInput");
            const departmentSuggestionBox = document.getElementById("departmentSuggestionBox");

            // Function to show suggestions
            function showSuggestions(input, suggestionBox, data) {
                const query = input.value.toLowerCase();
                suggestionBox.innerHTML = "";
                if (query.trim() === "") {
                    suggestionBox.style.display = "none";
                    return;
                }

                const filteredData = data.filter(item =>
                    item.name ? item.name.toLowerCase().includes(query) : item.toLowerCase().includes(query)
                );

                if (filteredData.length > 0) {
                    filteredData.forEach(item => {
                        const suggestion = document.createElement("div");
                        suggestion.textContent = item.name || item;
                        suggestion.addEventListener("click", () => {
                            input.value = item.name || item;
                            suggestionBox.style.display = "none";
                        });
                        suggestionBox.appendChild(suggestion);
                    });
                    suggestionBox.style.display = "block";
                } else {
                    suggestionBox.style.display = "none";
                }
            }

            // Event listeners for employee input
            employeeInput.addEventListener("input", () => {
                showSuggestions(employeeInput, employeeSuggestionBox, employees);
            });

            // Event listeners for department input
            departmentInput.addEventListener("input", () => {
                showSuggestions(departmentInput, departmentSuggestionBox, departments);
            });

            // Hide suggestion box when clicking outside
            document.addEventListener("click", (event) => {
                if (!employeeInput.contains(event.target) && !employeeSuggestionBox.contains(event.target)) {
                    employeeSuggestionBox.style.display = "none";
                }
                if (!departmentInput.contains(event.target) && !departmentSuggestionBox.contains(event.target)) {
                    departmentSuggestionBox.style.display = "none";
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            const reportCards = document.querySelectorAll(".report-card");
            const reportTypeInput = document.querySelector("input[name='reportType']");
            reportCards.forEach((card) => {
                card.addEventListener("click", function () {
                    // Remove the 'selected' class from all report cards
                    reportCards.forEach((c) => c.classList.remove("selected"));

                    // Add the 'selected' class to the clicked card
                    this.classList.add("selected");

                    // Update the hidden input with the report type
                    const reportType = this.querySelector("h3").textContent.trim();
                    if (reportType === "Standard Report") {
                        reportTypeInput.value = "standard";
                    } else if (reportType === "Tickets of the Employee") {
                        reportTypeInput.value = "employee";
                    } else if (reportType === "Tickets on a Department") {
                        reportTypeInput.value = "department";
                    }
                });
            });
        });
    </script>
</body>

</html>