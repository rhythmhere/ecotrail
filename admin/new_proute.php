<?php
include_once('../classes/functions.php');
$DB = new Database();
$plans = get_all_plans();
$message = '';
if (isset($_GET['s']) && $_GET['s']) {
    $message = "Added to popular plans!";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $populars = $_POST['populars'];
    foreach ($populars as $value) {
        $plan = $DB->read("SELECT origin,destination from plans where id='$value' limit 1");
        if (is_array($plan)) {
            $plan = $plan[0];
            $from = ucwords(get_place_name($plan["origin"]));
            $to = ucwords(get_place_name($plan["destination"]));
            $planName = "$from to $to";
            $query = "INSERT into populars (plan_id,name) values ('$value','$planName')";
            $DB->save($query);
        }
    }
    header("Location: new_proute.php?s=1");
    exit();
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
        #statusMessage {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid;
            color: green;
            display: block;
        }
    </style>
</head>

<body>
    <section id="planner" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Destination Trip Planner</h2>
            <div class="max-w-2xl mx-auto bg-gray-50 rounded-xl shadow-md p-6 md:p-8">
                <?php
                if ($message) {
                    echo "<div id='statusMessage'>$message</div>";
                }
                ?>
                <form method="post" id="tripPlannerForm" class="space-y-6">
                    <div>
                        <label for="populars" class="block text-lg font-medium text-gray-700 mb-2">Select
                            popualars</label>
                        <select id="populars"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            name="populars[]" multiple>
                            <?php
                            if (is_array($plans)) {
                                foreach ($plans as $plan) {
                                    $from = ucwords(get_place_name($plan["origin"]));
                                    $to = ucwords(get_place_name($plan["destination"]));
                                    $planName = "$from to $to";
                                    echo "<option value='$plan[id]'>$planName</option>";
                                }
                            }
                            ?>
                        </select>
                        <small>Hold Ctrl (Windows) or Cmd (Mac) to select multiple seasons</small>
                    </div>

                    <button type="submit" onclick="submit_form(this)"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300">Submit
                        Popular Plan</button>
            </div>
        </div>
        </div>
    </section>
</body>

</html>