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

document.addEventListener("DOMContentLoaded", function() {
    const tableRows = document.querySelectorAll("tbody tr");
    const confirmModal = document.getElementById("confirmModal");

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

    // Add click event listener to each row
    tableRows.forEach((row) => {
        row.addEventListener("click", function() {
            // Remove highlight from all rows
            tableRows.forEach((r) => r.classList.remove("highlighted"));

            // Highlight the clicked row
            this.classList.add("highlighted");

            // Get the values from the clicked row
            const ticketId = this.children[0].textContent.trim();
            const employeeName = this.children[1].textContent.trim();
            const assigned_department = this.children[2].textContent.trim();
            const subject = this.children[3].textContent.trim();
            const description = this.children[4].textContent.trim();
            const status = this.children[5].textContent.trim();
            const priority = this.children[6].textContent.trim();
            const category = this.children[7].textContent.trim();
            const assignedTo = this.children[8].textContent.trim();

            // Set the values in the confirmModal
            confirmModalFields.ticketIdField.textContent = ticketId;
            confirmModalFields.employeeNameField.textContent = employeeName;
            confirmModalFields.departmentField.textContent = assigned_department;
            confirmModalFields.subjectField.textContent = subject;
            confirmModalFields.categoryField.textContent = category;
            confirmModalFields.descriptionField.textContent = description;
            confirmModalFields.priorityField.textContent = priority;
            confirmModalFields.assignedToField.textContent = assignedTo;
            confirmModalFields.statusField.textContent = status;

            // Open the confirmModal
            confirmModal.style.display = "flex";
        });
    });

    // Close the modal when clicking the "BACK" button
    const closeModalButton = document.getElementById("confirmBack");
    closeModalButton.addEventListener("click", function() {
        confirmModal.style.display = "none";
    });

    // Close the modal when clicking outside of it
    window.addEventListener("click", function(event) {
        if (event.target === confirmModal) {
            confirmModal.style.display = "none";
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    // Add event listeners for the buttons
    document
        .getElementById("confirmButtonID")
        .addEventListener("click", function(e) {
            e.preventDefault();
            handleTicketAction("confirm");
        });

    document
        .getElementById("declineButtonID")
        .addEventListener("click", function(e) {
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



document.addEventListener("DOMContentLoaded", function() {

    const filterButton = document.querySelector(".filter-btn");


    // Filter dropdown functionality
    filterButton.addEventListener("click", function() {
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
            const filters = [{
                    column: 5,
                    label: "Status"
                },
                {
                    column: 6,
                    label: "Priority"
                },
                {
                    column: 7,
                    label: "Category"
                },
            ];

            filters.forEach((filter) => {
                const option = document.createElement("div");
                option.textContent = filter.label;
                option.style.cursor = "pointer";
                option.style.padding = "5px 10px";
                option.addEventListener("click", function() {
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
                        cell.textContent.trim().toLowerCase() === filterValue.toLowerCase() ?
                        "" :
                        "none";
                }
            }
        }
    }
});

document.addEventListener("DOMContentLoaded", function() {
    // Open modal function
    function openModal() {
        document.getElementById("addTicketModal").style.display = "flex";

        // Auto-fill department correctly

        let departmentField = document.getElementById("departmentInputField");

        if (departmentField) {
            departmentField = document.getElementById("departmentInputField");
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
        .addEventListener("submit", function(e) {
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
document.addEventListener("DOMContentLoaded", function() {
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