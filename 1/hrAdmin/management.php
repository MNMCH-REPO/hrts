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
    <link rel="stylesheet" href="../../assets/css/management.css">
    <title>HRTS</title>

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
                    <button type="button" class="btnDefault btnDangerDisabled" id="disableAccountID" name="disbaleAccount" disabled>Disable Account </button>
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
                        <option value="LINEN DEPARTMENT">LINEN DEPARTMENT</option>
                        <option value="SECURITY DEPARTMENT">SECURITY DEPARTMENT</option>
                        <option value="MAINTENANCE DEPARTMENT">MAINTENANCE DEPARTMENT</option>
                        <option value="INFORMATION DEPARTMENT">INFORMATION DEPARTMENT</option>
                        <option value="ADMITTING DEPARTMENT">ADMITTING DEPARTMENT</option>
                        <option value="PHARMACY DEPARTMENT">PHARMACY DEPARTMENT</option>
                        <option value="EMERGENCY ROOM DEPARTMENT">EMERGENCY ROOM DEPARTMENT</option>
                        <option value="CASHIER DEPARTMENT">CASHIER DEPARTMENT</option>
                        <option value="PHILHEALTH GF DEPARTMENT">PHILHEALTH GF DEPARTMENT</option>
                        <option value="BILLING DEPARTMENT">BILLING DEPARTMENT</option>
                        <option value="RADIOLOGY DEPARTMENT">RADIOLOGY DEPARTMENT</option>
                        <option value="HEART STATION DEPARTMENT">HEART STATION DEPARTMENT</option>
                        <option value="HMO DEPARTMENT">HMO DEPARTMENT</option>
                        <option value="LABORATORY DEPARTMENT">LABORATORY DEPARTMENT</option>
                        <option value="REHAB DEPARTMENT">REHAB DEPARTMENT</option>
                        <option value="DIALYSIS DEPARTMENT">DIALYSIS DEPARTMENT</option>
                        <option value="CSR DEPARTMENT">CSR DEPARTMENT</option>
                        <option value="OR/DR DEPARTMENT">OR/DR DEPARTMENT</option>
                        <option value="NICU DEPARTMENT">NICU DEPARTMENT</option>
                        <option value="ICU DEPARTMENT">ICU DEPARTMENT</option>
                        <option value="PULMONARY DEPARTMENT">PULMONARY DEPARTMENT</option>
                        <option value="OB-SONO DEPARTMENT">OB-SONO DEPARTMENT</option>
                        <option value="EYE CENTER DEPARTMENT">EYE CENTER DEPARTMENT</option>
                        <option value="DIETARY DEPARTMENT">DIETARY DEPARTMENT</option>
                        <option value="MEDICAL RECORDS DEPARTMENT">MEDICAL RECORDS DEPARTMENT</option>
                        <option value="CHEMO DEPARTMENT">CHEMO DEPARTMENT</option>
                        <option value="HRD DEPARTMENT">HRD DEPARTMENT</option>
                        <option value="ADMIN SEC DEPARTMENT">ADMIN SEC DEPARTMENT</option>
                        <option value="NONORTH POLE DEPARTMENT">NONORTH POLE DEPARTMENT</option>
                        <option value="PHILHEALTH 4TH F DEPARTMENT">PHILHEALTH 4TH F DEPARTMENT</option>
                        <option value="ACCOUNTING DEPARTMENT">ACCOUNTING DEPARTMENT</option>
                        <option value="CNC DEPARTMENT">CNC DEPARTMENT</option>
                        <option value="NSO DEPARTMENT">NSO DEPARTMENT</option>
                        <option value="MARKETING DEPARTMENT">MARKETING DEPARTMENT</option>
                        <option value="CRO DEPARTMENT">CRO DEPARTMENT</option>
                        <option value="MIS/IT DEPARTMENT">MIS/IT DEPARTMENT</option>
                        <option value="NURSE STATION DEPARTMENT">NURSE STATION DEPARTMENT</option>
                        <option value="PROPERTY DEPARTMENT">PROPERTY DEPARTMENT</option>
                        <option value="PURCHASING DEPARTMENT">PURCHASING DEPARTMENT</option>
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
            <input type="text" name="idhidden" id="idhidden">
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
                        <option value="LINEN DEPARTMENT">LINEN DEPARTMENT</option>
                        <option value="SECURITY DEPARTMENT">SECURITY DEPARTMENT</option>
                        <option value="MAINTENANCE DEPARTMENT">MAINTENANCE DEPARTMENT</option>
                        <option value="INFORMATION DEPARTMENT">INFORMATION DEPARTMENT</option>
                        <option value="ADMITTING DEPARTMENT">ADMITTING DEPARTMENT</option>
                        <option value="PHARMACY DEPARTMENT">PHARMACY DEPARTMENT</option>
                        <option value="EMERGENCY ROOM DEPARTMENT">EMERGENCY ROOM DEPARTMENT</option>
                        <option value="CASHIER DEPARTMENT">CASHIER DEPARTMENT</option>
                        <option value="PHILHEALTH GF DEPARTMENT">PHILHEALTH GF DEPARTMENT</option>
                        <option value="BILLING DEPARTMENT">BILLING DEPARTMENT</option>
                        <option value="RADIOLOGY DEPARTMENT">RADIOLOGY DEPARTMENT</option>
                        <option value="HEART STATION DEPARTMENT">HEART STATION DEPARTMENT</option>
                        <option value="HMO DEPARTMENT">HMO DEPARTMENT</option>
                        <option value="LABORATORY DEPARTMENT">LABORATORY DEPARTMENT</option>
                        <option value="REHAB DEPARTMENT">REHAB DEPARTMENT</option>
                        <option value="DIALYSIS DEPARTMENT">DIALYSIS DEPARTMENT</option>
                        <option value="CSR DEPARTMENT">CSR DEPARTMENT</option>
                        <option value="OR/DR DEPARTMENT">OR/DR DEPARTMENT</option>
                        <option value="NICU DEPARTMENT">NICU DEPARTMENT</option>
                        <option value="ICU DEPARTMENT">ICU DEPARTMENT</option>
                        <option value="PULMONARY DEPARTMENT">PULMONARY DEPARTMENT</option>
                        <option value="OB-SONO DEPARTMENT">OB-SONO DEPARTMENT</option>
                        <option value="EYE CENTER DEPARTMENT">EYE CENTER DEPARTMENT</option>
                        <option value="DIETARY DEPARTMENT">DIETARY DEPARTMENT</option>
                        <option value="MEDICAL RECORDS DEPARTMENT">MEDICAL RECORDS DEPARTMENT</option>
                        <option value="CHEMO DEPARTMENT">CHEMO DEPARTMENT</option>
                        <option value="HRD DEPARTMENT">HRD DEPARTMENT</option>
                        <option value="ADMIN SEC DEPARTMENT">ADMIN SEC DEPARTMENT</option>
                        <option value="NONORTH POLE DEPARTMENT">NONORTH POLE DEPARTMENT</option>
                        <option value="PHILHEALTH 4TH F DEPARTMENT">PHILHEALTH 4TH F DEPARTMENT</option>
                        <option value="ACCOUNTING DEPARTMENT">ACCOUNTING DEPARTMENT</option>
                        <option value="CNC DEPARTMENT">CNC DEPARTMENT</option>
                        <option value="NSO DEPARTMENT">NSO DEPARTMENT</option>
                        <option value="MARKETING DEPARTMENT">MARKETING DEPARTMENT</option>
                        <option value="CRO DEPARTMENT">CRO DEPARTMENT</option>
                        <option value="MIS/IT DEPARTMENT">MIS/IT DEPARTMENT</option>
                        <option value="NURSE STATION DEPARTMENT">NURSE STATION DEPARTMENT</option>
                        <option value="PROPERTY DEPARTMENT">PROPERTY DEPARTMENT</option>
                        <option value="PURCHASING DEPARTMENT">PURCHASING DEPARTMENT</option>
                    </select>
                </div>


                <div class="btnContainer">
                    <button type="submit" class="btnDefault" name="updateAccount" id="updateAccountID">UPDATE</button>
                    <button type="button" class="btnDanger" id="closeEditModal">BACK</button>
                </div>
            </form>
        </div>
    </div>



    <div id="disableAccountModal" class="modal">
        <div class="modal-content">
            <h1 class="modal-title">EDIT ACCOUNT</h1>
            <input type="text" name="idhidden" id="idhidden">
            <form id="disableAccountForm">
                <div class="input-container">
                    <input type="text" id="employeeDisableID" name="employeeID" required>
                    <label for="employeeID">Employee ID</label>
                </div>
                <div class="input-container">
                    <input type="text" id="employeeDisableName" name="employeeName" required>
                    <label for="employeeName">Employee Name</label>
                </div>

                <div class="input-container">
                    <input type="text" id="emailDisableID" name="email" required>
                    <label for="email">Email</label>
                </div>

                <div class="input-container">
                <input type="text" id="employeeDisableRole" name="employeeRole" required>
                    <label for="role">Role</label>
                </div>

                <div class="input-container">
                <input type="text" id="employeeDisableDepartment" name="employeeDepartment" required>
                <label for="department">Department</label>
                </div>


                <div class="btnContainer">
                    <button type="submit" class="btnDefault" name="disableAccount" id="disableAccountID">Disable</button>
                    <button type="button" class="btnDanger" id="closeEditModal">BACK</button>
                </div>
            </form>
        </div>
    </div>


    <script src="../../assets/js/framework.js"></script>
<script src="../../assets/js/management.js"></script>
</body>

</html>