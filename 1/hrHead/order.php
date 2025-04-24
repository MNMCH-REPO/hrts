<?php
require_once '../../0/includes/employeeTicket.php';
require_once '../../0/includes/hrHeadQuery.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/framework.css">
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <title>HRTS</title>
</head>
<style>
        .time-btn {
            padding: 8px 16px;
            border: 1px solid var(--neutral-300);
            background-color: var(--white);
            color: var(--black);
            border-radius: 4px;
            cursor: pointer;
            transition: var(--fast);
        }
        .time-btn:hover {
            background-color: var(--neutral-200);
        }
        .time-btn.active {
            background-color: var(--primary-500);
            color: var(--white);
            border-color: var(--primary-500);
        }
        .report-card {
            padding: 16px;
            border: 3px solid var(--neutral-300);
            border-radius: 8px;
            background-color: var(--white);
            cursor: pointer;
            transition: var(--fast);
            margin-bottom: 12px;
        }
        .report-card:hover {
            background-color: var(--neutral-200);
        }
        .report-card.selected {
            color: var(--white);
            border-color: var(--primary-500);
        }
    </style>
<body>
    <div class="container">
        <div class="sideNav">
            <div class="sideNavLogo img-cover"></div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/ticket.png);"></div>
                <a href="order.php">Oders</a>
            </div>

            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/settings.png);"></div>
                <a href="account.php">Account</a>
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

            <div class="row plateRow">
                <!-- Plates -->
                <div class="col plate" id="plate1" data-status="status">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/time-left.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Pending</div>
                        <div class="plateValue">
                            <?= isset($openTickets[0]['open_tickets']) ? htmlspecialchars($openTickets[0]['open_tickets']) : '0' ?>
                        </div>
                    </div>
                </div>

                <div class="col plate" id="plate2" data-status="status">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/hourglass.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">In Progress</div>
                        <div class="plateValue">
                            <?= isset($inprogressTickets[0]['inprogress_tickets']) ? htmlspecialchars($inprogressTickets[0]['inprogress_tickets']) : '0' ?>
                        </div>
                    </div>
                </div>

                <div class="col plate" id="plate3" data-status="status">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/ethics.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Resolved</div>
                        <div class="plateValue">
                            <?= isset($resolvedTickets[0]['resolved_tickets']) ? htmlspecialchars($resolvedTickets[0]['resolved_tickets']) : '0' ?>
                        </div>
                    </div>
                </div>

                <div class="col plate" id="plate4" data-status="status">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/ethics.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Rejected</div>
                        <div class="plateValue">
                            <?= htmlspecialchars(array_sum(array_column($rejectedTickets, 'rejected_count'))) ?>
                        </div>
                    </div>
                </div>

                <div class="col plate" id="plate5" data-status="status">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/ethics.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Total Tickets</div>
                        <div class="plateValue">
                            <?= isset($totalTickets[0]['total_tickets']) ? htmlspecialchars($totalTickets[0]['total_tickets']) : '0' ?>
                        </div>
                    </div>
                </div>
                <div class="col plate" id="plate6" data-status="Download">
                    <div class="plateIcon" style="background-image: url(../../assets/images/icons/folder.png);"></div>
                    <div class="plateContent">
                        <div class="plateTitle">Download</div>
                        <div class="plateValue"></div>
                    </div>
                </div>
            </div>




            <div class="pagination-wrapper">
                <div class="pagination" id="pageNationID">
                    <div id="paginationControls" class="mt-3"></div>
                </div>


                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="SEARCH..." class="search-input">
                    <div class="search-icon">
                        <img src="../../assets/images/icons/search.png" alt="Search">
                    </div>
                    <button id="filterButton" class="filter-btn">
                        <img src="../../assets/images/icons/sort.png" alt="Filter"> FILTER
                    </button>
                </div>
            </div>

            <div class="tableContainer">
                <table id="ticketTable" class="table">
                    <div class="table-title" style="text-align: center;">
                        <h2>Tickets</h2>
                        <p>List of tickets with their details.</p>

                    </div>
                    <thead>
                        <tr>
                            <th>ID <i class="fas fa-sort"></i></th>
                            <th>Employee Name <i class="fas fa-sort"></i></th>
                            <th>Department <i class="fas fa-sort"></i></th>
                            <th>Subject <i class="fas fa-sort"></i></th>
                            <th>Description <i class="fas fa-sort"></i></th>
                            <th>Status <i class="fas fa-sort"></i></th>
                            <th>Priority <i class="fas fa-sort"></i></th>
                            <th>Category ID <i class="fas fa-sort"></i></th>
                            <th>Assigned To <i class="fas fa-sort"></i></th>
                            <th>Created At <i class="fas fa-sort"></i></th>
                            <th>Duration <i class="fas fa-sort"></i></th>
                            <th>Updated At <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tickets)): ?>
                            <?php foreach ($tickets as $ticket): ?>
                                <tr data-id="<?= htmlspecialchars($ticket['id']) ?>"
                                    data-status="<?= htmlspecialchars($ticket['status']) ?>"
                                    data-priority="<?= htmlspecialchars($ticket['priority']) ?>"
                                    data-category="<?= htmlspecialchars($ticket['category_name']) ?>"
                                    data-assigned-name="<?= htmlspecialchars($ticket['assigned_to_name']) ?>"
                                    data-created-at="<?= htmlspecialchars($ticket['created_at']) ?>"
                                    data-start-at="<?= htmlspecialchars($ticket['start_at']) ?>"
                                    data-updated-at="<?= htmlspecialchars($ticket['updated_at']) ?>">


                                    <td><?= htmlspecialchars($ticket['id']) ?></td>
                                    <td><?= htmlspecialchars($ticket['employee_name']) ?></td>
                                    <td><?= htmlspecialchars($ticket['assigned_department']) ?></td>
                                    <td><?= htmlspecialchars($ticket['subject']) ?></td>
                                    <td><?= htmlspecialchars($ticket['description']) ?></td>
                                    <td><?= htmlspecialchars($ticket['status']) ?></td>
                                    <td><?= htmlspecialchars($ticket['priority']) ?></td>
                                    <td><?= htmlspecialchars($ticket['category_name']) ?></td>
                                    <td><?= htmlspecialchars($ticket['assigned_to_name']) ?></td>
                                    <td><?= htmlspecialchars($ticket['created_at']) ?></td>
                                    <td class="timer-cell" data-start-at="<?= htmlspecialchars($ticket['start_at']) ?>"></td>
                                    <td><?= htmlspecialchars($ticket['updated_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="12" style="text-align: center;">No tickets found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>


            </div>
            <br>
            <br><br>

            <div class="tableContainer">
                <table id="topAccountMostSolved" class="table">
                    <div class="table-title" style="text-align: center;">
                        <h2>Top HR Employees with Most Resolved Tickets</h2>
                        <p>List of HR employees with the highest number of resolved tickets.</p>
                    </div>
                    <thead>
                        <tr>
                            <th>ID <i class="fas fa-sort"></i></th>
                            <th>Employee Name <i class="fas fa-sort"></i></th>
                            <th>Total Resolved <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($topResolvedAccounts)): ?>
                            <?php foreach ($topResolvedAccounts as $account): ?>
                                <tr>
                                    <td><?= htmlspecialchars($account['user_id']) ?></td>
                                    <td><?= htmlspecialchars($account['employee_name']) ?></td>
                                    <td><?= htmlspecialchars($account['resolved_count']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align: center;">No resolved tickets found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <br><br><br>
        </div>


        <div id="reportModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Generate Report</h2>
            <div class="time-options">
                <button class="time-btn">Today</button>
                <button class="time-btn">This week</button>
                <button class="time-btn">This month</button>
                <button class="time-btn">Custom</button>
            </div>

            <div class="date-range">
                <label>From: <input type="date" id="startDate"></label>
                <label>To: <input type="date" id="endDate"></label>
            </div>

            <div class="report-options">
                <div class="report-card">
                    <h3>Generate Overall Tickets</h3>
                    <p>This will generate sample rows ("Open, In Progress, Resolved").</p>
                </div>

                <div class="report-card">
                    <h3>Generate Tickets per Employee</h3>
                    <label>Type:
                        <select>
                            <option>Please select a category</option>
                        </select>
                    </label>
                    <label>Name: <input type="text" placeholder="Enter Name"></label>
                </div>

                <div class="report-card">
                    <h3>Generate Tickets per Department</h3>
                    <label>Type:
                        <select>
                            <option>Please select a category</option>
                        </select>
                    </label>
                </div>
            </div>

            <button id="downloadReport">Download Report</button>
        </div>
    </div>




    <!-- Ticket Summarization Modal -->
    <div id="ticketSummarizationModal" class="modal">
        <div class="modal-content">
            <h1 class="modal-title">Ticket Summarization</h1>

            <form id="ticketSummarizationForm" method="POST">
                <div class="input-container">
                    <h1><strong>Ticket ID:</strong></h1>
                    <p class="center-text" id="summarizationTicketID"><?= htmlspecialchars($ticket['id'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Employee Name:</strong></h1>
                    <p class="center-text" id="summarizationEmployeeName"><?= htmlspecialchars($ticket['employee_name'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Department:</strong></h1>
                    <p class="center-text" id="summarizationDepartment" data-assigned="<?= htmlspecialchars($ticket['assigned_department']) ?>">Unassigned</p>
                </div>

                <div class="input-container">
                    <h1><strong>Subject:</strong></h1>
                    <p class="center-text" id="summarizationSubject"><?= htmlspecialchars($ticket['subject'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Category:</strong></h1>
                    <p class="center-text" id="summarizationCategory"><?= htmlspecialchars($ticket['category'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Description:</strong></h1>
                    <p class="center-text" id="summarizationDescription"><?= htmlspecialchars($ticket['description'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Priority:</strong></h1>
                    <p class="center-text" id="summarizationPriority"><?= htmlspecialchars($ticket['priority'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Assigned To:</strong></h1>
                    <p class="center-text" id="summarizationAssignedTo"><?= htmlspecialchars($ticket['assigned_to_name'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Status:</strong></h1>
                    <p class="center-text" id="summarizationStatus"><?= htmlspecialchars($ticket['status'] ?? 'N/A') ?></p>
                </div>

                <div class="input-container">
                    <h1><strong>Duration:</strong></h1>
                    <p class="center-text" id="summarizationDuration" data-assigned="<?= htmlspecialchars($ticket['start_at']) ?>">Unassigned</p>
                </div>

                <div class="btnContainer">
                    <button type="button" class="btnDanger" onclick="closeModal()">BACK</button>
                </div>
            </form>
        </div>
    </div>




        <script src="../../assets/js/framework.js"></script>
        <script>

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


//ticket summarization modal
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

       if (status === "Resolved") {
        // Populate the modal fields

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
        logModalOpened("Ticket Summarization Modal", {
          ticketId,
          employeeName,
          department,
          subject,
          description,
          status,
          priority,
          category,
          assignedTo,
        });
      }
    });
  });

  // Close the modal when clicking outside of it
  window.addEventListener("click", function (event) {
    if (event.target === ticketSummarizationModal) {
      ticketSummarizationModal.style.display = "none";
    }
  });

  // Close the modal when clicking the "BACK" button
  const closeModalButtons = document.querySelectorAll(".btnDanger");
  closeModalButtons.forEach((button) => {
    button.addEventListener("click", function () {
      ticketSummarizationModal.style.display = "none";
    });
  });
});




    //filter modals search
        document.addEventListener("DOMContentLoaded", function() {
            const allRows = Array.from(document.querySelectorAll("#ticketTable tbody tr"));
            const tbody = document.querySelector("#ticketTable tbody");
            const paginationContainer = document.getElementById("paginationControls");
            const rowsPerPage = 5;
            let currentPage = 1;
            let currentFilter = "";

            function getRowStatus(row) {
                return row.children[4].textContent.trim();
            }

            function renderTable(filter = "") {
                const filteredRows = filter ? allRows.filter(row => getRowStatus(row) === filter) : allRows;
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                currentPage = Math.min(currentPage, totalPages || 1);
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                tbody.innerHTML = "";
                filteredRows.slice(start, end).forEach(row => tbody.appendChild(row));
                renderPaginationButtons(totalPages);
            }
            let paginationStart = 1; // Tracks which set of pages we're viewing

            function renderPaginationButtons(totalPages) {
                paginationContainer.innerHTML = "";

                const maxVisible = 10;
                const paginationEnd = Math.min(paginationStart + maxVisible - 1, totalPages);

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

            const plateIDs = ["plate1", "plate2", "plate3", "plate4", "plate5"];
            plateIDs.forEach(id => {
                const plate = document.getElementById(id);
                if (plate) {
                    plate.addEventListener("click", function() {
                        currentFilter = this.getAttribute("data-status") || "";
                        currentPage = 1;
                        paginationStart = 1; // ✅ Reset pagination to start from 1
                        renderTable(currentFilter);

                    });
                }
            });
            renderTable();
        });

        //open modal
        document.addEventListener("DOMContentLoaded", function() {
            let modal = document.getElementById("reportModal");
            let downloadPlate = document.getElementById("plate6");
            let closeModal = document.querySelector(".close");

            // Show modal when clicking the download plate
            downloadPlate.addEventListener("click", function() {
                modal.style.display = "block";
            });

            // Close modal when clicking the close button
            closeModal.addEventListener("click", function() {
                modal.style.display = "none";
            });

            // Close modal when clicking outside the content
            window.addEventListener("click", function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });



        //report function  
        document.addEventListener("DOMContentLoaded", function () {
            const timeButtons = document.querySelectorAll(".time-btn");
            const startDateInput = document.getElementById("startDate");
            const endDateInput = document.getElementById("endDate");
            const reportCards = document.querySelectorAll(".report-card");
            function setTodayRange() {
                const today = new Date();
                const formattedDate = today.toISOString().split("T")[0]; // Format as YYYY-MM-DD
                startDateInput.value = formattedDate;
                endDateInput.value = formattedDate;
            }
            const defaultTimeButton = document.querySelector(".time-btn:nth-child(1)");
            defaultTimeButton.classList.add("active");
            setTodayRange();

            // Add click event listeners to time buttons
            timeButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    // Remove active class from all buttons
                    timeButtons.forEach((btn) => btn.classList.remove("active"));

                    // Add active class to the clicked button
                    this.classList.add("active");

                    // Set date range based on the selected button
                    if (this.textContent === "Today") {
                        setTodayRange();
                    } else if (this.textContent === "This week") {
                        const today = new Date();
                        const firstDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                        const lastDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay() + 6));
                        startDateInput.value = firstDayOfWeek.toISOString().split("T")[0];
                        endDateInput.value = lastDayOfWeek.toISOString().split("T")[0];
                    } else if (this.textContent === "This month") {
                        const today = new Date();
                        const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                        const lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                        startDateInput.value = firstDayOfMonth.toISOString().split("T")[0];
                        endDateInput.value = lastDayOfMonth.toISOString().split("T")[0];
                    } else if (this.textContent === "Custom") {
                        startDateInput.value = "";
                        endDateInput.value = "";
                    }
                });
            });

            // Set default selected report card
            const defaultReportCard = document.querySelector(".report-card:nth-child(1)");
            defaultReportCard.classList.add("selected");

            // Add click event listeners to report cards
            reportCards.forEach((card) => {
                card.addEventListener("click", function () {
                    // Remove selected class from all report cards
                    reportCards.forEach((c) => c.classList.remove("selected"));

                    // Add selected class to the clicked card
                    this.classList.add("selected");
                });
            });
        });
    </script>


</body>

</html>