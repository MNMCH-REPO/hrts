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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/framework.css">
    <link rel="stylesheet" href="../../assets/css/hrRepOrder.css">
    <title>HRTS</title>
</head>


<style>
    #leaveBalanceDisplay,
    #leaveWarning {
        display: block;
        text-align: center;
        /* Centers the text inside the elements */
        margin: 0 auto;
        /* Centers the elements themselves horizontally */
        width: 100%;
        /* Ensures it occupies full width */
    }
</style>

<body>
    <div class="container">
        <div class="sideNav">
            <div class="sideNavLogo img-cover"></div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/ticket.png);"></div>
                <a href="ticket.php">Tickets</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/leave.png);"></div>
                <a href="leave.php">Leave Management</a>
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
                <div class="col plate" id="plate1" data-status="Pending">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/hourglass.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Pending</div>
                        <div class="plateValue"><?= htmlspecialchars($statusCountsArray['Pending'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="col plate" id="plate2" data-status="Approved">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/ethics.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Approved</div>
                        <div class="plateValue"><?= htmlspecialchars($statusCountsArray['Approved'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="col plate" id="plate3" data-status="Rejected">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/hourglass.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Rejected</div>
                        <div class="plateValue"><?= htmlspecialchars($statusCountsArray['Rejected'] ?? 0) ?></div>
                    </div>
                </div>
                <div class="col plate" id="plate4" data-status="Leave">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/add.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Request</div>
                    </div>
                </div>
            </div>


            <br><br>

            <div class="tableContainer">
                <h1 class="table-title">LEAVE REQUEST TICKET</h1>
                <div class="pagination-wrapper">
                    <div class="pagination" id="pageNationID">
                        <div id="paginationControls" class="mt-3"></div>
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
                <table id="leaveTable" class="table">
                    <thead>
                        <tr>
                            <th>ID <i class="fas fa-sort"></i></th>
                            <th>Employee ID <i class="fas fa-sort"></i></th>
                            <th>Leave Type <i class="fas fa-sort"></i></th>
                            <th>Start Date <i class="fas fa-sort"></i></th>
                            <th>End Date <i class="fas fa-sort"></i></th>
                            <th>Status <i class="fas fa-sort"></i></th>
                            <th>Created At <i class="fas fa-sort"></i></th>
                            <th>Approved By <i class="fas fa-sort"></i></th>
                            <th>Updated At <i class="fas fa-sort"></i></th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php if (!empty($leave_requests)): ?>
                            <?php foreach ($leave_requests as $leave): ?>
                                <tr data-id="<?= htmlspecialchars($leave['id']) ?>"
                                    data-employee-id="<?= htmlspecialchars($leave['employee_id']) ?>"
                                    data-leave-type="<?= htmlspecialchars($leave['leave_types']) ?>"
                                    data-start-date="<?= htmlspecialchars($leave['start_date']) ?>"
                                    data-end-date="<?= htmlspecialchars($leave['end_date']) ?>"
                                    data-status="<?= htmlspecialchars($leave['status']) ?>"
                                    data-created-at="<?= htmlspecialchars($leave['created_at']) ?>"
                                    data-approved-by="<?= htmlspecialchars($leave['approved_by']) ?>"
                                    data-updated-at="<?= htmlspecialchars($leave['updated_at']) ?>">

                                    <td><?= htmlspecialchars($leave['id']) ?></td>
                                    <td><?= htmlspecialchars($leave['employee_id']) ?></td>
                                    <td><?= htmlspecialchars($leave['leave_types']) ?></td>
                                    <td><?= htmlspecialchars($leave['start_date']) ?></td>
                                    <td><?= htmlspecialchars($leave['end_date']) ?></td>
                                    <td><?= htmlspecialchars($leave['status']) ?></td>
                                    <td><?= htmlspecialchars($leave['created_at']) ?></td>
                                    <td><?= htmlspecialchars($leave['approved_by']) ?></td>
                                    <td><?= htmlspecialchars($leave['updated_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>


                        <?php else: ?>
                            <tr>
                                <td colspan="10" style="text-align: center;">No Leave Request Found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
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
                        <p class="center-text" id="confirmdepartmentID" value="<?= htmlspecialchars($ticket['assigned_department']) ?>">Accounting and Finance</p>
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
                <h1 class="modal-title">EDIT TICKET STATUS</h1>

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
                        <p class="center-text" id="editdepartmentID" value="<?= htmlspecialchars($ticket['department']) ?>">Accounting and Fnance</p>
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
                        <select name="statusEdit" id="statusEditID" required>
                            <option value="" disabled selected>Select a status</option>
                            <option value="Resolved">Resolved</option>
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



        <!--request Leave Modal -->
        <div id="requestLeaveModal" class="modal">
            <div class="modal-content">
                <!-- Leave Request Form with Balance Checker -->
                <div id="leaveForm" class="request-form" style="display:none;">
                    <h2>LEAVE REQUEST FORM</h2>
                    <form id="leaveFormContent" action="../../0/includes/submitLeaverequest.php" method="POST">
                        <input type="hidden" id="leaveEmployeeID" name="employeeId" value="<?= $_SESSION['user_id'] ?>">
                        <div class="input-container">
                            <input type="text" name="employeeName" value="<?= $_SESSION['name'] ?>" readonly>
                            <label for="employeeName">Employee Name</label>
                        </div>

                        <div class="input-container">
                            <input type="text" name="department" value="<?= $_SESSION['department'] ?>" readonly>
                            <label for="department">Department</label>
                        </div>

                        <div class="input-container">
                            <select name="leaveType" id="leaveTypeSelect" required>
                                <option value="" disabled selected>Select Leave Type</option>
                                <?php
                                require_once '../../0/includes/db.php'; // Include your database connection file

                                // Fetch leave balances from the total_balance table for the logged-in user
                                $userId = $_SESSION['user_id'] ?? null; // Assuming user_id is stored in the session
                                if ($userId) {
                                    $stmt = $pdo->prepare("
                                    SELECT 
                                        sick_leave_value, 
                                        service_incentive_leave_value, 
                                        earned_leave_credit_value, 
                                        vacation_value, 
                                        emergency_leave_value 
                                    FROM total_balance
                                    WHERE user_id = :user_id
                                ");
                                    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $leaveBalances = $stmt->fetch(PDO::FETCH_ASSOC);
                                    // Display the leave balances with default words
                                    if ($leaveBalances) {
                                        echo '<option value="Sick Leave">Sick Leave</option>';
                                        echo '<option value="Service Incentive Leave">Service Incentive Leave</option>';
                                        echo '<option value="Earned Leave Credit">Earned Leave Credit</option>';
                                        echo '<option value="Vacation">Vacation</option>';
                                        echo '<option value="Emergency Leave">Emergency Leave</option>';
                                    } else {
                                        echo '<option value="" disabled>No Leave Types found</option>';
                                    }
                                } else {
                                    echo '<option value="" disabled>User not logged in</option>';
                                }
                                ?>
                            </select>
                            <label for="leaveType">Leave Type</label>
                        </div>

                        <div class="input-container">
                            <input type="date" name="startDate" id="startDate" required>
                            <label for="startDate">Start Date</label>
                        </div>

                        <div class="input-container">
                            <input type="date" name="endDate" id="endDate" required>
                            <label for="endDate">End Date</label>
                        </div>

                        <div class="input-container">
                            <textarea name="reason" required></textarea>
                            <label for="reason">Reason</label>
                        </div>



                        <!-- Balance and warning -->
                        <div class="input-container">
                            <p id="leaveBalanceDisplay"><strong>Leave Balance:</strong> <span id="leaveBalance">--</span> days</p>
                            <p id="leaveWarning" style="color:red; display:none;">You do not have enough leave balance.</p>
                        </div>

                        <div class="modal-buttons">
                            <button type="submit" id="submitLeaveBtn" name="submitLeaveBtn" class="btnDefault btnContainer">SUBMIT REQUEST</button>
                            <button type="button" class="btnDanger btnContainer" onclick="closeModal()">CANCEL</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

    </style>





    <script src="../../assets/js/framework.js"></script>
    <script src="../../assets/js/hrRepOrder.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Elements for modal functionality
            const plate4 = document.getElementById('plate4');
            const requestLeaveModal = document.getElementById('requestLeaveModal');
            const leaveForm = document.getElementById('leaveForm');

            if (plate4 && requestLeaveModal && leaveForm) {
                plate4.addEventListener('click', () => {
                    // Open the modal
                    requestLeaveModal.style.display = 'flex';
                    leaveForm.style.display = 'block';
                });
            } else {
                console.error('One or more required elements not found.');
            }

            // Close modal functionality
            if (requestLeaveModal) {
                const closeModalButtons = requestLeaveModal.querySelectorAll('.btnDanger');
                closeModalButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        requestLeaveModal.style.display = 'none'; // Close the modal
                        leaveForm.style.display = 'none'; // Hide the form again
                    });
                });
            }
        });
    </script>


    <script>
        // These PHP values must be output into JS **before** any functions use them
        const sickLeaveTotal = <?= $leaveBalances['sick_leave_value'] ?? 0 ?>;
        const sickLeaveUsed = <?= $usedBalances['sick_leave_value'] ?? 0 ?>;
        const silTotal = <?= $leaveBalances['service_incentive_leave_value'] ?? 0 ?>;
        const silUsed = <?= $usedBalances['service_incentive_leave_value'] ?? 0 ?>;
        const elcTotal = <?= $leaveBalances['earned_leave_credit_value'] ?? 0 ?>;
        const elcUsed = <?= $usedBalances['earned_leave_credit_value'] ?? 0 ?>;
        const vacationTotal = <?= $leaveBalances['vacation_value'] ?? 0 ?>;
        const vacationUsed = <?= $usedBalances['vacation_value'] ?? 0 ?>;
        const emergencyTotal = <?= $leaveBalances['emergency_leave_value'] ?? 0 ?>;
        const emergencyUsed = <?= $usedBalances['emergency_leave_value'] ?? 0 ?>;

        // ✅ Define remainingBalances here FIRST
        const remainingBalances = {
            sick_leave: sickLeaveTotal - sickLeaveUsed,
            service_incentive_leave: silTotal - silUsed,
            earned_leave_credit: elcTotal - elcUsed,
            vacation_leave: vacationTotal - vacationUsed,
            emergency_leave: emergencyTotal - emergencyUsed
        };

        // ✅ Leave type mapping
        const leaveTypeMap = {
            "Sick Leave": "sick_leave",
            "Service Incentive Leave": "service_incentive_leave",
            "Earned Leave Credit": "earned_leave_credit",
            "Vacation": "vacation_leave",
            "Emergency Leave": "emergency_leave"
        };

        // ✅ Your existing functions below
        function calculateDaysBetween(start, end) {
            const startDate = new Date(start);
            const endDate = new Date(end);
            const diffTime = endDate - startDate;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            return diffDays;
        }

        function updateLeaveBalance() {
            const leaveTypeRaw = document.getElementById("leaveTypeSelect").value;
            const leaveType = leaveTypeMap[leaveTypeRaw] || null;
            const start = document.getElementById("startDate").value;
            const end = document.getElementById("endDate").value;
            const submitBtn = document.getElementById("submitLeaveBtn");
            const warning = document.getElementById("leaveWarning");

            const balance = remainingBalances[leaveType] ?? 0;
            document.getElementById("leaveBalance").textContent = balance;

            if (start && end && leaveType) {
                const requestedDays = calculateDaysBetween(start, end);
                if (requestedDays > balance) {
                    warning.style.display = "block";
                    leaveBalanceDisplay.style.display = "none"; // Hide the balance display
                    submitBtn.disabled = true;

                } else {
                    warning.style.display = "none";
                    leaveBalanceDisplay.style.display = "block"; // Hide the balance display
                    submitBtn.disabled = false;
                }
            }

        }

        // ✅ Make sure these event listeners come after all above code
        document.getElementById("leaveTypeSelect").addEventListener("change", updateLeaveBalance);
        document.getElementById("startDate").addEventListener("change", updateLeaveBalance);
        document.getElementById("endDate").addEventListener("change", updateLeaveBalance);
    </script>


</body>

</html>