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
                    <button type="submit" name="submitTicketBtn" id="submitTicketID" class="btnDefault">SUBMIT TICKET</button>
                    <button type="button" class="btnDanger" onclick="closeModal()">CANCEL</button>
                </div>
            </form>
        </div>
    </div>




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




<!-- <script>
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

        const selectedValue = formType.value; // Get the selected form type

        // Toggle visibility based on the selected form
        if (selectedValue === 'ticket') {
            document.getElementById('ticketForm').style.display = 'block'; // Show ticket form
            document.getElementById('leaveForm').style.display = 'none'; // Hide leave form
            document.getElementById('modalTitle').textContent = "TICKET FORM"; // Update title
        } else if (selectedValue === 'leave') {
            document.getElementById('ticketForm').style.display = 'none'; // Hide ticket form
            document.getElementById('leaveForm').style.display = 'block'; // Show leave form
            document.getElementById('modalTitle').textContent = "LEAVE REQUEST FORM"; // Update title
        }
    }

    // Ensure the correct form is displayed when the page loads
    window.onload = function() {
        toggleFormType(); // Toggle form type on page load
    };
</script> -->