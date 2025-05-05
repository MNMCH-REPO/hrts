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
                <div class="col plate" id="plate4">
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
                        <button type="button" class="btnDanger btnContainer" onclick="closeModal()">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Approved Summarization Modal -->
        <div id="approvedSummarizationModal" class="modal">
            <div class="modal-content">
                <h1 class="modal-title">Approved Leave Summarization</h1>
                <div class="input-container">
                    <h1><strong>Leave ID:</strong></h1>
                    <p class="center-text" id="approvedSummarizationLeaveID"><?= htmlspecialchars($leave['id'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Employee Name:</strong></h1>
                    <p class="center-text" id="approvedSummarizationEmployeeName"><?= htmlspecialchars($leave['employee_name'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Department:</strong></h1>
                    <p class="center-text" id="approvedSummarizationDepartment"><?= htmlspecialchars($leave['department'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Leave Type:</strong></h1>
                    <p class="center-text" id="approvedSummarizationLeaveType"><?= htmlspecialchars($leave['leave_types'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Start Date:</strong></h1>
                    <p class="center-text" id="approvedSummarizationStartDate"><?= htmlspecialchars($leave['start_date'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>End Date:</strong></h1>
                    <p class="center-text" id="approvedSummarizationEndDate"><?= htmlspecialchars($leave['end_date'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Reason:</strong></h1>
                    <p class="center-text" id="approvedSummarizationReason"><?= htmlspecialchars($leave['reason'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Status:</strong></h1>
                    <p class="center-text" id="approvedSummarizationStatus"><?= htmlspecialchars($leave['status'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Created At:</strong></h1>
                    <p class="center-text" id="approvedSummarizationCreatedAt"><?= htmlspecialchars($leave['created_at'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Updated At:</strong></h1>
                    <p class="center-text" id="approvedSummarizationUpdatedAt"><?= htmlspecialchars($leave['updated_at'] ?? 'N/A') ?></p>

                </div>

                <div class="input-container">
                    <h1><strong>Approved By:</strong></h1>
                    <p class="center-text" id="approvedSummarizationApprovedBy"><?= htmlspecialchars($leave['approved_by_name'] ?? 'N/A') ?></p>
                </div>


                <div class="btnContainer">
                    <button type="button" class="btnDanger" onclick="closeModal()">BACK</button>
                </div>
            </div>
        </div>
        <!-- Rejected Summarization Modal -->
        <div id="rejectedSummarizationModal" class="modal">
            <div class="modal-content">
                <h1 class="modal-title">Rejected Leave Summarization</h1>

                <form id="rejectedSummarizationForm" method="POST">
                    <div class="input-container">
                        <h1><strong>Leave ID:</strong></h1>
                        <p class="center-text" id="rejectedSummarizationLeaveID"><?= htmlspecialchars($leave['id'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Employee Name:</strong></h1>
                        <p class="center-text" id="rejectedSummarizationEmployeeName"><?= htmlspecialchars($leave['employee_name'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Department:</strong></h1>
                        <p class="center-text" id="rejectedSummarizationDepartment"><?= htmlspecialchars($leave['department'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Leave Type:</strong></h1>
                        <p class="center-text" id="rejectedSummarizationLeaveType"><?= htmlspecialchars($leave['leave_types'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Start Date:</strong></h1>
                        <p class="center-text" id="rejectedSummarizationStartDate"><?= htmlspecialchars($leave['start_date'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>End Date:</strong></h1>
                        <p class="center-text" id="rejectedSummarizationEndDate"><?= htmlspecialchars($leave['end_date'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Reason:</strong></h1>
                        <p class="center-text" id="rejectedSummarizationReason"><?= htmlspecialchars($leave['reason'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Status:</strong></h1>
                        <p class="center-text" id="rejectedSummarizationStatus"><?= htmlspecialchars($leave['status'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Created At:</strong></h1>
                        <p class="center-text" id="rejectedSummarizationCreatedAt"><?= htmlspecialchars($leave['created_at'] ?? 'N/A') ?></p>
                    </div>

                    <div class="input-container">
                        <h1><strong>Updated At:</strong></h1>
                        <p class="center-text" id="rejectedSummarizationUpdatedAt"><?= htmlspecialchars($leave['updated_at'] ?? 'N/A') ?></p>
                    </div>


                    <div class="input-container">
                        <h1><strong>Rejected By:</strong></h1>
                        <p class="center-text" id="rejectedSummarizationRejectedBy"><?= htmlspecialchars($leave['rejected_by_name'] ?? 'N/A') ?></p>
                    </div>

                    <div class="btnContainer">
                        <button type="button" class="btnDanger" onclick="closeModal()">BACK</button>
                    </div>
                </form>
            </div>
        </div>




        <!-- Leave Request Modal -->
        <div id="requestLeaveModal" class="modal">
            <div class="modal-content">
                <!-- Leave Request Form with Balance Checker -->
                <div id="leaveForm" class="request-form" style="display:none;">
                    <h2>LEAVE REQUEST FORM</h2>
                    <form id="leaveFormContent" action="../../0/includes/submitLeaverequest.php" method="POST" enctype="multipart/form-data">
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
                                        mil AS management_initiated_leave,
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
                                        echo '<option value="Management Intiated Leave">Management Intiated Leave</option>';
                                        echo '<option value="Maternity Leave">Maternity Leave</option>';
                                        echo '<option value="Paternity Leave">Paternity Leave</option>';
                                        echo '<option value="Solo Parent Leave">Solo Parent Leave</option>';
                                        echo '<option value="Bereavement Leave">Bereavement Leave</option>';
                                        echo '<option value="Leave Without Pay">Leave Without Pay</option>';
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
                            <input type="file" name="leaveAttachment" id="leaveAttachmentID" required>
                            <label for="leaveDuration">Leave Attachment Approval</label>
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

    <!-- Filter -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filterButton = document.querySelector("#filterButton");
            const rows = document.querySelectorAll("#leaveTable tbody tr");
            let selectedColumn = null;

            function filterTable(filterValue) {
                rows.forEach((row) => {
                    const cellText =
                        row.cells[selectedColumn]?.textContent.toLowerCase() || "";
                    row.style.display = cellText.includes(filterValue.toLowerCase()) ?
                        "" :
                        "none";
                });
            }

            // Filter dropdown functionality
            if (filterButton) {
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
                                column: 7,
                                label: "Status"
                            }, // Status column
                            {
                                column: 2,
                                label: "Department"
                            }, // Department column
                            {
                                column: 9,
                                label: "Approved By"
                            }, // Approved By column
                        ];

                        filters.forEach((filter) => {
                            const option = document.createElement("div");
                            option.textContent = filter.label;
                            option.style.cursor = "pointer";
                            option.style.padding = "5px 10px";
                            option.addEventListener("click", function() {
                                selectedColumn = filter.column;

                                // Show a prompt to input the filter value
                                const filterValue = prompt(
                                    `Enter the value to filter by for ${filter.label}:`
                                );
                                if (filterValue) {
                                    filterTable(filterValue); // Apply the filter
                                }

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
                            if (
                                !dropdown.contains(event.target) &&
                                event.target !== filterButton
                            ) {
                                dropdown.remove();
                                document.removeEventListener("click", closeDropdown);
                            }
                        });
                    }
                });
            }
        });
    </script>

    <!-- plate 4 -->
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

                    const formData = new FormData(leaveFormContent); // Keep it as FormData!

                    fetch('../../../hrts/0/includes/submitLeaverequest.php', {
                            method: 'POST',
                            body: formData,
                        })
                        .then((response) => response.json())
                        .then((response) => {
                            if (response.status === 'success') {
                                alert(response.message);
                                closeModal();
                                location.reload();
                            } else {
                                alert('Error: ' + response.message);
                            }
                        })
                        .catch((error) => {
                            alert('AJAX Error: ' + error);
                        });
                });
            }

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
        const birthdayLeaveTotal = <?= $leaveBalances['management_initiated_leaave'] ?? 0 ?>;
        const birthdayLeaveUsed = <?= $usedBalances['management_initiated_leaave'] ?? 0 ?>;
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
            "Management Intiated Leave": "mil",
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

            if (leaveTypeRaw == 'Leave Without Pay') {
                warning.style.display = "none";
                leaveBalanceDisplay.style.display = "block";
                leaveBalanceDisplay.textContent = "Leave duradtion: " + (calculateDaysBetween(start, end) > 0 ? calculateDaysBetween(start, end) : 0) + " days" // Hide the balance display
                submitBtn.disabled = false;
            } else {
                const balance = remainingBalances[leaveType] ?? 0;
                document.getElementById("leaveBalance").textContent = balance;

                if (start && end && leaveType !== null) {
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
            const approvedSummarizationModal = document.getElementById("approvedSummarizationModal");
            const rejectedSummarizationModal = document.getElementById("rejectedSummarizationModal");

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

            // Modal fields for Approved Summarize
            const approvedSummarizationModalFields = {
                leaveIdField: document.getElementById("approvedSummarizationLeaveID"),
                employeeNameField: document.getElementById("approvedSummarizationEmployeeName"),
                departmentField: document.getElementById("approvedSummarizationDepartment"),
                leaveTypeField: document.getElementById("approvedSummarizationLeaveType"),
                startDateField: document.getElementById("approvedSummarizationStartDate"),
                endDateField: document.getElementById("approvedSummarizationEndDate"),
                reasonField: document.getElementById("approvedSummarizationReason"),
                statusField: document.getElementById("approvedSummarizationStatus"),
                createdAtField: document.getElementById("approvedSummarizationCreatedAt"),
                updatedAtField: document.getElementById("approvedSummarizationUpdatedAt"),
                approvedByField: document.getElementById("approvedSummarizationApprovedBy"),
            };

            // Fields in the Ticket Summarization Modal
            const rejectedSummarizationModalFields = {
                leaveIdField: document.getElementById("rejectedSummarizationLeaveID"),
                employeeNameField: document.getElementById("rejectedSummarizationEmployeeName"),
                departmentField: document.getElementById("rejectedSummarizationDepartment"),
                leaveTypeField: document.getElementById("rejectedSummarizationLeaveType"),
                startDateField: document.getElementById("rejectedSummarizationStartDate"),
                endDateField: document.getElementById("rejectedSummarizationEndDate"),
                reasonField: document.getElementById("rejectedSummarizationReason"),
                statusField: document.getElementById("rejectedSummarizationStatus"),
                rejectedByField: document.getElementById("rejectedSummarizationRejectedBy"),
                rejectionReasonField: document.getElementById("rejectedSummarizationRejectionReason"),
                createdAtField: document.getElementById("rejectedSummarizationCreatedAt"),
                updatedAtField: document.getElementById("rejectedSummarizationUpdatedAt"),
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
                    } else if (status === "Approved") {
                        // Set the values in the Approved Summarization Modal
                        approvedSummarizationModalFields.leaveIdField.textContent = leaveId || "N/A";
                        approvedSummarizationModalFields.employeeNameField.textContent = employeeId || "N/A";
                        approvedSummarizationModalFields.departmentField.textContent = department || "N/A";
                        approvedSummarizationModalFields.leaveTypeField.textContent = leaveType || "N/A";
                        approvedSummarizationModalFields.startDateField.textContent = startDate || "N/A";
                        approvedSummarizationModalFields.endDateField.textContent = endDate || "N/A";
                        approvedSummarizationModalFields.reasonField.textContent = reason || "N/A";
                        approvedSummarizationModalFields.statusField.textContent = status || "N/A";
                        approvedSummarizationModalFields.createdAtField.textContent = createdAt || "N/A";
                        approvedSummarizationModalFields.updatedAtField.textContent = updatedAt || "N/A";
                        approvedSummarizationModalFields.approvedByField.textContent = approvedBy || "N/A";

                        approvedSummarizationModal.style.display = "flex";

                    } else if (status === "Rejected") {
                        // Populate the modal fields
                        rejectedSummarizationModalFields.leaveIdField.textContent = leaveId || "N/A";
                        rejectedSummarizationModalFields.employeeNameField.textContent = employeeId || "N/A";
                        rejectedSummarizationModalFields.departmentField.textContent = department || "N/A";
                        rejectedSummarizationModalFields.leaveTypeField.textContent = leaveType || "N/A";
                        rejectedSummarizationModalFields.startDateField.textContent = startDate || "N/A";
                        rejectedSummarizationModalFields.endDateField.textContent = endDate || "N/A";
                        rejectedSummarizationModalFields.reasonField.textContent = reason || "N/A";
                        rejectedSummarizationModalFields.statusField.textContent = status || "N/A";
                        rejectedSummarizationModalFields.createdAtField.textContent = createdAt || "N/A";
                        rejectedSummarizationModalFields.updatedAtField.textContent = updatedAt || "N/A";
                        rejectedSummarizationModalFields.rejectedByField.textContent = approvedBy || "N/A";

                        rejectedSummarizationModal.style.display = "flex";
                    }
                });
            });

            // Close the modal when clicking outside of it
            window.addEventListener("click", function(event) {
                if (event.target === approveModal) {
                    approveModal.style.display = "none";
                }
                if (event.target === approvedSummarizationModal) {
                    approvedSummarizationModal.style.display = "none";
                }
                if (event.target === rejectedSummarizationModal) {
                    rejectedSummarizationModal.style.display = "none";
                }
            });

            // Close the modal when clicking the "BACK" button
            const closeModalButtons = document.querySelectorAll(".btnDanger");
            closeModalButtons.forEach((button) => {
                button.addEventListener("click", function() {
                    approveModal.style.display = "none";
                    approvedSummarizationModal.style.display = "none";
                    rejectedSummarizationModal.style.display = "none";
                });
            });
        });





        // Pagination and filtering for leave requests
        document.addEventListener("DOMContentLoaded", function() {
            const allRows = Array.from(document.querySelectorAll("#leaveTable tbody tr"));
            const tbody = document.querySelector("#leaveTable tbody");
            const paginationContainer = document.getElementById("paginationControls");
            const rowsPerPage = 5;
            let currentPage = 1;
            let currentFilter = "";

            function getRowStatus(row) {
                return row.children[7].textContent.trim();
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
                filteredRows.slice(start, end).forEach((row) => tbody.appendChild(row));
                renderPaginationButtons(totalPages);
            }

            // Add event listener to the search input
            searchInput.addEventListener("input", filterTableBySearch);

            renderTable();
        });
    </script>



</body>

</html>