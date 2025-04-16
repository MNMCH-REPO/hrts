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
  



  document.addEventListener("DOMContentLoaded", function () {
    const tableRows = document.querySelectorAll("tbody tr");
    const confirmModal = document.getElementById("confirmModal");
    const editStatusModal = document.getElementById("editStatusModal");

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

            // Get the current user from the session
            const currentUser = document.querySelector(".accountName").textContent.trim();

            // Check the status and assigned user
            if (status === "Open" && assignedTo === currentUser) {
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
            } else if (status === "In Progress" && assignedTo === currentUser) {
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
    });

    // Close the modal when clicking the "BACK" button
    const closeModalButtons = document.querySelectorAll(".btnDanger");
    closeModalButtons.forEach((button) => {
        button.addEventListener("click", function () {
            confirmModal.style.display = "none";
            editStatusModal.style.display = "none";
        });
    });
});
  
  document.addEventListener("DOMContentLoaded", function () {
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
            alert(data.message);
            // Optionally reload the page or update the UI
            location.reload();
          } else {
            alert(data.message);
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("An error occurred while processing the request.");
        });
    }
  });
  
  document.addEventListener("DOMContentLoaded", function () {
    // const searchInput = document.querySelector(".search-input");
    // const filterButton = document.querySelector(".filter-btn");
    // const table = document.querySelector("#ticketTable tbody");
  
    // // Search functionality
    // searchInput.addEventListener("keyup", function () {
    //   const filter = searchInput.value.toLowerCase();
    //   const rows = table.getElementsByTagName("tr");
  
    //   for (let i = 0; i < rows.length; i++) {
    //     const cells = rows[i].getElementsByTagName("td");
    //     let found = false;
  
    //     for (let j = 0; j < cells.length; j++) {
    //       if (cells[j] && cells[j].textContent.toLowerCase().includes(filter)) {
    //         found = true;
    //         break;
    //       }
    //     }
  
    //     rows[i].style.display = found ? "" : "none";
    //   }
    // });
  
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




  
        document.addEventListener("DOMContentLoaded", function() {
            const editStatusForm = document.getElementById("editStatusForm");

            editStatusForm.addEventListener("submit", async function(event) {
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
                    const response = await fetch("../../0/includes/hrEdtiTicketStatus.php", {
                        method: "POST",
                        body: formData,
                    });

                    // Parse the JSON response
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
    

    
        document.addEventListener("DOMContentLoaded", function() {
            const plate = document.getElementById("plate1");

            plate.addEventListener("click", function() {
                const selectedStatus = this.getAttribute("data-status");
                const rows = document.querySelectorAll("#ticketTable tbody tr");

                rows.forEach(row => {
                    const rowStatus = row.getAttribute("data-status");

                    if (rowStatus === selectedStatus) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const plate = document.getElementById("plate2");

            plate.addEventListener("click", function() {
                const selectedStatus = this.getAttribute("data-status");
                const rows = document.querySelectorAll("#ticketTable tbody tr");

                rows.forEach(row => {
                    const rowStatus = row.getAttribute("data-status");

                    if (rowStatus === selectedStatus) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const plate = document.getElementById("plate3");

            plate.addEventListener("click", function() {
                const selectedStatus = this.getAttribute("data-status");
                const rows = document.querySelectorAll("#ticketTable tbody tr");

                rows.forEach(row => {
                    const rowStatus = row.getAttribute("data-status");

                    if (rowStatus === selectedStatus) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });



        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchInput");
            const rows = document.querySelectorAll("#ticketTable tbody tr");
            let selectedStatus = "";

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();

                rows.forEach(row => {
                    const rowStatus = row.getAttribute("data-status");
                    const rowText = row.textContent.toLowerCase();

                    const isStatusMatch = selectedStatus === "" || rowStatus === selectedStatus;
                    const isSearchMatch = rowText.includes(searchTerm);

                    if (isStatusMatch && isSearchMatch) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }


            const plateIDs = ["plate1", "plate2", "plate3"];
            plateIDs.forEach(id => {
                const plate = document.getElementById(id);
                if (plate) {
                    plate.addEventListener("click", function() {
                        selectedStatus = this.getAttribute("data-status");
                        searchInput.value = "";
                        filterTable();
                    });
                }
            });

            searchInput.addEventListener("input", function() {
                filterTable();
            });
        });
  