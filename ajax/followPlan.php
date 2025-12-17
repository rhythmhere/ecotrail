<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../classes/functions.php";
$DB = new Database();

$email = $_SESSION["email"];

$planId = false;
$message = "No Plans Found for Alert.";

if (isset($_GET['plan'])) {
    $planId = $_GET['plan'];
} elseif (isset($_GET['o']) && isset($_GET['d'])) {
    $origin = $_GET['o'];
    $destination = $_GET['d'];
    $query = "SELECT * from plans where origin='$origin' && destination='$destination' limit 1";
    $result = $DB->read($query);
    if (is_array($result)) {
        $planId = $result[0]["id"];
    }
}

if ($planId) {
    $previous = $DB->read("SELECT followed from users where email='$email' limit 1");
    if (is_array($previous)) {
        $previous = $previous[0]["followed"];
        if ($previous && $previous != '') {
            $previous = json_decode($previous, true);
            if (is_array($previous)) {
                if (in_array($planId, $previous)) {
                    // already exists
                    $message = "Plan already followed!";
                } else {
                    $previous[] = $planId;
                    $final = json_encode($previous);
                    if ($DB->save("UPDATE users set followed='$final' where email='$email' limit 1")) {
                        $message = "Followed the plan!";
                    }
                }
            }
        } else {
            $new[] = $planId;
            $final = json_encode($new);
            if ($DB->save("UPDATE users set followed='$final' where email='$email' limit 1")) {
                $message = "Followed the plan!";
            }
        }
    }
}
echo $message;
?>