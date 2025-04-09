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
  const closeEnableModalButton = document.getElementById("closeEditModal");
  let selectedRow = null;

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
    tableRows.forEach((row) => row.classList.remove("selected-row"));
  }

  // Row selection logic
  tableRows.forEach((row) => {
    row.addEventListener("click", function () {
      tableRows.forEach((r) => r.classList.remove("selected-row"));
      if (selectedRow === row) {
        resetSelection();
      } else {
        selectedRow = row;
        row.classList.add("selected-row");
        enableButtons();
      }
    });
  });

  document.addEventListener("click", function (event) {
    if (!event.target.closest(".tableContainer")) {
      resetSelection();
    }
  });

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
    enableModal.style.display = "flex";
  });

  window.addEventListener("click", function (event) {
    if (event.target === editModal || event.target === disableModal || event.target === enableModal) {
      editModal.style.display = "none";
      disableModal.style.display = "none";
      enableModal.style.display = "none"
    }
  });

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
