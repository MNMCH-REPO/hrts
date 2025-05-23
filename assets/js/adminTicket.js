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
  const table = document.getElementById("ticketTable");

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
          applyFilter(filter.column, filter.label); // Passing filter.column and filter.label
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

  function applyFilter(columnIndex, label) {
    const rows = table.getElementsByTagName("tr");
    const filterValue = prompt("Enter the value to filter by: " + label); // Display the label in the prompt

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

//create ticket modal
document.addEventListener("DOMContentLoaded", function () {
  // Open modal function
  function openModal() {
    document.getElementById("addTicketModal").style.display = "flex";

    // Auto-fill department correctly


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


// Function to handle the timer
document.addEventListener("DOMContentLoaded", function () {
  // Function to calculate elapsed time
  function calculateElapsedTime(startTime, endTime = null) {
    const startDate = new Date(startTime); // Convert start_at to a Date object
    const endDate = endTime ? new Date(endTime) : new Date(); // Use updated_at if provided, otherwise use current time
    const elapsed = Math.floor((endDate - startDate) / 1000); // Elapsed time in seconds

    const hours = Math.floor(elapsed / 3600);
    const minutes = Math.floor((elapsed % 3600) / 60);
    const seconds = elapsed % 60;

    return `${hours
      .toString()
      .padStart(
        2,
        "0"
      )}:${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
  }

  // Update all timer cells
  function updateTimers() {
    const timerCells = document.querySelectorAll(".timer-cell");
    timerCells.forEach((cell) => {
      const startAt = cell.getAttribute("data-start-at");
      const row = cell.closest("tr");
      const updatedAt = row
        .querySelector("td:nth-child(11)")
        ?.textContent.trim(); // Corrected column index
      const status = row.getAttribute("data-status");

      // Stop the timer if updated_at has a value or status is "Resolved"
      if ((updatedAt && updatedAt !== "") || status === "Resolved") {
        // Calculate the elapsed time between startAt and updatedAt
        cell.textContent = calculateElapsedTime(startAt, updatedAt);
        cell.classList.add("stopped"); // Add a class to indicate the timer has stopped
        return;
      }

      if (startAt) {
        cell.textContent = calculateElapsedTime(startAt);
      }
    });
  }

  // Update timers every second
  setInterval(updateTimers, 1000);

  // Initial update
  updateTimers();
});

document.addEventListener("DOMContentLoaded", function () {
  const tableRows = document.querySelectorAll("#ticketTable tbody tr");
  const assignTicketModal = document.getElementById("assignTicketModal");
  const confirmModal = document.getElementById("confirmModal");
  const editStatusModal = document.getElementById("editStatusModal");
  const ticketSummarizationModal = document.getElementById(
    "ticketSummarizationModal"
  );

  // Modal fields for assignTicketModal
  const assignTicketFields = {
    ticketIdField: assignTicketModal.querySelector(
      ".input-container:nth-child(1) .center-text"
    ),
    employeeNameField: assignTicketModal.querySelector(
      ".input-container:nth-child(2) .center-text"
    ),
    departmentField: assignTicketModal.querySelector(
      ".input-container:nth-child(3) .center-text"
    ),
    subjectField: assignTicketModal.querySelector(
      ".input-container:nth-child(4) .center-text"
    ),
    categoryField: assignTicketModal.querySelector(
      ".input-container:nth-child(5) .center-text"
    ),
    descriptionField: assignTicketModal.querySelector(
      ".input-container:nth-child(6) .center-text"
    ),
    prioritySelect: document.getElementById("priorityID"),
    assignToSelect: document.getElementById("assignToID"),
  };

  // Modal fields for confirmModal
  const confirmModalFields = {
    ticketIdField: document.getElementById("confirmTicketID"),
    employeeNameField: document.getElementById("confirmemployeeID"),
    departmentField: document.getElementById("confirmdepartmentID"),
    subjectField: document.getElementById("confirmsubjectID"),
    categoryField: document.getElementById("confirmcategoryID"),
    descriptionField: document.getElementById("confirmdescriptionID"),
    priorityField: document.getElementById("confirmpriorityID"),
    assignedToField: document.getElementById("confirmassignedID"),
    statusField: document.getElementById("confirmStatusID"),
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

  // Fields in the Ticket Summarization Modal
  const summarizationFields = {
    ticketIdField: document.getElementById("summarizationTicketID"),
    employeeNameField: document.getElementById("summarizationEmployeeName"),
    departmentField: document.getElementById("summarizationDepartment"),
    subjectField: document.getElementById("summarizationSubject"),
    categoryField: document.getElementById("summarizationCategory"),
    descriptionField: document.getElementById("summarizationDescription"),
    priorityField: document.getElementById("summarizationPriority"),
    assignedToField: document.getElementById("summarizationAssignedTo"),
    statusField: document.getElementById("summarizationStatus"),
    durationField: document.getElementById("summarizationDuration"),
  };

  // Add click event listener to each row
  tableRows.forEach((row) => {
    row.addEventListener("click", function () {
      // Remove highlight from all rows
      tableRows.forEach((r) => r.classList.remove("highlighted"));

      // Highlight the clicked row
      this.classList.add("highlighted");
      // Get the values from the clicked row
      const ticketId = this.children[0].textContent.trim();
      const employeeName = this.children[1].textContent.trim();
      const subject = this.children[2].textContent.trim();
      const description = this.children[3].textContent.trim();
      const status = this.children[4].textContent.trim();
      const department = this.children[4].textContent.trim();
      const priority = this.children[5].textContent.trim();
      const category = this.children[6].textContent.trim();
      const assignedTo = this.children[7].textContent.trim();

      // Get the current user from the session
      const currentUser = document
        .querySelector(".accountName")
        .textContent.trim();

      // Open the appropriate modal based on the status
      if (status === "Open" && assignedTo === currentUser) {
        // Open the confirmModal
        confirmModalFields.ticketIdField.textContent = ticketId;
        confirmModalFields.employeeNameField.textContent = employeeName;
        confirmModalFields.departmentField.textContent =
          confirmModalFields.departmentField.dataset.assigned;
        confirmModalFields.subjectField.textContent = subject;
        confirmModalFields.categoryField.textContent = category;
        confirmModalFields.descriptionField.textContent = description;
        confirmModalFields.priorityField.textContent = priority;
        confirmModalFields.assignedToField.textContent = assignedTo;
        confirmModalFields.statusField.textContent = status;

        confirmModal.style.display = "flex";
      } else if (status === "In Progress" && assignedTo === currentUser) {
        // Open the editStatusModal
        editStatusFields.ticketIdField.textContent = ticketId;
        editStatusFields.employeeNameField.textContent = employeeName;
        editStatusFields.departmentField.textContent =
          editStatusFields.departmentField.dataset.assigned;
        editStatusFields.subjectField.textContent = subject;
        editStatusFields.categoryField.textContent = category;
        editStatusFields.descriptionField.textContent = description;
        editStatusFields.priorityField.textContent = priority;
        editStatusFields.assignedToField.textContent = assignedTo;

        editStatusModal.style.display = "flex";
      } else if (status === "Open") {
        // Open the assignTicketModal
        assignTicketFields.ticketIdField.textContent = ticketId;
        assignTicketFields.employeeNameField.textContent = employeeName;
        assignTicketFields.departmentField.textContent = department;
        assignTicketFields.subjectField.textContent = subject;
        assignTicketFields.categoryField.textContent = category;
        assignTicketFields.descriptionField.textContent = description;

        if (assignTicketFields.prioritySelect) {
          assignTicketFields.prioritySelect.value = priority;
        }

        assignTicketModal.style.display = "flex";
      } else if (status === "Resolved") {
        // Get ticket details from the row
        const ticketId = this.children[0].textContent.trim();
        const employeeName = this.children[1].textContent.trim();
        const subject = this.children[2].textContent.trim();
        const description = this.children[3].textContent.trim();
        const status = this.children[4].textContent.trim();
        const priority = this.children[5].textContent.trim();
        const category = this.children[6].textContent.trim();
        const assignedTo = this.children[7].textContent.trim();
        const startAt =
          this.querySelector(".timer-cell").getAttribute("data-start-at"); // Adjusted to match new structure
        const updatedAt = this.children[10].textContent.trim(); // 11th column remains the same

        // Populate the modal fields
        summarizationFields.ticketIdField.textContent = ticketId;
        summarizationFields.employeeNameField.textContent = employeeName;
        summarizationFields.departmentField.textContent =
          summarizationFields.departmentField.dataset.assigned;
        summarizationFields.subjectField.textContent = subject;
        summarizationFields.categoryField.textContent = category;
        summarizationFields.descriptionField.textContent = description;
        summarizationFields.priorityField.textContent = priority;
        summarizationFields.assignedToField.textContent = assignedTo;
        summarizationFields.statusField.textContent = status;

        // Calculate and populate the duration
        if (Date.parse(startAt) && Date.parse(updatedAt)) {
          const startDate = new Date(startAt);
          const updatedDate = new Date(updatedAt);
          const durationMs = updatedDate - startDate;

          // Convert duration to days, hours, and minutes
          const days = Math.floor(durationMs / (1000 * 60 * 60 * 24));
          const hours = Math.floor(
            (durationMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
          );
          const minutes = Math.floor(
            (durationMs % (1000 * 60 * 60)) / (1000 * 60)
          );
          const seconds = Math.floor((durationMs % (1000 * 60)) / 1000);

          summarizationFields.durationField.textContent = `${days} days, ${hours} hours, ${minutes} minutes, ${seconds} seconds`;
        } else {
          summarizationFields.durationField.textContent = "N/A";
        }

        // Open the modal
        ticketSummarizationModal.style.display = "flex";
      }
    });
  });

  // Close the modals when clicking outside of them
  window.addEventListener("click", function (event) {
    if (event.target === assignTicketModal) {
      assignTicketModal.style.display = "none";
    }
    if (event.target === confirmModal) {
      confirmModal.style.display = "none";
    }
    if (event.target === editStatusModal) {
      editStatusModal.style.display = "none";
    }
    if (event.target === ticketSummarizationModal) {
      ticketSummarizationModal.style.display = "none";
    }
  });

  // Close the modals when clicking the "BACK" button
  const closeModalButtons = document.querySelectorAll(".btnDanger");
  closeModalButtons.forEach((button) => {
    button.addEventListener("click", function () {
      assignTicketModal.style.display = "none";
      confirmModal.style.display = "none";
      editStatusModal.style.display = "none";
      ticketSummarizationModal.style.display = "none";
    });
  });
});

//assign ticket
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

        const row = document.querySelector(`tr[data-id="${ticketId}"]`);
        if (row) {
          const priorityCell = row.querySelector("td:nth-child(6)"); // Assuming the priority column is the 6th column
          if (priorityCell) {
            priorityCell.textContent = priority; // Update the priority in the table
            row.setAttribute("data-priority", priority); // Update the data-priority attribute
          }

          const assignedToCell = row.querySelector("td:nth-child(8)"); // Assuming the assigned_to column is the 8th column
          if (assignedToCell) {
            // Display the name in the table cell
            assignedToCell.textContent = data.assignedToName; // Update the assigned_to with the name

            // Store the ID and name in data attributes for future reference
            row.setAttribute("data-assigned-name", data.assignedToName); // Update the data-assigned-name attribute
            row.setAttribute("data-assigned-id", data.assignedToId); // Update the data-assigned-id attribute
          }
        }
        console.log("Ticket ID:", ticketId);
        console.log("Status:", priority);
        console.log("Assigned To:", assignTo);
        console.log("Row:", row);

        // Close the modal
        document.getElementById("assignTicketModal").style.display = "none";
      }
    } catch (error) {
      console.error("Error updating ticket:", error);
      alert("An error occurred while updating the ticket. Please try again.");
    }
  });
});

//accept ticket
document.addEventListener("DOMContentLoaded", function () {
  // Function to calculate elapsed time
  function calculateElapsedTime(startTime, endTime = null) {
    const startDate = new Date(startTime); // Convert start_at to a Date object
    const endDate = endTime ? new Date(endTime) : new Date(); // Use updated_at if provided, otherwise use current time
    const elapsed = Math.floor((endDate - startDate) / 1000); // Elapsed time in seconds

    const hours = Math.floor(elapsed / 3600);
    const minutes = Math.floor((elapsed % 3600) / 60);
    const seconds = elapsed % 60;

    return `${hours
      .toString()
      .padStart(
        2,
        "0"
      )}:${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
  }

  // Function to update all timer cells
  function updateTimers() {
    const timerCells = document.querySelectorAll(".timer-cell");
    timerCells.forEach((cell) => {
      const startAt = cell.getAttribute("data-start-at");
      const row = cell.closest("tr");
      const updatedAt = row
        .querySelector("td:nth-child(11)")
        ?.textContent.trim(); // Corrected column index
      const status = row.getAttribute("data-status");

      // Stop the timer if updated_at has a value or status is "Resolved"
      if ((updatedAt && updatedAt !== "") || status === "Resolved") {
        // Calculate the elapsed time between startAt and updatedAt
        cell.textContent = calculateElapsedTime(startAt, updatedAt);
        cell.classList.add("stopped"); // Add a class to indicate the timer has stopped
        return;
      }

      if (startAt) {
        cell.textContent = calculateElapsedTime(startAt);
      }
    });
  }

  function updateDurationCell(row, data) {
    const durationCell = row.querySelector("td:nth-child(10)"); // Assuming the duration column is the 10th column
    if (durationCell) {
      const startAt = data.startAt || row.getAttribute("data-start-at");

      // Set the attribute on both row and cell for consistency
      row.setAttribute("data-start-at", startAt);
      durationCell.setAttribute("data-start-at", startAt); // <--- Add this line

      // Call the function to calculate elapsed time and update the cell
      durationCell.textContent = calculateElapsedTime(startAt);
    }
  }
  // Function to handle ticket action (confirm/decline)
  function handleTicketAction(action) {
    const ticketId = document
      .getElementById("confirmTicketID")
      .textContent.trim();

    // Send AJAX request
    fetch("../../0/includes/acceptTicket.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        action: action,
        ticketId: ticketId,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert(data.message); // Show success message

          const row = document.querySelector(`tr[data-id="${ticketId}"]`);
          if (row) {
            const statusCell = row.querySelector("td:nth-child(5)"); // Assuming the status column is the 5th column
            if (statusCell) {
              const status = data.status || "Unknown"; // Fallback to "Unknown" if status is undefined
              statusCell.textContent = status; // Update the status in the table
              row.setAttribute("data-status", status); // Update the data-status attribute
            }
            updateDurationCell(row, data);
          }
          console.log("Ticket ID:", ticketId);
          console.log("Status:", data.status);
          console.log("Row:", row);

          // Close the modal
          document.getElementById("confirmModal").style.display = "none";
        } else {
          alert(data.message); // Show error message
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while processing the request.");
      });
  }
  // Add event listeners for the buttons
  document
    .getElementById("confirmButtonID")
    .addEventListener("click", function (e) {
      e.preventDefault();
      handleTicketAction("confirm");
    });

  document
    .getElementById("declineButtonID")
    .addEventListener("click", function (e) {
      e.preventDefault();
      handleTicketAction("decline");
    });

  // Update timers every second
  setInterval(updateTimers, 1000);

  // Initial update
  updateTimers();
});

document.addEventListener("DOMContentLoaded", function () {
  const allRows = Array.from(
    document.querySelectorAll("#ticketTable tbody tr")
  );
  const tbody = document.querySelector("#ticketTable tbody");
  const paginationContainer = document.getElementById("paginationControls");
  const rowsPerPage = 5;
  let currentPage = 1;
  let currentFilter = "";

  function getRowStatus(row) {
    return row.children[4].textContent.trim();
  }

  function renderTable(filter = "") {
    const filteredRows = filter
      ? allRows.filter((row) => getRowStatus(row) === filter)
      : allRows;
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
    currentPage = Math.min(currentPage, totalPages || 1);
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    tbody.innerHTML = "";
    filteredRows.slice(start, end).forEach((row) => tbody.appendChild(row));
    renderPaginationButtons(totalPages);
  }
  let paginationStart = 1; // Tracks which set of pages we're viewing

  function renderPaginationButtons(totalPages) {
    paginationContainer.innerHTML = "";

    const maxVisible = 10;
    const paginationEnd = Math.min(
      paginationStart + maxVisible - 1,
      totalPages
    );

    // Left arrow (go back 10 pages)
    if (paginationStart > 1) {
      const leftArrow = document.createElement("button");
      leftArrow.textContent = "←";
      leftArrow.addEventListener("click", () => {
        paginationStart = Math.max(1, paginationStart - maxVisible);
        renderPaginationButtons(totalPages);
      });
      paginationContainer.appendChild(leftArrow);
    }

    // Page number buttons
    for (let i = paginationStart; i <= paginationEnd; i++) {
      const btn = document.createElement("button");
      btn.textContent = i;
      btn.className = i === currentPage ? "active" : "";
      btn.style.margin = "0 5px";
      btn.style.minWidth = "22px";
      btn.addEventListener("click", () => {
        currentPage = i;
        renderTable(currentFilter);
      });
      paginationContainer.appendChild(btn);
    }

    // Right arrow (go forward 10 pages)
    if (paginationEnd < totalPages) {
      const rightArrow = document.createElement("button");
      rightArrow.textContent = "→";
      rightArrow.addEventListener("click", () => {
        paginationStart = paginationStart + maxVisible;
        renderPaginationButtons(totalPages);
      });
      paginationContainer.appendChild(rightArrow);
    }
  }

  const plateIDs = ["plate1", "plate2", "plate3"];
  plateIDs.forEach((id) => {
    const plate = document.getElementById(id);
    if (plate) {
      plate.addEventListener("click", function () {
        currentFilter = this.getAttribute("data-status") || "";
        currentPage = 1;
        paginationStart = 1; // ✅ Reset pagination to start from 1
        renderTable(currentFilter);
      });
    }
  });
  renderTable();
});
