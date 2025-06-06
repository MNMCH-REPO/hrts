document.addEventListener("DOMContentLoaded", function () {
  function fetchTickets(status = "") {
    let url = `platesHRFilter.php?page=1`;
    if (status) {
      url += `&status=${encodeURIComponent(status)}`;
    }

    console.log("Fetching tickets from:", url); // Debugging line
  }

  // Ensure buttons exist before adding event listeners
  ["plate1", "plate2", "plate3"].forEach((id) => {
    const button = document.getElementById(id);
    if (button) {
      button.addEventListener("click", function () {
        const status = this.getAttribute("data-status");
        if (status) {
          console.log(`Filtering tickets by status: ${status}`); // Debugging line
          fetchTickets(status);
        } else {
          console.error(`No data-status attribute found for button #${id}`);
        }
      });
    } else {
      console.error(`Button #${id} not found`);
    }
  });

  // Fetch all tickets on page load
  fetchTickets();
});

//timer
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
        .querySelector("td:nth-child(12)")
        ?.textContent.trim(); // Updated At column
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
  const tableRows = document.querySelectorAll("tbody tr");
  const confirmModal = document.getElementById("confirmModal");
  const editStatusModal = document.getElementById("editStatusModal");
  const ticketSummarizationModal = document.getElementById(
    "ticketSummarizationModal"
  );

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
  const editStatusModalFields = {
    ticketIdField: document.getElementById("editTicketID"),
    employeeNameField: document.getElementById("editemployeeID"),
    departmentField: document.getElementById("editdepartmentID"),
    subjectField: document.getElementById("editsubjectID"),
    categoryField: document.getElementById("editcategoryID"),
    descriptionField: document.getElementById("editdescriptionID"),
    priorityField: document.getElementById("editpriorityID"),
    assignedToField: document.getElementById("editassignedID"),
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
      const assignedDepartment = this.children[2].textContent.trim();
      const subject = this.children[3].textContent.trim();
      const description = this.children[4].textContent.trim();
      const status = this.children[5].textContent.trim();
      const priority = this.children[6].textContent.trim();
      const category = this.children[7].textContent.trim();
      const assignedTo = this.children[8].textContent.trim();
      const startAt = this.getAttribute("data-start-at");
      const updatedAt = this.children[11]?.textContent.trim();

      // Get the current user from the session
      const currentUser = document
        .querySelector(".accountName")
        .textContent.trim();

      // Check the status and assigned user
      if (status === "Open"  && assignedTo.toLowerCase() === currentUser.toLowerCase()) {
        // Set the values in the confirmModal
        confirmModalFields.ticketIdField.textContent = ticketId;
        confirmModalFields.employeeNameField.textContent = employeeName;
        confirmModalFields.departmentField.textContent = assignedDepartment;
        confirmModalFields.subjectField.textContent = subject;
        confirmModalFields.categoryField.textContent = category;
        confirmModalFields.descriptionField.textContent = description;
        confirmModalFields.priorityField.textContent = priority;
        confirmModalFields.assignedToField.textContent = assignedTo;
        confirmModalFields.statusField.textContent = status;

        // Open the confirmModal
        confirmModal.style.display = "flex";
      } else if (status === "In Progress" && assignedTo.toLowerCase() === currentUser.toLowerCase()) {
        // Set the values in the editStatusModal
        editStatusModalFields.ticketIdField.textContent = ticketId;
        editStatusModalFields.employeeNameField.textContent = employeeName;
        editStatusModalFields.departmentField.textContent = assignedDepartment;
        editStatusModalFields.subjectField.textContent = subject;
        editStatusModalFields.categoryField.textContent = category;
        editStatusModalFields.descriptionField.textContent = description;
        editStatusModalFields.priorityField.textContent = priority;
        editStatusModalFields.assignedToField.textContent = assignedTo;

        // Open the editStatusModal
        editStatusModal.style.display = "flex";
      } else if (status === "Resolved") {
        // Populate the modal fields
        console.log("Resolved ticket clicked:", ticketId); // Debugging line
        console.log("Childeren:", this.children); // Debugging line
        summarizationFields.ticketIdField.textContent = ticketId;
        summarizationFields.employeeNameField.textContent = employeeName;
        editStatusModalFields.departmentField.textContent = assignedDepartment;
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

        ticketSummarizationModal.style.display = "flex";

      }
    });
  });

  // Close the modal when clicking outside of it
  window.addEventListener("click", function (event) {
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

  // Close the modal when clicking the "BACK" button
  const closeModalButtons = document.querySelectorAll(".btnDanger");
  closeModalButtons.forEach((button) => {
    button.addEventListener("click", function () {
      confirmModal.style.display = "none";
      editStatusModal.style.display = "none";
      ticketSummarizationModal.style.display = "none";
    });
  });
});

