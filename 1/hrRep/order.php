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

<body>
    <div class="container">
        <div class="sideNav">
            <div class="sideNavLogo img-cover"></div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/ticket.png);"></div>
                <a href="order.php">Oders</a>
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
                <table id="ticketTable" class="table">
                    <thead>
                        <tr>
                            <th>ID <i class="fas fa-sort"></i></th>
                            <th>Employee Name <i class="fas fa-sort"></i></th>
                            <th>Department <i class="fas fa-sort"></i></th>
                            <th>Subject <i class="fas fa-sort"></i></th>
                            <th>Description <i class="fas fa-sort"></i></th>
                            <th>Status <i class="fas fa-sort"></i></th>
                            <th>Priority <i class="fas fa-sort"></i></th>
                            <th>Category ID <i class="fas fa-sort"></i></th>
                            <th>Assigned To <i class="fas fa-sort"></i></th>
                            <th>Created At <i class="fas fa-sort"></i></th>
                            <th>Start At <i class="fas fa-sort"></i></th>
                            <th>Updated At <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tickets)): ?>
                            <?php foreach ($tickets as $ticket): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ticket['id']) ?></td>
                                    <td><?= htmlspecialchars($ticket['employee_name']) ?></td>
                                    <td><?= htmlspecialchars($ticket['employee_department']) ?></td>
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
    <div id="addTicketModal" class="modal">
        <div class="modal-content">
            <h1 class="modal-title">TICKET FORM</h1>

            <form id="ticketForm">

                <input type="hidden" name="employeeId" id="employeeID" value="<?= $_SESSION['user_id'] ?>">
                <div class="input-container">
                    <input type="text" name="employeeID" value="<?= $_SESSION['user_id'] ?>" id="employeeID" readonly>
                    <label for="employeeID">Employee ID</label>
                </div>

                <div class="input-container">
                    <input type="text" name="employeeName" value="<?= $_SESSION['name'] ?>" id="employeeName" readonly>
                    <label for="employeeName">Employee Name</label>
                </div>

                <div class="input-container">
                    <input type="text" id="subject" name="subject" required>
                    <label for="subject">Subject</label>
                </div>

                <div class="input-container">
                <input type="text" name="department" value="<?= $_SESSION['department'] ?>" id="departmentInputField" readonly>
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


<script>
    document.addEventListener("DOMContentLoaded", function () {
    const tableRows = document.querySelectorAll("tbody tr");
    const confirmModal = document.getElementById("confirmModal");
    const editStatusModal = document.getElementById("editStatusModal");

    // Modal fields for confirmModal
    const confirmModalFields = {
        ticketIdField: document.getElementById("confirmTicketID"),
        employeeNameField: document.getElementById("confirmemployeeID"),
        departmentField: document.getElementById("confirmdepartmentID"),
        subjectField: document.getElementById("confirmsubjectID"),
        categoryField: document.getElementById("confirmcategoryID"),
        descriptionField: document.getElementById("confirmdescriptionID"),
        priorityField: document.getElementById("confirmpriorityID"),
        assignedToField: document.getElementById("confirmassignedID"),
        statusField: document.getElementById("confirmStatusID"),
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
    tableRows.forEach((row) => {
        row.addEventListener("click", function () {
            // Remove highlight from all rows
            tableRows.forEach((r) => (r.style.backgroundColor = ""));

            // Highlight the clicked row
            this.style.backgroundColor = "var(--primary-500)";

            // Get the values from the clicked row
            const ticketId = this.children[0].textContent.trim();
            const employeeName = this.children[1].textContent.trim();
            const department = this.children[2].textContent.trim();
            const subject = this.children[3].textContent.trim();
            const description = this.children[4].textContent.trim();
            const status = this.children[5].textContent.trim(); // Status column
            const priority = this.children[6].textContent.trim();
            const category = this.children[7].textContent.trim();
            const assignedTo = this.children[8].textContent.trim();

            // Open the appropriate modal based on the status
            if (status === "Open") {
                // Set the values in the confirmModal
                confirmModalFields.ticketIdField.textContent = ticketId;
                confirmModalFields.employeeNameField.textContent = employeeName;
                confirmModalFields.departmentField.textContent = department;
                confirmModalFields.subjectField.textContent = subject;
                confirmModalFields.categoryField.textContent = category;
                confirmModalFields.descriptionField.textContent = description;
                confirmModalFields.priorityField.textContent = priority;
                confirmModalFields.assignedToField.textContent = assignedTo;
                confirmModalFields.statusField.textContent = status;

                // Open the confirmModal
                confirmModal.style.display = "flex";
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
    window.addEventListener("click", function (event) {
        if (event.target === confirmModal) {
            confirmModal.style.display = "none";
        }
        if (event.target === editStatusModal) {
            editStatusModal.style.display = "none";
        }
    });

    // Close the modals when clicking the "BACK" button
    const closeConfirmModalButton = confirmModal.querySelector(".btnDanger");
    const closeEditModalButton = editStatusModal.querySelector(".btnDanger");

    closeConfirmModalButton.addEventListener("click", function () {
        confirmModal.style.display = "none";
    });

    closeEditModalButton.addEventListener("click", function () {
        editStatusModal.style.display = "none";
    });

    // Handle the editStatusForm submission
    const editStatusForm = document.getElementById("editStatusForm");

    editStatusForm.addEventListener("submit", async function (event) {
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




    </div>
    <script src="../../assets/js/framework.js"></script>
    <script src="../../assets/js/hrRepOrder.js"></script>
</body>

</html>