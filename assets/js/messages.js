let selectedTicketId = null;
let refreshInterval = null; // Store interval reference

function loadMessages(ticketId = null, assignedName = null) {
  if (ticketId && ticketId !== selectedTicketId) {
    selectedTicketId = ticketId;

    // ✅ Clear previous interval before setting a new one
    if (refreshInterval) {
      clearInterval(refreshInterval);
    }

    // ✅ Start a new interval for auto-refresh
    refreshInterval = setInterval(() => {
      loadMessages();
    }, 6000);
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

  $.ajax({
    url: "../../0/includes/employeeLoad_messages.php",
    type: "GET",
    data: {
      ticket_id: selectedTicketId,
    },
    success: function (response) {
      let chatbox = $("#chatbox");
      chatbox.html(response);
      chatbox.scrollTop(chatbox[0].scrollHeight);
    },
    error: function (xhr, status, error) {
      console.error("Error loading messages:", error);
    },
  });
}

function sendMessage(event) {
  if (event) event.preventDefault();

  let messageText = $("#message").val().trim();
  let fileInput = $("#fileInput")[0].files[0];
  let formData = new FormData();

  if (selectedTicketId) {
    formData.append("ticket_id", selectedTicketId);
    if (fileInput) {
      formData.append("file", fileInput);
    } else if (messageText !== "") {
      formData.append("message", messageText);
    } else {
      console.warn("No message or file selected.");
      return;
    }

    $.ajax({
      url: "../../0/includes/send_message.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        $("#message").val(""); // Clear message input
        $("#fileInput").val(""); // Clear file input
        loadMessages(); // Refresh messages
      },
      error: function (xhr, status, error) {
        console.error("Error sending message:", error);
      },
    });
  } else {
    console.warn("No ticket selected.");
  }
}

$(document).ready(function () {
  $(document).on("click", ".card", function () {
    let ticketId = parseInt($(this).attr("onclick").match(/\d+/)[0]);
    loadMessages(ticketId);
  });

  $("#sendmesageBtn").click(function (event) {
    sendMessage(event);
  });

  $("#message").keypress(function (event) {
    if (event.which == 13) {
      sendMessage(event);
    }
  });

  $("#attach").click(function () {
    $("#fileInput").click();
  });

  $("#fileInput").change(function () {
    let file = this.files[0];
    if (file) {
      $("#message").val(file.name);
    }
  });
});
