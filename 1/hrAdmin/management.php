<?php
require_once '../../0/includes/employeeTicket.php';
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
    <link rel="stylesheet" href="../../assets/css/management.css">
    <title>HRTS</title>

</head>

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
                    <button type="button" class="btnDanger btnDangerDisabled" id="disableAccountID" name="disbaleAccount" style="display: none;" disabled>Disable Account </button>
                    <button type="button" class="btnApprove btnApproveDisabled" id="enableAccountID" name="enableAccount" style="display: none;" disable>Enable Account </button>
                    <button type="button" class="btnDefault" id="addAccountID" name="addAccount">Add Account +</button>
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

            <style>
                /* Highlight rows with Inactive status */
                .inactive-row {
                    background-color: var(--danger-highlight) !important;
                    color: white;
                    /* Optional: Change text color for better contrast */
                }
            </style>



            <!-- Add this button to trigger the modal -->
            <div class="btnContainer">
                <button type="button" class="btnContainer btnDefault" id="resetLeaveButtonID">Reset Leave Request Values</button>
            </div>


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



            </style>



            <!-- Add this modal structure to your management.php file -->
            <div id="resetLeaveModal" class="modal">
                <div class="modal-content">
                    <h2>Confirm Reset Leave Values</h2>
                    <p>Are you sure you want to reset all leave request values? This action cannot be undone.</p>
                    <form action="../../0/includes/resetLeaveValue.php" method="post">
                        <button type="submit" class="btnDanger btnContainer" name="resetValueButton">Confirm Reset</button>
                        <button type="button" class="btnDefault btnContainer" id="cancelReset">Cancel</button>
                    </form>
                </div>
            </div>



            <script>
                // Get modal elements
                const resetLeaveModal = document.getElementById('resetLeaveModal');
                const openResetModalButton = document.getElementById('resetLeaveButtonID');
                const cancelResetButton = document.getElementById('cancelReset');

                // Open the modal when the button is clicked
                openResetModalButton.addEventListener('click', () => {
                    resetLeaveModal.style.display = 'flex';
                });

                // Close the modal when the close button is clicked
                closeModalButton.addEventListener('click', () => {
                    resetLeaveModal.style.display = 'none';
                });

                // Close the modal when the cancel button is clicked
                cancelResetButton.addEventListener('click', () => {
                    resetLeaveModal.style.display = 'none';
                });

                // Close the modal when clicking outside the modal content
                window.addEventListener('click', (event) => {
                    if (event.target === resetLeaveModal) {
                        resetLeaveModal.style.display = 'none';
                    }
                });
            </script>
            <br><br><br><br>

            <div class="tableContainer">
                <table>
                    <thead>
                        <tr>
                            <th>ID <i class="fas fa-sort"></i></th>
                            <th>Name <i class="fas fa-sort"></i></th>
                            <th>Email <i class="fas fa-sort"></i></th>
                            <th>Role <i class="fas fa-sort"></i></th>
                            <th>Department <i class="fas fa-sort"></i></th>
                            <th>Status <i class="fas fa-sort"></i></th>
                            <th>Created At <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr data-id="<?= htmlspecialchars($user['id']) ?>"
                                    class="<?= htmlspecialchars($user['status']) === 'Inactive' ? 'inactive-row' : '' ?>">
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                    <td><?= htmlspecialchars($user['department']) ?></td>
                                    <td><?= htmlspecialchars($user['status']) ?> <!-- Debug: Output status here --></td>
                                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" style="text-align: center;">No Users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>


            <div class="tableContainer">
                <table id="">
                    <thead>
                        <tr>
                            <th>ID <i class="fas fa-sort"></i></th>
                            <th>Name <i class="fas fa-sort"></i></th>
                            <th>Email <i class="fas fa-sort"></i></th>
                            <th>Role <i class="fas fa-sort"></i></th>
                            <th>Department <i class="fas fa-sort"></i></th>
                            <th>Status <i class="fas fa-sort"></i></th>
                            <th>Created At <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr data-id="<?= htmlspecialchars($user['id']) ?>"
                                    class="<?= htmlspecialchars($user['status']) === 'Inactive' ? 'inactive-row' : '' ?>">
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                    <td><?= htmlspecialchars($user['department']) ?></td>
                                    <td><?= htmlspecialchars($user['status']) ?> <!-- Debug: Output status here --></td>
                                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" style="text-align: center;">No Users found</td>
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



    <?php

    require_once 'modals.php';

    ?>

    <script src="../../assets/js/framework.js"></script>
    <script src="../../assets/js/management.js"></script>
</body>

</html>