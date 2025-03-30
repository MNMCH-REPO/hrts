<?php
require_once '../../0/includes/employeeTicket.php';
require_once '../../0/includes/adminTableQuery.php';
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
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/settings.png);"></div>
                <a href="management.php">Management</a>

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



            <div class="table-container">
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


    <script>
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
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });
    </script>

</body>

</html>