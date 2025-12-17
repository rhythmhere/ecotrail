<?php
include_once('../classes/connect.php');
$DB = new Database();
$cache = '';
$message = '';
$isError = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cache = $_POST['place'];
    $name = strtolower($_POST['place']);
    $result = $DB->read("SELECT * from places where name='$name' limit 1");
    if (is_array($result)) {
        $isError = true;
        $message = "$cache already exists!";
    } else {
        if ($DB->save("INSERT INTO places (name) values ('$name')")) {
            $isError = false;
            $message = "$cache uploaded successfully!";
        }
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
        #statusMessage {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid;
            display: none;
        }

        #statusMessage.success {
            color: green;
            display: block;
        }

        #statusMessage.error {
            color: red;
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
                    echo "<div id='statusMessage' class='";
                    if ($isError)
                        echo 'error';
                    else
                        echo 'success';
                    echo "'>$message</div>";
                }
                ?>
                <form id="tripPlannerForm" class="space-y-6" method="post">
                    <div>
                        <label for="destination" class="block text-lg font-medium text-gray-700 mb-2">Place Name</label>
                        <input id="destination"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            name="place"></input>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300">
                        Submit Place
                    </button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>