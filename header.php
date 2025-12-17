<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "classes/connect.php";
$logged = false;
$isAdmin = false;
if (isset($_SESSION['email'])) {
  $logged = true;
  $DB = new Database();
  $user = $DB->read("SELECT admin FROM users WHERE email='$_SESSION[email]' LIMIT 1");
  if (is_array($user)) {
      $user = $user[0]['admin'];
      if ($user == 1)
          $isAdmin = true;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>EcoTrail+ Navbar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="/ecotrail/lakpa-chatbot.css" />
  <script src="/ecotrail/lakpa-chatbot.js"></script>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f7f6;
      margin: 0;
      padding: 0;
    }
    .navbar {
      background: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease-in-out;
    }
    .navbar-brand {
      font-weight: bold;
      font-size: 1.8rem;
      color: #27ae60 !important;
      display: flex;
      align-items: center;
    }
    .navbar-brand img {
      height: 50px;
      margin-right: 10px;
    }
    .nav-link {
      font-weight: 500;
      color: #34495e !important;
      margin-right: 1rem;
      transition: color 0.3s ease;
      position: relative;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      width: 0%;
      height: 2px;
      background: #27ae60;
      bottom: -5px;
      left: 0;
      transition: width 0.3s;
    }
    .nav-link:hover {
      color: #27ae60 !important;
    }
    .nav-link:hover::after {
      width: 100%;
    }
    .btn-nav {
      background: linear-gradient(135deg, #27ae60, #2ecc71);
      color: white;
      border-radius: 25px;
      padding: 8px 22px;
      font-weight: 600;
      border: none;
      transition: all 0.3s ease;
      text-decoration: none;
    }
    .btn-nav:hover {
      background: linear-gradient(135deg, #219150, #28b463);
      color: white;
      transform: translateY(-1px);
      text-decoration: none;
    }
    .navbar-toggler {
      border: none;
      outline: none;
    }
    @media (max-width: 991px) {
      .nav-link {
        margin-right: 0;
        padding: 10px 0;
      }
      .btn-nav {
        margin-top: 10px;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="/ecotrail/index.php">
      <img src="/ecotrail/ecotrail.png" alt="EcoTrail+">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
      <ul class="navbar-nav align-items-lg-center text-center">
        <li class="nav-item"><a class="nav-link" href="/ecotrail/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/ecotrail/contribute/alert.php">Alerts</a></li>
        <li class="nav-item"><a class="nav-link" href="/ecotrail/community">Forum</a></li>
        <li class="nav-item"><a class="nav-link" href="/ecotrail/planner.php">Trip Planner</a></li>
        <li class="nav-item"><a class="nav-link" href="/ecotrail/stay.php">Stays</a></li>

        <?php if ($isAdmin): ?>
          <li class="nav-item"><a class="nav-link" href="/ecotrail/admin">Admin</a></li>
        <?php endif; ?>

        <?php if ($logged): ?>
          <li class="nav-item">
            <a class="btn btn-nav ms-lg-2" href="/ecotrail/auth/logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="btn btn-nav ms-lg-2" href="/ecotrail/auth/login.php">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

</body>
</html>
