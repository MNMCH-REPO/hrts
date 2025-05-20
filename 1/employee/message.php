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
  @media screen and (max-width: 600px) {
            .content {
                display: flex;
                flex-direction: column;
                width: 100%;
                min-height: 90vh;
                align-self: center;
            }
        }
        @media screen and (min-width: 600px) {
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
                <div class="navBtnIcon img-contain"
                    style="background-image: url(../../assets/images/icons/ticket.png);"></div>
                <a href="ticket.php">Tickets</a>
            </div>
            <div class="navBtn">
                <div class="navBtnIcon img-contain" style="background-image: url(../../assets/images/icons/leave.png);"></div>
                <a href="leave.php">Leave Management</a>
            </div>
            <div class="navBtn currentPage">
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
                <div class="chatbox-container">
                    <div class="chat-container" id="chatbox">
                        <!-- Messages will be loaded here -->
                    </div>
                    <div class="input-area">
                        <input type="file" id="fileInput" style="display: none;"> <!-- Hidden file input -->
                        <div class="attach" id="attach">Attachment📎</div>
                        <input type="text" id="message" placeholder="Type a message...">
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

                    $employeeID = $_SESSION['user_id'];

                    try {
                        // Fetch employee's own tickets
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
                                c.name AS category_name, -- Join to get the category name
                                'ticket' AS type
                            FROM tickets t
                            LEFT JOIN users u1 ON t.assigned_to = u1.id
                            LEFT JOIN users u2 ON t.employee_id = u2.id
                            LEFT JOIN categories c ON t.category_id = c.id -- Join to get the category name
                            WHERE t.employee_id = :employee_id OR t.assigned_to = :employee_id
                            ORDER BY t.updated_at DESC; 
                        ");
                        $stmt1->execute(['employee_id' => $employeeID]);
                        $tickets = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                        // Fetch employee's own leave requests
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
                            WHERE l.employee_id = :employee_id
                            ORDER BY l.updated_at DESC, l.created_at DESC
                        ");
                        $stmt2->execute(['employee_id' => $employeeID]);
                        $leaves = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                        // Combine and sort
                        $items = array_merge($tickets, $leaves);
                        usort($items, function ($a, $b) {
                            $dateA = $a['updated_at'] ?? $a['created_at'];
                            $dateB = $b['updated_at'] ?? $b['created_at'];
                            return strtotime($dateB) - strtotime($dateA);
                        });

                        // Render
                        if ($items) {
                            foreach ($items as $index => $item) {
                                if (!empty($item['id']) && !empty($item['type'])) {
                                    echo '<!-- DEBUG: ID=' . $item['id'] . ', TYPE=' . $item['type'] . ' -->';

                                    echo '<div class="card card-' . (($index % 4) + 1) . '" data-id="' . htmlspecialchars($item['id']) . '" data-type="' . htmlspecialchars($item['type']) . '">';

                                    echo '<h1>Type: ' . strtoupper($item['type']) . '</h1>';
                                    echo '<h1>ID: ' . htmlspecialchars($item['id']) . '</h1>';
                                    echo '<h1>Name: ' . ucwords(strtolower(htmlspecialchars($item['employee_name'] ?? 'N/A'))) . '</h1>';

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
    <script src="../../assets/js/messages.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search');
            const cardsContainer = document.getElementById('cardsContainer');

            if (!searchInput || !cardsContainer) return; // Prevent errors if elements are missing

            function filterCards() {
                const query = searchInput.value.toLowerCase();
                const cards = cardsContainer.getElementsByClassName('card');

                Array.from(cards).forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    card.style.display = cardText.includes(query) ? 'block' : 'none';
                });
            }

            searchInput.addEventListener('input', filterCards);
        });
    </script>




</body>

</html>