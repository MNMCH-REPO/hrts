document.addEventListener("DOMContentLoaded", function () {
    function fetchTickets(status = "") {
        let url = `platesHRFilter.php?page=1`;
        if (status) {
            url += `&status=${encodeURIComponent(status)}`;
        }

        console.log("Fetching tickets from:", url); // Debugging line

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Received data:", data); // Debugging line

                const tableBody = document.querySelector("#ticketTable tbody");
                tableBody.innerHTML = "";

                if (!data.tickets || data.tickets.length === 0) {
                    tableBody.innerHTML = "<tr><td colspan='9'>No records found</td></tr>";
                    return;
                }

                data.tickets.forEach(ticket => {
                    let row = `<tr>
                        <td>${ticket.id}</td>
                        <td>${ticket.employee_name || "N/A"}</td>
                        <td>${ticket.employee_department || "N/A"}</td>
                        <td>${ticket.subject || "N/A"}</td>
                        <td>${ticket.status || "N/A"}</td>
                        <td>${ticket.priority || "N/A"}</td>
                        <td>${ticket.category_name || "N/A"}</td>
                        <td>${ticket.assigned_to_name || "N/A"}</td>
                        <td>${ticket.created_at || "N/A"}</td>
                    </tr>`;
                    tableBody.innerHTML += row;
                });
            })
            .catch(error => console.error("Error fetching tickets:", error));
    }

    // Ensure buttons exist before adding event listeners
    ["plate1", "plate2", "plate3"].forEach(id => {
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
        row.addEventListener("click", function () {
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

    // Close the modal when clicking outside of it
    window.addEventListener("click", function (event) {
        if (event.target === confirmModal) {
            confirmModal.style.display = "none";
        }
    });

    // Close the modal when clicking the "BACK" button
    const closeModalButton = document.querySelector(".btnDanger");
    closeModalButton.addEventListener("click", function () {
        confirmModal.style.display = "none";
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
    const searchInput = document.querySelector(".search-input");
    const filterButton = document.querySelector(".filter-btn");
    const table = document.querySelector("#ticketTable tbody");

    // Search functionality
    searchInput.addEventListener("keyup", function () {
        const filter = searchInput.value.toLowerCase();
        const rows = table.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let found = false;

            for (let j = 0; j < cells.length; j++) {
                if (cells[j] && cells[j].textContent.toLowerCase().includes(filter)) {
                    found = true;
                    break;
                }
            }

            rows[i].style.display = found ? "" : "none";
        }
    });

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

document.addEventListener("DOMContentLoaded", function () {
    // Open modal function
    function openModal() {
        document.getElementById("addTicketModal").style.display = "flex";

        
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
