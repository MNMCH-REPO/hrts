let selectedTicketId = null; // Declare selectedTicketId globally
let refreshInterval = null; // Declare refreshInterval globally


function loadMessages(ticketId = null, assignedName = null) {
  if (ticketId && ticketId !== selectedTicketId) {
      selectedTicketId = ticketId;

      $("#message").val("");       // Clear message input
      $("#fileInput").val("");     // Clear file input

      // Clear existing interval
      if (refreshInterval) clearInterval(refreshInterval);

      // Auto-refresh messages every second
      refreshInterval = setInterval(() => {
          loadMessages(); // Refresh only if the same ticket is still selected
      }, 1000);
  }

  if (!selectedTicketId) {
      console.error("No ticket selected.");
      return;
  }

  if (assignedName) {
      $("#assignedName").text("You are now having a conversation with: " + assignedName);
  }

  // Save the current scroll position
  let chatbox = $("#chatbox");
  let scrollPosition = chatbox.scrollTop();

  // Load messages via AJAX
  $.ajax({
      url: "../../0/includes/employeeLoad_messages.php",
      type: "GET",
      data: { ticket_id: selectedTicketId },
      success: function (response) {
          chatbox.html(response);

          // Restore the scroll position
          chatbox.scrollTop(scrollPosition);
      },
      error: function (xhr, status, error) {
          console.error("Error loading messages:", error);
      }
  });
}

function connectWebSocket() {
  socket = new WebSocket("ws://your-websocket-server-url");

  socket.onopen = function () {
    console.log("WebSocket connection established.");
  };

  socket.onmessage = function (event) {
    const data = JSON.parse(event.data);

    if (data.ticket_id === selectedTicketId) {
      updateChatbox(data.message);
    }
  };

  socket.onerror = function (error) {
    console.error("WebSocket error:", error);
  };

  socket.onclose = function () {
    console.log("WebSocket closed. Reconnecting...");
    setTimeout(connectWebSocket, 5000);
  };
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

  if (socket && socket.readyState === WebSocket.OPEN) {
    socket.send(JSON.stringify({ action: "select_ticket", ticket_id: ticketId }));
  }

  loadMessages(ticketId);
}





function uploadFile(fileInput, ticketId, callback) {
  let formData = new FormData();
  formData.append("ticket_id", ticketId);
  formData.append("file", fileInput);

  $.ajax({
    url: "../../0/includes/upload_file.php", // New backend file for file uploads
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
    console.warn("No ticket selected.");
    alert("Please select a ticket before sending a message.");
    return;
  }

  if (fileInput) {
    // Upload the file first, then send the message
    uploadFile(fileInput, selectedTicketId, function (fileResponse) {
      // After file upload, send the message
      sendTextMessage(messageText);
    });
  } else {
    // If no file, just send the message
    sendTextMessage(messageText);
  }
}

function sendTextMessage(messageText) {
  if (!messageText) {
    console.warn("No message to send.");
    alert("Please enter a message before sending.");
    return;
  }

  let formData = new FormData();
  formData.append("ticket_id", selectedTicketId);
  formData.append("message", messageText);

  $.ajax({
    url: "../../0/includes/send_message.php", // Existing backend for sending messages
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      console.log("Message sent successfully:", response);
      if (response.success) {
        $("#message").val(""); // Clear message input
        loadMessages(); // Refresh messages
      } else {
        console.error("Message sending failed:", response.message);
        alert(response.message); // Show error message to the user
      }
    },
    error: function (xhr, status, error) {
      console.error("Error sending message:", error);
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
      $("#message").val(`${file.name}`); // Set the file name in the message input
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