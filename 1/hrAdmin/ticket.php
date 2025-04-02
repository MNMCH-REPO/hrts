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
            justify-content: space-between;
            margin: 0 0 32px 0;
        }

        .plate {
            width: 300px;
            height: 180px;
            background-color: var(--primary-300);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
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
                    <span class="plate-label">OPEN</span>
                    <?= $statusCounts['Open'] ?>
                </div>
                <div class="col plate" id="plate2">
                    <span class="plate-label">IN PROGRESS</span>
                    <?= $statusCounts['In Progress'] ?>
                </div>
                <div class="col plate" id="plate3">
                    <span class="plate-label">RESOLVED</span>
                    <?= $statusCounts['Resolved'] ?>
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
                    <h1><strong>Priority:</strong></h1>
                    <p class="center-text" value="<?= htmlspecialchars($ticket['priority']) ?>">Paycheck miscalculation</p>
                    </select>
                </div>

                <div class="input-container">
                    <h1><strong>Assigned To:</strong></h1>
                    <p class="center-text" value="<?= htmlspecialchars($ticket['assigned_to_name']) ?>">Paycheck miscalculation</p>
                    </select>
                </div>

                <br>

                <div class="input-container">
                    <select name="statusEdit" id="statusID" required>
                        <option value="" disabled selected>Select User</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= htmlspecialchars($ticket['status']) ?>"></option>
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



    <script src="../../assets/js/framework.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get all plates
            const plates = document.querySelectorAll(".plate");
            const tableRows = document.querySelectorAll("tbody tr");

            plates.forEach(plate => {
                plate.addEventListener("click", function() {
                    // Get the status from the clicked plate and normalize it to lowercase
                    const status = this.querySelector(".plate-label").textContent.trim().toLowerCase();

                    // Debugging: Log the clicked plate's status
                    console.log("Filtering by status:", status);

                    // Filter table rows based on the status
                    tableRows.forEach(row => {
                        // Get the row's status and normalize it to lowercase
                        const rowStatus = row.children[4].textContent.trim().toLowerCase(); // Adjust index if needed

                        // Debugging: Log the status of each row
                        console.log("Row status:", rowStatus);

                        // Compare the normalized statuses
                        if (rowStatus === status || status === "all") {
                            row.style.display = ""; // Show the row
                        } else {
                            row.style.display = "none"; // Hide the row
                        }
                    });
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Get all table rows
            const tableRows = document.querySelectorAll("tbody tr");
            const modal = document.getElementById("assignTicketModal");
            const prioritySelect = document.getElementById("priorityID");
            const assignToSelect = document.getElementById("assignToID");

            // Modal fields
            const ticketIdField = modal.querySelector(".input-container:nth-child(1) .center-text");
            const employeeNameField = modal.querySelector(".input-container:nth-child(2) .center-text");
            const departmentField = modal.querySelector(".input-container:nth-child(3) .center-text");
            const subjectField = modal.querySelector(".input-container:nth-child(4) .center-text");
            const categoryField = modal.querySelector(".input-container:nth-child(5) .center-text");
            const descriptionField = modal.querySelector(".input-container:nth-child(6) .center-text");

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
                    const department = this.children[4].textContent.trim();
                    const priority = this.children[5].textContent.trim();
                    const category = this.children[6].textContent.trim();

                    // Set the values in the modal
                    ticketIdField.textContent = ticketId;
                    employeeNameField.textContent = employeeName;
                    departmentField.textContent = department;
                    subjectField.textContent = subject;
                    categoryField.textContent = category;
                    descriptionField.textContent = description;

                    // Set the priority dropdown value (if applicable)
                    if (prioritySelect) {
                        prioritySelect.value = priority;
                    }

                    // Open the modal
                    modal.style.display = "flex";
                });
            });

            // Close the modal when clicking outside of it
            window.addEventListener("click", function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });

            // Close the modal when clicking the "BACK" button
            const closeModalButton = modal.querySelector(".btnDanger");
            closeModalButton.addEventListener("click", function() {
                modal.style.display = "none";
            });
        });

        // Handle form submission

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
    </script>
</body>

</html>c