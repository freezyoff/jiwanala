<?php
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function getReferer() { return isset($_GET['referer'])? $_GET['referer'] : ""; }

function getActivity(){
    $key = false;
    if ( isset($_GET['activity']) ){
        $key = $_GET['activity'];
    }
    
    return $key? $key : 'visit';
}

function getUserID(){
    $userid = str_replace(' ', '', microtime().'');
    if (!isset($_COOKIE['jn_userid'])){
        setcookie("jn_userid", $userid, time()+(60*60*24*365));
        $_COOKIE['jn_userid'] = $userid;
    }
    
    return $_COOKIE['jn_userid'];
}

function getDevice(){
    if (stripos($_SERVER['HTTP_USER_AGENT'],"iPod")) return 'ipod';
    elseif (stripos($_SERVER['HTTP_USER_AGENT'],"iPhone")) return 'iphone';
    elseif (stripos($_SERVER['HTTP_USER_AGENT'],"iPad")) return 'ipad';
    elseif (stripos($_SERVER['HTTP_USER_AGENT'],"Android")) return 'android';
    elseif (stripos($_SERVER['HTTP_USER_AGENT'],"webOS")) return 'webos';
    else return 'desktop';
}

function save(){
    $username = "jiwanala_core";
    $password = "j1w4n4l4t3rb41k";
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=jiwanala_core', $username, $password);
        
        $sql = "INSERT INTO visitor (userid, device, ip, browser, referer, action) VALUES (?,?,?,?,?,?)";
        $stmt= $dbh->prepare($sql);
        $stmt->execute([$_COOKIE['jn_userid'], getDevice(), getRealIpAddr(), $_SERVER['HTTP_USER_AGENT'], getReferer(), getActivity()]);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        exit;
    }
}
?>