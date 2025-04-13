<?php
require_once '../../0/includes/employeeTicket.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/framework.css">
    <link rel="stylesheet" href="../../assets/css/message.css">
    <title>Tickets</title>
    <style>
        .content {
            display: flex;
            flex-direction: column;
            width: 80%;
            min-height: 90vh;
            margin: 5% 0 0 260px;
            align-self: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sideNav">
            <div class="sideNavLogo img-cover"></div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain"
                    style="background-image: url(../../assets/images/icons/ticket.png);"></div>
                <a href="order.php">Oders</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/chat.png);">
                </div>
                <a href="message.php">Messages</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain"
                    style="background-image: url(../../assets/images/icons/settings.png);"></div>
                <a href="account.php">Account</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain"
                    style="background-image: url(../../assets/images/icons/switch.png);"></div>
                <a href="../../0/includes/signout.php">Signout</a>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="topNav">
            <div class="account">
                <div class="accountName">John Doe</div>
                <div class="accountIcon img-contain"></div>
            </div>
        </div>
        <div class="main-convo">
            <div class="container-convo">

                <div class="chat-container" id="chatbox">
                    <!-- Messages will be loaded here -->

                </div>

                <div class="cards-container">
                    <?php
                    require_once '../../0/includes/db.php';


                    if (!isset($_SESSION['user_id'])) {
                        exit('User not logged in.');
                    }

                    $employee_id = $_SESSION['user_id'];

                    try {
                        // Fetch tickets assigned to the logged-in employee
                        $stmt = $pdo->prepare("
                        SELECT 
                            
    t.id, 
    t.subject, 
    u2.department, -- Fetch the department from the user who created the ticket
    t.description, 
    t.priority, 
    t.status,
    t.created_at,
    COALESCE(u1.name, 'Unassigned') AS assigned_name, -- Assigned to
    u2.name AS employee_name -- Employee who created the ticket
FROM tickets t
LEFT JOIN users u1 ON t.assigned_to = u1.id -- Join to get the assigned user's name
LEFT JOIN users u2 ON t.employee_id = u2.id -- Join to get the employee's name and department
WHERE t.assigned_to = :employee_id OR t.employee_id = :employee_id
ORDER BY t.updated_at DESC; -- Sort by newest update
                            ");
                        $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
                        $stmt->execute();
                        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if ($tickets) {
                            foreach ($tickets as $index => $ticket) {
                                echo '<div class="card card-' . (($index % 4) + 1) . '" 
                                      onclick="loadMessages(' . htmlspecialchars($ticket['id']) . ', \'' . htmlspecialchars($ticket['assigned_name']) . '\')">';
                                echo '<h1>Ticket ID: ' . htmlspecialchars($ticket['id']) . '</h1>';
                                echo '<h1>Employee Name: ' . htmlspecialchars($ticket['employee_name']) . '</h1>'; // Fixed typo
                                echo '<h1>Department: ' . htmlspecialchars($ticket['department']) . '</h1>';
                                echo '<h1>Subject: ' . htmlspecialchars($ticket['subject']) . '</h1>';
                                echo '<h1>Assigned Name: ' . htmlspecialchars($ticket['assigned_name']) . '</h1>';
                                echo '<h1>Priority: ' . htmlspecialchars($ticket['priority']) . '</h1>';
                                echo '<h1>Status: ' . htmlspecialchars($ticket['status']) . '</h1>';
                                echo '<h1>Created At: ' . htmlspecialchars($ticket['created_at']) . '</h1>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No tickets assigned to you.</p>';
                        }
                    } catch (PDOException $e) {
                        echo 'Error fetching tickets: ' . $e->getMessage();
                    }
                    ?>

                </div>




                <div class="input-area">
                    <input type="file" name="file" id="fileInput" style="display: none;"> <!-- Hidden file input -->
                    <div class="attach" id="attach">Attachment📎</div>
                    <input type="text" id="message" placeholder="Type a message...">
                    <button id="sendmesageBtn">Send</button>
                </div>


                <br><br>
                <div class="footer" style="text-align: center;">
                    <p>All rights reserved ©</p>
                </div>

            </div>

        </div>

    </div>


    <!-- Image Modal -->
<div id="imageModal" class="modal">
    <span class="close" id="closeModal">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<style>
/* Modal styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1000; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    background-color: rgba(0, 0, 0, 0.8); /* Black background with opacity */
    justify-content: center; /* Center content horizontally */
    align-items: center; /* Center content vertically */
    display: flex; /* Flexbox for centering */
}

.modal-content {
    margin: auto;
    display: block;
    max-width: 60%; /* Limit the image size to 60% of the viewport width */
    max-height: 60%; /* Limit the image size to 60% of the viewport height */
    width: auto; /* Maintain aspect ratio */
    height: auto; /* Maintain aspect ratio */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add a subtle shadow */
}

.close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: red;
    text-decoration: none;
    cursor: pointer;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modal-content {
        max-width: 80%; /* Adjust for smaller screens */
        max-height: 50%; /* Adjust for smaller screens */
    }

    .close {
        font-size: 30px; /* Smaller close button on small screens */
    }
}


