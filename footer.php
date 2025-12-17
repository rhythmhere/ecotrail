<!-- footer.php -->
<style>
  footer {
    background-color: #1e293b; /* dark slate */
    color: #cbd5e1; /* light slate */
    padding: 30px 20px;
    text-align: center;
    margin-top: 60px;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    letter-spacing: 0.05em;
    box-shadow: 0 -4px 12px rgba(30, 41, 59, 0.8);
    user-select: none;
  }
  footer a {
    color: #2563eb; /* bright blue */
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s ease;
  }
  footer a:hover {
    color: #60a5fa; /* lighter blue */
    text-decoration: underline;
  }
  footer p {
    font-size: 1rem;
    margin-bottom: 8px;
  }
  footer small {
    font-size: 0.875rem;
    color: #94a3b8; /* muted slate */
  }
  .footer-container {
    max-width: 960px;
    margin: 0 auto;
  }

  /* Floating Assistance AI button */
  #assist-ai-btn {
    position: fixed;
    bottom: 30px;
    left: 30px; /* instead of right: 30px; */
    background-color: #2563eb; /* bright blue */
    color: white;
    border: none;
    border-radius: 50px;
    padding: 12px 18px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    letter-spacing: 0.05em;
    cursor: pointer;
    box-shadow: 0 6px 15px rgba(37, 99, 235, 0.5);
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    z-index: 1050;
    user-select: none;
  }
  #assist-ai-btn:hover {
    background-color: #1d4ed8; /* darker blue */
    box-shadow: 0 8px 20px rgba(29, 78, 216, 0.7);
  }
  #assist-ai-btn i {
    font-size: 1.2rem;
  }
</style>

<?php include_once("sos/index.php"); ?>

<footer>
  <div class="footer-container">
    <p>
      Contact us at <a href="mailto:ecotrail@codecrypse.com">ecotrail@codecrypse.com</a> |
      Follow us on
      <a href="#" aria-label="Facebook">Facebook</a>,
      <a href="#" aria-label="Instagram">Instagram</a>,
      <a href="#" aria-label="Twitter">Twitter</a>
    </p>
    <small>© 2025 EcoTrail+. All rights reserved.</small>
  </div>
</footer>

<button id="assist-ai-btn" aria-label="Assistance AI" onclick="location.href='/ecotrail/lakpa.php'">
  <i class="fas fa-robot" aria-hidden="true"></i> Lakpa AI
</button>
<?php include_once("sos/index.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
