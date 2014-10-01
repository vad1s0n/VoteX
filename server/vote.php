<?php
/**
 * Created by Vad1s0n
 * Date: 29.09.14
 * Time: 1:29
 * gitHub: https://github.com/vad1s0n/
 * Skype: keltus916
 */
if( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" ||
    $_SERVER['HTTP_HOST'] != $_SERVER['SERVER_NAME']
) {
    echo json_encode(array("error"=>"You're not permitted to this action"));
    exit;
}
require_once("Config.php");

Config::connect();

switch($_POST['action']) {
    case 'get_vote':
        $answer = Config::get_info();
        break;

    case 'vote':
        $answer = Config::vote($_POST['q'],$_POST['a']);
        break;
    default:
        $answer['error'] = "Action isn't defined";
}


echo json_encode($answer);