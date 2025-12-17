<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../classes/connect.php");
if (isset($_SESSION["email"])) {
    header("Location: ../index.php");
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login & Signup - EcoTrail+</title>

  <!-- Icons + Fonts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Quicksand", sans-serif;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #0a0a0a, #1f1f1f); /* darker blackish background */
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    .ring {
      position: relative;
      width: 500px;
      height: 500px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .ring i {
      position: absolute;
      inset: 0;
      border: 2px solid #fff;
      transition: 0.5s;
    }

    .ring i:nth-child(1) {
      border-radius: 38% 62% 63% 37% / 41% 44% 56% 59%;
      animation: animate 6s linear infinite;
    }

    .ring i:nth-child(2) {
      border-radius: 41% 44% 56% 59%/38% 62% 63% 37%;
      animation: animate 4s linear infinite;
    }

    .ring i:nth-child(3) {
      border-radius: 41% 44% 56% 59%/38% 62% 63% 37%;
      animation: animate2 10s linear infinite;
    }

    .ring:hover i {
      border: 6px solid var(--clr);
      filter: drop-shadow(0 0 20px var(--clr));
    }

    @keyframes animate {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @keyframes animate2 {
      0% { transform: rotate(360deg); }
      100% { transform: rotate(0deg); }
    }

    .login {
      position: relative;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 40px 30px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      display: flex;
      flex-direction: column;
      gap: 20px;
      z-index: 1;

      width: 340px; /* small width for login */
      transition: width 0.5s ease;
    }

    .login.signup-active {
      width: 460px; /* expanded width for signup */
    }

    .toggle-btns {
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .toggle-btns button {
      background: none;
      border: none;
      font-weight: bold;
      color: #555;
      cursor: pointer;
      border-bottom: 2px solid transparent;
      padding: 5px 10px;
      transition: 0.3s;
    }

    .toggle-btns button.active {
      color: #2575fc;
      border-color: #2575fc;
    }

    .form-container {
      position: relative;
      height: 330px;
      overflow: hidden;
      transition: height 0.5s ease;
    }

    .login.signup-active .form-container {
      height: 400px; /* taller for signup */
    }

    form {
      position: absolute;
      width: 100%;
      top: 0;
      left: 0;
      transition: opacity 0.5s ease, z-index 0.5s;
    }

    form.hidden {
      opacity: 0;
      z-index: 0;
      pointer-events: none;
    }

    form.active {
      opacity: 1;
      z-index: 1;
      pointer-events: auto;
    }

    .inputBx {
      width: 100%;
      margin-bottom: 15px;
    }

    .inputBx input {
      width: 100%;
      padding: 12px 20px;
      border: 2px solid #ddd;
      border-radius: 40px;
      font-size: 1em;
      background: transparent;
      color: #333;
      outline: none;
      transition: 0.3s;
    }

    .inputBx input:focus {
      border-color: #2575fc;
      box-shadow: 0 0 10px rgba(37, 117, 252, 0.3);
    }

    .inputBx input[type="submit"] {
      background: linear-gradient(45deg, #4facfe, #00f2fe);
      border: none;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    .inputBx input[type="submit"]:hover {
      background: linear-gradient(45deg, #00f2fe, #4facfe);
      box-shadow: 0 0 20px rgba(79, 172, 254, 0.7);
    }

    .links {
      display: flex;
      justify-content: space-between;
      font-size: 0.9em;
    }

    .links a {
      color: #2575fc;
      text-decoration: none;
    }

    .links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="ring">
  <i style="--clr:#00ff0a;"></i>
  <i style="--clr:#ff0057;"></i>
  <i style="--clr:#fffd44;"></i>

  <div class="login" id="loginBox">
    <div class="toggle-btns">
      <button id="loginToggle" class="active" onclick="toggleForm('login')">Login</button>
      <button id="signupToggle" onclick="toggleForm('signup')">Signup</button>
    </div>

    <div class="form-container">
      <!-- Login Form -->
      <form id="loginForm" class="active" method="POST" action="auth.php">
        <div class="inputBx">
          <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="inputBx">
          <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="inputBx">
          <input type="submit" name="signIn" value="Sign in">
        </div>
      </form>

      <!-- Signup Form -->
      <form id="signupForm" class="hidden" method="POST" action="auth.php">
        <div class="inputBx">
          <input type="text" name="fname" placeholder="First Name" required>
        </div>
        <div class="inputBx">
          <input type="text" name="lname" placeholder="Last Name" required>
        </div>
        <div class="inputBx">
          <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="inputBx">
          <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="inputBx">
          <input type="submit" name="signUp" value="Sign up">
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const loginForm = document.getElementById("loginForm");
  const signupForm = document.getElementById("signupForm");
  const loginToggle = document.getElementById("loginToggle");
  const signupToggle = document.getElementById("signupToggle");
  const loginBox = document.getElementById("loginBox");

  function toggleForm(type) {
    if (type === "login") {
      loginForm.classList.add("active");
      loginForm.classList.remove("hidden");
      signupForm.classList.remove("active");
      signupForm.classList.add("hidden");
      loginToggle.classList.add("active");
      signupToggle.classList.remove("active");
      loginBox.classList.remove("signup-active");
    } else {
      signupForm.classList.add("active");
      signupForm.classList.remove("hidden");
      loginForm.classList.remove("active");
      loginForm.classList.add("hidden");
      signupToggle.classList.add("active");
      loginToggle.classList.remove("active");
      loginBox.classList.add("signup-active");
    }
  }
</script>

</body>
</html>
