<?php
include 'db_config.php';

$action_msg = "";

// Admin Actions for alerts only
if (isset($_GET['approve_alert'])) {
    $id = (int)$_GET['approve_alert'];
    $conn->query("UPDATE alerts SET approved='approved' WHERE id=$id");
    $action_msg = "Alert approved.";
} elseif (isset($_GET['deny_alert'])) {
    $id = (int)$_GET['deny_alert'];
    $conn->query("UPDATE alerts SET approved='denied' WHERE id=$id");
    $action_msg = "Alert denied.";
} elseif (isset($_GET['delete_alert'])) {
    $id = (int)$_GET['delete_alert'];
    $conn->query("DELETE FROM alerts WHERE id=$id");
    $action_msg = "Alert deleted.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Panel - EcoTrail+ (Alerts Only)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .pending-row { background-color: #fff3cd; }
    .approved-row { background-color: #d1e7dd; }
    .denied-row { background-color: #f8d7da; }
    .img-thumb { max-height: 80px; width: auto; cursor: pointer; transition: transform 0.2s; }
    .img-thumb:hover { transform: scale(1.05); }
    .table-responsive { max-height: 500px; overflow-y: auto; }
  </style>
</head>
<body>
<div class="container mt-5 mb-5">
  <h1 class="mb-4">Admin Panel - Manage Alerts</h1>

  <?php if($action_msg): ?>
    <div class="alert alert-info"><?= htmlspecialchars($action_msg) ?></div>
  <?php endif; ?>

  <!-- ALERTS -->
  <h2>Submitted Alerts</h2>
  <div class="table-responsive mb-5">
    <?php
    // JOIN alerts with places to get place name
    $alerts = $conn->query("SELECT alerts.*, places.name AS place_name FROM alerts LEFT JOIN places ON alerts.place_id = places.id ORDER BY alerts.id DESC");
    if ($alerts->num_rows > 0):
    ?>
    <table class="table table-bordered table-hover align-middle text-nowrap">
      <thead class="table-dark">
        <tr>
          <th>ID</th><th>Title</th><th>Location</th><th>Place Name</th><th>Date</th><th>Severity</th><th>Type</th><th>Status</th><th>Alt Route</th><th>Proof</th><th>Approved</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($alert = $alerts->fetch_assoc()):
          $row_class = match($alert['approved']) {
            'pending' => 'pending-row',
            'approved' => 'approved-row',
            'denied' => 'denied-row',
            default => ''
          };
        ?>
        <tr class="<?= $row_class ?>">
          <td><?= $alert['id'] ?></td>
          <td><?= htmlspecialchars($alert['title']) ?></td>
          <td><?= htmlspecialchars($alert['location']) ?></td>
          <td><?= ucwords(htmlspecialchars($alert['place_name'] ?? 'N/A')) ?></td>
          <td><?= htmlspecialchars($alert['date']) ?></td>
          <td><?= htmlspecialchars($alert['severity']) ?></td>
          <td><?= htmlspecialchars($alert['type']) ?></td>
          <td><?= htmlspecialchars($alert['status']) ?></td>
          <td style="white-space: pre-wrap; max-width:150px;"><?= htmlspecialchars($alert['alt_route']) ?></td>
          <td>
            <?php if ($alert['proof'] && file_exists($alert['proof'])): ?>
              <a href="<?= htmlspecialchars($alert['proof']) ?>" target="_blank">
                <img src="<?= htmlspecialchars($alert['proof']) ?>" class="img-thumb rounded" alt="Proof" />
              </a>
            <?php else: ?>
              <small>No Image</small>
            <?php endif; ?>
          </td>
          <td><?= ucfirst($alert['approved']) ?></td>
          <td style="white-space: nowrap;">
            <?php if ($alert['approved'] == 'pending'): ?>
              <a href="?approve_alert=<?= $alert['id'] ?>" class="btn btn-success btn-sm mb-1" onclick="return confirm('Approve this alert?')">Approve</a>
              <a href="?deny_alert=<?= $alert['id'] ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Deny this alert?')">Deny</a>
            <?php else: ?>
              <span class="text-muted d-block mb-1">No actions</span>
            <?php endif; ?>
            <a href="?delete_alert=<?= $alert['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this alert?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php else: ?>
      <p>No alerts found.</p>
    <?php endif; ?>
  </div>

  <a href="/ecotrail/admin" class="btn btn-primary mt-4">Back to Home</a>
</div>
</body>
</html>