//filter
document.addEventListener("DOMContentLoaded", function () {
  const filterButton = document.getElementById("filterButton");

  if (!filterButton) {
    console.warn("⚠️ 'filterButton' not found in the DOM.");
    return;
  }

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
        { column: 6, label: "Priority" },
        { column: 7, label: "Category" },
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
    const table = document.querySelector("#ticketTable"); // Ensure the table is selected
    if (!table) {
      console.error("Table element not found.");
      return;
    }
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

//status form
document.addEventListener("DOMContentLoaded", function () {
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
        .querySelector("td:nth-child(12)")
        ?.textContent.trim(); // Corrected column index
      const status = row.getAttribute("data-status");

      if (startAt) {
        cell.textContent = calculateElapsedTime(startAt);
      }
    });
  }

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
        alert(data.message);

        const row = document.querySelector(`tr[data-id="${ticketId}"]`);
        let updatedAt = ""; // 🔧 Declare updatedAt in outer scope

        if (row) {
          const statusCell = row.querySelector("td:nth-child(6)");
          if (statusCell) {
            statusCell.textContent = status;
            row.setAttribute("data-status", status);
          }

          updatedAt =
            data.updatedAt ||
            (() => {
              const now = new Date();
              const gmt8 = new Date(now.getTime() + 8 * 60 * 60 * 1000);
              const year = gmt8.getUTCFullYear();
              const month = String(gmt8.getUTCMonth() + 1).padStart(2, "0");
              const day = String(gmt8.getUTCDate()).padStart(2, "0");
              const hours = String(gmt8.getUTCHours()).padStart(2, "0");
              const minutes = String(gmt8.getUTCMinutes()).padStart(2, "0");
              const seconds = String(gmt8.getUTCSeconds()).padStart(2, "0");
              return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            })();

          const updatedCell = row.querySelector("td:nth-child(12)");
          if (updatedCell) {
            updatedCell.textContent = updatedAt;
            row.setAttribute("data-updated-at", updatedAt);
          }

          const startAt = row
            .querySelector(".timer-cell")
            ?.getAttribute("data-start-at");
          const cell = row.querySelector(".timer-cell");

          if ((updatedAt && updatedAt !== "") || status === "Resolved") {
            if (startAt && cell) {
              cell.textContent = calculateElapsedTime(startAt, updatedAt);
              cell.classList.add("stopped");
            }
          }

          updateTimers();
        }

        console.log("Ticket ID:", ticketId);
        console.log("Status:", status);
        console.log("Updated At:", updatedAt);
        console.log("Row:", row);

        document.getElementById("editStatusModal").style.display = "none";
      } else {
        alert(data.message); // Show error message
      }
    } catch (error) {
      console.error("Error updating status:", error);
      alert("An error occurred while updating the status. Please try again.");
    }

    // Initial update
    updateTimers();
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
        .querySelector("td:nth-child(12)")
        ?.textContent.trim(); // Corrected column index
      const status = row.getAttribute("data-status");

      // Stop the timer if updated_at has a value or status is "Resolved"
      if ((updatedAt && updatedAt !== "") || status === "Resolved") {
        // Calculate the elapsed time between startAt and updatedAt
        // cell.textContent = calculateElapsedTime(startAt, updatedAt);
        cell.classList.add("stopped"); // Add a class to indicate the timer has stopped
        return;
      }

      if (startAt) {
        cell.textContent = calculateElapsedTime(startAt);
      }
    });
  }

  function updateDurationCell(row, data) {
    const durationCell = row.querySelector("td:nth-child(11)"); // Assuming the duration column is the 10th column
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
            const statusCell = row.querySelector("td:nth-child(6)"); // Assuming the status column is the 5th column
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
      console.log("runs......");
      location.reload();
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

// document.addEventListener("DOMContentLoaded", function () {
//   const plate = document.getElementById("plate1");

//   plate.addEventListener("click", function () {
//     const selectedStatus = this.getAttribute("data-status");
//     const rows = document.querySelectorAll("#ticketTable tbody tr");

//     rows.forEach((row) => {
//       const rowStatus = row.getAttribute("data-status");

//       if (rowStatus === selectedStatus) {
//         row.style.display = "";
//       } else {
//         row.style.display = "none";
//       }
//     });
//   });
// });

// document.addEventListener("DOMContentLoaded", function () {
//   const plate = document.getElementById("plate2");

//   plate.addEventListener("click", function () {
//     const selectedStatus = this.getAttribute("data-status");
//     const rows = document.querySelectorAll("#ticketTable tbody tr");

//     rows.forEach((row) => {
//       const rowStatus = row.getAttribute("data-status");

//       if (rowStatus === selectedStatus) {
//         row.style.display = "";
//       } else {
//         row.style.display = "none";
//       }
//     });
//   });
// });

// document.addEventListener("DOMContentLoaded", function () {
//   const plate = document.getElementById("plate3");

//   plate.addEventListener("click", function () {
//     const selectedStatus = this.getAttribute("data-status");
//     const rows = document.querySelectorAll("#ticketTable tbody tr");

//     rows.forEach((row) => {
//       const rowStatus = row.getAttribute("data-status");

//       if (rowStatus === selectedStatus) {
//         row.style.display = "";
//       } else {
//         row.style.display = "none";
//       }
//     });
//   });
// });

//search
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

      if (isStatusMatch && isSearchMatch) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }

  const plateIDs = ["plate1", "plate2", "plate3"];
  plateIDs.forEach((id) => {
    const plate = document.getElementById(id);
    if (plate) {
      plate.addEventListener("click", function () {
        selectedStatus = this.getAttribute("data-status");
        searchInput.value = "";
        filterTable();
      });
    }
  });

  searchInput.addEventListener("input", function () {
    filterTable();
  });
});
