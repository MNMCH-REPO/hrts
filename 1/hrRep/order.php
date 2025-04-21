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

</style>

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
            </div>


            <div class="pagination-wrapper">
                <div class="pagination" id="pageNationID">
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
                    <p class="center-text" id="summarizationDepartment"><?= htmlspecialchars($ticket['assigned_department'] ?? 'N/A') ?></p>
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
                    <p class="center-text" id="summarizationDuration">
                        <?php
                        if (!empty($ticket['start_at']) && !empty($ticket['updated_at'])) {
                            $startAt = new DateTime($ticket['start_at']);
                            $updatedAt = new DateTime($ticket['updated_at']);
                            $duration = $startAt->diff($updatedAt);

                            // Format the duration (e.g., "2 days, 3 hours, 15 minutes")
                            echo $duration->format('%d days, %h hours, %i minutes');
                        } else {
                            echo 'N/A'; // Fallback if timestamps are missing
                        }
                        ?>
                    </p>
                </div>

                <div class="btnContainer">
                    <button type="button" class="btnDanger" onclick="closeModal()">BACK</button>
                </div>
            </form>
        </div>
    </div>




    <script src="../../assets/js/framework.js"></script>
    <script src="../../assets/js/hrRepOrder.js"></script>

    <script>
        // Function to handle the timer
        document.addEventListener("DOMContentLoaded", function() {
            // Function to calculate elapsed time
            function calculateElapsedTime(startTime, endTime = null) {
                const startDate = new Date(startTime); // Convert start_at to a Date object
                const endDate = endTime ? new Date(endTime) : new Date(); // Use updated_at if provided, otherwise use current time
                const elapsed = Math.floor((endDate - startDate) / 1000); // Elapsed time in seconds

                const hours = Math.floor(elapsed / 3600);
                const minutes = Math.floor((elapsed % 3600) / 60);
                const seconds = elapsed % 60;

                return `${hours
      .toString()
      .padStart(2, "0")}:${minutes.toString().padStart(2, "0")}:${seconds
      .toString()
      .padStart(2, "0")}`;
            }

            // Update all timer cells
            function updateTimers() {
                const timerCells = document.querySelectorAll(".timer-cell");
                timerCells.forEach((cell) => {
                    const startAt = cell.getAttribute("data-start-at");
                    const row = cell.closest("tr");
                    const updatedAt = row.querySelector("td:nth-child(12)")?.textContent.trim(); // Updated At column
                    const status = row.getAttribute("data-status");

                    // Stop the timer if updated_at has a value or status is "Resolved"
                    if ((updatedAt && updatedAt !== "") || status === "Resolved") {
                        // Calculate the elapsed time between startAt and updatedAt
                        cell.textContent = calculateElapsedTime(startAt, updatedAt);
                        cell.classList.add("stopped"); // Add a class to indicate the timer has stopped
                        return;
                    }

                    if (startAt) {
                        cell.textContent = calculateElapsedTime(startAt);
                    }
                });
            }

            // Update timers every second
            setInterval(updateTimers, 1000);

            // Initial update
            updateTimers();
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
                    const response = await fetch("../../0/includes/hrEdtiTicketStatus.php", {
                        method: "POST",
                        body: formData,
                    });

                    // Parse the JSON response
                    const data = await response.json();

                    if (data.success) {
                        alert(data.message); // Show success message

                        // Update the UI dynamically
                        const row = document.querySelector(`tr[data-id="${ticketId}"]`);
                        if (row) {
                            const statusCell = row.querySelector("td:nth-child(6)"); // Assuming the status column is the 6th column
                            if (statusCell) {
                                statusCell.textContent = status; // Update the status in the table
                            }

                            const updatedAtCell = row.querySelector("td:nth-child(12)"); // Assuming the updated_at column is the 12th column
                            if (updatedAtCell) {
                                const currentDate = new Date().toISOString().slice(0, 19).replace("T", " "); // Format current date
                                updatedAtCell.textContent = currentDate; // Update the updated_at column
                            }
                        }

                        // Close the modal
                        closeModal();
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

</html>