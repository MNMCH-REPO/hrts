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


 <div id="editAccountModal" class="modal">
     <div class="modal-content">
         <h1 class="modal-title">EDIT ACCOUNT</h1>
         <form id="editAccountForm">
             <input type="hidden" name="idhidden" id="idhidden">
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
                     <option value="Employee">Employee</option>
                     <option value="HR Rep">HR Rep</option>
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
                 <button type="button" class="btnWarning" name="resetPassword" id="resetPasswordID">Reset Password</button>
                 <button type="submit" class="btnDefault" name="updateAccount" id="updateAccountID">UPDATE</button>
                 <button type="button" class="btnDanger" id="closeEditModal">BACK</button>
             </div>
         </form>
     </div>
 </div>



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