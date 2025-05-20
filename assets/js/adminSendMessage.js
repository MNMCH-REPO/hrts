$(document).ready(function () {
  let selectedTicketId = null; // Declare globally
  let selectedTicketType = null;

  $(document).on("click", ".card", function () {
    const itemId = $(this).data("id");
    const itemType = $(this).data("type");

    console.log("Clicked card. ID:", itemId, "Type:", itemType);

    $(".card").removeClass("selected");
    $(this).addClass("selected");

    if (!itemId || !itemType) {
      console.error("No ticket ID or type found for this card.");
      return;
    }

    selectedTicketId = itemId;
    selectedTicketType = itemType;

    if (itemType === "ticket") {
      console.log("Selected Ticket ID:", selectedTicketId);
      checkTicketPermissions(itemId);
      loadMessages(itemId, null, itemType);
    } else if (itemType === "leave") {
      console.log("Selected Leave ID:", selectedTicketId);
      checkTicketPermissions(itemId);
      loadMessages(itemId, null, itemType);
    } else {
      console.warn("Unknown item type:", itemType);
    }
  });
});

// Already existing: your checkTicketPermissions function
function checkTicketPermissions(id, type) {
  $.ajax({
    url: "../../0/includes/adminSendPermission.php",
    type: "GET",
    dataType: "json", // ✅ Let jQuery parse the response as JSON
    data: type === "ticket" ? { ticket_id: id } : { leave_id: id },
    success: function (res) {
      console.log("Permissions response:", res); // Already parsed

      if (res.canReply) {
        $(".input-area").show();
      } else {
        $(".input-area").hide();
      }
    },
    error: function (xhr, status, error) {
      console.error("Error checking permissions:", error);
      $(".input-area").hide();
    },
  });
}

// ✅ Add this part at the bottom of adminSendMessage.js
$(document).ready(function () {
  $(document).on("click", ".card", function () {
    const id = $(this).data("id");
    const type = $(this).data("type");

    console.log("Clicked card ID:", id, "Type:", type);

    if (id && type) {
      checkTicketPermissions(id, type);
    } else {
      console.warn("Card clicked missing ID or type.");
      $(".input-area").hide();
    }
  });
});

let selectedTicketId = null; // Declare selectedTicketId globally
let refreshInterval = null; // Declare refreshInterval globally

function loadMessages(ticketId = null, assignedName = null, type = null) {
  if (ticketId && ticketId !== selectedTicketId) {
    selectedTicketId = ticketId;
    selectedTicketType = type; // Set the type (ticket or leave)

    $("#message").val(""); // Clear message input
    $("#fileInput").val(""); // Clear file input

    // Clear existing interval
    if (refreshInterval) clearInterval(refreshInterval);

    // Auto-refresh messages every second
    refreshInterval = setInterval(() => {
      loadMessages(selectedTicketId, assignedName, selectedTicketType); // Pass type during refresh
    }, 1000);
  }

  if (!selectedTicketId) {
    console.error("No ticket selected.");
    return;
  }

  if (assignedName) {
    $("#assignedName").text(
      "You are now having a conversation with: " + assignedName
    );
  }


  // Save the current scroll position
  let chatbox = $("#chatbox");
  let previousScrollTop = chatbox.scrollTop(); // Save the current scroll position
  let isAtBottom =
    chatbox.scrollTop() + chatbox.innerHeight() >= chatbox[0].scrollHeight - 1; // Check if user is at the bottom

  // Load messages via AJAX
  $.ajax({
    url: "../../0/includes/load_messages.php",
    type: "GET",
    data: { ticket_id: selectedTicketId, ticket_type: selectedTicketType },
    success: function (response) {
      const oldHeight = chatbox[0].scrollHeight; // Save the old height before updating
      
      chatbox.html(response); // Update the chatbox with the loaded messages

      const newHeight = chatbox[0].scrollHeight; // Get the new height after updating

      // Restore the scroll position
      if (isAtBottom) {
        
        chatbox.scrollTop(chatbox[0].scrollHeight); // Scroll to the bottom if the user was already there
      } else if (newHeight > oldHeight) {
        
        // Adjust scroll position if new messages were added
        chatbox.scrollTop(previousScrollTop + (newHeight - oldHeight));
        
      } else {
        
        chatbox.scrollTop(previousScrollTop); // Restore the previous scroll position
      }
    },
    
    error: function (xhr, status, error) {
      
      console.error("Error loading messages:", error);
    },
  });
}

