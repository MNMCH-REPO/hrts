//raymond
document.addEventListener("DOMContentLoaded", function () {
  const plate = document.getElementById("plate1");

  plate.addEventListener("click", function () {
    const selectedStatus = this.getAttribute("data-status");
    const rows = document.querySelectorAll("#ticketTable tbody tr");

    rows.forEach((row) => {
      const rowStatus = row.getAttribute("data-status");

      if (rowStatus === selectedStatus) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const plate = document.getElementById("plate2");

  plate.addEventListener("click", function () {
    const selectedStatus = this.getAttribute("data-status");
    const rows = document.querySelectorAll("#ticketTable tbody tr");

    rows.forEach((row) => {
      const rowStatus = row.getAttribute("data-status");

      if (rowStatus === selectedStatus) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const plate = document.getElementById("plate3");

  plate.addEventListener("click", function () {
    const selectedStatus = this.getAttribute("data-status");
    const rows = document.querySelectorAll("#ticketTable tbody tr");

    rows.forEach((row) => {
      const rowStatus = row.getAttribute("data-status");

      if (rowStatus === selectedStatus) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const rows = document.querySelectorAll("#ticketTable tbody tr");
  let selectedStatus = "";

  function filterTable() {
    const searchTerm = searchInput.value.toLowerCase();

    rows.forEach((row) => {
      const rowStatus = row.getAttribute("data-status");
      const rowText = row.textContent.toLowerCase();

      const isStatusMatch =
        selectedStatus === "" || rowStatus === selectedStatus;
      const isSearchMatch = rowText.includes(searchTerm);

      row.style.display = isStatusMatch && isSearchMatch ? "" : "none";
    });
  }

  // Plate click event setup
  const plateIDs = ["plate1", "plate2", "plate3"];
  plateIDs.forEach((id) => {
    const plate = document.getElementById(id);
    if (plate) {
      plate.addEventListener("click", function () {
        selectedStatus = this.getAttribute("data-status");
        searchInput.value = ""; // clear search input
        filterTable(); // trigger filtering
      });
    }
  });

  // Search input listener
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      filterTable();
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  // Define filterButton
  const filterButton = document.getElementById("filterButton");

  if (!filterButton) {
    console.error("❌ filterButton element not found!");
    return;
  }
  // Filter dropdown functionality
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
        {
          column: 5,
          label: "Status",
        },
        {
          column: 6,
          label: "Priority",
        },
        {
          column: 7,
          label: "Category",
        },
      ];

      filters.forEach((filter) => {
        const option = document.createElement("div");
        option.textContent = filter.label;
        option.style.cursor = "pointer";
        option.style.padding = "5px 10px";
        option.addEventListener("click", function () {
          applyFilter(filter.column);
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
        if (!dropdown.contains(event.target) && event.target !== filterButton) {
          dropdown.remove();
          document.removeEventListener("click", closeDropdown);
        }
      });
    }
  });

  // Apply filter based on the selected column
  function applyFilter(columnIndex) {
    const rows = table.getElementsByTagName("tr");
    const filterValue = prompt("Enter the value to filter by:");

    if (filterValue) {
      for (let i = 0; i < rows.length; i++) {
        const cell = rows[i].getElementsByTagName("td")[columnIndex];
        if (cell) {
          rows[i].style.display =
            cell.textContent.trim().toLowerCase() === filterValue.toLowerCase()
              ? ""
              : "none";
        }
      }
    }
  }
});

document.addEventListener("DOMContentLoaded", function () {
  // Open modal function
  function openModal() {
    document.getElementById("addTicketModal").style.display = "flex";

    // Auto-fill department correctly
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
  document
    .getElementById("ticketForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      let formData = new FormData(this);

      fetch("../../0/includes/submitTicket.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert("Ticket submitted successfully!");
            document.getElementById("ticketForm").reset();
            closeModal();
            location.reload();
          } else {
            alert("Error: " + data.message);
          }
        })
        .catch((error) => {
          console.error("❌ Fetch Error:", error);
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const tableRows = document.querySelectorAll("tbody tr");
    const assignTicketModal = document.getElementById("assignTicketModal");
    const editStatusModal = document.getElementById("editStatusModal");

    // Modal fields for assignTicketModal
    const assignTicketFields = {
        ticketIdField: assignTicketModal.querySelector(".input-container:nth-child(1) .center-text"),
        employeeNameField: assignTicketModal.querySelector(".input-container:nth-child(2) .center-text"),
        departmentField: assignTicketModal.querySelector(".input-container:nth-child(3) .center-text"),
        subjectField: assignTicketModal.querySelector(".input-container:nth-child(4) .center-text"),
        categoryField: assignTicketModal.querySelector(".input-container:nth-child(5) .center-text"),
        descriptionField: assignTicketModal.querySelector(".input-container:nth-child(6) .center-text"),
        prioritySelect: document.getElementById("priorityID"),
        assignToSelect: document.getElementById("assignToID"),
    };

    // Modal fields for editStatusModal
    const editStatusFields = {
        ticketIdField: document.getElementById("editTicketID"),
        employeeNameField: document.getElementById("editemployeeID"),
        departmentField: document.getElementById("editdepartmentID"),
        subjectField: document.getElementById("editsubjectID"),
        categoryField: document.getElementById("editcategoryID"),
        descriptionField: document.getElementById("editdescriptionID"),
        priorityField: document.getElementById("editpriorityID"),
        assignedToField: document.getElementById("editassignedID"),
        statusSelect: document.getElementById("statusEditID"),
    };

  
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
                    const status = this.children[4].textContent.trim(); // Status column
                    const department = this.children[4].textContent.trim();
                    const priority = this.children[5].textContent.trim();
                    const category = this.children[6].textContent.trim();
                    const assignedTo = this.children[7].textContent.trim();

                    // Open the appropriate modal based on the status
                    if (status === "Open") {
                        // Set the values in the assignTicketModal
                        assignTicketFields.ticketIdField.textContent = ticketId;
                        assignTicketFields.employeeNameField.textContent = employeeName;
                        assignTicketFields.departmentField.textContent = department;
                        assignTicketFields.subjectField.textContent = subject;
                        assignTicketFields.categoryField.textContent = category;
                        assignTicketFields.descriptionField.textContent = description;

                        // Set the priority dropdown value (if applicable)
                        if (assignTicketFields.prioritySelect) {
                            assignTicketFields.prioritySelect.value = priority;
                        }

                        // Open the assignTicketModal
                        assignTicketModal.style.display = "flex";
                    } else if (status === "In Progress") {
                        // Set the values in the editStatusModal
                        editStatusFields.ticketIdField.textContent = ticketId;
                        editStatusFields.employeeNameField.textContent = employeeName;
                        editStatusFields.departmentField.textContent = department;
                        editStatusFields.subjectField.textContent = subject;
                        editStatusFields.categoryField.textContent = category;
                        editStatusFields.descriptionField.textContent = description;
                        editStatusFields.priorityField.textContent = priority;
                        editStatusFields.assignedToField.textContent = assignedTo;

                        // Open the editStatusModal
                        editStatusModal.style.display = "flex";
                    }
                });
            });

  // Close the modals when clicking outside of them
  window.addEventListener("click", function (event) {
    if (event.target === assignTicketModal) {
      assignTicketModal.style.display = "none";
    }
    if (event.target === editStatusModal) {
      editStatusModal.style.display = "none";
    }
  });

  // Close the modals when clicking the "BACK" button
  const closeAssignModalButton = assignTicketModal.querySelector(".btnDanger");
  const closeEditModalButton = editStatusModal.querySelector(".btnDanger");

  closeAssignModalButton.addEventListener("click", function () {
    assignTicketModal.style.display = "none";
  });

  closeEditModalButton.addEventListener("click", function () {
    editStatusModal.style.display = "none";
  });
});

// Handle form submission assign

document.addEventListener("DOMContentLoaded", function () {
  const assignTicketForm = document.getElementById("assignTicketForm");

  assignTicketForm.addEventListener("submit", async function (event) {
    event.preventDefault(); // Prevent the default form submission

    // Get form data
    const ticketId = document
      .querySelector(".input-container:nth-child(1) .center-text")
      .textContent.trim();
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

document.addEventListener("DOMContentLoaded", function () {
  const editStatusForm = document.getElementById("editStatusForm");

  editStatusForm.addEventListener("submit", async function (event) {
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
      const response = await fetch("../../0/includes/editStatusTicket.php", {
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
      console.error("Error updating status:", error);
      alert("An error occurred while updating the status. Please try again.");
    }
  });
});
