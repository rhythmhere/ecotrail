<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel</title>
  <style>
    :root {
      --primary: #2563eb;
      --bg-light: #f9fafb;
      --bg-white: #ffffff;
      --text-dark: #1e293b;
      --card-hover: #eff6ff;
      --shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: var(--bg-light);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 40px;
      color: var(--text-dark);
    }

    .topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: var(--bg-white);
      padding: 20px 30px;
      border-radius: 12px;
      box-shadow: var(--shadow);
      margin-bottom: 40px;
    }

    .topbar h1 {
      font-size: 2rem;
      color: var(--primary);
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 30px;
    }

    .card {
      background: var(--bg-white);
      padding: 25px;
      border-radius: 12px;
      box-shadow: var(--shadow);
      transition: all 0.3s ease;
      cursor: pointer;
      text-align: center;
    }

    .card:hover {
      background: var(--card-hover);
      transform: translateY(-5px);
    }

    .card h3 {
      color: var(--primary);
      font-size: 1.1rem;
    }

    .card a {
      text-decoration: none;
      color: inherit;
    }

    @media (max-width: 768px) {
      body {
        padding: 20px;
      }

      .topbar h1 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>

<body>

  <div class="topbar">
    <h1>Admin Dashboard</h1>
  </div>

  <div class="cards">
    <div class="card">
      <a href="new_place.php">
        <h3>📍 Add New Place</h3>
      </a>
    </div>
    <div class="card">
      <a href="new_route.php">
        <h3>🗺️ Add New Plans</h3>
      </a>
    </div>
    <div class="card">
      <a href="../sponsors/">
        <h3>🤝 Add New Sponsor</h3>
      </a>
    </div>
    <div class="card">
      <a href="new_proute.php">
        <h3>🔥 Submit Popular Plans</h3>
      </a>
    </div>
    <div class="card">
      <a href="../contribute/admin.php">
        <h3>✅ Review Contributions</h3>
      </a>
    </div>
  </div>

</body>

</html>
