document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector(".search-input");
  const filterButton = document.querySelector(".filter-btn");
  const rows = document.querySelectorAll("table tbody tr");
  let selectedColumn = null;

  function filterTable(filterValue) {
    rows.forEach((row) => {
      const cellText =
        row.cells[selectedColumn]?.textContent.toLowerCase() || "";
      row.style.display = cellText.includes(filterValue.toLowerCase())
        ? ""
        : "none";
    });
  }

  // Filter dropdown functionality
  if (filterButton) {
    filterButton.addEventListener("click", function () {
      // Create a dropdown menu dynamically
      let dropdown = document.querySelector(".filter-dropdown");
      if (!dropdown) {
        dropdown = document.createElement("div");
        dropdown.classList.add("filter-dropdown");
        dropdown.style.position = "absolute";
        dropdown.style.backgroundColor = "#fff";
        dropdown.style.border = "1px solid #ccc";
        dropdown.style.padding = "10px";
        dropdown.style.zIndex = "1000";

        // Add filter options
        const filters = [
          { column: 5, label: "Status" },
          { column: 4, label: "Department" },
          { column: 3, label: "Role" },
        ];

        filters.forEach((filter) => {
          const option = document.createElement("div");
          option.textContent = filter.label;
          option.style.cursor = "pointer";
          option.style.padding = "5px 10px";
          option.addEventListener("click", function () {
            selectedColumn = filter.column;

            // Show a prompt to input the filter value
            const filterValue = prompt(
              `Enter the value to filter by for ${filter.label}:`
            );
            if (filterValue) {
              filterTable(filterValue); // Apply the filter
            }

            dropdown.remove(); // Remove dropdown after selection
          });
          dropdown.appendChild(option);
        });

        document.body.appendChild(dropdown);

        // Position the dropdown below the filter button
        const rect = filterButton.getBoundingClientRect();
        dropdown.style.left = `${rect.left}px`;
        dropdown.style.top = `${rect.bottom + window.scrollY}px`;

        // Close dropdown when clicking outside
        document.addEventListener("click", function closeDropdown(event) {
          if (
            !dropdown.contains(event.target) &&
            event.target !== filterButton
          ) {
            dropdown.remove();
            document.removeEventListener("click", closeDropdown);
          }
        });
      }
    });
  }
});

let selectedRow = null;

