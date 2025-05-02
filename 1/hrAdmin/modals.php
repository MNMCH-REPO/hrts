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
                     <option value="Employee">Employee</option>
                     <option value="HR Rep">HR Rep</option>

                 </select>
             </div>

             <div class="input-container">
                 <select id="department" name="department" required>
                     <option value="" disabled selected>Please select the Department</option>
                     <option value="ACCOUNTING DEPARTMENT">ACCOUNTING DEPARTMENT</option>
                     <option value="ADMIN SEC DEPARTMENT">ADMIN SEC DEPARTMENT</option>
                     <option value="BILLING DEPARTMENT">BILLING DEPARTMENT</option>
                     <option value="CASHIER DEPARTMENT">CASHIER DEPARTMENT</option>
                     <option value="CHEMO DEPARTMENT">CHEMO DEPARTMENT</option>
                     <option value="CNC DEPARTMENT">CNC DEPARTMENT</option>
                     <option value="CSR DEPARTMENT">CSR DEPARTMENT</option>
                     <option value="DIETARY DEPARTMENT">DIETARY DEPARTMENT</option>
                     <option value="DIALYSIS DEPARTMENT">DIALYSIS DEPARTMENT</option>
                     <option value="EMERGENCY ROOM DEPARTMENT">EMERGENCY ROOM DEPARTMENT</option>
                     <option value="EYE CENTER DEPARTMENT">EYE CENTER DEPARTMENT</option>
                     <option value="HEART STATION DEPARTMENT">HEART STATION DEPARTMENT</option>
                     <option value="HR DEPARTMENT">HR DEPARTMENT</option>
                     <option value="ICU DEPARTMENT">ICU DEPARTMENT</option>
                     <option value="INFORMATION DEPARTMENT">INFORMATION DEPARTMENT</option>
                     <option value="LABORATORY DEPARTMENT">LABORATORY DEPARTMENT</option>
                     <option value="LINEN DEPARTMENT">LINEN DEPARTMENT</option>
                     <option value="MAINTENANCE DEPARTMENT">MAINTENANCE DEPARTMENT</option>
                     <option value="MARKETING DEPARTMENT">MARKETING DEPARTMENT</option>
                     <option value="MEDICAL RECORDS DEPARTMENT">MEDICAL RECORDS DEPARTMENT</option>
                     <option value="MIS/IT DEPARTMENT">MIS/IT DEPARTMENT</option>
                     <option value="NORTH POLE DEPARTMENT">NORTH POLE DEPARTMENT</option>
                     <option value="NICU DEPARTMENT">NICU DEPARTMENT</option>
                     <option value="NSO DEPARTMENT">NSO DEPARTMENT</option>
                     <option value="NURSE STATION DEPARTMENT">NURSE STATION DEPARTMENT</option>
                     <option value="OB-SONO DEPARTMENT">OB-SONO DEPARTMENT</option>
                     <option value="OR/DR DEPARTMENT">OR/DR DEPARTMENT</option>
                     <option value="PHARMACY DEPARTMENT">PHARMACY DEPARTMENT</option>
                     <option value="PHILHEALTH 4TH F DEPARTMENT">PHILHEALTH 4TH F DEPARTMENT</option>
                     <option value="PHILHEALTH GF DEPARTMENT">PHILHEALTH GF DEPARTMENT</option>
                     <option value="PROPERTY DEPARTMENT">PROPERTY DEPARTMENT</option>
                     <option value="PULMONARY DEPARTMENT">PULMONARY DEPARTMENT</option>
                     <option value="PURCHASING DEPARTMENT">PURCHASING DEPARTMENT</option>
                     <option value="RADIOLOGY DEPARTMENT">RADIOLOGY DEPARTMENT</option>
                     <option value="REHAB DEPARTMENT">REHAB DEPARTMENT</option>
                     <option value="SECURITY DEPARTMENT">SECURITY DEPARTMENT</option>
                     <option value="SHARED SERVICES DEPARTMENT">SHARED SERVICES DEPARTMENT</option>
                     <option value="TALENT ACQUISITION DEPARTMENT">TALENT ACQUISITION DEPARTMENT</option>
                     <option value="ZONAL MANAGEMENT DEPARTMENT">ZONAL MANAGEMENT DEPARTMENT</option>

                 </select>
             </div>

             <div class="btnContainer">
                 <button type="submit" name="submitAccount" class="btnDefault">SUBMIT</button>
                 <button type="button" class="btnDanger" onclick="closeModal()">BACK</button>
             </div>
         </form>
     </div>
 </div>

 <!-- edit -->
 <div id="editAccountModal" class="modal">
     <div class="modal-content">
         <h1 class="modal-title">EDIT ACCOUNT</h1>
         <form id="editAccountForm">
             <input type="hidden" name="idhidden" id="idhidden">
             <div class="input-container">
                 <input type="text" id="employeeEditID" name="employeeID" readonly>
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
                     <option value="Employee">Employee</option>
                     <option value="HR">HR Repepresentative</option>
                 </select>
             </div>

             <div class="input-container">
                 <select id="departmentEditID" name="department" required>
                     <option value="" disabled selected>Please select the Department</option>
                     <option value="ACCOUNTING DEPARTMENT">ACCOUNTING DEPARTMENT</option>
                     <option value="ADMIN SEC DEPARTMENT">ADMIN SEC DEPARTMENT</option>
                     <option value="BILLING DEPARTMENT">BILLING DEPARTMENT</option>
                     <option value="CASHIER DEPARTMENT">CASHIER DEPARTMENT</option>
                     <option value="CHEMO DEPARTMENT">CHEMO DEPARTMENT</option>
                     <option value="CNC DEPARTMENT">CNC DEPARTMENT</option>
                     <option value="CSR DEPARTMENT">CSR DEPARTMENT</option>
                     <option value="DIETARY DEPARTMENT">DIETARY DEPARTMENT</option>
                     <option value="DIALYSIS DEPARTMENT">DIALYSIS DEPARTMENT</option>
                     <option value="EMERGENCY ROOM DEPARTMENT">EMERGENCY ROOM DEPARTMENT</option>
                     <option value="EYE CENTER DEPARTMENT">EYE CENTER DEPARTMENT</option>
                     <option value="HEART STATION DEPARTMENT">HEART STATION DEPARTMENT</option>
                     <option value="HR DEPARTMENT">HR DEPARTMENT</option>
                     <option value="ICU DEPARTMENT">ICU DEPARTMENT</option>
                     <option value="INFORMATION DEPARTMENT">INFORMATION DEPARTMENT</option>
                     <option value="LABORATORY DEPARTMENT">LABORATORY DEPARTMENT</option>
                     <option value="LINEN DEPARTMENT">LINEN DEPARTMENT</option>
                     <option value="MAINTENANCE DEPARTMENT">MAINTENANCE DEPARTMENT</option>
                     <option value="MARKETING DEPARTMENT">MARKETING DEPARTMENT</option>
                     <option value="MEDICAL RECORDS DEPARTMENT">MEDICAL RECORDS DEPARTMENT</option>
                     <option value="MIS/IT DEPARTMENT">MIS/IT DEPARTMENT</option>
                     <option value="NORTH POLE DEPARTMENT">NORTH POLE DEPARTMENT</option>
                     <option value="NICU DEPARTMENT">NICU DEPARTMENT</option>
                     <option value="NSO DEPARTMENT">NSO DEPARTMENT</option>
                     <option value="NURSE STATION DEPARTMENT">NURSE STATION DEPARTMENT</option>
                     <option value="OB-SONO DEPARTMENT">OB-SONO DEPARTMENT</option>
                     <option value="OR/DR DEPARTMENT">OR/DR DEPARTMENT</option>
                     <option value="PHARMACY DEPARTMENT">PHARMACY DEPARTMENT</option>
                     <option value="PHILHEALTH 4TH F DEPARTMENT">PHILHEALTH 4TH F DEPARTMENT</option>
                     <option value="PHILHEALTH GF DEPARTMENT">PHILHEALTH GF DEPARTMENT</option>
                     <option value="PROPERTY DEPARTMENT">PROPERTY DEPARTMENT</option>
                     <option value="PULMONARY DEPARTMENT">PULMONARY DEPARTMENT</option>
                     <option value="PURCHASING DEPARTMENT">PURCHASING DEPARTMENT</option>
                     <option value="RADIOLOGY DEPARTMENT">RADIOLOGY DEPARTMENT</option>
                     <option value="REHAB DEPARTMENT">REHAB DEPARTMENT</option>
                     <option value="SECURITY DEPARTMENT">SECURITY DEPARTMENT</option>
                     <option value="SHARED SERVICES DEPARTMENT">SHARED SERVICES DEPARTMENT</option>
                     <option value="TALENT ACQUISITION DEPARTMENT">TALENT ACQUISITION DEPARTMENT</option>
                     <option value="ZONAL MANAGEMENT DEPARTMENT">ZONAL MANAGEMENT DEPARTMENT</option>

                 </select>
             </div>


             <div class="btnContainer">
                 <button type="button" class="btnDefault" name="leaveRequest" id="leaveReaquestBtnID">Leave Request</button>
                 <button type="button" class="btnWarning" name="resetPassword" id="resetPasswordID">Reset Password</button>
                 <button type="submit" class="btnDefault" name="updateAccount" id="updateAccountID">UPDATE</button>
                 <button type="button" class="btnDanger" id="closeEditModal">BACK</button>
             </div>
         </form>
     </div>
 </div>


 <!-- disable -->
 <div id="disableAccountModal" class="modal">
     <div class="modal-content">
         <h1 class="modal-title">DISABLE ACCOUNT</h1>
         <form id="disableAccountForm">
             <input type="hidden" name="idhidden" id="idDisableHidden">
             <div class="input-container">
                 <input type="text" id="employeeDisableID" name="employeeID" readonly>
                 <label for="employeeID">Employee ID</label>
             </div>
             <div class="input-container">
                 <input type="text" id="employeeDisableName" name="employeeName" readonly>
                 <label for="employeeName">Employee Name</label>
             </div>

             <div class="input-container">
                 <input type="text" id="emailDisableID" name="email" readonly>
                 <label for="email">Email</label>
             </div>

             <div class="input-container">
                 <input type="text" id="employeeDisableRole" name="employeeRole" readonly>
                 <label for="role">Role</label>
             </div>

             <div class="input-container">
                 <input type="text" id="employeeDisableDepartment" name="employeeDepartment" readonly>
                 <label for="department">Department</label>
             </div>


             <div class="btnContainer">
                 <button type="submit" class="btnDefault" name="disableAccount" id="disableAccountID">Disable</button>
                 <button type="button" class="btnDanger" id="closeEditModal">BACK</button>
             </div>
         </form>
     </div>
 </div>

 <!-- enable -->
 <div id="enableAccountModal" class="modal">
     <div class="modal-content">
         <h1 class="modal-title">ENABLE ACCOUNT</h1>
         <form id="enableAccountForm">
             <input type="hidden" name="idhidden" id="idEnableHidden">

             <div class="input-container">
                 <input type="text" id="employeeEnableID" name="employeeID" readonly>
                 <label for="employeeID">Employee ID</label>
             </div>

             <div class="input-container">
                 <input type="text" id="employeeEnableName" name="employeeName" readonly>
                 <label for="employeeName">Employee Name</label>
             </div>

             <div class="input-container">
                 <input type="text" id="emailEnableID" name="email" readonly>
                 <label for="email">Email</label>
             </div>

             <div class="input-container">
                 <input type="text" id="employeeEnableRole" name="employeeRole" readonly>
                 <label for="role">Role</label>
             </div>

             <div class="input-container">
                 <input type="text" id="employeeEnableDepartment" name="employeeDepartment" readonly>
                 <label for="department">Department</label>
             </div>

             <div class="btnContainer">

                 <button type="submit" class="btnDefault" name="enableAccount" id="enableAccountID">Enable</button>
                 <button type="button" class="btnDanger" id="closeEnableModal">BACK</button>
             </div>
         </form>
     </div>
 </div>

 <!-- reset -->
 <div id="resetPasswordModal" class="modal">
     <div class="modal-content">
         <h1 class="modal-title">RESET PASSWORD</h1>
         <form id="resetPasswordForm">
             <input type="hidden" name="idhidden" id="idResetHidden">

             <p class="center-text">
                 Are you sure you want to reset the password of
                 <strong id="resetAccountName"></strong>?
             </p>

             <div class="btnContainer">
                 <button type="submit" class="btnApprove" name="resetPassword" id="resetPasswordID">Confirm</button>
                 <button type="button" class="btnDanger" id="closeResetModal">Cancel</button>
             </div>
         </form>
     </div>
 </div>

 <!-- leave Request Balances Modal -->
 <div id="leaveRequestBalanceModal" class="modal">
     <div class="modal-content">
         <h1 class="modal-title">Edit Leave Request</h1>
         <form id="leaveBalancesForm">
             <input type="hidden" name="leaveRequestId" id="leaveRequestIdHidden">
             <div class="input-container">
                 <input type="text" id="leaveEmployeeNameID" name="employeeName" readonly>
                 <label for="employeeName">Employee Name</label>
             </div>
             <div class="input-container">
                 <input type="text" id="leaveDeparmentID" name="department" readonly>
                 <label for="Department">Department</label>
             </div>
             <div class="input-container">
                 <input type="text" id="sickLeaveID" name="sl" required>
                 <label for="sickLeaveID">Sick Leave (SL)</label>
             </div>
             <div class="input-container">
                 <input type="text" id="leaveServiceIncentiveID" name="sil" required>
                 <label for="leaveServiceIncentiveID">Service Incentive Leave (SIL)</label>
             </div>
             <div class="input-container">
                 <input type="text" id="leaveEarnedLeaveID" name="elc" required>
                 <label for="leaveEarnedLeaveID">Earned Leave Credit (ELC)</label>
             </div>
             <div class="input-container">
                 <input type="text" id="managementInitiatedID" name="mil" required>
                 <label for="managementInitiatedID">Management Initiated Leave (MIL)</label>
             </div>
             <div class="input-container">
                 <input type="text" id="leaveMaternityLeaveID" name="ml" required>
                 <label for="leaveMaternityLeaveID">Maternity Leave (ML)</label>
             </div>
             <div class="input-container">
                 <input type="text" id="leavePaternityLeaveID" name="pl" required>
                 <label for="leavePaternityLeaveID">Paternity Leave (PL)</label>
             </div>
             <div class="input-container">
                 <input type="text" id="leaveSoloParentLeaveID" name="spl" required>
                 <label for="leaveSoloParentLeaveID">Solo Parent Leave (SPL)</label>
             </div>
             <!-- <div class="input-container">
                 <input type="text" id="leaveWithoutPayID" name="lwop" required>
                 <label for="leaveWithoutPayID">Leave Without Pay (LWOP)</label>
             </div> -->
             <div class="input-container">
                 <input type="text" id="leaveBereavementLeaveID" name="brl" required>
                 <label for="leaveBereavementLeaveID">Bereavement Leave (BRL)</label>
             </div>
             <div class="modal-buttons btnContainer">
                 <button type="button" class="btnWarning" name="markLWOP" id="markAWOLBtnID">Mark as AWOL</button>
                 <button type="submit" id="leaveBtnID" name="leaveButton" class="btnDefault">Save Changes</button>
                 <button type="button" class="btnDanger" onclick="closeModal()">Cancel</button>
             </div>
         </form>
     </div>
 </div>



 <div id="markAWOLModal" class="modal">
     <div class="modal-content">
         <h1 class="modal-title">MARK AS ABSENT WITHOUT OFFICIAL LEAVE</h1>
         <br><br><br>

         <form id="markAWOLForm" method="POST">
             <input type="text" name="usedBalanceId" id="markAWOLID">
             <input type="text" name="employeeLeaveUserId" id="markAWOLEmployeeID">
             <input type="hidden" name="approvedBy" value="<?php echo $_SESSION['user_id']; ?>"> <!-- Logged-in user ID -->
             <p class="center-text">
                 Are you sure you want to mark <strong id="markAWOLEmployeeName"></strong> today
                 <br>as Absent Without Official Leave (AWOL)?
             </p>
             <br><br>
             <p class="center-text">
                 Total Absent Without Official Leave (AWOL): <strong id="awolBalances"><?php echo htmlspecialchars($totalAWOL); ?></strong>
             </p>
             <br>
             <div class="btnContainer">
                 <button type="submit" class="btnApprove" name="confirmMarkAWOL" id="confirmMarkAWOLID">Confirm</button>
                 <button type="button" class="btnDanger" id="closemarkAWOLModal">Cancel</button>
             </div>
         </form>
     </div>
 </div>



 <script>
     document.addEventListener("DOMContentLoaded", function() {
         const markAWOLButton = document.getElementById("markAWOLBtnID");
         const markAWOLModal = document.getElementById("markAWOLModal");
         const markAWOLEmployeeName = document.getElementById("markAWOLEmployeeName");
         const awolBalancesElement = document.getElementById("awolBalances");
         const markAWOLID = document.getElementById("markAWOLID");
         const markAWOLEmployeeID = document.getElementById("markAWOLEmployeeID");
         const closemarkAWOLModal = document.getElementById("closemarkAWOLModal");

         // Check if required elements exist
         if (!markAWOLModal || !markAWOLButton) {
             console.error("Required elements for Mark AWOL modal not found!");
             return;
         }

         // Open Mark AWOL Modal
         markAWOLButton.addEventListener("click", function() {
             console.log("Mark AWOL button clicked");

             const userId = selectedRow.getAttribute("data-id");

             // Fetch data from getLeaveBalancesQuery.php
             fetch(`../../0/includes/getLeaveBalancesQuery.php?userId=${userId}`)
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         // Populate modal fields with fetched data
                         markAWOLEmployeeName.textContent = data.leaveBalances.name || "Unknown";
                         awolBalancesElement.textContent = data.leaveBalances.totalAWOL || "0";

                         // Populate the input fields
                         markAWOLID.value = data.leaveBalances.usedBalanceId || ""; // Populate usedBalanceId

                         markAWOLEmployeeID.value = data.leaveBalances.userId || "";


                         // Convert totalAWOL to an integer for comparison
                         const totalAWOLValue = parseInt(data.leaveBalances.totalAWOL, 10) || 0;

                         // Apply color based on the value of totalAWOL
                         if (totalAWOLValue === 3 || totalAWOLValue === 4) {
                             awolBalancesElement.style.color = "orange"; // Set color to orange if value is 3
                         } else if (totalAWOLValue >= 5) {
                             awolBalancesElement.style.color = "red"; // Set color to red if value is 5 or greater
                         } else {
                             awolBalancesElement.style.color = ""; // Reset color for other values
                         }


                         console.log("Mark AWOL Employee ID:", markAWOLEmployeeID.value);
                         console.log("Data fetched successfully:", data);

                         // Show the modal
                         markAWOLModal.style.display = "flex";
                     } else {
                         console.error("Failed to fetch leave balances:", data.message);
                         alert("Failed to fetch leave balances. Please try again.");
                     }
                 })
                 .catch(error => {
                     console.error("Error fetching leave balances:", error);
                     alert("An error occurred while fetching leave balances.");
                 });
         });



         document.addEventListener("DOMContentLoaded", function() {
             const markAWOLForm = document.getElementById("markAWOLForm");
             const markAWOLModal = document.getElementById("markAWOLModal"); // Ensure it's defined

             markAWOLForm.addEventListener("submit", function(event) {
                 event.preventDefault();

                 const formData = new FormData(markAWOLForm);

                 fetch("../../0/includes/markAWOLQuery.php", {
                         method: "POST",
                         body: formData,
                     })
                     .then(response => response.json())
                     .then(data => {
                         if (data.success) {
                             alert(data.message);
                             markAWOLModal.style.display = "none";
                             location.reload();
                         } else {
                             alert(data.message);
                         }
                     })
                     .catch(error => {
                         console.error("Error submitting Mark AWOL form:", error);
                         alert("An error occurred while marking AWOL.");
                     });
             });
         });

         // Close Mark AWOL Modal
         closemarkAWOLModal.addEventListener("click", function() {
             console.log("Close Mark AWOL modal button clicked");
             markAWOLModal.style.display = "none";
         });

     });
 </script>