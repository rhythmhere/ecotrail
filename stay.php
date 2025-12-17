<?php include 'header.php'; ?>
<style>
  /* Only style the container and cards on this page */
  .explore-container {
    background: linear-gradient(135deg, #e0f7fa, #f1f8e9);
    min-height: 100vh;
    padding-top: 4rem;
    padding-bottom: 4rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #334155;
  }

  .explore-container h2 {
    font-weight: 700;
    font-size: 2.4rem;
    letter-spacing: 0.05em;
    color: #0f172a;
    text-align: center;
    margin-bottom: 1.5rem;
  }

  .explore-container p.lead {
    max-width: 700px;
    margin: 0 auto 3rem;
    font-weight: 500;
    color: #64748b;
    text-align: center;
  }

  .explore-cards .card {
    border-radius: 1rem;
    box-shadow: 0 6px 20px rgba(14, 165, 233, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    background: #ffffffcc;
    backdrop-filter: saturate(180%) blur(10px);
  }

  .explore-cards .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 35px rgba(14, 165, 233, 0.25);
  }

  .explore-cards .card-img-top {
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
    object-fit: cover;
    height: 220px;
    transition: transform 0.3s ease;
  }

  .explore-cards .card-img-top:hover {
    transform: scale(1.03);
  }

  .explore-cards .card-title {
    font-weight: 700;
    font-size: 1.3rem;
    color: #0369a1;
    letter-spacing: 0.04em;
  }

  .explore-cards .card-text {
    font-weight: 500;
    color: #475569;
    line-height: 1.4;
  }

  .explore-cards .card-footer {
    background: transparent;
    border: none;
    padding: 1rem 1.5rem 1.5rem;
  }

  .explore-cards .btn-outline-primary {
    border-width: 2px;
    font-weight: 600;
    border-radius: 1.2rem;
    padding: 0.5rem 0;
    color: #0369a1;
    transition: all 0.3s ease;
    letter-spacing: 0.05em;
    box-shadow: 0 3px 12px rgba(14, 165, 233, 0.15);
  }

  .explore-cards .btn-outline-primary:hover {
    background: #0369a1;
    color: white;
    box-shadow: 0 6px 22px rgba(14, 165, 233, 0.3);
    transform: scale(1.05);
  }

  .explore-container .more-info {
    text-align: center;
    margin-top: 4rem;
    color: #334155;
  }

  .explore-container .more-info h4 {
    font-weight: 700;
    color: #22c55e;
    letter-spacing: 0.06em;
    margin-bottom: 0.5rem;
  }

  .explore-container .more-info p {
    color: #64748b;
    font-weight: 500;
  }

  @media (max-width: 768px) {
    .explore-container h2 {
      font-size: 1.9rem;
      letter-spacing: 0.04em;
    }

    .explore-cards .card-img-top {
      height: 180px;
    }
  }
</style>

<div class="container explore-container">
  <h2>🏔️ Explore Home Stays & Hotels for Trekkers</h2>
  <p class="lead">Discover eco-friendly, local accommodations to rest, recharge, and reconnect with nature. Full marketplace coming soon!</p>

  <div class="row row-cols-1 row-cols-md-3 g-4 explore-cards">
    <!-- Hotel Card 1 -->
    <div class="col">
      <div class="card h-100 shadow-sm">
        <img src="https://media-cdn.tripadvisor.com/media/photo-s/2f/45/9a/2e/new-family-room-after.jpg" class="card-img-top" alt="Himalayan Bliss Stay">
        <div class="card-body">
          <h5 class="card-title">Himalayan Bliss Stay</h5>
          <p class="card-text">Pokhara • Near Fewa Lake<br>Starting from Rs. 1500/night</p>
        </div>
        <div class="card-footer text-center">
          <a href="#" class="btn btn-outline-primary w-100">View Details</a>
        </div>
      </div>
    </div>

    <!-- Hotel Card 2 -->
    <div class="col">
      <div class="card h-100 shadow-sm">
        <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/04/2c/da/d8/everest-summit-lodge.jpg?w=500&h=-1&s=1" class="card-img-top" alt="Everest Eco Lodge">
        <div class="card-body">
          <h5 class="card-title">Everest Eco Lodge</h5>
          <p class="card-text">Namche Bazaar • 3-star eco stay<br>Starting from Rs. 2500/night</p>
        </div>
        <div class="card-footer text-center">
          <a href="#" class="btn btn-outline-primary w-100">View Details</a>
        </div>
      </div>
    </div>

    <!-- Hotel Card 3 -->
    <div class="col">
      <div class="card h-100 shadow-sm">
        <img src="https://cdn.getyourguide.com/image/format=auto,fit=contain,gravity=auto,quality=60,width=1440,height=650,dpr=1/tour_img/118cafc77709d6fa.jpeg" class="card-img-top" alt="Gosaikunda Base Retreat">
        <div class="card-body">
          <h5 class="card-title">Gosaikunda Base Retreat</h5>
          <p class="card-text">Rasuwa • Near trailhead<br>Starting from Rs. 1200/night</p>
        </div>
        <div class="card-footer text-center">
          <a href="#" class="btn btn-outline-primary w-100">View Details</a>
        </div>
      </div>
    </div>
  </div>

  <div class="more-info">
    <h4>🌱 More Eco Stays Coming Soon!</h4>
    <p>We’re partnering with local homestays to grow this network. Stay tuned.</p>
  </div>
</div>

<?php include 'footer.php'; ?>
