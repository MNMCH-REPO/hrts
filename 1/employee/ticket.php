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
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
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
            background-color: var(--neutral-100);
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
            position: relative;
            margin: 15px 0;
            width: 100%;
        }

        .input-container input,
        .input-container select,
        .input-container textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            font-size: 16px;
            background: transparent;
        }

        .input-container label {
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
        .input-container input:focus+label,
        .input-container input:not(:placeholder-shown)+label,
        .input-container select:focus+label,
        .input-container select:not(:placeholder-shown)+label,
        .input-container textarea:focus+label,
        .input-container textarea:not(:placeholder-shown)+label {
            top: 5px;
            font-size: 12px;
            color: #007BFF;
        }

        /* Buttons */
        .modal-buttons {
            display: flex;
            justify-content: space-between;
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
                <div class="navBtnIcon img-contain"
                    style="background-image: url(../../assets/images/icons/ticket.png);"></div>
                <a href="ticket.php">Tickets</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/chat.png);">
                </div>
                <a href="messages.php">Messages</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain"
                    style="background-image: url(../../assets/images/icons/settings.png);"></div>
                <a href="account.php">Account</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain"
                    style="background-image: url(../../assets/images/icons/switch.png);"></div>
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


            <div class="main-ticket">
                <div class="container-ticket">
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
                        <div class="col plate" id="plate4" onclick="openModal()">
                            <span class="plate-label">ADD</span>
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

    </div>
    <footer class="footer-messages">
        <p>All rights reserved to Metro North Medical Center and Hospital, Inc.</p>
    </footer>

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
                    <button type="submit" name="submitTicket" class="btnDefault">SUBMIT TICKET</button>
                    <button type="button" class="btnDanger" onclick="closeModal()">CANCEL</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../../assets/js/framework.js"></script>

    <!-- modal -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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
            document.getElementById("ticketForm").addEventListener("submit", function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                fetch("../../0/includes/submitTicket.php", {
                    method: "POST",
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Ticket submitted successfully!");
                            document.getElementById("ticketForm").reset();
                            closeModal();
                            location.reload();
                        } else {
                            alert("Error: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("❌ Fetch Error:", error);
                    });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
        // Attach click event listeners to plates
        const plates = document.querySelectorAll(".plate");
        plates.forEach(plate => {
            plate.addEventListener("click", function () {
                const statusMap = {
                    plate1: "Open",
                    plate2: "In Progress",
                    plate3: "Resolved"
                };

                const status = statusMap[this.id];
                if (!status) return; // Exit if the plate is not related to a status

                // Fetch filtered tickets using AJAX
                fetch(`../../0/includes/platesFilter.php?status=${encodeURIComponent(status)}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.text(); // Read response as text
                    })
                    .then(text => {
                        try {
                            const data = JSON.parse(text); // Attempt to parse JSON
                            if (data.success) {
                                updateTable(data.tickets);
                            } else {
                                console.error("Error:", data.message);
                                alert("Failed to fetch tickets. Please try again.");
                            }
                        } catch (error) {
                            console.error("JSON Parse Error:", error);
                            alert("An error occurred while processing the server response.");
                        }
                    })
                    .catch(error => {
                        console.error("Fetch Error:", error);
                        alert("An error occurred while fetching tickets.");
                    });
            });
        });

        // Function to update the table with filtered tickets
        function updateTable(tickets) {
            const tableBody = document.querySelector(".tableContainer tbody");
            tableBody.innerHTML = ""; // Clear existing table rows

            if (!tickets || tickets.length === 0) {
                tableBody.innerHTML = "<tr><td colspan='10'>No tickets found</td></tr>";
                return;
            }

            tickets.forEach(ticket => {
                const row = `
                    <tr>
                        <td>${escapeHTML(ticket.id)}</td>
                        <td>${escapeHTML(ticket.employee_name)}</td>
                        <td>${escapeHTML(ticket.subject)}</td>
                        <td>${escapeHTML(ticket.description)}</td>
                        <td>${escapeHTML(ticket.status)}</td>
                        <td>${escapeHTML(ticket.priority)}</td>
                        <td>${escapeHTML(ticket.category_name)}</td>
                        <td>${escapeHTML(ticket.assigned_to_name)}</td>
                        <td>${escapeHTML(ticket.created_at)}</td>
                        <td>${escapeHTML(ticket.updated_at)}</td>
                    </tr>`;
                tableBody.insertAdjacentHTML("beforeend", row);
            });
        }

        // Utility function to escape HTML to prevent XSS
        function escapeHTML(str) {
            const div = document.createElement("div");
            div.textContent = str;
            return div.innerHTML;
        }
    });

    </script>



</body>

</html>