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
    <title>Trip Planner</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* --- Sticky footer flexbox fix --- */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        /* --- Your existing styles below --- */

        body {
            background-color: #f0f4ff;
            /* padding-bottom removed, handled by flexbox */
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

        #tripPlannerForm {
            display: none;
        }

        #helloWorld {
            display: none;
        }

        #followBTN {
            display: none;
        }

        #statusMessage {
            display: none;
            color: green;
            border: 1px solid;
            padding: 10px;
            margin-top: 10px;
        }

        #tripInfo .waypoints {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 10px;
        }

        #tripInfo .waypoints .point {
            padding: 14px;
            background: rgba(124, 134, 185, 0.22);
            color: black;
            border-radius: 16px;
        }

        #tripInfo .waypoints .sponsors {
            margin-left: 20px;
        }

        #tripInfo .waypoints .sponsors .title {
            color: black;
            width: fit-content;
            padding: 2px 13px;
            border-radius: 38px;
            background: orange;
            font-size: 13px;
            margin: 10px 0;
        }

        #tripInfo .waypoints .sponsors ul {
            display: flex;
            gap: 10px;
            list-style: disc;
            flex-direction: column;
        }

        #trekInformative p {
            margin-bottom: 0;
        }

        #trekInformative .font-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="page-content">
        <section id="planner">
            <div class="planner-header">
                <h2>Destination Trip Planner</h2>
            </div>
            <div class="container card-container">
                <div class="card">

                    <!-- Popular Plans -->
                    <div id="popularPlans" class="mb-4">
                        <div class="mb-3">
                            <label for="populars" class="form-label fw-semibold">Select Plan</label>
                            <select id="populars" class="form-select" name="origin" list="all_places" style="padding:12px;">
                                <?php
                                if (is_array($populars)) {
                                    foreach ($populars as $popular) {
                                        echo "<option value='$popular[plan_id]'>$popular[name]</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <button type="button" onclick="search_plan_popular(this)" class="btn btn-primary w-100 mb-2" style="padding:12px;">
                            <i class="fas fa-search me-2"></i>Check Plans
                        </button>
                        <p style="font-size:18px;text-align:center;">
                            Trip not included?
                            <a href="ai_planner.php">Use Smart Planner</a> instead!
                        </p>
                    </div>

                    <!-- Manual Entry -->
                    <div id="tripPlannerForm" class="mb-4">
                        <div class="mb-3">
                            <label for="origin" class="form-label fw-semibold">Origin</label>
                            <input id="origin" class="form-control" name="origin" list="all_places"
                                autocomplete="off" />
                        </div>
                        <div class="mb-3">
                            <label for="destination" class="form-label fw-semibold">Destination</label>
                            <input id="destination" class="form-control" name="destination" list="all_places"
                                autocomplete="off" />
                        </div>

                        <datalist id="all_places">
                            <?php
                            foreach ($places as $place) {
                                echo "<option id='p_$place[name]' data-value='$place[id]'>$place[name]</option>";
                            }
                            ?>
                        </datalist>

                        <button type="button" onclick="search_plan_manually(this)" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Check Plans
                        </button>
                    </div>

                    <!-- Trek Info -->
                    <div id="helloWorld" class="mt-4">
                        <h5 class="fw-bold text-dark">Trekking Information</h5>
                        <div id="tripInfo" class="p-3 bg-light border-start border-primary rounded">
                            <!-- trek details loaded here -->
                        </div>

                        <?php if ($logged): ?>
                            <button type="button" id="followBTN" onclick="follow_plan(this)"
                                class="btn btn-success mt-3 w-100">
                                <i class="fas fa-bell me-2"></i>Follow Plan
                            </button>
                            <div id="statusMessage" class="mt-2"></div>
                            <small class="text-muted">You will get alerts personalized for you by following a plan!</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let tripInfo = document.getElementById("tripInfo");
        let helloWorld = document.getElementById("helloWorld");
        let followBTN = document.getElementById("followBTN");
        let manual = false;

        function follow_plan(ele) {
            let temp = ele;
            ele = ele.parentElement;
            if (manual) {
                let parent = ele.parentElement;
                let origin = parent.querySelector('#origin').value;
                let destination = parent.querySelector("#destination").value;

                if (origin && destination) {
                    origin = document.getElementById(`p_${origin}`);
                    origin = origin ? origin.dataset.value : null;
                    destination = document.getElementById(`p_${destination}`);
                    destination = destination ? destination.dataset.value : null;
                    if (origin && destination) {
                        followPlan(temp, true, origin, destination);
                    }
                }
            } else {
                let plan = ele.parentElement.querySelector("#populars").value;
                followPlan(temp, false, plan);
            }
        }

        function followPlan(btn, manual, place, destination = 0) {
            let url = '';
            if (manual) {
                url = `ajax/followPlan.php?o=${place}&d=${destination}`;
            } else {
                url = `ajax/followPlan.php?plan=${place}`;
            }
            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(data => {
                    btn.style.display = 'none';
                    let msgDiv = document.getElementById('statusMessage');
                    if (msgDiv) {
                        msgDiv.style.display = 'block';
                        msgDiv.textContent = data;
                    }
                })
                .catch(err => {
                    console.error("Error following plan:", err);
                });
        }

        function search_plan_popular(ele) {
            let plan = ele.parentElement.querySelector("#populars").value;
            fetch(`ajax/trekinfo.php?plan=${plan}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(data => {
                    helloWorld.style.display = 'block';
                    if (followBTN && data !== 'No any plans found!') {
                        followBTN.style.display = 'block';
                    }
                    tripInfo.innerHTML = data;
                })
                .catch(err => {
                    console.error("Error loading plan:", err);
                });
        }


    </script>
</body>

</html>