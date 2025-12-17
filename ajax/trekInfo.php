<?php
require_once "../classes/functions.php";
$DB = new Database();

if (isset($_GET['plan'])) {
    $plan = $_GET['plan'];
}
if (isset($_GET['o']) && isset($_GET['d'])) {
    $origin = $_GET['o'];
    $destination = $_GET['d'];
}
if (isset($_GET['plan'])) {
    $plan = $DB->read("SELECT origin,destination from plans where id='$plan' limit 1");
    if (is_array($plan)) {
        $plan = $plan[0];
        $origin = $plan['origin'];
        $destination = $plan['destination'];
    }
}
$oname = '';
$dname = '';
$query = "SELECT * from plans where origin='$origin' && destination='$destination' limit 1";

$result = $DB->read($query);
if (is_array($result)) {
    $plan = $result[0];
    $from = ucwords(get_place_name($origin));
    $oname = $from . ",Nepal";
    $to = ucwords(get_place_name($destination));
    $dname = $to . ",Nepal";
    $trekName = "$from - $to";
    $permits = $plan['permits'];
    if ($permits) {
        $permits = json_decode($permits, true);
        $permits = implode(", ", $permits);
    } else {
        $permits = 'None';
    }
    $guide = '';
    if ($plan['guide'] == 0) {
        $guide = 'Optional';
    } else if ($plan['guide'] == 1) {
        $guide = 'Highly Recommended';
    } else {
        $guide = '<strong>Required!</strong>';
    }
    if ($plan['guide_fee']) {
        $guide .= "<br>Est. Rs.$plan[guide_fee]";
    }
    $html = "
                        <h4 id='trek-name' class='font-bold text-lg text-blue-800'>$trekName</h4>
                        <div style='display:flex;flex-direction:column;gap:10px;margin:10px 0;' id='trekInformative'>
        <div>
                                <p class='font-bold text-gray-700'>Permit Requirements:</p>
                                <p id='permit-info' class='text-gray-600'>$permits</p>
                                </div>
                            
                            <div>
                                <p class='font-bold text-gray-700'>Guide Requirement:</p>
                                <p id='guide-info' class='text-gray-600'>$guide</p>
                            </div>
                            <div>
                                <p class='font-bold text-gray-700'>Best Season:</p>
                                <p id='season-info' class='text-gray-600'>$plan[season]</p>
                            </div>
                            <div>
                                <p class='font-bold text-gray-700'>Difficulty Level:</p>
                                <p id='difficulty-info' class='text-gray-600'>$plan[level]";
    if ($plan['altitude'])
        $html .= "<br>(Altitude up to $plan[altitude]m)";
    $html .= "</p>
                            </div>
                        </div>";

    $checkpoints = get_checkpoints($plan['id']);
    if (is_array($checkpoints)) {
        $html .= "
                         <br>
                         <div>
                             <h4 id='trek-name' class='font-bold text-lg text-blue-800'>Waypoints</h4>
                             <div class='waypoints'>";
        foreach ($checkpoints as $point) {
            $pname = ucwords(get_place_name($point['place']));
            $sponsors = get_sponsors($point['place']);
            $html .= "
                                 <div class='point'>
                                 <h5 id='point-name' class='font-bold text-lg text-blue-800'>$pname</h5>";
            if (is_array($sponsors)) {
                $html .= "<div class='sponsors' style='margin-left: 20px;'>
                <p class='title'>Sponsored</p>
                <ul>";
                foreach ($sponsors as $sponsor) {
                    $html .= "<li>$sponsor[HotelName] , $sponsor[address]</li>";
                }
                $html .= "</ul></div>";
            }
            $html .= "</div>";
        }
        $html .= "
                                 </div>
                             </div>
                         </div>";
    }
    echo $html;
} else {
    $from = ucwords(get_place_name($origin));
    $oname = $from . ",Nepal";
    $to = ucwords(get_place_name($destination));
    $dname = $to . ",Nepal";
    echo "No any plans found!";
}
echo "<iframe class='map' style='width:100%;height:400px;border:1px solid;margin: 20px 0;' src='map.php?origin=$oname&dest=$dname'>View Map</iframe>";
?>