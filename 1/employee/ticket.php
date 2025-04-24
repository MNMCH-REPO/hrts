<?php
require_once '../../0/includes/employeeTicket.php';
require_once '../../0/includes/platesHrFilter.php'; // Include the query file
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
    <link rel="stylesheet" href="../../assets/css/employeeTicket.css">
    <title>Tickets</title>

</head>

<body>
    <div class="container">
        <div class="sideNav">
            <div class="sideNavLogo img-cover"></div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain"
                    style="background-image: url(../../assets/images/icons/ticket.png);"></div>
                <a href="ticket.php">Tickets</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/chat.png);">
                </div>
                <a href="message.php">Messages</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain"
                    style="background-image: url(../../assets/images/icons/settings.png);"></div>
                <a href="account.php">Account</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain"
                    style="background-image: url(../../assets/images/icons/switch.png);"></div>
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
                <div class="row plateRow">
                    <div class="col plate" id="plate1" data-status="Open">
                        <div class="plateIcon" style="background-image: url(../../assets/images/icons/time-left.png);"></div>
                        <div class="plateContent">
                            <div class="plateTitle">Open</div>
                            <div class="plateValue"><?= htmlspecialchars($statusCounts['Open']) ?></div>
                        </div>
                    </div>
                    <div class="col plate" id="plate2" data-status="In Progress">
                        <div class="plateIcon" style="background-image: url(../../assets/images/icons/hourglass.png);"></div>
                        <div class="plateContent">
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

                    <div class="col plate" id="plate4">
                        <div class="plateIcon" style="background-image: url(../../assets/images/icons/add.png);"></div>
                        <div class="plateContent">
                            <div class="plateTitle">Create Ticket</div>

                        </div>
                    </div>
                </div>


                <div class="pagination-wrapper">
                    <div class="pagination">
                        <div id="paginationControls" class="mt-3"></div>
                    </div>
                    <div class="search-container">
                        <input type="text" id="searchInput" placeholder="SEARCH..." class="search-input">
                        <div class="search-icon">
                            <img src="../../assets/images/icons/search.png" alt="Search">
                        </div>
                        <button class="filter-btn">
                            <img src="../../assets/images/icons/sort.png" alt="Filter"> FILTER
                        </button>
                    </div>
                </div>



                <div class="tableContainer">
                    <?php
                    require 'employeeTable.php';
                    ?>
                </div>

            </div>

        </div>

    </div>
    <footer class="footer-messages">
        <p>All rights reserved to Metro North Medical Center and Hospital, Inc.</p>
    </footer>

    <?php

    require 'employeeModals.php'; // Include the modal for creating tickets

    ?>


    <script src="../../assets/js/framework.js"></script>

    <script src="../../assets/js/employeeTicket.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const allRows = Array.from(document.querySelectorAll("#ticketTable tbody tr"));
            const tbody = document.querySelector("#ticketTable tbody");
            const paginationContainer = document.getElementById("paginationControls");
            const rowsPerPage = 5;
            let currentPage = 1;
            let currentFilter = "";

            function getRowStatus(row) {
                return row.children[5].textContent.trim();
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
    </script>

</body>

</html>