.card.active {
  border: 2px solid #007bff;
  background-color: #f0f8ff;
}
</style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../assets/js/framework.js"></script>
    <script src="../../assets/js/messages.js"></script>

    <script>
        function handleFileAction(filePath, action) {
  if (!filePath) {
    console.error("File path is missing.");
    return;
  }

  if (action === "view") {
    // Open the file in a new tab for viewing
    window.open(filePath, "_blank");
  } else if (action === "download") {
    // Trigger a download using AJAX
    const link = document.createElement("a");
    link.href = filePath;
    link.download = filePath.split("/").pop(); // Extract the file name from the path
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  } else {
    console.error("Invalid action specified.");
  }
}

// Ensure modal is hidden on page load
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("imageModal");
    modal.style.display = "none"; // Ensure modal is hidden
});




// Open the modal and display the image
function openImageModal(imagePath) {
    const modal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");

    modal.style.display = "flex"; // Use flex to center the modal
    modalImage.src = imagePath; // Set the image source
}

// Close the modal
document.getElementById("closeModal").onclick = function () {
    const modal = document.getElementById("imageModal");
    modal.style.display = "none";
};

// Close the modal when clicking outside the image
window.onclick = function (event) {
    const modal = document.getElementById("imageModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
};




function renderTickets() {
  const cardsContainer = document.querySelector(".cards-container");
  cardsContainer.innerHTML = ""; // Clear existing cards

  if (tickets.length > 0) {
    tickets.forEach((ticket, index) => {
      const card = document.createElement("div");
      card.className = `card card-${(index % 4) + 1}`;
      card.onclick = () => {
        loadMessages(ticket.id, ticket.assigned_name);
        startAutoRefresh(ticket.id, ticket.assigned_name);
      };

      card.innerHTML = `
        <h1>Ticket ID: ${ticket.id}</h1>
        <h1>Employee Name: ${ticket.employee_name}</h1>
        <h1>Department: ${ticket.department}</h1>
        <h1>Subject: ${ticket.subject}</h1>
        <h1>Assigned Name: ${ticket.assigned_name}</h1>
        <h1>Priority: ${ticket.priority}</h1>
        <h1>Status: ${ticket.status}</h1>
        <h1>Created At: ${ticket.created_at}</h1>
      `;

      cardsContainer.appendChild(card);
    });

    // Automatically open the newest ticket
    const newestTicket = tickets[0];
    loadMessages(newestTicket.id, newestTicket.assigned_name);
  } else {
    cardsContainer.innerHTML = "<p>No tickets assigned to you.</p>";
  }
}

    </script>

</body>

</html>