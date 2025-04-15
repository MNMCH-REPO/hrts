$(document).ready(function () {
    // Handle card click to load messages and check permissions
    $(document).on("click", ".card", function () {
        const ticketId = $(this).data("ticket-id");
        if (ticketId) {
            checkTicketPermissions(ticketId); // Check permissions for the clicked ticket
            loadMessages(ticketId); // Load messages for the clicked ticket
        } else {
            console.warn("No ticket ID found for this card.");
        }
    });

    // Function to check ticket permissions
    function checkTicketPermissions(ticketId) {
        $.ajax({
            url: "../../0/includes/adminSendPermission.php", // Backend to check permissions
            type: "GET",
            data: { ticket_id: ticketId },
            success: function (response) {
                const res = JSON.parse(response);
                if (res.canReply) {
                    $(".input-area").show(); // Show the input area if the user can reply
                } else {
                    $(".input-area").hide(); // Hide the input area if the user cannot reply
                }
            },
            error: function (xhr, status, error) {
                console.error("Error checking ticket permissions:", error);
                $(".input-area").hide(); // Hide the input area on error
            },
        });
    }

    // Function to load messages for a specific ticket
    function loadMessages(ticketId) {
        $.ajax({
            url: "../../0/includes/load_messages.php",
            type: "GET",
            data: { ticket_id: ticketId },
            success: function (response) {
                $("#chatbox").html(response); // Load messages into the chatbox
            },
            error: function (xhr, status, error) {
                console.error("Error loading messages:", error);
                $("#chatbox").html("<p>Error loading messages.</p>");
            },
        });
    }
});





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
  
  