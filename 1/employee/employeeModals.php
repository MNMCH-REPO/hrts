<!-- Modal -->
<div id="addTicketModal" class="modal">
    <div class="modal-content">
        <h1 class="modal-title">REQUEST FORM</h1>

        <!-- Form Selection for Leave or Ticket -->
        <div class="input-container">
            <label for="requestType">Choose Request Type</label>
            <select id="requestType" name="requestType" required onchange="toggleRequestForm()">
                <option value="" disabled selected>Select Request Type</option>
                <option value="ticket">Ticket Request</option>
                <option value="leave">Leave Request</option>
            </select>
        </div>

        <!-- Ticket Request Form -->
        <div id="ticketForm" class="request-form" style="display:none;">
            <h2>Ticket Form</h2>
            <form id="ticketFormContent">
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
                    <input type="text" id="departmentInputField" class="form-control" value="<?= $_SESSION['department'] ?>" name="department" placeholder="Enter Department">
                    <label for="department">Department</label>
                </div>

                <div class="input-container">
                    <select id="category" name="category" required>
                        <option value="" disabled selected>Select a category</option>
                        <?php
                        require "../../0/includes/db.php";
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

        <!-- Leave Request Form with Balance Checker -->
        <div id="leaveForm" class="request-form" style="display:none;">
            <h2>Leave Request Form</h2>
            <form id="leaveFormContent" method="POST">
                <input type="hidden" name="employeeId" value="<?= $_SESSION['user_id'] ?>">

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
                        <option value="Sick Leave">Sick Leave</option>
                        <option value="Service Incentive Leave">Service Incentive Leave</option>
                        <option value="Earned Leave Credit">Earned Leave Credit</option>
                        <option value="Vacation">Vacation</option>
                        <option value="Emergency Leave">Emergency Leave</option>
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
                    <button type="submit" id="submitLeaveBtn" class="btnDefault">SUBMIT REQUEST</button>
                    <button type="button" class="btnDanger" onclick="closeModal()">CANCEL</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleRequestForm() {
        const requestType = document.getElementById('requestType').value;
        const ticketForm = document.getElementById('ticketForm');
        const leaveForm = document.getElementById('leaveForm');

        if (requestType === 'ticket') {
            ticketForm.style.display = 'block';
            leaveForm.style.display = 'none';
        } else if (requestType === 'leave') {
            leaveForm.style.display = 'block';
            ticketForm.style.display = 'none';
        }
    }

    const leaveBalances = {
        'Sick Leave': 5,
        'Service Incentive Leave': 3,
        'Earned Leave Credit': 2,
        'Vacation': 7,
        'Emergency Leave': 1
    };

    function calculateDaysBetween(start, end) {
        const startDate = new Date(start);
        const endDate = new Date(end);
        const diffTime = endDate - startDate;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        return diffDays;
    }

    function updateLeaveBalance() {
        const leaveType = document.getElementById("leaveTypeSelect").value;
        const start = document.getElementById("startDate").value;
        const end = document.getElementById("endDate").value;
        const balance = leaveBalances[leaveType] || 0;

        document.getElementById("leaveBalance").textContent = balance;
        const submitBtn = document.getElementById("submitLeaveBtn");
        const warning = document.getElementById("leaveWarning");

        if (start && end && leaveType) {
            const requestedDays = calculateDaysBetween(start, end);
            if (requestedDays > balance) {
                warning.style.display = "block";
                submitBtn.disabled = true;
            } else {
                warning.style.display = "none";
                submitBtn.disabled = false;
            }
        }
    }

    document.getElementById("leaveTypeSelect").addEventListener("change", updateLeaveBalance);
    document.getElementById("startDate").addEventListener("change", updateLeaveBalance);
    document.getElementById("endDate").addEventListener("change", updateLeaveBalance);
</script>



    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <h1 class="modal-title">ACCEPT TICKET</h1>

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
                    <button type="button" class="btnDanger" id="confirmBack" onclick="closeModal()">BACK</button>
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
    <script>
    // Open modal function
function openModal(id) {
    document.getElementById(id).style.display = 'flex'; // Open the modal
    toggleFormType(); // Ensure the correct form is shown when modal opens
}

// Close modal function
function closeModal() {
    document.getElementById('addTicketModal').style.display = 'none'; // Close the modal
}

// Toggle between ticket and leave form
function toggleFormType() {
    const formType = document.getElementById('formType').value; // Get the selected form type

    // Toggle visibility based on the selected form
    if (formType === 'ticket') {
        document.getElementById('ticketForm').style.display = 'block'; // Show ticket form
        document.getElementById('leaveForm').style.display = 'none';  // Hide leave form
        document.getElementById('modalTitle').textContent = "TICKET FORM"; // Update title
    } else if (formType === 'leave') {
        document.getElementById('ticketForm').style.display = 'none'; // Hide ticket form
        document.getElementById('leaveForm').style.display = 'block';  // Show leave form
        document.getElementById('modalTitle').textContent = "LEAVE REQUEST FORM"; // Update title
    }
}

// Ensure the correct form is displayed when the page loads
window.onload = function() {
    toggleFormType(); // Toggle form type on page load
};
</script>
