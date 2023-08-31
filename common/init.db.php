<?php

include_once('config.php');
if (!defined('INSTALL_PATH')) {
    define('INSTALL_PATH', '');
}

$setsesname = md5(DB_NAME . INSTALL_PATH);
session_name($setsesname);
session_start();

if (INSTALL_PATH == '') {
    header("Location: ../install");
}
if (!defined('OK_LOADME')) {
    die("<title>Error!</title><body>No such file or directory.</body>");
}
// -----

$FORM = array_merge((array) $FORM, (array) $_REQUEST);
$LANG = array_merge((array) $LANG, (array) $lang);

// database
include_once('db.func.php');

$dsn = "mysql:dbname=" . DB_NAME . ";host=" . DB_HOST . "";
$pdo = "";

try {
    $pdo = new PDO($dsn, base64_decode(DB_USER), base64_decode(DB_PASSWORD));
    $pdo->exec('SET CHARACTER SET utf8');

    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$db = new Database($pdo);
$db->doQueryStr("SET SESSION sql_mode = ''");

$tplstr = $cfgrow = $bpprow = $bpparr = $stcrow = $payrow = array();

// load site configuration
$didId = 1;

// settings
$row = $db->getAllRecords(DB_TBLPREFIX . '_configs', '*', ' AND cfgid = "' . $didId . '"');
foreach ($row as $value) {
    $cfgrow = array_merge($cfgrow, $value);
}
$cfgrow['md5sess'] = 'sess_' . md5(INSTALL_PATH) . '_';
$cfgrow['site_url'] = (defined('INSTALL_URL')) ? INSTALL_URL : trim($cfgrow['site_url']);
$site_logo = ($cfgrow['site_logo']) ? $cfgrow['site_logo'] : DEFIMG_LOGO;
$cfgtoken = get_optionvals($cfgrow['cfgtoken']);
$cfgrow['_isnocredit'] = (($cfgtoken['lictype'] != '2083' && $cfgtoken['licpk'] == '-') ||
        ($cfgtoken['lictype'] == '2083' && $cfgtoken['licpk'] != '')) ? true : false;
$langlist = base64_decode($cfgtoken['langlist']);
$langlistarr = json_decode($langlist, true);
if (empty(array_filter((array) $langlistarr))) {
    $langlistarr['en'] = 'English';
}

// dark css
if ($cfgtoken['isdarkthemeopt'] == 1) {
    $whatdarkcss = '<link rel="stylesheet" href="../assets/css/customdark.css">';
} else if ($cfgtoken['isdarkthemeopt'] == 2) {
    $whatdarkcss = '<link rel="stylesheet" href="../assets/css/customsidedark.css">';
} else {
    $whatdarkcss = '';
}
$customdark_css = ($cfgtoken['isdarktheme'] != 1) ? '' : $whatdarkcss;

// website logo style
switch ($cfgtoken['weblogostyle']) {
    case 'rounded':
        $weblogo_style = ' rounded';
        break;
    case 'circle':
        $weblogo_style = ' rounded-circle';
        break;
    case 'thumbnail':
        $weblogo_style = ' img-thumbnail img-shadow';
        break;
    default:
        $weblogo_style = '';
}

// custom color css
if ($cfgtoken['themeclr'] != '') {
    $stylecolor_css = '<link rel="stylesheet" href="../assets/css/colors/' . $cfgtoken['themeclr'] . '/style.css"><link rel="stylesheet" href="../assets/css/colors/' . $cfgtoken['themeclr'] . '/components.css">';
} else {
    $stylecolor_css = '<link rel="stylesheet" href="../assets/css/style.css"><link rel="stylesheet" href="../assets/css/components.css">';
}
