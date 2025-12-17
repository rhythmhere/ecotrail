<?php include_once 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lakpa Trekking AI | EcoTrail+</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }

    .typing-indicator span {
      animation: pulse 1.5s infinite ease-in-out;
    }

    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

    .message-enter {
      animation: messageEnter 0.3s ease-out forwards;
    }

    @keyframes messageEnter {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* === Scoped styles for chat card only === */
    #chatCard {
      max-width: 600px;
      margin: auto;
      box-shadow: 0 6px 16px rgba(0,0,0,0.12);
      border-radius: 14px;
      background: white;
      display: flex;
      flex-direction: column;
      height: 90vh;
    }

    #chatCard .card-header {
      padding: 0.75rem 1rem;
      background-color: #2563eb;
      border-bottom-left-radius: 14px;
      border-bottom-right-radius: 14px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    #chatCard .card-header h5 {
      font-size: 1.2rem;
      margin-bottom: 0;
      font-weight: 700;
      color: white;
    }

    #chatCard .card-header small {
      font-size: 0.8rem;
      color: rgba(255,255,255,0.75);
    }

    #chatCard .chat-container {
      flex-grow: 1;
      overflow-y: auto;
      background: linear-gradient(to bottom right, #ebf8ff, #f0fff4);
      padding: 1rem;
      border-radius: 0 0 0 0;
    }

    #chatCard .message-enter {
      margin-bottom: 0.5rem !important;
    }

    #chatCard .d-flex.justify-content-end > div,
    #chatCard .d-flex.justify-content-start > div {
      max-width: 75%;
      padding: 0.6rem 1rem;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      font-size: 0.9rem;
      line-height: 1.3;
    }

    #chatCard .d-flex.justify-content-end > div {
      background-color: #2563eb;
      color: white;
      border-bottom-right-radius: 0;
    }

    #chatCard .d-flex.justify-content-start > div {
      background-color: white;
      border: 1px solid #ddd;
      border-bottom-left-radius: 0;
    }

    #chatCard .card-footer {
      padding: 0.6rem 1rem;
      background: white;
      border-top: 1px solid #ddd;
      border-bottom-left-radius: 14px;
      border-bottom-right-radius: 14px;
    }

    #chatCard form#chatForm {
      display: flex;
      gap: 0.5rem;
      align-items: center;
    }

    #chatCard #userInput {
      flex-grow: 1;
      resize: none;
      min-height: 38px;
      max-height: 90px;
      font-size: 0.95rem;
      padding: 0.5rem 0.75rem;
      border-radius: 12px;
      border: 1px solid #ced4da;
      transition: border-color 0.2s ease;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    #chatCard #userInput:focus {
      border-color: #2563eb;
      outline: none;
      box-shadow: 0 0 8px rgba(37, 99, 235, 0.5);
    }

    #chatCard #sendButton {
      height: 38px;
      width: 38px;
      padding: 0;
      border-radius: 50%;
      font-size: 1.2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background-color 0.2s ease;
    }
    #chatCard #sendButton:hover {
      background-color: #1e40af;
    }
  </style>
</head>
<body class="bg-light">

