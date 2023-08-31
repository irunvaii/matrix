<?php

include_once('../common/init.loader.php');

if (verifylog_sess('admin') == '') {
    die('o o p s !');
}
if ($mdlhasher != $FORM['mdlhasher']) {
    echo $LANG['a_loadingmdlcnt'];
    redirpageto('index.php', 1);
    exit;
}

$ppVal = base64_decode($FORM['ppVal']);
//echo $ppVal;

echo '<pre>';

$cmlistarr = get_sprppcm($FORM['ppId'], $ppVal);
//print_r($cmlistarr);

echo "When a new Referral registered on this #{$FORM['ppId']} (" . $bpparr[$FORM['ppId']]['ppname'] . "), the commission list for sponsors as follow:<br />";

foreach ($cmlistarr as $key1 => $value1) {
    echo "<br />Commission list for the sponsors on #{$key1} (" . $bpparr[$key1]['ppname'] . ")<br />";
    foreach ($value1 as $key2 => $value2) {
        echo "Tier {$key2}: {$value2}<br />";
    }
}

echo '</pre>';
