<?php include 'header.php'; ?>

<style>
  :root {
    --glow-accent: #00cc88;
    --light-bg: #f5f7fa;
    --glass-bg: rgba(255, 255, 255, 0.65);
    --glass-border: rgba(0, 0, 0, 0.08);
    --text-main: #1f2937;
    --text-subtle: #4b5563;
  }

  .bodyall {
    background: var(--light-bg);
    color: var(--text-main);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  /* HERO */
  .hero-section {
    background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
    position: relative;
    min-height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .hero-overlay {
    background: rgba(255, 255, 255, 0.29);
    backdrop-filter: blur(3px);
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: 1;
  }

  .hero-content {
    z-index: 2;
    text-align: center;
    max-width: 800px;
    padding: 2rem;
  }

  .hero-content h1 {
    font-size: 3.2rem;
    font-weight: 800;
    color: var(--text-main);
    text-shadow: 0 0 10px rgba(0, 204, 136, 0.2);
  }

  .hero-content span {
    color: var(--glow-accent);
  }

  .hero-content p {
    font-size: 1.2rem;
    color: var(--text-subtle);
  }

  .hero-content .btn {
    border-radius: 40px;
    padding: 12px 28px;
    margin: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
  }

  .btn-glass {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    color: var(--text-main);
    backdrop-filter: blur(12px);
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  }

  .btn-glass:hover {
    background: var(--glow-accent);
    color: white;
    box-shadow: 0 0 18px var(--glow-accent);
  }

  /* FEATURES */
  .features-section {
    background: #ffffff;
    padding: 5rem 1rem;
  }

  .features-section h2 {
    text-align: center;
    margin-bottom: 3rem;
    font-weight: 700;
    color: var(--text-main);
    text-shadow: 0 0 10px rgba(0, 204, 136, 0.15);
  }

  .card-glass {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: 18px;
    backdrop-filter: blur(16px);
    padding: 2rem;
    transition: all 0.3s ease;
    color: var(--text-main);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  }

  .card-glass:hover {
    transform: translateY(-4px) scale(1.015);
    box-shadow: 0 0 22px var(--glow-accent);
  }

  .card-glass .icon {
    font-size: 2.2rem;
    margin-bottom: 1rem;
    color: var(--glow-accent);
  }

  /* CTA */
  .cta-section {
    background: linear-gradient(to right, #e0f7ef, #f4fff8);
    padding: 4rem 1rem;
    text-align: center;
    color: var(--text-main);
  }

  .cta-section h3 {
    font-weight: 800;
    text-shadow: 0 0 8px rgba(0, 204, 136, 0.2);
  }

  .cta-section p {
    color: var(--text-subtle);
  }

  .cta-section a {
    margin-top: 20px;
    font-weight: bold;
    font-size: 1.1rem;
    padding: 12px 28px;
    border-radius: 30px;
  }
</style>

<div class="bodyall">
  <!-- Hero Section -->
  <section class="hero-section text-center">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
      <h1>Welcome to <span>EcoTrail+</span></h1>
      <p class="lead">Track smarter. Trek safer. Explore Nepal's hidden trails with real-time insights.</p>
      <div class="mt-4 d-flex flex-wrap justify-content-center">
        <a href="/ecotrail/contribute/submit_alert.php" class="btn btn-glass">🚨 Submit Alert</a>
        <a href="/ecotrail/community/new.php" class="btn btn-glass">🌄 Share Hidden Gem</a>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features-section">
    <div class="container">
      <h2>🚀 What EcoTrail+ Offers</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card-glass text-center h-100">
            <div class="icon">📡</div>
            <h5 class="fw-bold">Trail Alerts</h5>
            <p>Get real-time, community-powered updates on trail conditions, safety, and route changes.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-glass text-center h-100">
            <div class="icon">🧭</div>
            <h5 class="fw-bold">Hidden Gems</h5>
            <p>Explore secret trekking spots shared by fellow explorers. Share your own unforgettable trails.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-glass text-center h-100">
            <div class="icon">🗺️</div>
            <h5 class="fw-bold">AI Trip Planner</h5>
            <p>Plan your trek with ease using smart suggestions for guides, costs, stays, and permits.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta-section">
    <div class="container">
      <h3>🌐 Join the EcoTrail+ Movement</h3>
      <p>Build a connected trekking community. Safer journeys start with shared knowledge.</p>
      <a href="/ecotrail/community" class="btn btn-outline-success btn-lg">💬 Join Community</a>
    </div>
  </section>

  <?php include 'footer.php'; ?>
</div>
