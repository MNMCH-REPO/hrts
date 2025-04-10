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



        /* modal */

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 600px;
            max-width: 95%;
            text-align: center;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }

        .input-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* Ensures equal spacing */
            width: 100%;
            padding: 5px 0;
            /* Adjust vertical spacing */
        }

        .input-container h1 {
            font-size: 16px;
            font-weight: bold;
            text-align: left;
            margin: 0;
            width: 40%;
            /* Adjust label width for proper spacing */
        }

        .center-text {
            width: 60%;
            /* Ensures proper alignment */
            font-size: 16px;
            text-align: left;
            /* Match exact alignment from the image */
            font-weight: normal;
            /* Ensure text weight matches */
        }



        .input-container select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }



        #addTicketModal .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 600px;
            max-width: 95%;
            text-align: center;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }

        #addTicketModal .input-container {
            position: relative;
            margin: 15px 0;
            width: 100%;
        }

        #addTicketModal .input-container input,
        #addTicketModal .input-container select,
        #addTicketModal .input-container textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            font-size: 16px;
            background: transparent;
        }

        #addTicketModal .input-container label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            transition: 0.3s ease-out;
            background: white;
            padding: 0 5px;
            font-size: 16px;
            color: #666;
            pointer-events: none;
        }

        /* Floating label effect */
        #addTicketModal .input-container input:focus+label,
        #addTicketModal .input-container input:not(:placeholder-shown)+label,
        #addTicketModal .input-container select:focus+label,
        #addTicketModal .input-container select:not(:placeholder-shown)+label,
        #addTicketModal .input-container textarea:focus+label,
        #addTicketModal .input-container textarea:not(:placeholder-shown)+label {
            top: 5px;
            font-size: 12px;
            color: #007BFF;
        }

        /* Buttons */
        .modal-buttons {
            display: flex;
            align-items: right;

            margin-top: 15px;

        }

        .btnDefault {
            cursor: pointer;
            border-radius: 50px;
        }

        .btnDanger {
            border-radius: 50px;
            cursor: pointer;


        }

        .btnDefault:hover {
            background: #0056b3;
        }

        .btnDanger:hover {
            background: #c82333;
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

                <div class="col plate" id="plate4">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/add.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Create Ticket</div>
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
                        <img src="../../assets/images/icons/sort.png" alt="Filter"> FILTER
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

    </div>
    <footer class="footer-messages">
        <p>All rights reserved to Metro North Medical Center and Hospital, Inc.</p>
    </footer>




    <!-- Modal -->
    <div id="assignTicketModal" class="modal">
        <div class="modal-content">
            <h1 class="modal-title">ASSIGN TICKET</h1>

            <form id="assignTicketForm" method="POST">
                <div class="input-container">
                    <h1><strong>Ticket ID:</strong></h1>
                    <p class="center-text" value="<?= htmlspecialchars($ticket['id']) ?>"></p>
                </div>

                <div class="input-container">
                    <h1><strong>Employee Name:</strong></h1>
                    <p class="center-text" value="<?= htmlspecialchars($ticket['employee_name']) ?>">John Doe</p>
                </div>

                <div class="input-container">
                    <h1><strong>Department:</strong></h1>
                    <p class="center-text" value="<?= htmlspecialchars($ticket['department']) ?>">Accounting and Finance</p>
                </div>

                <div class="input-container">
                    <h1><strong>Subject:</strong></h1>
                    <p class="center-text" value="<?= htmlspecialchars($ticket['subject']) ?>">Paycheck Calculation</p>
                </div>

                <div class="input-container">
                    <h1><strong>Category:</strong></h1>
                    <p class="center-text" value="<?= htmlspecialchars($ticket['category']) ?>">Paycheck</p>
                </div>

                <div class="input-container">
                    <h1><strong>Description:</strong></h1>
                    <p class="center-text" value="<?= htmlspecialchars($ticket['description']) ?>">Paycheck miscalculation</p>
                </div>


                <br>


                <div class="input-container">
                    <select id="priorityID" name="priotity" required>
                        <option value="" disabled selected>Please select the level of Priority</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>

                <br>

                <div class="input-container">
                    <select name="assignTo" id="assignToID" required>
                        <option value="" disabled selected>Select User</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="btnContainer">
                    <button type="submit" name="assignTicket" id="assignTIcketID" class="btnDefault">SUBMIT</button>
                    <button type="button" class="btnDanger" onclick="closeModal()">BACK</button>
                </div>
            </form>
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


    <!-- Modal -->
    <div id="addTicketModal" class="modal">
        <div class="modal-content">
            <h1 class="modal-title">TICKET FORM</h1>

            <form id="ticketForm">

                <input type="hidden" name="employeeId" id="employeeID" value="<?= $_SESSION['user_id'] ?>">
                <div class="input-container">
                    <input type="text" name="employeeName" value="<?= $_SESSION['name'] ?>" id="employeeName" required>
                    <label for="employeeName">Employee Name</label>
                </div>

                <div class="input-container">
                    <input type="text" id="subject" name="subject" required>
                    <label for="subject">Subject</label>
                </div>

                <div class="input-container">
                    <input type="text" id="departmentInputField" class="form-control"
                        value="{{ session('department') }}" name="department" placeholder="Enter Department">

                    <label for="department">Department</label>
                </div>

                <div class="input-container">
                    <select id="category" name="category" required>
                        <option value="" disabled selected>Select a category</option>
                        <?php
                        require "../../0/includes/db.php"; // Ensure correct database connection

                        try {
                            $stmt = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['id']}'>{$row['name']}</option>";
                            }
                        } catch (PDOException $e) {
                            echo "<option disabled>Error loading categories</option>";
                        }
                        ?>
                    </select>
                    <label for="category">Category</label>
                </div>


                <div class="input-container">
                    <textarea id="description" name="description" required></textarea>
                    <label for="description">Description</label>
                </div>

                <div class="modal-buttons">
                    <button type="submit" name="submitTicket" id="submitTicketID" class="btnDefault">SUBMIT TICKET</button>
                    <button type="button" class="btnDanger" onclick="closeModal()">CANCEL</button>
                </div>
            </form>
        </div>
    </div>




    <script src="../../assets/js/framework.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const plate = document.getElementById("plate1");

            plate.addEventListener("click", function() {
                const selectedStatus = this.getAttribute("data-status");
                const rows = document.querySelectorAll("#ticketTable tbody tr");

                rows.forEach(row => {
                    const rowStatus = row.getAttribute("data-status");

                    if (rowStatus === selectedStatus) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const plate = document.getElementById("plate2");

            plate.addEventListener("click", function() {
                const selectedStatus = this.getAttribute("data-status");
                const rows = document.querySelectorAll("#ticketTable tbody tr");

                rows.forEach(row => {
                    const rowStatus = row.getAttribute("data-status");

                    if (rowStatus === selectedStatus) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const plate = document.getElementById("plate3");

            plate.addEventListener("click", function() {
                const selectedStatus = this.getAttribute("data-status");
                const rows = document.querySelectorAll("#ticketTable tbody tr");

                rows.forEach(row => {
                    const rowStatus = row.getAttribute("data-status");

                    if (rowStatus === selectedStatus) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });



        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchInput");
            const rows = document.querySelectorAll("#ticketTable tbody tr");
            let selectedStatus = ""; // track which plate was clicked

            // Function to filter table based on status and search
            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();

                rows.forEach(row => {
                    const rowStatus = row.getAttribute("data-status");
                    const rowText = row.textContent.toLowerCase();

                    const isStatusMatch = selectedStatus === "" || rowStatus === selectedStatus;
                    const isSearchMatch = rowText.includes(searchTerm);

                    if (isStatusMatch && isSearchMatch) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            // Handle typing in search bar
            searchInput.addEventListener("input", function() {
                filterTable();
            });
        });



        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.querySelector(".search-input");
            const filterButton = document.querySelector(".filter-btn");
            const table = document.querySelector("#ticketTable tbody");

            // Search functionality
            searchInput.addEventListener("keyup", function() {
                const filter = searchInput.value.toLowerCase();
                const rows = table.getElementsByTagName("tr");

                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName("td");
                    let found = false;

                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j] && cells[j].textContent.toLowerCase().includes(filter)) {
                            found = true;
                            break;
                        }
                    }

                    rows[i].style.display = found ? "" : "none";
                }
            });

            // Filter dropdown functionality
            filterButton.addEventListener("click", function() {
                // Create a dropdown menu dynamically
                let dropdown = document.querySelector(".filter-dropdown");
                if (!dropdown) {
                    dropdown = document.createElement("div");
                    dropdown.classList.add("filter-dropdown");
                    dropdown.style.position = "absolute";
                    dropdown.style.backgroundColor = "#fff";
                    dropdown.style.border = "1px solid #ccc";
                    dropdown.style.padding = "10px";
                    dropdown.style.zIndex = "1000";

                    // Add filter options
                    const filters = [{
                            column: 5,
                            label: "Status"
                        },
                        {
                            column: 6,
                            label: "Priority"
                        },
                        {
                            column: 7,
                            label: "Category"
                        },
                    ];

                    filters.forEach((filter) => {
                        const option = document.createElement("div");
                        option.textContent = filter.label;
                        option.style.cursor = "pointer";
                        option.style.padding = "5px 10px";
                        option.addEventListener("click", function() {
                            applyFilter(filter.column);
                            dropdown.remove(); // Remove dropdown after selection
                        });
                        dropdown.appendChild(option);
                    });

                    document.body.appendChild(dropdown);

                    // Position the dropdown below the filter button
                    const rect = filterButton.getBoundingClientRect();
                    dropdown.style.left = `${rect.left}px`;
                    dropdown.style.top = `${rect.bottom + window.scrollY}px`;

                    // Close dropdown when clicking outside
                    document.addEventListener("click", function closeDropdown(event) {
                        if (!dropdown.contains(event.target) && event.target !== filterButton) {
                            dropdown.remove();
                            document.removeEventListener("click", closeDropdown);
                        }
                    });
                }
            });

            // Apply filter based on the selected column
            function applyFilter(columnIndex) {
                const rows = table.getElementsByTagName("tr");
                const filterValue = prompt("Enter the value to filter by:");

                if (filterValue) {
                    for (let i = 0; i < rows.length; i++) {
                        const cell = rows[i].getElementsByTagName("td")[columnIndex];
                        if (cell) {
                            rows[i].style.display =
                                cell.textContent.trim().toLowerCase() === filterValue.toLowerCase() ?
                                "" :
                                "none";
                        }
                    }
                }
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Open modal function
            function openModal() {
                document.getElementById("addTicketModal").style.display = "flex";

                // Auto-fill department correctly
                let userDept = "<?= $_SESSION['department'] ?>"; // Use PHP instead of Blade
                let departmentField = document.getElementById("departmentInputField");

                if (departmentField) {
                    departmentField.value = userDept;
                } else {
                    console.error("❌ Department field not found!");
                }
            }

            // Make the function globally accessible
            window.openModal = openModal;

            // Attach event listener to "ADD" button
            document.getElementById("plate4").addEventListener("click", openModal);

            // Close modal function
            function closeModal() {
                document.getElementById("addTicketModal").style.display = "none";
            }

            window.closeModal = closeModal;

            // Submit form via AJAX
            document
                .getElementById("ticketForm")
                .addEventListener("submit", function(e) {
                    e.preventDefault();

                    let formData = new FormData(this);

                    fetch("../../0/includes/submitTicket.php", {
                            method: "POST",
                            body: formData,
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                alert("Ticket submitted successfully!");
                                document.getElementById("ticketForm").reset();
                                closeModal();
                                location.reload();
                            } else {
                                alert("Error: " + data.message);
                            }
                        })
                        .catch((error) => {
                            console.error("❌ Fetch Error:", error);
                        });
                });
        });



        document.addEventListener("DOMContentLoaded", function() {
            const tableRows = document.querySelectorAll("tbody tr");
            const assignTicketModal = document.getElementById("assignTicketModal");
            const editStatusModal = document.getElementById("editStatusModal");

            // Modal fields for assignTicketModal
            const assignTicketFields = {
                ticketIdField: assignTicketModal.querySelector(".input-container:nth-child(1) .center-text"),
                employeeNameField: assignTicketModal.querySelector(".input-container:nth-child(2) .center-text"),
                departmentField: assignTicketModal.querySelector(".input-container:nth-child(3) .center-text"),
                subjectField: assignTicketModal.querySelector(".input-container:nth-child(4) .center-text"),
                categoryField: assignTicketModal.querySelector(".input-container:nth-child(5) .center-text"),
                descriptionField: assignTicketModal.querySelector(".input-container:nth-child(6) .center-text"),
                prioritySelect: document.getElementById("priorityID"),
                assignToSelect: document.getElementById("assignToID"),
            };

            // Modal fields for editStatusModal
            const editStatusFields = {
                ticketIdField: document.getElementById("editTicketID"),
                employeeNameField: document.getElementById("editemployeeID"),
                departmentField: document.getElementById("editdepartmentID"),
                subjectField: document.getElementById("editsubjectID"),
                categoryField: document.getElementById("editcategoryID"),
                descriptionField: document.getElementById("editdescriptionID"),
                priorityField: document.getElementById("editpriorityID"),
                assignedToField: document.getElementById("editassignedID"),
                statusSelect: document.getElementById("statusEditID"),
            };

            // Add click event listener to each row
            tableRows.forEach(row => {
                row.addEventListener("click", function() {
                    // Remove highlight from all rows
                    tableRows.forEach(r => r.style.backgroundColor = "");

                    // Highlight the clicked row
                    this.style.backgroundColor = "var(--primary-500)";

                    // Get the values from the clicked row
                    const ticketId = this.children[0].textContent.trim();
                    const employeeName = this.children[1].textContent.trim();
                    const subject = this.children[2].textContent.trim();
                    const description = this.children[3].textContent.trim();
                    const status = this.children[4].textContent.trim(); // Status column
                    const department = this.children[4].textContent.trim();
                    const priority = this.children[5].textContent.trim();
                    const category = this.children[6].textContent.trim();
                    const assignedTo = this.children[7].textContent.trim();

                    // Open the appropriate modal based on the status
                    if (status === "Open") {
                        // Set the values in the assignTicketModal
                        assignTicketFields.ticketIdField.textContent = ticketId;
                        assignTicketFields.employeeNameField.textContent = employeeName;
                        assignTicketFields.departmentField.textContent = department;
                        assignTicketFields.subjectField.textContent = subject;
                        assignTicketFields.categoryField.textContent = category;
                        assignTicketFields.descriptionField.textContent = description;

                        // Set the priority dropdown value (if applicable)
                        if (assignTicketFields.prioritySelect) {
                            assignTicketFields.prioritySelect.value = priority;
                        }

                        // Open the assignTicketModal
                        assignTicketModal.style.display = "flex";
                    } else if (status === "In Progress") {
                        // Set the values in the editStatusModal
                        editStatusFields.ticketIdField.textContent = ticketId;
                        editStatusFields.employeeNameField.textContent = employeeName;
                        editStatusFields.departmentField.textContent = department;
                        editStatusFields.subjectField.textContent = subject;
                        editStatusFields.categoryField.textContent = category;
                        editStatusFields.descriptionField.textContent = description;
                        editStatusFields.priorityField.textContent = priority;
                        editStatusFields.assignedToField.textContent = assignedTo;

                        // Open the editStatusModal
                        editStatusModal.style.display = "flex";
                    }
                });
            });

            // Close the modals when clicking outside of them
            window.addEventListener("click", function(event) {
                if (event.target === assignTicketModal) {
                    assignTicketModal.style.display = "none";
                }
                if (event.target === editStatusModal) {
                    editStatusModal.style.display = "none";
                }
            });

            // Close the modals when clicking the "BACK" button
            const closeAssignModalButton = assignTicketModal.querySelector(".btnDanger");
            const closeEditModalButton = editStatusModal.querySelector(".btnDanger");

            closeAssignModalButton.addEventListener("click", function() {
                assignTicketModal.style.display = "none";
            });

            closeEditModalButton.addEventListener("click", function() {
                editStatusModal.style.display = "none";
            });
        });
        // Handle form submission assign

        document.addEventListener("DOMContentLoaded", function() {
            const assignTicketForm = document.getElementById("assignTicketForm");

            assignTicketForm.addEventListener("submit", async function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Get form data
                const ticketId = document.querySelector(".input-container:nth-child(1) .center-text").textContent.trim();
                const priority = document.getElementById("priorityID").value;
                const assignTo = document.getElementById("assignToID").value;

                // Validate form data
                if (!ticketId || !priority || !assignTo) {
                    alert("All fields are required.");
                    return;
                }

                // Prepare the data to send
                const formData = new FormData();
                formData.append("ticketId", ticketId);
                formData.append("priority", priority);
                formData.append("assignTo", assignTo);

                try {
                    // Send the AJAX request
                    const response = await fetch("../../0/includes/assignTicket.php", {
                        method: "POST",
                        body: formData,
                    });

                    const data = await response.json();

                    if (data.success) {
                        alert(data.message); // Show success message
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert(data.message); // Show error message
                    }
                } catch (error) {
                    console.error("Error updating ticket:", error);
                    alert("An error occurred while updating the ticket. Please try again.");
                }
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            const editStatusForm = document.getElementById("editStatusForm");

            editStatusForm.addEventListener("submit", async function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Get form data
                const ticketId = document.getElementById("editTicketID").textContent.trim();
                const status = document.getElementById("statusEditID").value;

                // Validate form data
                if (!ticketId || !status) {
                    alert("All fields are required.");
                    return;
                }

                // Prepare the data to send
                const formData = new FormData();
                formData.append("ticketId", ticketId);
                formData.append("statusEdit", status);

                try {
                    // Send the AJAX request
                    const response = await fetch("../../0/includes/editStatusTicket.php", {
                        method: "POST",
                        body: formData,
                    });

                    const data = await response.json();

                    if (data.success) {
                        alert(data.message); // Show success message
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert(data.message); // Show error message
                    }
                } catch (error) {
                    console.error("Error updating status:", error);
                    alert("An error occurred while updating the status. Please try again.");
                }
            });
        });
    </script>
</body>

</html>c