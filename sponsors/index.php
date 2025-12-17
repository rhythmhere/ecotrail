<?php
include_once('connect.php');
$query = "SELECT * FROM places";
$DB = new Database();
$data = $DB->read($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add New Sponsor</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <div class="container" id="info">
    <h1 class="form-title">Add New Sponsor</h1>
    <form id="sponsorshipForm" method="POST" action="hotel.php">
      <!-- Hotel Name -->
      <div class="input-group">
        <label for="hotelName">Hotel Name</label>
        <input type="text" id="hotelName" name="hotelName" placeholder="Enter your hotel name" required />
      </div>

      <div class="input-group">
        <label for="address">Address</label>
        <input type="text" id="address" name="address" placeholder="Enter the exact address" required />
      </div>

      <!-- Location Dropdown -->
      <div class="input-group">
        <label for="place">Trek Areas or Destinations</label>
        <select id="place" name="place" required>
          <?php
          foreach ($data as $place) {
            echo "<option value='$place[id]'>", ucwords($place['name']), "</option>";
          }
          ?>
        </select>
      </div>

      <!-- Message -->
      <div class="input-group">
        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" placeholder="Write your sponsorship message..."
          required></textarea>
      </div>

      <!-- Submit Button -->
      <input type="submit" class="btn" value="Add Sponsors" />
    </form>
  </div>
</body>

</html>