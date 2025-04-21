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

        /* table */

        .tableContainer {
            display: flex;
            flex-direction: column;
            border: 1px solid var(--neutral-300);
            border-radius: 8px;
            width: 100%;
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

        tbody tr.highlighted {
            background-color: var(--primary-500) !important;
            /* Highlight color */
            color: white;
            /* Optional: Change text color */
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



        <div class="content">
            <div class="topNav">
                <div class="account">
                    <div class="accountName">John Doe</div>
                    <div class="accountIcon img-contain"></div>
                </div>
            </div>



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
                    <input type="text" id="searchInput" placeholder="SEARCH..." class="search-input">
                    <div class="search-icon">
                        <img src="../../assets/images/icons/search.png" alt="Search">
                    </div>
                    <button id="filterButton" class="filter-btn">
                        <img src="../../assets/images/icons/sort.png" alt="Filter"> FILTER
                    </button>
                </div>
            </div>



            <div class="tableContainer">
                <table id="ticketTable">
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
                            <th>Duration <i class="fas fa-sort"></i></th>
                            <th>Updated At <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tickets)): ?>
                            <?php foreach ($tickets as $ticket): ?>
                                <tr data-status="<?= htmlspecialchars($ticket['status']) ?>">
                                    <td><?= htmlspecialchars($ticket['id']) ?></td>
                                    <td><?= htmlspecialchars($ticket['employee_name']) ?></td>
                                    <td><?= htmlspecialchars($ticket['subject']) ?></td>
                                    <td><?= htmlspecialchars($ticket['description']) ?></td>
                                    <td><?= htmlspecialchars($ticket['status']) ?></td>
                                    <td><?= htmlspecialchars($ticket['priority']) ?></td>
                                    <td><?= htmlspecialchars($ticket['category_name']) ?></td>
                                    <td><?= htmlspecialchars($ticket['assigned_to_name']) ?></td>
                                    <td><?= htmlspecialchars($ticket['created_at']) ?></td>
                                    <td class="timer-cell" data-start-at="<?= htmlspecialchars($ticket['start_at']) ?>"></td>
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
                        <option value="" disabled selected>Select HR Representative</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>">
                                <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['department']) ?>)
                            </option>
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
                        value="<?= $_SESSION['department'] ?>" name="department" placeholder="Enter Department">

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



    <!-- Modal -->

    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <h1 class="modal-title">ASSIGN TICKET</h1>

            <form id="confirmationForm" method="POST">
                <div class="input-container">
                    <h1><strong>Ticket ID:</strong></h1>
                    <p class="center-text" id="confirmTicketID" name="editticketID" value="<?= htmlspecialchars($ticket['id']) ?>"></p>
                </div>

                <div class="input-container">
                    <h1><strong>Employee Name:</strong></h1>
                    <p class="center-text" id="confirmemployeeID" value="<?= htmlspecialchars($ticket['employee_name']) ?>">John Doe</p>
                </div>

                <div class="input-container">
                    <h1><strong>Department:</strong></h1>
                    <p class="center-text" id="confirmdepartmentID" data-assigned="<?= htmlspecialchars($ticket['assigned_department']) ?>">Unassigned</p>
                </div>

                <div class="input-container">
                    <h1><strong>Subject:</strong></h1>
                    <p class="center-text" id="confirmsubjectID" value="<?= htmlspecialchars($ticket['subject']) ?>">Paycheck Calculation</p>
                </div>

                <div class="input-container">
                    <h1><strong>Category:</strong></h1>
                    <p class="center-text" id="confirmcategoryID" value="<?= htmlspecialchars($ticket['category']) ?>">Paycheck</p>
                </div>

                <div class="input-container">
                    <h1><strong>Description:</strong></h1>
                    <p class="center-text" id="confirmdescriptionID" value="<?= htmlspecialchars($ticket['description']) ?>">Paycheck miscalculation</p>
                </div>

                <div class="input-container">
                    <h1><strong>Priority:</strong></h1>
                    <p class="center-text" id="confirmpriorityID" value="<?= htmlspecialchars($ticket['priority']) ?>">Paycheck miscalculation</p>
                    </select>
                </div>

                <div class="input-container">
                    <h1><strong>Assigned To:</strong></h1>
                    <p class="center-text" id="confirmassignedID" name="confirmAssigned" value="<?= htmlspecialchars($tickets['assigned_to_name']) ?>"></p>
                    </select>
                </div>


                <div class="input-container">
                    <h1><strong>Status:</strong></h1>
                    <p class="center-text" id="confirmStatusID" value="<?= htmlspecialchars($ticketStatus['status']) ?>"></p>
                    </select>
                </div>


                <div class="btnContainer">
                    <button type="submit" name="confirmButton" id="confirmButtonID" class="btnDefault">CONFIRM ORDER</button>
                    <button type="submit" name="declineButton" id="declineButtonID" class="btnWarning">DECLINE ORDER</button>
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
                    <p class="center-text" id="editdepartmentID" data-assigned="<?= htmlspecialchars($ticket['assigned_department']) ?>">Unassigned</p>
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


    <!-- Ticket Summarization Modal -->
    <div id="ticketSummarizationModal" class="modal">
        <div class="modal-content">
            <h1 class="modal-title">Ticket Summarization</h1>

            <form id="ticketSummarizationForm" method="POST">
                <div class="input-container">
                    <h1><strong>Ticket ID:</strong></h1>
                    <p class="center-text" id="summarizationTicketID"><?= htmlspecialchars($ticket['id'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Employee Name:</strong></h1>
                    <p class="center-text" id="summarizationEmployeeName"><?= htmlspecialchars($ticket['employee_name'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Department:</strong></h1>
                    <p class="center-text" id="summarizationDepartment" data-assigned="<?= htmlspecialchars($ticket['assigned_department']) ?>">Unassigned</p>
                </div>

                <div class="input-container">
                    <h1><strong>Subject:</strong></h1>
                    <p class="center-text" id="summarizationSubject"><?= htmlspecialchars($ticket['subject'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Category:</strong></h1>
                    <p class="center-text" id="summarizationCategory"><?= htmlspecialchars($ticket['category'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Description:</strong></h1>
                    <p class="center-text" id="summarizationDescription"><?= htmlspecialchars($ticket['description'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Priority:</strong></h1>
                    <p class="center-text" id="summarizationPriority"><?= htmlspecialchars($ticket['priority'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Assigned To:</strong></h1>
                    <p class="center-text" id="summarizationAssignedTo"><?= htmlspecialchars($ticket['assigned_to_name'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Status:</strong></h1>
                    <p class="center-text" id="summarizationStatus"><?= htmlspecialchars($ticket['status'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Duration:</strong></h1>
                    <p class="center-text" id="summarizationDuration" data-assigned="<?= htmlspecialchars($ticket['start_at']) ?>">Unassigned</p>
                </div>

                <div class="btnContainer">
                    <button type="button" class="btnDanger" onclick="closeModal()">BACK</button>
                </div>
            </form>
        </div>
    </div>








    <script src="../../assets/js/framework.js"></script>

    <script src="../../assets/js/adminTicket.js"></script>
</body>

</html>