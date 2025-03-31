<?php
require_once '../../0/includes/employeeTicket.php';
require_once '../../0/includes/adminTableQuery.php'; // Include the query file
require_once '../../0/includes/accountQuery.php'; // Include the query file
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

        /* Disabled button styles */
        .btnWarningDisabled,
        .btnDefaultDisabled,
        .btnDangerDisabled {
            cursor: not-allowed;
            opacity: 0.6;
        }


        /* Highlight the selected row */
        .selected-row {
            background-color: var(--primary-500) !important;

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

        .pagination-wrapper>.btnContainer {
            display: flex;
            justify-content: flex-end;
            width: 100%;
            height: 100%;
            margin: 0 12px 0 0 !important;
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

                <div class="btnContainer">
                    <button type="button" class="btnWarning btnWarningDisabled" id="editAccountID" name="editAccount" disabled>Edit Account</button>
                    <button type="button" class="btnDanger btnDangerDisabled" id="removeAccountID" name="removeAccount" disabled>Remove Account </button>
                    <button type="button" class="btnDefault btnDisabled" id="disableAccountID" name="disbaleAccount" disabled>Disable Account </button>
                    <button type="button" class="btnDefault" id="addAccountID" name="addAccount">Add Account +</button>
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
                            <th>Name <i class="fas fa-sort"></i></th>
                            <th>Email <i class="fas fa-sort"></i></th>
                            <th>Role <i class="fas fa-sort"></i></th>
                            <th>Department <i class="fas fa-sort"></i></th>
                            <th>Created At <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr data-id="<?= htmlspecialchars($user['id']) ?>">
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                    <td><?= htmlspecialchars($user['department']) ?></td>
                                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10">No Users found</td>
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
    <div id="addAccountModal" class="modal">
        <div class="modal-content">
            <h1 class="modal-title">ADD ACCOUNT</h1>

            <form id="addAccountForm">
                <div class="input-container">
                    <input type="text" id="employeeID" name="employeeID" required>
                    <label for="employeeID">Employee ID</label>
                </div>
                <div class="input-container">
                    <input type="text" id="employeeName" name="employeeName" required>
                    <label for="employeeName">Employee Name</label>
                </div>

                <div class="input-container">
                    <input type="text" id="email" name="email" required>
                    <label for="email">Email</label>
                </div>

                <div class="input-container">

                    <select id="role" name="role" required>
                        <option value="" disabled selected>Please select a Role</option>
                        <option value="Admin">Admin</option>
                        <option value="HR Rep">HR Rep</option>
                        <option value="Employee">Employee</option>
                    </select>
                </div>

                <div class="input-container">

                    <select id="department" name="department" required>
                        <option value="" disabled selected>Please select the Department</option>
                        <option value="HR Department">HR Department</option>
                        <option value="CnC Department">CnC Department</option>
                        <option value="Accounting Department">Accounting Department</option>
                    </select>
                </div>

                <div class="btnContainer">
                    <button type="submit" name="submitAccount" class="btnDefault">SUBMIT</button>
                    <button type="button" class="btnDanger" onclick="closeModal()">BACK</button>
                </div>
            </form>
        </div>
    </div>


    <div id="editAccountModal" class="modal">
        <div class="modal-content">
            <h1 class="modal-title">EDIT ACCOUNT</h1>
            <input type="text" name="id" id="id" value="<?php echo htmlspecialchars($userId); ?>">
            <form id="editAccountForm">
                <div class="input-container">
                    <input type="text" id="employeeEditID" name="employeeID" required>
                    <label for="employeeID">Employee ID</label>
                </div>
                <div class="input-container">
                    <input type="text" id="employeeEditName" name="employeeName" required>
                    <label for="employeeName">Employee Name</label>
                </div>

                <div class="input-container">
                    <input type="text" id="emailEditID" name="email" required>
                    <label for="email">Email</label>
                </div>

                <div class="input-container">
                    <select id="roleEditID" name="role" required>
                        <option value="" disabled selected>Please select a Role</option>
                        <option value="Admin">Admin</option>
                        <option value="HR Rep">HR Rep</option>
                        <option value="Employee">Employee</option>
                    </select>
                </div>

                <div class="input-container">
                    <select id="departmentEditID" name="department" required>
                        <option value="" disabled selected>Please select the Department</option>
                        <option value="HR Department">HR Department</option>
                        <option value="CnC Department">CnC Department</option>
                        <option value="Accounting Department">Accounting Department</option>
                    </select>
                </div>

                <div class="btnContainer">
                    <button type="submit" class="btnDefault" name="updateAccount" id="updateAccountID">UPDATE</button>
                    <button type="button" class="btnDanger" id="closeEditModal">BACK</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../../assets/js/framework.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Open modal function
            function openModal() {
                document.getElementById("addAccountModal").style.display = "flex";
            }

            // Make the function globally accessible
            window.openModal = openModal;

            // Attach event listener to "ADD ACCOUNT" button
            document.getElementById("addAccountID").addEventListener("click", openModal);

            // Close modal function
            function closeModal() {
                document.getElementById("addAccountModal").style.display = "none";
            }

            window.closeModal = closeModal;

            // Submit form via AJAX
            document.getElementById("addAccountForm").addEventListener("submit", function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                fetch("../../0/includes/createAccount.php", { // Update the URL to match the correct PHP script
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("✅ Response Data:", data); // Log the response data
                        if (data.success) {
                            alert("Account added successfully!");
                            location.reload();
                        } else {
                            alert("Error: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("❌ Fetch Error:", error); // Log any fetch errors
                    });
            });
        });




        // Highlight selected row and enable buttons
        document.addEventListener("DOMContentLoaded", function() {
            const tableRows = document.querySelectorAll(".tableContainer tbody tr");
            const editButton = document.getElementById("editAccountID");
            const removeButton = document.getElementById("removeAccountID");
            const disableButton = document.getElementById("disableAccountID");

            let selectedRow = null; // Store the currently selected row

            // Function to enable buttons
            function enableButtons() {
                editButton.classList.remove("btnWarningDisabled");
                editButton.removeAttribute("disabled");

                removeButton.classList.remove("btnDangerDisabled");
                removeButton.removeAttribute("disabled");

                disableButton.classList.remove("btnDisabled");
                disableButton.removeAttribute("disabled");
            }

            // Function to disable buttons
            function disableButtons() {
                editButton.classList.add("btnWarningDisabled");
                editButton.setAttribute("disabled", "true");

                removeButton.classList.add("btnDangerDisabled");
                removeButton.setAttribute("disabled", "true");

                disableButton.classList.add("btnDisabled");
                disableButton.setAttribute("disabled", "true");
            }

            // Add click event listener to each row
            tableRows.forEach(row => {
                row.addEventListener("click", function() {
                    // Remove previous selection
                    tableRows.forEach(r => r.classList.remove("selected-row"));

                    // Toggle selection
                    if (selectedRow === row) {
                        selectedRow = null;
                        disableButtons(); // Disable buttons when deselected
                    } else {
                        selectedRow = row;
                        enableButtons(); // Enable buttons when selected
                        row.classList.add("selected-row");
                    }
                });
            });

            // Click outside the table to reset selection
            document.addEventListener("click", function(event) {
                if (!event.target.closest(".tableContainer")) {
                    selectedRow = null;
                    disableButtons();
                    tableRows.forEach(row => row.classList.remove("selected-row"));
                }
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            const tableRows = document.querySelectorAll(".tableContainer tbody tr");
            const editButton = document.getElementById("editAccountID");
            const editModal = document.getElementById("editAccountModal");
            const closeModalButton = document.getElementById("closeEditModal");

            // Input fields in the modal
            const employeeEditIDInput = document.getElementById("employeeEditID");
            const employeeNameEditInput = document.getElementById("employeeEditName");
            const emailEditIDInput = document.getElementById("emailEditID");
            const roleEditIDSelect = document.getElementById("roleEditID");
            const departmentEditIDSelect = document.getElementById("departmentEditID");

            let selectedUserId = null;

            // Add click event listener to each row
            tableRows.forEach(row => {
                row.addEventListener("click", function() {
                    // Highlight the selected row
                    tableRows.forEach(r => r.classList.remove("selected-row"));
                    row.classList.add("selected-row");

                    // Store the selected user ID
                    selectedUserId = row.getAttribute("data-id");
                    console.log("Selected User ID:", selectedUserId); // Debugging log

                    // Enable the "Edit Account" button
                    editButton.classList.remove("btnWarningDisabled");
                    editButton.removeAttribute("disabled");
                });
            });



            // Click outside the table to reset selection
            document.addEventListener("click", function(event) {
                if (!event.target.closest(".tableContainer")) {
                    selectedUserId = null;
                    editButton.classList.add("btnWarningDisabled");
                    editButton.setAttribute("disabled", "true");
                    tableRows.forEach(row => row.classList.remove("selected-row"));
                }
            });

            editButton.addEventListener("click", function() {
                if (selectedUserId) {
                    fetchAndPopulateModal(selectedUserId); // Call the fetchAndPopulateModal function
                }
            });

            // Function to fetch and populate modal
            async function fetchAndPopulateModal(userID) {
                try {
                    const response = await fetch("../../0/includes/editAccountQuery.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body: `id=${encodeURIComponent(userID)}`,
                    });

                    const data = await response.json();

                    console.log("Fetched Data:", data); // Debugging log

                    if (data.success) {
                        // Populate input fields
                        console.log(data.data.id)
                        employeeEditIDInput.value = data.data.id || "";
                        employeeNameEditInput.value = data.data.name || "";
                        emailEditIDInput.value = data.data.email || "";
                        roleEditIDSelect.value = data.data.role || "";
                        departmentEditIDSelect.value = data.data.department || "";
                        console.log("Department:", data.data.department);

                        // Open the modal
                        editModal.style.display = "flex";
                    } else {
                        console.error("Error fetching employee data:", data.message);
                    }
                } catch (error) {
                    console.error("Fetch error:", error);
                }
            }

            // Close the modal
            closeModalButton.addEventListener("click", function() {
                editModal.style.display = "none";
            });

            // Close the modal when clicking outside of it
            window.addEventListener("click", function(event) {
                if (event.target === editModal) {
                    editModal.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>