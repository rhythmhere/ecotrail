<?php
include '../header.php';
include 'db_config.php';

$message = "";

// Fetch places for dropdown
$places_result = $conn->query("SELECT id, name FROM places ORDER BY name ASC");
$places_options = [];
while ($row = $places_result->fetch_assoc()) {
    $places_options[] = $row;
}

// Handle submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic sanitization + escaping
    $title = $conn->real_escape_string(trim($_POST['alert_title'] ?? ''));
    $description = $conn->real_escape_string(trim($_POST['alert_description'] ?? ''));
    $location = $conn->real_escape_string(trim($_POST['alert_location'] ?? ''));
    $place_id = isset($_POST['alert_place']) ? intval($_POST['alert_place']) : 'NULL';
    $date = $conn->real_escape_string(trim($_POST['alert_date'] ?? ''));
    $severity = strtoupper($conn->real_escape_string(trim($_POST['alert_severity'] ?? '')));
    $type = $conn->real_escape_string(trim($_POST['alert_type'] ?? ''));
    $alt_route = $conn->real_escape_string(trim($_POST['alert_alt_route'] ?? ''));
    $proof_filename = NULL;

    // Validate required fields
    if (!$title || !$description || !$location || !$date || !$severity || !$type) {
        $message = "Please fill all required fields.";
    } else {
        // Handle file upload
        if (isset($_FILES['alert_proof']) && $_FILES['alert_proof']['error'] == UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (in_array($_FILES['alert_proof']['type'], $allowed_types)) {
                $upload_dir = "uploads/";
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                $tmp_name = $_FILES['alert_proof']['tmp_name'];
                $original_name = basename($_FILES['alert_proof']['name']);
                $safe_name = preg_replace('/[^a-zA-Z0-9._-]/', '', $original_name);
                $target_file = $upload_dir . time() . "_" . $safe_name;
                if (move_uploaded_file($tmp_name, $target_file)) {
                    $proof_filename = $conn->real_escape_string($target_file);
                } else {
                    $message = "Failed to upload proof image.";
                }
            } else {
                $message = "Only JPG, PNG, GIF, WEBP images are allowed.";
            }
        }

        if (!$message) {
            $sql = "INSERT INTO alerts (title, description, location, place_id, date, severity, type, status, alt_route, proof, approved)
                    VALUES ('$title', '$description', '$location', " . ($place_id === 0 ? "NULL" : $place_id) . ", '$date', '$severity', '$type', 'active', '$alt_route', " . 
                    ($proof_filename ? "'$proof_filename'" : "NULL") . ", 'pending')";

            if ($conn->query($sql)) {
                header("Location: submit_alert.php?success=1");
                exit();
            } else {
                $message = "Error submitting alert: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Submit Alert - EcoTrail+</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container my-5">
  <div class="card shadow-sm p-4" style="max-width: 700px; margin: auto;">

    <h2 class="mb-4 text-primary text-center fw-bold">Submit Alert</h2>

    <?php if ($message): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
    <?php elseif (isset($_GET['success'])): ?>
      <div class="alert alert-success">Alert submitted successfully and awaiting approval.</div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" novalidate class="needs-validation" id="alertForm" autocomplete="off">
      <div class="mb-3">
        <label for="alert_title" class="form-label">Alert Title *</label>
        <input type="text" name="alert_title" id="alert_title" class="form-control" required
               placeholder="Enter alert title" value="<?= htmlspecialchars($_POST['alert_title'] ?? '') ?>" />
        <div class="invalid-feedback">Please enter the alert title.</div>
      </div>

      <div class="mb-3">
        <label for="alert_description" class="form-label">Description *</label>
        <textarea name="alert_description" id="alert_description" rows="4" class="form-control" required
                  placeholder="Describe the alert in detail"><?= htmlspecialchars($_POST['alert_description'] ?? '') ?></textarea>
        <div class="invalid-feedback">Please enter the description.</div>
      </div>

      <div class="mb-3">
        <label for="alert_location" class="form-label">Location *</label>
        <input type="text" name="alert_location" id="alert_location" class="form-control" required
               placeholder="Specify the location" value="<?= htmlspecialchars($_POST['alert_location'] ?? '') ?>" />
        <div class="invalid-feedback">Please enter the location.</div>
      </div>

      <div class="mb-3">
        <label for="alert_place" class="form-label">Place / Trekking Base (Optional)</label>
        <select name="alert_place" id="alert_place" class="form-select">
          <option value="" selected disabled>Select a Place</option>
          <?php foreach ($places_options as $place): ?>
            <option value="<?= $place['id'] ?>" <?= (isset($_POST['alert_place']) && $_POST['alert_place'] == $place['id']) ? 'selected' : '' ?>><?= htmlspecialchars(ucwords($place['name'])) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="alert_date" class="form-label">Date *</label>
        <input type="date" name="alert_date" id="alert_date" class="form-control" required
               value="<?= htmlspecialchars($_POST['alert_date'] ?? '') ?>" />
        <div class="invalid-feedback">Please select a date.</div>
      </div>

      <div class="mb-3">
        <label for="alert_severity" class="form-label">Severity *</label>
        <select name="alert_severity" id="alert_severity" class="form-select" required>
          <option value="" disabled <?= empty($_POST['alert_severity']) ? 'selected' : '' ?>>Select severity</option>
          <option value="LOW" <?= (isset($_POST['alert_severity']) && $_POST['alert_severity'] === 'LOW') ? 'selected' : '' ?>>Low</option>
          <option value="MEDIUM" <?= (isset($_POST['alert_severity']) && $_POST['alert_severity'] === 'MEDIUM') ? 'selected' : '' ?>>Medium</option>
          <option value="HIGH" <?= (isset($_POST['alert_severity']) && $_POST['alert_severity'] === 'HIGH') ? 'selected' : '' ?>>High</option>
        </select>
        <div class="invalid-feedback">Please select severity.</div>
      </div>

      <div class="mb-3">
        <label for="alert_type" class="form-label">Type *</label>
        <input type="text" name="alert_type" id="alert_type" class="form-control" required
               placeholder="e.g. strike, roadblock" value="<?= htmlspecialchars($_POST['alert_type'] ?? '') ?>" />
        <div class="invalid-feedback">Please specify the alert type.</div>
      </div>

      <div class="mb-3">
        <label for="alert_alt_route" class="form-label">Alternative Route (Optional)</label>
        <textarea name="alert_alt_route" id="alert_alt_route" rows="2" class="form-control"
                  placeholder="Optional"><?= htmlspecialchars($_POST['alert_alt_route'] ?? '') ?></textarea>
      </div>

      <div class="mb-3">
        <label for="alert_proof" class="form-label">Proof Image (optional)</label>
        <input type="file" name="alert_proof" id="alert_proof" accept="image/*" class="form-control" />
      </div>

      <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">Submit Alert</button>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  (() => {
    'use strict';
    const form = document.getElementById('alertForm');
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  })();
</script>

</body>
</html>

<?php include '../footer.php'; ?>