document.addEventListener("DOMContentLoaded", function () {
  // Shared variables
  const tableRows = document.querySelectorAll(".tableContainer tbody tr");
  const editButton = document.getElementById("editAccountID");
  const disableButton = document.getElementById("disableAccountID");
  const enableButton = document.getElementById("enableAccountID");
  const editModal = document.getElementById("editAccountModal");
  const disableModal = document.getElementById("disableAccountModal");
  const closeEditModalButton = document.getElementById("closeEditModal");
  const enableModal = document.getElementById("enableAccountModal");

  // Utility functions
  function enableButtons() {
    editButton.classList.remove("btnWarningDisabled");
    editButton.removeAttribute("disabled");
    disableButton.classList.remove("btnDangerDisabled");
    disableButton.removeAttribute("disabled");
    enableButton.classList.remove("btnSuccessDisabled");
    enableButton.removeAttribute("disabled");
  }

  // Disable buttons (edit, disable, and enable)
  function disableButtons() {
    editButton.classList.add("btnWarningDisabled");
    editButton.setAttribute("disabled", "true");
    disableButton.classList.add("btnDangerDisabled");
    disableButton.setAttribute("disabled", "true");
    enableButton.classList.add("btnSuccessDisabled");
    enableButton.setAttribute("disabled", "true");
  }

  function resetSelection() {
    selectedRow = null;
    disableButtons();
    enableButton.style.display = "none"; // Hide Enable button by default
    disableButton.style.display = "none"; // Hide Disable button by default
    tableRows.forEach((row) => row.classList.remove("selected-row"));
  }

  tableRows.forEach((row) => {
    row.addEventListener("click", function () {
      tableRows.forEach((r) => r.classList.remove("selected-row"));
      if (selectedRow === row) {
        resetSelection();
      } else {
        selectedRow = row;
        row.classList.add("selected-row");

        const statusCell = row.cells[5]; // Assuming the status is in the 6th column (index 5)
        const status = statusCell ? statusCell.innerText.trim() : "";

        if (status === "Inactive") {
          disableButton.style.display = "none"; // Hide Disable button
          enableButton.style.display = "inline-block"; // Show Enable button
        } else {
          disableButton.style.display = "inline-block"; // Show Disable button
          enableButton.style.display = "none"; // Hide Enable button
        }

        enableButtons();
      }
    });
  });

  // document.addEventListener("click", function (event) {
  //   if (!event.target.closest(".tableContainer")) {
  //     resetSelection();
  //   }
  // });

  // Add Account Modal
  document
    .getElementById("addAccountID")
    .addEventListener("click", function () {
      document.getElementById("addAccountModal").style.display = "flex";
    });

  document
    .getElementById("addAccountForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch("../../0/includes/createAccount.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert("Account added successfully!");
            location.reload();
          } else {
            alert("Error: " + data.message);
          }
        })
        .catch((error) => console.error("❌ Fetch Error:", error));
    });

  // Edit Account Modal
  editButton.addEventListener("click", function () {
    if (!selectedRow) {
      alert("Please select a row to edit.");
      return;
    }

    const userID = selectedRow.getAttribute("data-id");
    fetch("../../0/includes/editAccountQuery.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${encodeURIComponent(userID)}`,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          document.getElementById("idhidden").value = data.data.id || "";
          document.getElementById("employeeEditID").value = data.data.id || "";
          document.getElementById("employeeEditName").value =
            data.data.name || "";
          document.getElementById("emailEditID").value = data.data.email || "";
          document.getElementById("roleEditID").value = data.data.role || "";
          document.getElementById("departmentEditID").value =
            data.data.department || "";
          editModal.style.display = "flex";
        } else {
          console.error("Error fetching employee data:", data.message);
        }
      })
      .catch((error) => console.error("Fetch error:", error));
  });

  // Handle Edit Account Form Submission
  document
    .getElementById("editAccountForm")
    .addEventListener("submit", function (e) {
      e.preventDefault(); // Prevent default form submission

      const formData = new FormData(this); // Collect form data

      fetch("../../0/includes/updateAccount.php", {
        // Update the URL to your PHP script
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert(data.message); // Show success message
            location.reload(); // Reload the page to reflect changes
          } else {
            alert("Error: " + data.message); // Show error message
          }
        })
        .catch((error) => console.error("❌ Fetch Error:", error));
    });

  closeEditModalButton.addEventListener("click", function () {
    editModal.style.display = "none";
    disableModal.style.display = "none"; // Close both modals if needed
  });

  // Disable Account Modal
  disableButton.addEventListener("click", function () {
    if (!selectedRow) {
      alert("Please select a row to disable.");
      return;
    }
    document.getElementById("idDisableHidden").value =
      selectedRow.getAttribute("data-id");
    document.getElementById("employeeDisableID").value =
      selectedRow.cells[0].innerText;
    document.getElementById("employeeDisableName").value =
      selectedRow.cells[1].innerText;
    document.getElementById("emailDisableID").value =
      selectedRow.cells[2].innerText;
    document.getElementById("employeeDisableRole").value =
      selectedRow.cells[3].innerText;
    document.getElementById("employeeDisableDepartment").value =
      selectedRow.cells[4].innerText;
    disableModal.style.display = "flex";
  });

  enableButton.addEventListener("click", function () {
    if (!selectedRow) {
      alert("Please select a row to enable.");
      return;
    }
    document.getElementById("idEnableHidden").value =
      selectedRow.getAttribute("data-id");
    document.getElementById("employeeEnableID").value =
      selectedRow.cells[0].innerText;
    document.getElementById("employeeEnableName").value =
      selectedRow.cells[1].innerText;
    document.getElementById("emailEnableID").value =
      selectedRow.cells[2].innerText;
    document.getElementById("employeeEnableRole").value =
      selectedRow.cells[3].innerText;
    document.getElementById("employeeEnableDepartment").value =
      selectedRow.cells[4].innerText;
    enableModal.style.display = "flex";
  });

  window.addEventListener("click", function (event) {
    if (
      event.target === editModal ||
      event.target === disableModal ||
      event.target === enableModal
    ) {
      editModal.style.display = "none";
      disableModal.style.display = "none";
      enableModal.style.display = "none";
    }
  });

  //disable account form submission
  document
    .getElementById("disableAccountForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(this);

      fetch("../../0/includes/disableAccount.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert("Account disabled successfully!");
            location.reload(); // Reload the page to reflect changes
          } else {
            alert("Error: " + data.message);
          }
        })
        .catch((error) => console.error("❌ Fetch Error:", error));
    });

  // Close modals when clicking outside of them
  window.addEventListener("click", function (event) {
    if (event.target === editModal || event.target === disableModal) {
      editModal.style.display = "none";
      disableModal.style.display = "none";
    }
  });
});