<div class="container py-3 d-flex justify-content-center align-items-center min-vh-100">
  <div id="chatCard" class="card">
    <!-- Header -->
    <div class="card-header">
      <div class="d-flex align-items-center">
        <div class="bg-white bg-opacity-25 p-2 rounded me-3">
          <i class="fas fa-mountain fs-4" style="color:#2563eb;"></i>
        </div>
        <div>
          <h5 class="mb-0">Lakpa Trekking AI</h5>
          <small>Powered by EcoTrail+</small>
        </div>
      </div>
      <div>
        <button class="btn btn-sm btn-light me-2" title="Settings" aria-label="Settings">
          <i class="fas fa-cog"></i>
        </button>
        <button class="btn btn-sm btn-light" title="Close" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>

    <!-- Messages -->
    <div class="card-body chat-container" id="chatMessages" role="log" aria-live="polite" aria-relevant="additions">
      <!-- Welcome message -->
      <div class="d-flex message-enter mb-3">
        <div class="bg-white border rounded p-3 shadow-sm">
          <div class="text-primary fw-semibold small mb-1">Lakpa by EcoTrail+</div>
          <p class="mb-0 text-dark">
            Namaste! I'm Lakpa, your AI trekking guide. I can help with trail recommendations, gear advice, altitude tips, and more. Where would you like to explore today?
          </p>
        </div>
      </div>
    </div>

    <!-- Input -->
    <div class="card-footer">
      <form id="chatForm" class="d-flex align-items-end gap-2" autocomplete="off">
        <textarea
          id="userInput"
          rows="1"
          placeholder="Ask about trekking routes, gear, or preparation..."
          required
        ></textarea>
        <button
          type="submit"
          id="sendButton"
          class="btn btn-primary"
          aria-label="Send message"
          title="Send"
        >
          <i class="fas fa-paper-plane"></i>
        </button>
      </form>
      <div class="text-center small text-muted mt-2">
        Lakpa may produce inaccurate information about trails, weather, or safety.
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const chatMessages = document.getElementById("chatMessages");
    const chatForm = document.getElementById("chatForm");
    const userInput = document.getElementById("userInput");
    const sendButton = document.getElementById("sendButton");

    userInput.addEventListener("input", () => {
      userInput.style.height = "auto";
      userInput.style.height = `${Math.min(userInput.scrollHeight, 90)}px`;
    });

    function showTypingIndicator() {
      const typingDiv = document.createElement("div");
      typingDiv.className = "d-flex mb-3 message-enter";
      typingDiv.innerHTML = `
        <div class="bg-white border rounded p-3 shadow-sm">
          <div class="text-primary fw-semibold small mb-1">Lakpa by EcoTrail+</div>
          <div class="typing-indicator d-flex align-items-center gap-1 text-secondary small">
            <span>Lakpa is thinking</span>
            <span class="d-inline-block rounded-circle bg-primary" style="width:8px;height:8px;"></span>
            <span class="d-inline-block rounded-circle bg-primary" style="width:8px;height:8px;"></span>
            <span class="d-inline-block rounded-circle bg-primary" style="width:8px;height:8px;"></span>
          </div>
        </div>
      `;
      chatMessages.appendChild(typingDiv);
      chatMessages.scrollTop = chatMessages.scrollHeight;
      return typingDiv;
    }

    function removeTypingIndicator(indicator) {
      if (indicator && indicator.parentNode) {
        indicator.parentNode.removeChild(indicator);
      }
    }

    function appendMessage(text, sender) {
      const messageDiv = document.createElement("div");
      messageDiv.className = `d-flex ${sender === "user" ? "justify-content-end" : "justify-content-start"} mb-3`;

      messageDiv.innerHTML = sender === "user"
        ? `<div class="message">${text}</div>`
        : `<div class="message">
            <div class="text-primary fw-semibold small mb-1">Lakpa by EcoTrail+</div>
            <p class="mb-0 text-dark">${text}</p>
           </div>`;

      messageDiv.classList.add("message-enter");
      chatMessages.appendChild(messageDiv);
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    chatForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const question = userInput.value.trim();
      if (!question) return;

      appendMessage(question, "user");
      userInput.value = "";
      userInput.style.height = "38px";
      userInput.disabled = true;
      sendButton.disabled = true;
      sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

      const typingIndicator = showTypingIndicator();

      try {
        const response = await fetch("trek_chatbot.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ question }),
        });

        const data = await response.json();
        removeTypingIndicator(typingIndicator);

        if (data.answer) {
          appendMessage(data.answer, "bot");
        } else if (data.error) {
          appendMessage("Error: " + data.error, "bot");
        } else {
          appendMessage("No response from Lakpa.", "bot");
        }
      } catch (error) {
        removeTypingIndicator(typingIndicator);
        appendMessage("Sorry, I'm having trouble connecting. Please try again later.", "bot");
        console.error("Error:", error);
      } finally {
        userInput.disabled = false;
        sendButton.disabled = false;
        sendButton.innerHTML = '<i class="fas fa-paper-plane"></i>';
        userInput.focus();
      }
    });

    userInput.focus();
  });
</script>

</body>
</html>
<?php include_once 'footer.php'; ?>
