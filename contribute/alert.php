<?php include_once '../header.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include 'db_config.php';
require_once "../classes/connect.php";
require_once "../classes/functions.php";
$DB = new Database();
$logged = false;
if (isset($_SESSION['email'])) {
  $logged = true;
  $my_followed_alerts = get_my_followed_alerts($_SESSION['email']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>EcoTrail+ Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    body {
      background: #f9fafb;
      font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #1e293b; /* modern dark slate */
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      margin: 0;
      padding-bottom: 3rem;
    }

    h1 {
      color: #16a34a; /* vivid blue */
      font-weight: 700;
      margin-bottom: 1.5rem;
      letter-spacing: 0.02em;
    }
    h2 {
      color: #2563eb; /* vivid blue */
      font-weight: 700;
      margin-bottom: 1.5rem;
      letter-spacing: 0.02em;
    }

    /* Glassmorphic Alert Cards */
    .alert-card {
      border-left: 6px solid;
      margin-bottom: 2rem;
      padding: 1.75rem 2.5rem;
      border-radius: 1rem;
      background: rgba(255, 255, 255, 0.22);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      color: #1e293b;
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: default;
    }

    .alert-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 18px 36px rgba(37, 99, 235, 0.25);
    }

    /* Severity Border Colors */
    .alert-high {
      border-color: #ef4444;
    }

    .alert-medium {
      border-color: #fbbf24;
    }

    .alert-low {
      border-color: #22c55e;
    }

    .alert-card h4 {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 0.6rem;
      color: #0f172a;
    }

    /* Tag Styles */
    .alert-severity,
    .alert-type,
    .alert-base {
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      padding: 0.35rem 0.8rem;
      border-radius: 0.5rem;
      display: inline-block;
      margin: 0.2rem 0.5rem 0.4rem 0;
      letter-spacing: 0.6px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.07);
      user-select: none;
    }

    .alert-severity.high {
      background: linear-gradient(135deg, #f87171, #ef4444);
      color: #fff;
    }

    .alert-severity.medium {
      background: linear-gradient(135deg, #fde68a, #fbbf24);
      color: #202020;
    }

    .alert-severity.low {
      background: linear-gradient(135deg, #86efac, #22c55e);
      color: #fff;
    }

    .alert-type {
      background: linear-gradient(135deg, #60a5fa, #2563eb);
      color: #fff;
    }

    .alert-base {
      background: linear-gradient(135deg, #4ade80, #16a34a);
      color: #fff;
    }

    .alert-meta {
      font-size: 0.95rem;
      color: #475569;
      margin-bottom: 1rem;
      font-weight: 500;
    }

    .alert-description {
      font-size: 1.05rem;
      color: #334155;
      margin-bottom: 1rem;
      line-height: 1.65;
      white-space: pre-wrap;
    }

    /* Alt Route Box */
    .alt-route {
      background: rgba(37, 99, 235, 0.07);
      border-left: 5px solid #2563eb;
      padding: 1rem 1.5rem;
      border-radius: 0.75rem;
      margin-bottom: 1.5rem;
      color: #1e293b;
      font-style: italic;
      font-weight: 600;
    }

    /* Image Proof Style */
    .proof-image {
      max-width: 100%;
      height: auto;
      max-height: 260px;
      object-fit: cover;
      border-radius: 0.75rem;
      border: 1px solid #cbd5e1;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      cursor: zoom-in;
      display: block;
      margin: 1rem auto 1.5rem auto;
    }

    .proof-image:hover {
      transform: scale(1.04);
      box-shadow: 0 12px 30px rgba(37, 99, 235, 0.3);
    }

    /* Image Zoom Overlay */
    #img-zoom-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(15, 23, 42, 0.85);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1050;
      cursor: zoom-out;
    }

    #img-zoom-overlay img {
      max-width: 90%;
      max-height: 90%;
      border-radius: 1rem;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.8);
      transition: transform 0.3s ease;
    }

    /* Responsive */
    @media (max-width: 576px) {
      .alert-card {
        padding: 1.25rem 1.5rem;
      }

      .alert-card h4 {
        font-size: 1.25rem;
      }
    }
  </style>
</head>

<body>
  <div class="container mt-5">

    <h1 class="mb-4">EcoTrail+ - Alerts</h1>
    <h2>Alerts for You</h2>
    <?php
    if ($logged && is_array($my_followed_alerts)) {
      foreach ($my_followed_alerts as $my_id) {
        $alert = $DB->read("SELECT * from alerts where id='$my_id' limit 1");
        if (is_array($alert)):
          $alert = $alert[0];
          $severity_class = strtolower($alert['severity']);
          ?>
          <div class="alert-card alert-<?= $severity_class ?>">
            <h4><?= htmlspecialchars($alert['title']) ?></h4>
            <p class="alert-meta">
              <span class="alert-severity <?= $severity_class ?>"><?= htmlspecialchars($alert['severity']) ?> Impact</span>
              <span class="alert-type"><?= htmlspecialchars($alert['type']) ?></span>
              <span class="alert-base"><?= ucwords(htmlspecialchars($alert['place_name'] ?? 'N/A')) ?></span>
              <br><br>
              <strong>Location:</strong> <?= htmlspecialchars($alert['location']) ?> | <strong>Date:</strong>
              <?= htmlspecialchars($alert['date']) ?>
            </p>
            <p class="alert-description"><?= nl2br(htmlspecialchars($alert['description'])) ?></p>
            <?php if ($alert['alt_route']): ?>
              <p class="alt-route"><strong>Alternative Route:</strong> <?= nl2br(htmlspecialchars($alert['alt_route'])) ?></p>
            <?php endif; ?>
            <?php if ($alert['proof'] && file_exists($alert['proof'])): ?>
              <img src="<?= htmlspecialchars($alert['proof']) ?>" alt="Proof Image" class="proof-image" />
            <?php endif; ?>
          </div>
          <?php
        else:
          echo "No results found!";
        endif;
      }
    } else {
      echo "<p>You are not following any alerts.</p>";
    }
    ?>
    <br><br>
    <h2>Current Alerts</h2>
    <?php
    $alerts = $conn->query("SELECT alerts.*, places.name AS place_name FROM alerts LEFT JOIN places ON alerts.place_id = places.id WHERE alerts.approved = 'approved' ORDER BY alerts.id DESC");
    if ($alerts->num_rows > 0):
      while ($alert = $alerts->fetch_assoc()):
        $severity_class = strtolower($alert['severity']);
        ?>
        <div class="alert-card alert-<?= $severity_class ?>">
          <h4><?= htmlspecialchars($alert['title']) ?></h4>
          <p class="alert-meta">
            <span class="alert-severity <?= $severity_class ?>"><?= htmlspecialchars($alert['severity']) ?> Impact</span>
            <span class="alert-type"><?= htmlspecialchars($alert['type']) ?></span>
            <span class="alert-base"><?= ucwords(htmlspecialchars($alert['place_name'] ?? 'N/A')) ?></span>
            <br><br>
            <strong>Location:</strong> <?= htmlspecialchars($alert['location']) ?> | <strong>Date:</strong>
            <?= htmlspecialchars($alert['date']) ?>
          </p>
          <p class="alert-description"><?= nl2br(htmlspecialchars($alert['description'])) ?></p>
          <?php if ($alert['alt_route']): ?>
            <p class="alt-route"><strong>Alternative Route:</strong> <?= nl2br(htmlspecialchars($alert['alt_route'])) ?></p>
          <?php endif; ?>
          <?php if ($alert['proof'] && file_exists($alert['proof'])): ?>
            <img src="<?= htmlspecialchars($alert['proof']) ?>" alt="Proof Image" class="proof-image" />
          <?php endif; ?>
        </div>
        <?php
      endwhile;
    else:
      echo "<p>No alerts at the moment.</p>";
    endif;
    ?>

  </div>

  <!-- Image Zoom Overlay -->
  <div id="img-zoom-overlay" aria-hidden="true">
    <img src="" alt="Zoomed Image" />
  </div>

  <script>
    // Zoom out effect on card click (optional)
    document.querySelectorAll('.alert-card, .gem-card').forEach(card => {
      card.addEventListener('click', () => {
        card.classList.add('zoomed-out');
        setTimeout(() => {
          card.classList.remove('zoomed-out');
        }, 300);
      });
    });

    // Image zoom overlay logic
    const overlay = document.getElementById('img-zoom-overlay');
    const overlayImg = overlay.querySelector('img');

    // Attach zoom-in cursor and click event to images
    document.querySelectorAll('.proof-image, .gem-photo').forEach(img => {
      img.style.cursor = 'zoom-in';
      img.addEventListener('click', e => {
        e.stopPropagation(); // Prevent card click zoom effect
        overlayImg.src = e.target.src;
        overlay.style.display = 'flex';
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden'; // Prevent scroll when zoomed
      });
    });

    // Close overlay when clicking outside or on image
    overlay.addEventListener('click', e => {
      if (e.target === overlay || e.target === overlayImg) {
        overlay.style.display = 'none';
        overlay.setAttribute('aria-hidden', 'true');
        overlayImg.src = '';
        document.body.style.overflow = ''; // Restore scroll
      }
    });
  </script>
</body>

</html>
<?php include '../footer.php'; ?>