//enable account form submission
document
  .getElementById("enableAccountForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("../../0/includes/enableAccount.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Account enabled successfully!");
          location.reload(); // Reload the page to reflect changes
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch((error) => console.error("❌ Fetch Error:", error));
  });

// Close modal when clicking the close button
document.addEventListener("DOMContentLoaded", function () {
  // Function to hide parent element when close button is clicked
  function setupCloseButtons() {
    const closeButtons = document.querySelectorAll(".btnDanger"); // Select all close buttons with the class 'btnDanger'

    closeButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const parentElement = this.closest(".modal"); // Find the closest parent with the 'modal' class
        if (parentElement) {
          parentElement.style.display = "none"; // Hide the parent element
        }
      });
    });
  }

  // Initialize the close button functionality
  setupCloseButtons();
});

//reet password modal
document.addEventListener("DOMContentLoaded", function () {
  const resetPasswordButton = document.getElementById("resetPasswordID");
  const resetPasswordModal = document.getElementById("resetPasswordModal");
  const resetAccountName = document.getElementById("resetAccountName");
  const idResetHidden = document.getElementById("idResetHidden");

  if (!resetPasswordModal) {
    console.error("resetPasswordModal element not found!");
    return;
  }

  // Open Reset Password Modal
  resetPasswordButton.addEventListener("click", function () {
    const employeeName = document.getElementById("employeeEditName").value; // Get the name from the Edit Account form
    const employeeId = document.getElementById("idhidden").value; // Get the ID from the hidden input

    // Populate the modal with the account details
    resetAccountName.textContent = employeeName;
    idResetHidden.value = employeeId;

    // Show the modal
    resetPasswordModal.style.display = "flex";
  });
});

// reset password form submission
document.addEventListener("DOMContentLoaded", function () {
  const resetPasswordForm = document.getElementById("resetPasswordForm");
  const resetPasswordModal = document.getElementById("resetPasswordModal");

  // Handle Reset Password Form Submission
  resetPasswordForm.addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this); // Collect form data

    fetch("../../0/includes/resetPasswordManagement.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert(data.message); // Show success message
          resetPasswordModal.style.display = "none"; // Close the modal
          location.reload(); // Reload the page to reflect changes
        } else {
          alert("Error: " + data.message); // Show error message
        }
      })
      .catch((error) => console.error("❌ Fetch Error:", error));
  });
});

