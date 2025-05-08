<?php
require_once '../../0/includes/employeeTicket.php';
require_once '../../0/includes/adminTableQuery.php'; // Include the query file
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
    <link rel="stylesheet" href="../../assets/css/message.css">
    <title>Tickets</title>
    <style>
        @media only screen and (max-width: 600px) {
            .content {
                display: flex;
                flex-direction: column;
                width: 100%;
                min-height: 90vh;
                align-self: center;
            } 
        }
        @media only screen and (min-width: 600px) {
            .content {
                display: flex;
                flex-direction: column;
                width: 80%;
                min-height: 90vh;
                margin: 5% 0 0 260px;
                align-self: center;
            } 
        }
        
    </style>
</head>

<body>
    <div class="container">
        <div class="sideNav">
            <div class="sideNavLogo img-cover"></div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/dashboard.png);"></div>
                <a href="dashboard.php">Dashboard</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/ticket.png);"></div>
                <a href="ticket.php">Tickets</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/chat.png);"></div>
                <a href="message.php">Messages</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/settings.png);"></div>
                <a href="account.php">Account</a>
            </div>

            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/management.png);"></div>
                <a href="management.php">Management</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/leave.png);"></div>
                <a href="leaveManagement.php">Leave Management</a>
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
            <div class="main-convo">
                <div class="container-convo">
                    <div class="chatbox-container">
                        <div class="chat-container" id="chatbox">
                            <!-- Messages will be loaded here -->
                        </div>
                        <div class="input-area">
                            <input type="file" id="fileInput" style="display: none;"> <!-- Hidden file input -->
                            <div class="attach" id="attach">Attachment📎</div>
                            <input type="text" id="message" name="message">
                            <button id="sendmesageBtn" aria-label="Send Message" style="width: 40px; height: 40px; border: none; background-color: transparent; padding: 0;">
                                <img src="../../assets/images/icons/send.png" style="width: 100%; height: 100%; object-fit: contain;">
                            </button>
                        </div>
                    </div>

                    <div class="cards-container" id="cardsContainer">
                        <div class="search">
                            <input type="text" id="search" placeholder="Search...">
                        </div>

                        <?php
                        require_once '../../0/includes/db.php';

                        if (!isset($_SESSION['user_id'])) {
                            exit('User not logged in.');
                        }

                        $admin_ID = $_SESSION['user_id'];

                        try {
                            // Fetch tickets
                            $stmt1 = $pdo->prepare("
            SELECT 
                t.id, 
                t.subject, 
                u2.department, 
                t.description, 
                t.priority, 
                t.status,
                t.created_at,
                COALESCE(u1.name, 'Unassigned') AS assigned_name,
                u2.name AS employee_name,
                'ticket' AS type
            FROM tickets t
            LEFT JOIN users u1 ON t.assigned_to = u1.id
            LEFT JOIN users u2 ON t.employee_id = u2.id
            ORDER BY t.updated_at DESC
        ");
                            $stmt1->execute();
                            $tickets = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                            // Fetch leave requests
                            $stmt2 = $pdo->prepare("
            SELECT 
                l.id AS id,
                l.employee_id,
                l.leave_types, 
                l.start_date,
                l.end_date,
                l.reason,
                l.status,
                l.created_at,
                l.approved_by,
                l.updated_at,
                u3.name AS employee_name,
                'leave' AS type
            FROM leave_requests l
            LEFT JOIN users u3 ON l.employee_id = u3.id
            ORDER BY l.updated_at DESC, l.created_at DESC
        ");
                            $stmt2->execute();
                            $leaves = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                            // Combine both arrays
                            $items = array_merge($tickets, $leaves);

                            // Sort by updated_at or created_at if updated_at is missing
                            usort($items, function ($a, $b) {
                                $dateA = $a['updated_at'] ?? $a['created_at'];
                                $dateB = $b['updated_at'] ?? $b['created_at'];
                                return strtotime($dateB) - strtotime($dateA);
                            });


                            // Render
                            if ($items) {
                                foreach ($items as $index => $item) {
                                    if (!empty($item['id']) && !empty($item['type'])) {
                                        // Debug output
                                        echo '<!-- DEBUG: ID=' . $item['id'] . ', TYPE=' . $item['type'] . ' -->';

                                        echo '<div class="card card-' . (($index % 4) + 1) . '" data-id="' . htmlspecialchars($item['id']) . '" data-type="' . htmlspecialchars($item['type']) . '">';

                                        echo '<h1>Type: ' . strtoupper($item['type']) . '</h1>';
                                        echo '<h1>ID: ' . htmlspecialchars($item['id']) . '</h1>';
                                        echo '<h1>Name: ' . ucwords(strtolower(htmlspecialchars($item['employee_name'] ?? 'N/A'))) . '</h1>';
                                        echo '<h1>Subject: ' . htmlspecialchars($item['subject'] ?? 'N/A') . '</h1>';

                                        if ($item['type'] === 'ticket') {
                                            echo '<h1>Department: ' . ucwords(strtolower(htmlspecialchars($item['department'] ?? 'N/A'))) . '</h1>';
                                            echo '<h1>Assigned Name: ' . htmlspecialchars($item['assigned_name'] ?? 'N/A') . '</h1>';
                                        } else {
                                            echo '<h1>Leave Type: ' . htmlspecialchars($item['leave_types'] ?? 'N/A') . '</h1>';
                                        }

                                        echo '</div>';
                                    } else {
                                        echo '<!-- Skipped item: Missing id or type -->';
                                    }
                                }
                            } else {
                                echo '<p>No tickets or leave requests found.</p>';
                            }
                        } catch (PDOException $e) {
                            echo 'Error: ' . $e->getMessage();
                        }
                        ?>
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../../assets/js/framework.js"></script>
        <script src="../../assets/js/adminSendMessage.js"></script>

        <script>
            const searchInput = document.getElementById('search');
            const cardsContainer = document.getElementById('cardsContainer');

            // Function to filter cards based on search input
            function filterCards() {
                const query = searchInput.value.toLowerCase();
                const cards = cardsContainer.getElementsByClassName('card');

                Array.from(cards).forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    if (cardText.includes(query)) {
                        card.style.display = 'block'; // Show card if it matches
                    } else {
                        card.style.display = 'none'; // Hide card if it doesn't match
                    }
                });
            }

            // Add event listener for search input
            searchInput.addEventListener('input', filterCards);
        </script>

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
            document.addEventListener("DOMContentLoaded", function() {
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
            document.getElementById("closeModal").onclick = function() {
                const modal = document.getElementById("imageModal");
                modal.style.display = "none";
            };

            // Close the modal when clicking outside the image
            window.onclick = function(event) {
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
<script>
</script>
</body>
</html>