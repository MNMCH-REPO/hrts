document.addEventListener("DOMContentLoaded", function() {
    // Open modal function
    function openModal() {
        document.getElementById("addAccountModal").style.display = "flex";
    }

    // Make the function globally accessible
    window.openModal = openModal;

    // Attach event listener to "ADD ACCOUNT" button
    document.getElementById("addAccountID").addEventListener("click", openModal);

    // Close modal function
    function closeModal() {
        document.getElementById("addAccountModal").style.display = "none";
    }

    window.closeModal = closeModal;

    // Submit form via AJAX
    document.getElementById("addAccountForm").addEventListener("submit", function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch("../../0/includes/createAccount.php", { // Update the URL to match the correct PHP script
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log("✅ Response Data:", data); // Log the response data
                if (data.success) {
                    alert("Account added successfully!");
                    location.reload();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => {
                console.error("❌ Fetch Error:", error); // Log any fetch errors
            });
    });
});




// Highlight selected row and enable buttons
document.addEventListener("DOMContentLoaded", function() {
    const tableRows = document.querySelectorAll(".tableContainer tbody tr");
    const editButton = document.getElementById("editAccountID");
    const removeButton = document.getElementById("removeAccountID");
    const disableButton = document.getElementById("disableAccountID");

    let selectedRow = null; // Store the currently selected row

    // Function to enable buttons
    function enableButtons() {
        editButton.classList.remove("btnWarningDisabled");
        editButton.removeAttribute("disabled");

        removeButton.classList.remove("btnDangerDisabled");
        removeButton.removeAttribute("disabled");

        disableButton.classList.remove("btnDisabled");
        disableButton.removeAttribute("disabled");
    }

    // Function to disable buttons
    function disableButtons() {
        editButton.classList.add("btnWarningDisabled");
        editButton.setAttribute("disabled", "true");

        removeButton.classList.add("btnDangerDisabled");
        removeButton.setAttribute("disabled", "true");

        disableButton.classList.add("btnDisabled");
        disableButton.setAttribute("disabled", "true");
    }

    // Add click event listener to each row
    tableRows.forEach(row => {
        row.addEventListener("click", function() {
            // Remove previous selection
            tableRows.forEach(r => r.classList.remove("selected-row"));

            // Toggle selection
            if (selectedRow === row) {
                selectedRow = null;
                disableButtons(); // Disable buttons when deselected
            } else {
                selectedRow = row;
                enableButtons(); // Enable buttons when selected
                row.classList.add("selected-row");
            }
        });
    });

    // Click outside the table to reset selection
    document.addEventListener("click", function(event) {
        if (!event.target.closest(".tableContainer")) {
            selectedRow = null;
            disableButtons();
            tableRows.forEach(row => row.classList.remove("selected-row"));
        }
    });
});


document.addEventListener("DOMContentLoaded", function() {
    const tableRows = document.querySelectorAll(".tableContainer tbody tr");
    const editButton = document.getElementById("editAccountID");
    const editModal = document.getElementById("editAccountModal");
    const closeModalButton = document.getElementById("closeEditModal");

    // Input fields in the modal
    const employeeEditIDInput = document.getElementById("employeeEditID");
    const employeeNameEditInput = document.getElementById("employeeEditName");
    const emailEditIDInput = document.getElementById("emailEditID");
    const roleEditIDSelect = document.getElementById("roleEditID");
    const departmentEditIDSelect = document.getElementById("departmentEditID");

    let selectedUserId = null;

    // Add click event listener to each row
    tableRows.forEach(row => {
        row.addEventListener("click", function() {
            // Highlight the selected row
            tableRows.forEach(r => r.classList.remove("selected-row"));
            row.classList.add("selected-row");

            // Store the selected user ID
            selectedUserId = row.getAttribute("data-id");
            console.log("Selected User ID:", selectedUserId); // Debugging log

            // Enable the "Edit Account" button
            editButton.classList.remove("btnWarningDisabled");
            editButton.removeAttribute("disabled");
        });
    });



    // Click outside the table to reset selection
    document.addEventListener("click", function(event) {
        if (!event.target.closest(".tableContainer")) {
            selectedUserId = null;
            editButton.classList.add("btnWarningDisabled");
            editButton.setAttribute("disabled", "true");
            tableRows.forEach(row => row.classList.remove("selected-row"));
        }
    });

    editButton.addEventListener("click", function() {
        if (selectedUserId) {
            fetchAndPopulateModal(selectedUserId); // Call the fetchAndPopulateModal function
        }
    });

    // Function to fetch and populate modal
    async function fetchAndPopulateModal(userID) {
        try {
            const response = await fetch("../../0/includes/editAccountQuery.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `id=${encodeURIComponent(userID)}`,
            });

            const data = await response.json();

            console.log("Fetched Data:", data); // Debugging log

            if (data.success) {
                // Populate input fields
                console.log(data.data.id)
                idhidden.value = data.data.id || "";
                employeeEditIDInput.value = data.data.id || "";
                employeeNameEditInput.value = data.data.name || "";
                emailEditIDInput.value = data.data.email || "";
                roleEditIDSelect.value = data.data.role || "";
                departmentEditIDSelect.value = data.data.department || "";
                console.log("Department:", data.data.department);
                console.log("Setting Department Value:", departmentEditIDSelect.value);

                // Open the modal
                editModal.style.display = "flex";
            } else {
                console.error("Error fetching employee data:", data.message);
            }
        } catch (error) {
            console.error("Fetch error:", error);
        }
    }

    // Close the modal
    closeModalButton.addEventListener("click", function() {
        editModal.style.display = "none";
    });

    // Close the modal when clicking outside of it
    window.addEventListener("click", function(event) {
        if (event.target === editModal) {
            editModal.style.display = "none";
        }
    });
});