// Logic for populating the Leave Request modal
document.addEventListener("DOMContentLoaded", function () {
  const leaveRequestButton = document.getElementById("leaveReaquestBtnID");
  const leaveRequestModal = document.getElementById("leaveRequestBalanceModal");
  const leaveEmployeeName = document.getElementById("leaveEmployeeNameID");
  const leaveDepartment = document.getElementById("leaveDeparmentID");
  const leaveRequestIdHidden = document.getElementById("leaveRequestIdHidden");
  const sickLeave = document.getElementById("sickLeaveID");
  const serviceIncentiveLeave = document.getElementById(
    "leaveServiceIncentiveID"
  );
  const earnedLeaveCredit = document.getElementById("leaveEarnedLeaveID");
  const managementInitiated = document.getElementById("managementInitiatedID");
  const maternityLeave = document.getElementById("leaveMaternityLeaveID");
  const paternityLeave = document.getElementById("leavePaternityLeaveID");
  const soloParentLeave = document.getElementById("leaveSoloParentLeaveID");
  // const leaveWithoutPay = document.getElementById("leaveWithoutPayID");
  // if (leaveWithoutPay) {
  //   leaveWithoutPay.style.color = "red";
  // }
  const bereavementLeave = document.getElementById("leaveBereavementLeaveID");
  // let selectedRow = null; // Global variable to store the selected row

  // Add event listener to the Leave Request button
  leaveRequestButton.addEventListener("click", function () {
    if (!selectedRow) {
      alert("Please select a row to view leave request details.");
      return;
    }

    const userId = selectedRow.getAttribute("data-id");

    fetch(`../../0/includes/getLeaveBalancesQuery.php?userId=${userId}`)
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          // Populate the modal with the fetched data
          leaveRequestIdHidden.value = userId;
          leaveEmployeeName.value = data.leaveBalances.name || "";
          leaveDepartment.value = data.leaveBalances.department || "";
          sickLeave.value = data.leaveBalances.sl || 0;
          serviceIncentiveLeave.value = data.leaveBalances.sil || 0;
          earnedLeaveCredit.value = data.leaveBalances.elc || 0;
          managementInitiated.value = data.leaveBalances.mil || 0;
          maternityLeave.value = data.leaveBalances.ml || 0;
          paternityLeave.value = data.leaveBalances.pl || 0;
          soloParentLeave.value = data.leaveBalances.spl || 0;
          // leaveWithoutPay.value = data.leaveBalances.lwop || 0;
          bereavementLeave.value = data.leaveBalances.brl || 0;

          // Open the modal
          leaveRequestModal.style.display = "flex";
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while fetching leave balances.");
      });
  });

  // Close the modal when clicking outside of it
  window.addEventListener("click", function (event) {
    if (event.target === leaveRequestModal) {
      leaveRequestModal.style.display = "none";
    }
  });

  // Optional: Add a close button functionality inside the modal
  const closeButtons = leaveRequestModal.querySelectorAll(".btnDanger");
  closeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      leaveRequestModal.style.display = "none";
    });
  });
});
// leave request form 
document.addEventListener("DOMContentLoaded", function () {
  const leaveBalancesForm = document.getElementById("leaveBalancesForm");
  const leaveRequestModal = document.getElementById("leaveRequestBalanceModal");

  leaveBalancesForm.addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent default form submission

    // Collect form data
    const formData = new FormData(leaveBalancesForm);

    // Add the user ID to the form data
    const userId = document.getElementById("leaveRequestIdHidden").value;
    formData.append("userId", userId);

    // Send the AJAX request
    fetch("../../0/includes/updateLeaveBalances.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert(data.message); // Show success message
          leaveRequestModal.style.display = "none"; // Close the modal
          location.reload(); // Reload the page to reflect changes
        } else {
          alert("Error: " + data.message); // Show error message
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while updating leave balances.");
      });
  });
});


// Function to close modals (optional utility)
function closeModal() {
  const modals = document.querySelectorAll(".modal");
  modals.forEach((modal) => {
    modal.style.display = "none";
  });
}
