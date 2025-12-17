<?php
include_once('connect.php');

function get_posts()
{
    $DB = new Database();
    $result = $DB->read("SELECT * from posts order by id desc");
    if (is_array($result)) {
        return $result;
    }
    return false;
}

function is_admin($email)
{
    if (isset($_SESSION['email'])) {
        $DB = new Database();
        $user = $DB->read("SELECT admin from users where email='$_SESSION[email]' limit 1");
        if (is_array($user)) {
            $user = $user[0]['admin'];
            if ($user == 1)
                return true;
        }
    }
    return false;
}

function get_post_username($id)
{
    $DB = new Database();
    $result = $DB->read("SELECT * from users where id='$id' limit 1");
    if (is_array($result)) {
        $result = $result[0];
        $name = $result["FirstName"] . " " . $result["LastName"];
        return $name;
    }
    return false;
}
function get_commentor_name($id)
{
    $DB = new Database();
    $result = $DB->read("SELECT userid from comments where id='$id' limit 1");
    if (is_array($result)) {
        $result = $result[0]['userid'];
        $result = $DB->read("SELECT * from users where id='$result' limit 1");
        if (is_array($result)) {
            $result = $result[0];
            $name = $result["FirstName"] . " " . $result["LastName"];
            return $name;
        }
        return false;
    }
    return false;
}
function get_comments($id)
{
    $DB = new Database();
    $result = $DB->read("SELECT * from comments where (postId='$id' && parent='0') order by id desc");
    if (is_array($result)) {
        return $result;
    }
    return false;
}
function get_replies($id)
{
    $DB = new Database();
    $result = $DB->read("SELECT * from comments where (postId='$id' && parent='1')");
    if (is_array($result)) {
        return $result;
    }
    return false;
}
function get_userid($email)
{
    $DB = new Database();
    $result = $DB->read("SELECT id from users where email='$email' limit 1");
    if (is_array($result)) {
        return $result[0]['id'];
    }
    return false;
}
function get_all_places()
{
    $DB = new Database();
    $result = $DB->read("SELECT * from places");
    if (is_array($result))
        return $result;
    return false;
}
function get_user_name($email)
{
    $DB = new Database();
    $result = $DB->read("SELECT * from users where email='$email' limit 1");
    if (is_array($result)) {
        $result = $result[0];
        $name = $result["FirstName"] . $result["LastName"];
        return $name;
    }
    return false;
}
function get_my_followed_alerts($email)
{
    $DB = new Database();
    $associated = [];
    $result = $DB->read("SELECT followed from users where email='$email' limit 1");
    if (is_array($result)) {
        $followed = $result[0]['followed'];
        $followed = json_decode($followed, true);
        if(is_array($followed)){
        foreach ($followed as $follow) {

            $routes = $DB->read("select * from routes where plan_id='$follow'");
            if (is_array($routes)) {
                foreach ($routes as $route) {
                    $alerts = $DB->read("SELECT id from alerts where place_id='$route[place]' limit 1");
                    if (is_array($alerts)) {
                        $alertId = $alerts[0]["id"];
                        if (!in_array($alertId, $associated)) {
                            $associated[] = $alertId;
                        }
                    }
                }
            }
        }
        }else{
            return false;
        }

    }
    return $associated;
}
function get_sponsors($place)
{
    $DB = new Database();
    $result = $DB->read("SELECT * from sponsers where place='$place'");
    if (is_array($result))
        return $result;
    return false;
}

function get_popular_plans()
{
    $DB = new Database();
    $result = $DB->read("SELECT * from populars");
    if (is_array($result))
        return $result;
    return false;
}

function get_all_plans()
{
    $DB = new Database();
    $result = $DB->read("SELECT id,origin,destination from plans");
    if (is_array($result))
        return $result;
    return false;
}
function get_checkpoints($id)
{
    $DB = new Database();
    $checkpoints = $DB->read("SELECT * from routes where plan_id='$id'");
    if (is_array($checkpoints))
        return $checkpoints;
    return false;
}
function get_place_name($placeId)
{
    $DB = new Database();
    $name = $DB->read("SELECT * from places where id='$placeId' limit 1");
    if (is_array($name))
        return $name[0]['name'];
    return null;
}
function get_latest_plan_id()
{
    $DB = new Database();
    $id = $DB->read("SELECT id from plans order by id desc limit 1");
    if (is_array($id))
        return $id[0]['id'];
    return false;
}
?>