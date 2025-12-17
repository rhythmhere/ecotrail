<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../classes/functions.php";
$DB = new Database();
$userId = get_userid($_SESSION['email']);
$input = file_get_contents("php://input");
if ($input) {
    $input = json_decode($input, true);
    if (isset($input["action"])) {
        if ($input["action"] == "reply") {
            $content = addslashes(htmlspecialchars($input['content']));
            $cId = $input["comment"];
            $query = "INSERT INTO comments (postid,userid,content,parent) VALUES ('$cId','$userId','$content','1')";
            if ($DB->save($query)) {
                echo "success";
            }
        }
    }
}
return 'failed';
