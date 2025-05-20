<?php
require_once '../../0/includes/employeeTicket.php';
require_once '../../0/includes/accountQuery.php'; // Include the query file
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/framework.css">
    <link rel="stylesheet" href="../../assets/css/management.css">
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

            <div class="navBtn currentPage">
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


        <div class="content">
            <div class="topNav">
                <div class="account">
                    <div class="accountName">John Doe</div>
                    <div class="accountIcon img-contain"></div>
                </div>
            </div>






            <div class="pagination-wrapper">
                <div class="pagination" id="pageNationID">
                    <div id="paginationControls" class="mt-3"></div>
                </div>

                <div class="btnContainer">
                    <button type="button" class="btnDefault" id="uploadExcelID" name="iploadExcel">Upload</button>
                    <button type="button" class="btnWarning btnWarningDisabled" id="editAccountID" name="editAccount" disabled>Edit Account</button>
                    <button type="button" class="btnDanger btnDangerDisabled" id="disableAccountID" name="disbaleAccount" style="display: none;" disabled>Disable Account </button>
                    <button type="button" class="btnApprove btnApproveDisabled" id="enableAccountID" name="enableAccount" style="display: none;" disable>Enable Account </button>
                    <button type="button" class="btnDefault" id="addAccountID" name="addAccount">Add Account +</button>
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

            <style>
                /* Highlight rows with Inactive status */
                .inactive-row {
                    background-color: var(--danger-highlight) !important;
                    color: white;
                    /* Optional: Change text color for better contrast */
                }
            </style>



            <div class="tableContainer">
                <table id="usersTable">
                    <thead>
                        <tr>
                            <th>ID <i class="fas fa-sort"></i></th>
                            <th>Name <i class="fas fa-sort"></i></th>
                            <th>Email <i class="fas fa-sort"></i></th>
                            <th>Role <i class="fas fa-sort"></i></th>
                            <th>Department <i class="fas fa-sort"></i></th>
                            <th>Status <i class="fas fa-sort"></i></th>
                            <th>Created At <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr data-id="<?= htmlspecialchars($user['id']) ?>"
                                    class="<?= htmlspecialchars($user['status']) === 'Inactive' ? 'inactive-row' : '' ?>">
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                    <td><?= htmlspecialchars($user['department']) ?></td>
                                    <td><?= htmlspecialchars($user['status']) ?> <!-- Debug: Output status here --></td>
                                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" style="text-align: center;">No Users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>

    </div>
    <footer class="footer-messages">
        <p>All rights reserved to Metro North Medical Center and Hospital, Inc.</p>
    </footer>


    <style>
        .blink-red {
            animation: blink-red 3.5s infinite ease-in-out;
        }

        @keyframes blink-red {
            0% {
                background-color: #ffcccc;
                /* Lighter red */
            }

            25% {
                background-color: #ff9999;
                /* Slightly darker red */
            }

            50% {
                background-color: transparent;
            }

            75% {
                background-color: #ff9999;
                /* Slightly darker red */
            }

            100% {
                background-color: #ffcccc;
                /* Lighter red */
            }
        }


        .blink-orange {
            animation: blink-orange 3.5s infinite ease-in-out;
        }

        @keyframes blink-orange {
            0% {
                background-color: #ffcc99;
                /* Slightly darker orange */
            }

            25% {
                background-color: #ff9966;
                /* Darker orange */
            }

            50% {
                background-color: transparent;
            }

            75% {
                background-color: #ff9966;
                /* Darker orange */
            }

            100% {
                background-color: #ffcc99;
                /* Slightly darker orange */
            }
        }

        .blink-yellow {
            animation: blink-yellow 3.5s infinite ease-in-out;
        }

        @keyframes blink-yellow {
            0% {
                background-color: #ffff99;
                /* Light yellow */
            }

            25% {
                background-color: #ffeb3b;
                /* Bright yellow */
            }

            50% {
                background-color: transparent;
            }

            75% {
                background-color: #ffeb3b;
                /* Bright yellow */
            }

            100% {
                background-color: #ffff99;
                /* Light yellow */
            }
        }
    </style>


    <?php

    require_once 'modals.php';


    ?>

    <script src="../../assets/js/framework.js"></script>
    <script src="../../assets/js/management.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.querySelector(".search-input");
            const allRows = Array.from(document.querySelectorAll("#usersTable tbody tr"));
            const tbody = document.querySelector("#usersTable tbody");
            const paginationContainer = document.getElementById("paginationControls");
            const rowsPerPage = 5;
            let currentPage = 1;
            let currentFilter = "";

            function getRowStatus(row) {
                return row.children[7]?.textContent.trim() || "";
            }

            function fetchAndApplyAWOL(rows) {
                rows.forEach((row) => {
                    const userId = row.getAttribute("data-id"); // Get the user ID from the row

                    // Fetch AWOL value for the user
                    fetch(`../../0/includes/getLeaveBalancesQuery.php?userId=${userId}`)
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                const awolValue = parseInt(data.leaveBalances.totalAWOL, 10) || 0;

                                if (awolValue >= 5) {
                                    // Add a blinking red effect if AWOL is 5 or greater
                                    row.classList.add("blink-red");
                                } else if (awolValue === 3) {
                                    // Add a blinking orange effect if AWOL is 3
                                    row.classList.add("blink-yellow");
                                } else if (awolValue === 4) {
                                    row.classList.add("blink-orange");
                                }
                            } else {
                                console.error(`Failed to fetch AWOL value for user ID ${userId}: ${data.message}`);
                            }
                        })
                        .catch((error) => {
                            console.error(`Error fetching AWOL value for user ID ${userId}:`, error);
                        });
                });
            }

            function renderTable(filter = "") {
                const filteredRows = filter ? allRows.filter(row => getRowStatus(row) === filter) : allRows;
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                currentPage = Math.min(currentPage, totalPages || 1);
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                tbody.innerHTML = "";
                const rowsToRender = filteredRows.slice(start, end);
                rowsToRender.forEach(row => tbody.appendChild(row));
                fetchAndApplyAWOL(rowsToRender); // Reapply AWOL logic for the current page
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

            const plateIDs = ["plate1", "plate2", "plate3"];
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

            // Search functionality
            function filterTableBySearch() {
                const searchValue = searchInput.value.toLowerCase(); // Get the search input value
                const filteredRows = allRows.filter((row) =>
                    row.textContent.toLowerCase().includes(searchValue)
                ); // Filter rows based on search value
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                currentPage = Math.min(currentPage, totalPages || 1);
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                tbody.innerHTML = "";
                const rowsToRender = filteredRows.slice(start, end);
                rowsToRender.forEach((row) => tbody.appendChild(row));
                fetchAndApplyAWOL(rowsToRender); // Reapply AWOL logic for the filtered rows
                renderPaginationButtons(totalPages);
            }

            // Add event listener to the search input
            searchInput.addEventListener("input", filterTableBySearch);

            renderTable();
        });
    </script>
</body>

</html>