function updateChatbox(message) {
  const chatbox = $("#chatbox");
  const messageDiv = `
    <div class="message">
    
      <p><strong>${message.sender}:</strong> ${message.text}</p>
      <small>${message.time}</small>
    </div>
  `;
  chatbox.append(messageDiv);
  
  chatbox.scrollTop(chatbox[0].scrollHeight);
}
function selectTicket(ticketId) {
  selectedTicketId = ticketId;

  loadMessages(ticketId);
}

function resetSendState() {
  isSending = false;
  $("#sendmesageBtn").prop("disabled", false);
}

function resumeSendState() {
  resetSendState();
  // Restart the refresh
  if (!refreshInterval) {
    console.log("Scroll1"); // Log the loaded messages
    refreshInterval = setInterval(() => loadMessages(), 1000);
  }
}






function uploadFile(fileInput, ticketId, type, callback) {
  let formData = new FormData();
  formData.append("id", ticketId); // Send the ID
  formData.append("type", type); // Send the type (ticket or leave)
  formData.append("file", fileInput); // Send the file

  $.ajax({
    url: "../../../hrts/0/includes/admin_upload_file.php", // Backend file for file uploads
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      console.log("File uploaded successfully:", response);
      if (response.success) {
        if (callback) callback(response); // Call the callback function after file upload
      } else {
        console.error("File upload failed:", response.message);
        alert(response.message); // Show error message to the user
      }
    },
    error: function (xhr, status, error) {
      console.error("Error uploading file:", error);
      alert("An error occurred while uploading the file.");
    },
  });
}

function sendMessage(event) {
  if (event) event.preventDefault();

  let messageText = $("#message").val().trim();
  let fileInput = $("#fileInput")[0].files[0];

  if (!selectedTicketId) {
    console.warn("No ticket or leave request selected.");
    alert("Please select a ticket or leave request before sending a message.");
    return;
  }

  if (fileInput) {
    // Upload the file first, then send the filename as message (even if messageText is empty)
    uploadFile(
      fileInput,
      selectedTicketId,
      selectedTicketType,
      function (fileResponse) {
        let fileName = fileResponse.file_name || "File uploaded";

        // ✅ Send filename as message only if no manual message is written
        sendTextMessage(messageText || fileName);
      }
    );
  } else {
    sendTextMessage(messageText);
  }
}

function sendTextMessage(messageText) {
  let formData = new FormData();
  if (selectedTicketType === "ticket") {
    formData.append("ticket_id", selectedTicketId);
  } else if (selectedTicketType === "leave") {
    formData.append("leave_id", selectedTicketId);
  }
  formData.append("message", messageText);

  $.ajax({
    url: "../../../hrts/0/includes/adminSendMessage.php", // Existing backend for sending messages
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      console.log("Message sent successfully:", response);
      if (response.success) {
        $("#fileInput").val(""); // ✅ Clear file input
        $("#message").val(""); // ✅ Clear message input
        $("#message").attr("placeholder", "Type your message..."); // Reset placeholder

        // Optionally, refresh messages to ensure consistency
        loadMessages();
      } else {
        console.error("Message sending failed:", response.message);
        alert(response.message); // Show error message to the user
      }
    },
    error: function (xhr, status, error) {
      console.error("Error sending message:", error);
      console.error("Raw response:", xhr.responseText); // Add this
      alert("An error occurred while sending the message.");
    },
  });
}

$(document).ready(function () {
  // Handle file attachment
  $("#attach").click(function () {
    $("#fileInput").click(); // Trigger the hidden file input
  });

  // Display selected file name inside the message input field
  $("#fileInput").change(function () {
    let file = this.files[0];
    if (file) {
      console.log(`Setting message value: ${file.name}`);
      $("#message").attr("placeholder", ""); // Clear the placeholder
      $("#message").val(file.name); // Set the file name as the message text
    } else {
      $("#message").val(""); // Clear the message input if no file is selected
    }
  });

  // Handle send button click
  $("#sendmesageBtn").click(function (event) {
    sendMessage(event);
  });

  // Handle Enter key press in the message input
  $("#message").keypress(function (event) {
    if (event.which == 13) {
      sendMessage(event);
    }
  });
});

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

      card.setAttribute("data-id", ticket.id); // Add ticket ID
      card.setAttribute("data-type", "ticket"); // Set type to 'ticket' (adjust if needed based on your use case)
      card.setAttribute("data-name", ticket.assigned_name); // Optionally store the assigned name

      cardsContainer.appendChild(card);
    });

    // Automatically open the newest ticket
    const newestTicket = tickets[0];
    loadMessages(newestTicket.id, newestTicket.assigned_name);
  } else {
    cardsContainer.innerHTML = "<p>No tickets assigned to you.</p>";
  }
}
