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
                <div class="col plate" id="plate5" data-status="ResetLeave">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/reset.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Reset Leave Balances</div>
                    </div>
                </div>

            </div>
            <br><br>


            <!-- Add this button to trigger the modal
            <div class="btnContainer">
                <button type="button" class="btnContainer btnDefault" id="resetLeaveButtonID">Reset Leave Request Values</button>
            </div> -->


            <style>
                /* Specific styles for the Reset Leave Request Modal */
                #resetLeaveModal {
                    display: none;
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: rgba(0, 0, 0, 0.5);
                    /* Semi-transparent background */
                    justify-content: center;
                    /* Horizontally center the modal */
                    align-items: center;
                    /* Vertically center the modal */

                }

                #resetLeaveModal .modal-content {
                    background: white;
                    padding: 20px;
                    border-radius: 8px;
                    width: 600px;
                    max-width: 95%;
                    text-align: center;
                    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
                }

                /* Modal buttons */
                #resetLeaveModal .modal-buttons {
                    display: flex;
                }
            </style>

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
                            <th>Employee Name <i class="fas fa-sort"></i></th>
                            <th>Department <i class="fas fa-sort"></i></th>
                            <th>Leave Type <i class="fas fa-sort"></i></th>
                            <th>Start Date <i class="fas fa-sort"></i></th>
                            <th>End Date <i class="fas fa-sort"></i></th>
                            <th>Reason <i class="fas fa-sort"></i></th>
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
                                    data-employee-id="<?= htmlspecialchars($leave['name']) ?>"
                                    data-department="<?= htmlspecialchars($leave['department']) ?>"
                                    data-leave-type="<?= htmlspecialchars($leave['leave_types']) ?>"
                                    data-start-date="<?= htmlspecialchars($leave['start_date']) ?>"
                                    data-end-date="<?= htmlspecialchars($leave['end_date']) ?>"
                                    data-reason="<?= htmlspecialchars($leave['reason']) ?>"
                                    data-status="<?= htmlspecialchars($leave['status']) ?>"
                                    data-created-at="<?= htmlspecialchars($leave['created_at']) ?>"
                                    data-approved-by="<?= htmlspecialchars($leave['approved_by_name']) ?>"
                                    data-updated-at="<?= htmlspecialchars($leave['updated_at']) ?>">

                                    <td><?= htmlspecialchars($leave['id']) ?></td>
                                    <td><?= htmlspecialchars($leave['name']) ?></td>
                                    <td><?= htmlspecialchars($leave['department']) ?></tdhidden>
                                    <td><?= htmlspecialchars($leave['leave_types']) ?></td>
                                    <td><?= htmlspecialchars($leave['start_date']) ?></td>
                                    <td><?= htmlspecialchars($leave['end_date']) ?></td>
                                    <td><?= htmlspecialchars($leave['reason']) ?></td>
                                    <td><?= htmlspecialchars($leave['status']) ?></td>
                                    <td><?= htmlspecialchars($leave['created_at']) ?></td>
                                    <td><?= htmlspecialchars($leave['approved_by_name']) ?></td>
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
        <!-- approve Modal -->
        <div id="approveModal" class="modal">
            <div class="modal-content">
                <h2>APPROVE LEAVE REQUEST</h2>
                <form id="approveFormContent" method="POST">
                    <input type="hidden" id="approveLeaveID" name="leaveId" value="<?= htmlspecialchars($leave['id'] ?? '') ?>">

                    <div class="input-container">
                        <h1><strong>Employee Name:</strong></h1>
                        <p class="center-text" id="approveNameId"><?= htmlspecialchars($leave['employee_name'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Department:</strong></h1>
                        <p class="center-text" id="approveDepartmentId"><?= htmlspecialchars($leave['department'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Leave Type:</strong></h1>
                        <p class="center-text" id="approveLeaveTypeId"><?= htmlspecialchars($leave['leave_types'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Start Date:</strong></h1>
                        <p class="center-text" id="approveStartDateId"><?= htmlspecialchars($leave['start_date'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>End Date:</strong></h1>
                        <p class="center-text" id="approveEndDateId"><?= htmlspecialchars($leave['end_date'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Reason:</strong></h1>
                        <p class="center-text" id="approveReasonId"><?= htmlspecialchars($leave['reason'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Status:</strong></h1>
                        <p class="center-text" id="approveStatusId"><?= htmlspecialchars($leave['status'] ?? 'N/A') ?></p>
                    </div>

                    <div class="modal-buttons">
                        <button type="submit" id="approveLeaveBtnID" name="approveLeaveBtn" class="btnDefault btnContainer">APPROVE</button>
                        <button type="submit" id="declineLeaveBtnID" name="declineLeaveBtn" class="btnWarning btnContainer">REJECT</button>
                        <button type="button" class="btnDanger btnContainer" onclick="closeModal()">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- edit Modal -->
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
                                    $stmt = $pdo->prepare("SELECT 
                                        sl AS sick_leave,
                                        sil AS service_incentive_leave,
                                        elc AS earned_leave_credit,
                                        bl AS birthday_leave,
                                        ml AS maternity_leave,
                                        pl AS paternity_leave,
                                        spl AS solo_parent_leave,
                                        brl AS bereavement_leave
                                    FROM total_balance
                                    WHERE user_id = :user_id");

                                    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $leaveBalances = $stmt->fetch(PDO::FETCH_ASSOC);

                                    // Debug: Check if $leaveBalances contains the expected data
                                    var_dump($leaveBalances); // Use this to debug

                                    if ($leaveBalances) {
                                        // Ensure that we have data to work with before rendering options
                                        echo '<option value="Sick Leave">Sick Leave</option>';
                                        echo '<option value="Service Incentive Leave">Service Incentive Leave</option>';
                                        echo '<option value="Earned Leave Credit">Earned Leave Credit</option>';
                                        echo '<option value="Birthday Leave">Birthday Leave</option>';
                                        echo '<option value="Maternity Leave">Maternity Leave</option>';
                                        echo '<option value="Paternity Leave">Paternity Leave</option>';
                                        echo '<option value="Solo Parent Leave">Solo Parent Leave</option>';
                                        echo '<option value="Bereavement Leave">Bereavement Leave</option>';
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
        <!-- Reset Leave Request Modal -->
        <div id="resetLeaveModal" class="modal">
            <div class="modal-content">
                <h2>Confirm Reset Leave Values</h2>
                <p>Are you sure you want to reset all leave request values? This action cannot be undone.</p>
                <div class="btnContainer">
                    <form id="resetLeaveForm" method="POST">
                        <button type="submit" class="btnWarning " name="resetValueButton">Confirm Reset</button>
                        <button type="button" class="btnDefault" id="cancelReset">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

    </div>





    <script src="../../assets/js/framework.js"></script>
    <!-- function plate 4 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements for modal functionality
            const plate4 = document.getElementById('plate4');
            const requestLeaveModal = document.getElementById('requestLeaveModal');
            const leaveForm = document.getElementById('leaveForm');
            const leaveFormContent = document.getElementById('leaveFormContent');

            // Open modal functionality
            if (plate4 && requestLeaveModal && leaveForm) {
                plate4.addEventListener('click', () => {
                    requestLeaveModal.style.display = 'flex'; // Show the modal
                    leaveForm.style.display = 'block'; // Show the form
                });
            } else {
                console.error('One or more required elements not found.');
            }

            // Close modal functionality
            const closeModal = () => {
                if (requestLeaveModal) {
                    requestLeaveModal.style.display = 'none'; // Hide the modal
                }
            };

            if (requestLeaveModal) {
                const closeModalButtons = requestLeaveModal.querySelectorAll('.btnDanger');
                closeModalButtons.forEach(button => {
                    button.addEventListener('click', closeModal); // Use the closeModal function to close the modal
                });
            }

            // Form submission functionality
            if (leaveFormContent) {
                leaveFormContent.addEventListener('submit', function(e) {
                    e.preventDefault(); // Prevent normal form submission

                    // Serialize form data
                    const formData = new FormData(leaveFormContent);
                    const data = new URLSearchParams();
                    formData.forEach((value, key) => {
                        data.append(key, value);
                    });

                    // Send AJAX request using Fetch API
                    fetch('../../0/includes/submitLeaverequest.php', {
                            method: 'POST',
                            body: data,
                        })
                        .then((response) => response.json())
                        .then((response) => {
                            if (response.status === 'success') {
                                alert(response.message); // Show success message
                                closeModal(); // Close modal using the closeModal function
                                location.reload(); // Reload the page
                            } else {
                                alert('Error: ' + response.message); // Show error message
                            }
                        })
                        .catch((error) => {
                            alert('AJAX Error: ' + error); // Handle connection/server error
                        });
                });
            }
        });
    </script>
    <!-- function plate 5 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resetLeaveModal = document.getElementById('resetLeaveModal');
            const cancelResetButton = document.getElementById('cancelReset');
            const plate5 = document.getElementById('plate5');
            const resetLeaveForm = document.getElementById('resetLeaveForm');

            // Check if the form exists
            if (!resetLeaveForm) {
                console.error("resetLeaveForm element not found!");
                return;
            }

            // Open the modal when the plate is clicked
            plate5.addEventListener('click', () => {
                resetLeaveModal.style.display = 'flex';
            });

            // Close the modal when the cancel button is clicked
            cancelResetButton.addEventListener('click', () => {
                resetLeaveModal.style.display = 'none';
            });

            // Close the modal when clicking outside of it
            window.addEventListener('click', (event) => {
                if (event.target === resetLeaveModal) {
                    resetLeaveModal.style.display = 'none';
                }
            });

            // Handle form submission via AJAX
       
            resetLeaveForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(resetLeaveForm);
    formData.append('resetValueButton', true);

    fetch('../../0/includes/resetLeaveValue.php', {
        method: 'POST',
        body: formData,
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then((data) => {
        alert(data.message);
        if (data.success) {
            location.reload();
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('An error occurred: ' + error.message);
    });
});
       
       
        });
    </script>
    <!-- function close modal -->
    <script>
        // Function to close the modal
        function closeModal() {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.style.display = 'none';
            });
        }

        // Event listener for clicking outside the modal to close it
        window.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    closeModal();
                }
            });
        });
    </script>

    <script>
        // These PHP values must be output into JS **before** any functions use them
        const sickLeaveTotal = <?= $leaveBalances['sick_leave'] ?? 0 ?>;
        const sickLeaveUsed = <?= $usedBalances['sick_leave'] ?? 0 ?>;
        const serviceIncentiveLeaveTotal = <?= $leaveBalances['service_incentive_leave'] ?? 0 ?>;
        const serviceIncentiveLeaveUsed = <?= $usedBalances['service_incentive_leave'] ?? 0 ?>;
        const earnedLeaveCreditTotal = <?= $leaveBalances['earned_leave_credit'] ?? 0 ?>;
        const earnedLeaveCreditUsed = <?= $usedBalances['earned_leave_credit'] ?? 0 ?>;
        const birthdayLeaveTotal = <?= $leaveBalances['birthday_leave'] ?? 0 ?>;
        const birthdayLeaveUsed = <?= $usedBalances['birthday_leave'] ?? 0 ?>;
        const maternityLeaveTotal = <?= $leaveBalances['maternity_leave'] ?? 0 ?>;
        const maternityLeaveUsed = <?= $usedBalances['maternity_leave'] ?? 0 ?>;
        const paternityLeaveTotal = <?= $leaveBalances['paternity_leave'] ?? 0 ?>;
        const paternityLeaveUsed = <?= $usedBalances['paternity_leave'] ?? 0 ?>;
        const soloParentLeaveTotal = <?= $leaveBalances['solo_parent_leave'] ?? 0 ?>;
        const soloParentLeaveUsed = <?= $usedBalances['solo_parent_leave'] ?? 0 ?>;
        const bereavementLeaveTotal = <?= $leaveBalances['bereavement_leave'] ?? 0 ?>;
        const bereavementLeaveUsed = <?= $usedBalances['bereavement_leave'] ?? 0 ?>;

        // ✅ Define remainingBalances here FIRST
        const remainingBalances = {
            sl: sickLeaveTotal - sickLeaveUsed,
            sil: serviceIncentiveLeaveTotal - serviceIncentiveLeaveUsed,
            elc: earnedLeaveCreditTotal - earnedLeaveCreditUsed,
            bl: birthdayLeaveTotal - birthdayLeaveUsed,
            ml: maternityLeaveTotal - maternityLeaveUsed,
            pl: paternityLeaveTotal - paternityLeaveUsed,
            spl: soloParentLeaveTotal - soloParentLeaveUsed,
            brl: bereavementLeaveTotal - bereavementLeaveUsed
        };

        // ✅ Leave type mapping
        const leaveTypeMap = {
            "Sick Leave": "sl",
            "Service Incentive Leave": "sil",
            "Earned Leave Credit": "elc",
            "Birthday Leave": "bl",
            "Maternity Leave": "ml",
            "Paternity Leave": "pl",
            "Solo Parent Leave": "spl",
            "Bereavement Leave": "brl"
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



        // Ensure the currentUserId is available globally
        const currentUserId = <?= json_encode($_SESSION['user_id'] ?? null) ?>;
        console.log("Current User ID in Session:" + currentUserId);
        document.addEventListener("DOMContentLoaded", function() {
            const tableRows = document.querySelectorAll("tbody tr");
            const approveModal = document.getElementById("approveModal");
            const editStatusModal = document.getElementById("editStatusModal");
            const ticketSummarizationModal = document.getElementById(
                "ticketSummarizationModal"
            );

            // Modal fields for approveModal
            const approveModalFields = {
                leaveIdField: document.getElementById("approveLeaveID"),
                employeeNameField: document.getElementById("approveNameId"),
                departmentField: document.getElementById("approveDepartmentId"),
                leaveTypeField: document.getElementById("approveLeaveTypeId"),
                startDateField: document.getElementById("approveStartDateId"),
                reasonField: document.getElementById("approveReasonId"),
                endDateField: document.getElementById("approveEndDateId"),
                reasonField: document.getElementById("approveReasonId"),
                statusField: document.getElementById("approveStatusId"),
            };

            // Modal fields for editStatusModal
            const editStatusModalFields = {
                ticketIdField: document.getElementById("editTicketID"),
                employeeNameField: document.getElementById("editemployeeID"),
                departmentField: document.getElementById("editdepartmentID"),
                subjectField: document.getElementById("editsubjectID"),
                categoryField: document.getElementById("editcategoryID"),
                descriptionField: document.getElementById("editdescriptionID"),
                priorityField: document.getElementById("editpriorityID"),
                assignedToField: document.getElementById("editassignedID"),
            };

            // Fields in the Ticket Summarization Modal
            const summarizationFields = {
                ticketIdField: document.getElementById("summarizationTicketID"),
                employeeNameField: document.getElementById("summarizationEmployeeName"),
                departmentField: document.getElementById("summarizationDepartment"),
                subjectField: document.getElementById("summarizationSubject"),
                categoryField: document.getElementById("summarizationCategory"),
                descriptionField: document.getElementById("summarizationDescription"),
                priorityField: document.getElementById("summarizationPriority"),
                assignedToField: document.getElementById("summarizationAssignedTo"),
                statusField: document.getElementById("summarizationStatus"),
                durationField: document.getElementById("summarizationDuration"),
            };

            // Add click event listener to each row
            tableRows.forEach((row) => {
                row.addEventListener("click", function() {
                    // Remove highlight from all rows
                    tableRows.forEach((r) => r.classList.remove("highlighted"));

                    // Highlight the clicked row
                    this.classList.add("highlighted");

                    // Get the values from the clicked row
                    const leaveId = this.children[0].textContent.trim(); // ID
                    const employeeId = this.children[1].textContent.trim(); // Employee ID
                    const department = this.children[2].textContent.trim(); // Department
                    const leaveType = this.children[3].textContent.trim(); // Leave Type
                    const startDate = this.children[4].textContent.trim(); // Start Date
                    const endDate = this.children[5].textContent.trim(); // End Date
                    const reason = this.children[6].textContent.trim(); // Reason
                    const status = this.children[7].textContent.trim(); // Status
                    const createdAt = this.children[8].textContent.trim(); // Created At
                    const approvedBy = this.children[9].textContent.trim(); // Approved By
                    const updatedAt = this.children[10].textContent.trim(); // Updated At
                    // Get the current user from the session
                    const currentUser = document
                        .querySelector(".accountName")
                        .textContent.trim();


                    const currentUserId = <?= json_encode($_SESSION['user_id'] ?? null) ?>;
                    console.log("Currnt User ID in Session:" + currentUserId);

                    // Check the status
                    if (status === "Pending") {
                        // Set the values in the approveModal
                        approveModalFields.leaveIdField.textContent = leaveId;
                        approveModalFields.employeeNameField.textContent = employeeId;
                        approveModalFields.departmentField.textContent = department; // No department field in the table rows
                        approveModalFields.leaveTypeField.textContent = leaveType;
                        approveModalFields.startDateField.textContent = startDate;
                        approveModalFields.endDateField.textContent = endDate;
                        approveModalFields.reasonField.textContent = reason; // No reason field in the table rows
                        approveModalFields.statusField.style.color = "red";
                        approveModalFields.statusField.textContent = status;

                        // Open the approveModal
                        approveModal.style.display = "flex";
                    } else if (status === "In Progress" && assignedTo.toLowerCase() === currentUser.toLowerCase()) {
                        // Set the values in the editStatusModal
                        editStatusModalFields.ticketIdField.textContent = ticketId;
                        editStatusModalFields.employeeNameField.textContent = employeeName;
                        editStatusModalFields.departmentField.textContent = assignedDepartment;
                        editStatusModalFields.subjectField.textContent = subject;
                        editStatusModalFields.categoryField.textContent = category;
                        editStatusModalFields.descriptionField.textContent = description;
                        editStatusModalFields.priorityField.textContent = priority;
                        editStatusModalFields.assignedToField.textContent = assignedTo;

                        // Open the editStatusModal
                        editStatusModal.style.display = "flex";
                    } else if (status === "Resolved") {
                        // Populate the modal fields
                        console.log("Resolved ticket clicked:", ticketId); // Debugging line
                        console.log("Childeren:", this.children); // Debugging line
                        summarizationFields.ticketIdField.textContent = ticketId;
                        summarizationFields.employeeNameField.textContent = employeeName;
                        editStatusModalFields.departmentField.textContent = assignedDepartment;
                        summarizationFields.subjectField.textContent = subject;
                        summarizationFields.categoryField.textContent = category;
                        summarizationFields.descriptionField.textContent = description;
                        summarizationFields.priorityField.textContent = priority;
                        summarizationFields.assignedToField.textContent = assignedTo;
                        summarizationFields.statusField.textContent = status;

                        // Calculate and populate the duration
                        if (Date.parse(startAt) && Date.parse(updatedAt)) {
                            const startDate = new Date(startAt);
                            const updatedDate = new Date(updatedAt);
                            const durationMs = updatedDate - startDate;

                            // Convert duration to days, hours, and minutes
                            const days = Math.floor(durationMs / (1000 * 60 * 60 * 24));
                            const hours = Math.floor(
                                (durationMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                            );
                            const minutes = Math.floor(
                                (durationMs % (1000 * 60 * 60)) / (1000 * 60)
                            );
                            const seconds = Math.floor((durationMs % (1000 * 60)) / 1000);

                            summarizationFields.durationField.textContent = `${days} days, ${hours} hours, ${minutes} minutes, ${seconds} seconds`;
                        } else {
                            summarizationFields.durationField.textContent = "N/A";
                        }

                        ticketSummarizationModal.style.display = "flex";

                    }
                });
            });

            // Close the modal when clicking outside of it
            window.addEventListener("click", function(event) {
                if (event.target === approveModal) {
                    approveModal.style.display = "none";
                }
                if (event.target === editStatusModal) {
                    editStatusModal.style.display = "none";
                }
                if (event.target === ticketSummarizationModal) {
                    ticketSummarizationModal.style.display = "none";
                }
            });

            // Close the modal when clicking the "BACK" button
            const closeModalButtons = document.querySelectorAll(".btnDanger");
            closeModalButtons.forEach((button) => {
                button.addEventListener("click", function() {
                    approveModal.style.display = "none";
                    editStatusModal.style.display = "none";
                    ticketSummarizationModal.style.display = "none";
                });
            });
        });


        // Approve Leave Request Form
        document.addEventListener("DOMContentLoaded", function() {
            const approveButton = document.getElementById("approveLeaveBtnID");

            approveButton.addEventListener("click", function(event) {
                event.preventDefault();

                // Retrieve values from the modal
                const leaveId = document.getElementById("approveLeaveID").textContent.trim();
                const leaveType = document.getElementById("approveLeaveTypeId").textContent.trim(); // Retrieve leave type
                const startDate = document.getElementById("approveStartDateId").textContent.trim(); // Retrieve start date
                const endDate = document.getElementById("approveEndDateId").textContent.trim(); // Retrieve end date

                console.log("Approving Leave ID:", leaveId);
                console.log("Leave Type:", leaveType);
                console.log("Start Date:", startDate);
                console.log("End Date:", endDate);
                console.log("Current User ID in Session:", currentUserId);

                // Send the data to the backend
                fetch("../../0/includes/approveLeaveRequest.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            leaveId: leaveId,
                            approvedBy: currentUserId,
                            leaveType: leaveType,
                            startDate: startDate,
                            endDate: endDate
                        }),
                    })
                    .then((response) => response.json()) // Parse the JSON response
                    .then((data) => {
                        if (data.success) {
                            alert("Leave request approved successfully!");
                            location.reload();
                        } else {
                            alert("Failed to approve leave request: " + data.message);
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert("An error occurred while approving the leave request.");
                    });

            });
        });
    </script>


</body>

</html>