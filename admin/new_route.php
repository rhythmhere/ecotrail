<?php
include_once('../classes/functions.php');
$DB = new Database();
$places = get_all_places();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $permits = $_POST['permits'];
    $guide = $_POST['guide'];
    $guideFee = $_POST['guideFee'];
    $bestSeasons = $_POST['best_seasons'];
    $level = $_POST['level'];
    $altitude = $_POST['altitude'];
    $checkpoints = $_POST['checkpoints'];

    if (is_array($bestSeasons)) {
        $bestSeasons = implode(",", $bestSeasons);
    }
    //origin 	destination 	permits 	guide 	guide_fee 	season 	level 	altitude 	
    $query = "INSERT into plans (origin,destination,permits,guide,guide_fee,season,level,altitude) values 
        ('$origin','$destination','$permits','$guide','$guideFee','$bestSeasons','$level','$altitude')";
    if ($DB->save($query)) {
        if ($checkpoints) {
            $checkpoints = json_decode($checkpoints);
            $id = get_latest_plan_id();
            if ($id) {
                foreach ($checkpoints as $point) {
                    $query = "insert into routes (plan_id,place) values ('$id','$point')";
                    $DB->save($query);
                }
            }
        }
        header("Location: ../index.php");
        die;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        #permit_lists {
            margin-bottom: 10px;
            list-style: disc;
            margin-left: 20px;
        }

        #checkpoint_s {
            margin-bottom: 10px;
            list-style: numbers;
            margin-left: 40px;
        }
    </style>
</head>

<body>
    <section id="planner" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Destination Trip Planner</h2>
            <div class="max-w-2xl mx-auto bg-gray-50 rounded-xl shadow-md p-6 md:p-8">
                <form method="post" id="tripPlannerForm" class="space-y-6">
                    <input type="text" id="f_permits" name="permits" hidden>
                    <input type="text" id="f_checkpoints" name="checkpoints" hidden>
                    <input type="text" id="f_origin" name="origin" hidden>
                    <input type="text" id="f_destination" name="destination" hidden>
                    <div>
                        <label for="destination" class="block text-lg font-medium text-gray-700 mb-2">Origin</label>
                        <input id="origin"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            list="all_places"></input>
                    </div>
                    <div>
                        <label for="destination"
                            class="block text-lg font-medium text-gray-700 mb-2">Destination</label>
                        <input id="destination"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            list="all_places"></input>
                    </div>
                    <div>
                        <label for="permits" class="block text-lg font-medium text-gray-700 mb-2">Permits</label>
                        <ul id="permit_lists">
                        </ul>
                        <input id="permits" placeholder="type and press enteer" onkeyup="handle_permits(event)"
                            id="permits"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></input>
                    </div>
                    <div>
                        <label for="guide" class="block text-lg font-medium text-gray-700 mb-2">Guide Required</label>
                        <select id="guide"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            name="guide">
                            <option value="0">Optional</option>
                            <option value="1">Highly Recommended</option>
                            <option value="2">Required</option>
                        </select>
                    </div>
                    <div>
                        <label for="guideFee" class="block text-lg font-medium text-gray-700 mb-2">Estimated Guide
                            Fee(If required)</label>
                        Rs.<input id="guideFee"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            name="guideFee"></input>
                    </div>
                    <div>
                        <label for="best_seasons" class="block text-lg font-medium text-gray-700 mb-2">Best Seasons to
                            go</label>
                        <select id="best_seasons"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            name="best_seasons[]" multiple>
                            <option value="Spring">Spring (Mar-May)</option>
                            <option value="Summer">Summer (Jun-Aug)</option>
                            <option value="Autumn">Autumn (Sep-Nov)</option>
                            <option value="Winter">Winter (Dec-Feb)</option>
                        </select>
                        <small>Hold Ctrl (Windows) or Cmd (Mac) to select multiple seasons</small>
                    </div>
                    <div>
                        <label for="level" class="block text-lg font-medium text-gray-700 mb-2">Difficulty Level</label>
                        <select id="level"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            name="level">
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                    <div>
                        <label for="altitude" class="block text-lg font-medium text-gray-700 mb-2">Altitude (In
                            m)</label>
                        <input id="altitude"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            name="altitude"></input>
                    </div>

                    <div>
                        <label for="checkpoints" class="block text-lg font-medium text-gray-700 mb-2">Check
                            Points</label>
                        <ul id="checkpoint_s">
                        </ul>
                        <input placeholder="type and press enteer" onkeyup="handle_checkpoints(event)" id="checkpoints"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            list="all_places"></input>
                    </div>

                    <datalist id="all_places">
                        <?php
                        foreach ($places as $place) {
                            echo "<option id='p_$place[name]' data-value='$place[id]'>$place[name]</option>";
                        }
                        ?>
                    </datalist>
                    <button type="button" onclick="submit_form(this)"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300">Submit
                        Route</button>
            </div>
        </div>
        </div>
    </section>

    <script>
        let permit_lists = document.getElementById("permit_lists");
        let checkpoints = document.getElementById("checkpoint_s");
        let to_add_permits = [];
        let to_add_checkpoints = [];



        function handle_permits(ev) {
            ev.preventDefault();
            if (ev.keyCode == 13) {
                let value = ev.target.value.trim();
                if (value) {
                    if (to_add_permits.includes(value)) {
                        alert("Permit already selected.");
                        return;
                    }
                    to_add_permits.push(value);
                    permit_lists.innerHTML += `<li>${value}</li>`;
                    ev.target.value = '';
                }
                else
                    alert("NO ANIME SELECTED");
            }
        }

        function handle_checkpoints(ev) {
            ev.preventDefault();
            if (ev.keyCode == 13) {
                let value = ev.target.value.trim();
                let name = value;
                let ele = document.getElementById(`p_${value}`)
                if (ele) {
                    value = ele.dataset.value;
                    if (value) {
                        if (to_add_checkpoints.includes(value)) {
                            alert("Check Point already selected.");
                            ev.target.value = '';
                            return;
                        }
                        to_add_checkpoints.push(value);
                        checkpoints.innerHTML += `<li>${name}</li>`;
                        ev.target.value = '';
                    }
                    else
                        alert("NO ANIME SELECTED");
                }
            }
        }
        function submit_form(btn) {
            let origin = document.getElementById("origin").value;
            let destination = document.getElementById("destination").value;

            let op = document.getElementById(`p_${origin}`);
            let dp = document.getElementById(`p_${destination}`);
            if (op) {
                document.getElementById("f_origin").value = op.dataset.value;
            }
            if (dp) {
                document.getElementById("f_destination").value = dp.dataset.value;
            }

            let guideFee = document.getElementById("guideFee").value;
            let altitude = document.getElementById("altitude").value;

            if (to_add_checkpoints.length > 1) {
                document.getElementById("f_checkpoints").value = JSON.stringify(to_add_checkpoints);
            }
            if (to_add_permits.length > 1) {
                document.getElementById("f_permits").value = JSON.stringify(to_add_permits);
            }

            let form = btn.parentElement;
            form.submit();
        }
    </script>
</body>

</html>