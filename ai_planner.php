<?php include 'header.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('classes/functions.php');
$DB = new Database();
$places = get_all_places();
$populars = get_popular_plans();

$logged = false;
if (isset($_SESSION['email'])) {
    $logged = true;
    $username = get_user_name($_SESSION['email']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Smart Trip Planner</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

    <style>
        /* --- Sticky footer flexbox fix --- */
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f0f4ff;
        }

        /* Wrapper for all content except footer */
        .page-content {
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
        }

        /* Ensure footer doesn’t shrink */
        footer {
            flex-shrink: 0;
        }

        .planner-header {
            max-width: 700px;
            margin: 3rem auto 1.5rem;
            text-align: center;
        }

        .planner-header h2 {
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #0d6efd;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.1);
        }

        .container.card-container {
            background: #fff;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 8px 24px rgb(0 0 0 / 0.05);
            background-image: radial-gradient(circle, #f0f8ff 1px, transparent 1px);
            background-size: 20px 20px;
            max-width: 700px;
            margin: 0 auto 3rem;
        }

        .card {
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.15);
            background: linear-gradient(135deg, #e0f0ff, #ffffff);
            transition: transform 0.3s ease;
            padding: 1.5rem;
            border: none;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 123, 255, 0.3);
        }

        #helloWorld h5 {
            border-left: 5px solid #0d6efd;
            padding-left: 10px;
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, #0d6efd, #0056b3);
            border: none;
            transition: background 0.4s ease;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: linear-gradient(45deg, #0056b3, #0d6efd);
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.7);
        }

        .btn-success {
            background: linear-gradient(45deg, #198754, #146c43);
            border: none;
            transition: background 0.4s ease;
        }

        .btn-success:hover,
        .btn-success:focus {
            background: linear-gradient(45deg, #146c43, #198754);
            box-shadow: 0 0 10px rgba(25, 135, 84, 0.7);
        }

        #tripPlannerForm {
            /* We'll repurpose this id */
            margin-bottom: 2rem;
        }

        #helloWorld {
            display: none;
        }

        #tripInfo {
            padding: 1.5rem;
            background: #f8f9fa;
            border-left: 6px solid #0d6efd;
            border-radius: 0 0.75rem 0.75rem 0;
            color: black;
            font-weight: 600;
            white-space: pre-line;
        }

        #tripInfo p {
            margin-bottom: 0.6rem;
            display: flex;
            flex-direction: column;
        }

        /* Highlight labels in bold */
        #tripInfo strong {
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="page-content">
        <section id="planner">
            <div class="planner-header">
                <h2>Smart Trip Planner</h2>
            </div>
            <div class="container card-container">
                <div class="card" id="tripPlannerForm">

                    <div class="mb-3">
                        <label for="origin" class="form-label fw-semibold">Origin</label>
                        <input type="text" id="origin" class="form-control" placeholder="e.g. Kathmandu" autocomplete="off" />
                    </div>
                    <div class="mb-3">
                        <label for="destination" class="form-label fw-semibold">Destination</label>
                        <input type="text" id="destination" class="form-control" placeholder="e.g. Langtang" autocomplete="off" />
                    </div>
                    <button type="button" onclick="search_plan_manually(this)" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Plan My Trip
                    </button>
                </div>

                <div id="helloWorld" class="mt-4">
                    <h5>Trekking Information</h5>
                    <div id="tripInfo">
                        <!-- trek details loaded here -->
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function parseSmartResponse(responseText) {
            const lines = responseText.trim().split('\n').filter(line => line.trim() !== '');
            let html = '';
            let insideWaypoints = false;

            lines.forEach(line => {
                const lower = line.toLowerCase();

                if (lower.includes('waypoints')) {
                    html += `<p style='font-size:20px;margin-bottom:20px;' class="fw-bold mt-4">Waypoints</p>`;
                    line = line.split('points:')[1];
                    let routes = line.split('-');
                    routes.forEach(route => {
                        html += `<h5 style='background: #e3e3e3;padding: 15px;'><strong>${route.trim()}</strong></h5>`;
                    });
                } else {
                    // Check for known labels
                    const labelMatch = line.match(/^(Permit Requirements|Guide Requirement|Best Season|Difficulty Level|Estimated Cost|Trek Time)\s*[:\-]?\s*(.*)$/i);
                    if (labelMatch) {
                        const label = labelMatch[1];
                        const content = labelMatch[2];
                        html += `<p><strong>${label}:</strong> ${content}</p>`;
                    } else {
                        // Fallback for any unmatched lines
                        html += `<p>${line}</p>`;
                    }
                }
            });

            return html;
        }

        function search_plan_manually(btn) {
            const origin = document.getElementById("origin").value.trim();
            const destination = document.getElementById("destination").value.trim();

            if (!origin || !destination) {
                alert("Please enter both origin and destination.");
                return;
            }

            btn.disabled = true;
            btn.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i>Planning...`;

            fetch(`smart_plan.php?origin=${encodeURIComponent(origin)}&destination=${encodeURIComponent(destination)}`)
                .then(res => res.text())
                .then(data => {
                    document.getElementById("helloWorld").style.display = "block";
                    document.getElementById("tripInfo").innerHTML = parseSmartResponse(data);
                    let iframe = document.createElement('iframe');
                    iframe.className = 'map';
                    iframe.style = 'width:100%;height:400px;border:1px solid;margin: 20px 0;';
                    iframe.src = `map.php?origin=${origin}&dest=${destination}`;
                    document.getElementById("tripInfo").appendChild(iframe);
                })
                .catch(err => {
                    alert("Failed to fetch trip plan: " + err.message);
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = `<i class="fas fa-search me-2"></i>Plan My Trip`;
                });
        }
    </script>
</body>

</html>
