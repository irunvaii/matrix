<?php
include_once('../common/init.loader.php');

if ($cfgrow['site_status'] != 1) {
    redirpageto($cfgrow['site_url'] . '/' . MBRFOLDER_NAME . '/offline.php');
    exit;
}

$seskey = verifylog_sess('member');
if ($seskey != '') {
    $sesRow = getlog_sess($seskey);
    $username = get_optionvals($sesRow['sesdata'], 'un');

    // Get member details
    $mbrstr = getmbrinfo($username, 'username');
}

$goglacode = base64_decode($cfgtoken['goglacode']);

$thisyear = date("Y");
$site_subname = ($cfgtoken['site_subname'] != '') ? "<a href='{$cfgrow['site_url']}'>{$cfgtoken['site_subname']}</a>" : "<a href='{$ssysout('SSYS_URL')}/id/{$cfgrow['envacc']}' target='_blank'>{$cfgrow['site_name']}</a>";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="<?php echo myvalidate($LANG['lang_charset']); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title><?php echo myvalidate($cfgrow['site_name']); ?></title>

        <meta name="description" content="<?php echo myvalidate($cfgrow['site_descr']); ?>">
        <meta name="keywords" content="<?php echo myvalidate($cfgrow['site_keywrd']); ?>">
        <meta name="author" content="<?php echo myvalidate($ssysout('SSYS_AUTHOR')); ?>">

        <!-- General CSS Files -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/fellow/fontawesome5121/css/all.min.css">

        <link rel="shortcut icon" type="image/png" href="../assets/image/favicon.png"/>

        <!-- CSS Libraries -->
        <link rel="stylesheet" href="../assets/css/pace-theme-minimal.css">

        <!-- Template CSS -->
        <link rel="stylesheet" href="../assets/css/fontmuli.css">

        <?php echo myvalidate($stylecolor_css); ?>

        <?php echo myvalidate($goglacode); ?>

    </head>

    <body>
        <div id="app">
            <div class="main-wrapper">
                <div class="navbar-bg"></div>

                <!-- Main Content -->
                <div class="container">
                    <section class="section">
                        <div class="section-header">
                            <h1><?php echo myvalidate($cfgrow['site_name']); ?></h1>
                            <div class="section-header-breadcrumb">
                                <div class="breadcrumb-item">Digital Store</div>
                                <div class="breadcrumb-item active"><a href="<?php echo myvalidate($cfgrow['site_url'] . '/' . MBRFOLDER_NAME . '/register.php'); ?>">Register</a></div>
                                <div class="breadcrumb-item"><a href="<?php echo myvalidate($cfgrow['site_url'] . '/' . MBRFOLDER_NAME . '/'); ?>">Login</a></div>
                            </div>
                        </div>

                        <div class="section-body">
                            <div class="row">

                                <?php
                                $itscount = 0;
                                $itsuserlist = '';
                                $condition = " AND itid > '1' AND itname != '' AND itprice > '0' AND itstock >= '0' AND itimage != ''";
                                $condition .= " ORDER BY RAND() LIMIT 33";
                                $row = $db->getAllRecords(DB_TBLPREFIX . '_items LEFT JOIN ' . DB_TBLPREFIX . '_groups ON itgrid = grid', '*', $condition);
                                $pgcntrow = array();
                                foreach ($row as $value) {

                                    if ($value['itstatus'] != 1) {
                                        continue;
                                    }

                                    $itshash = md5($value['id'] . $value['itid'] . date("dh"));
                                    $itsimgstr = ($value['itimage']) ? $value['itimage'] : DEFIMG_FILE;

                                    $itsdesc = (strlen($value['itdescr']) > 196) ? substr($value['itdescr'], 0, 196) . '...' : $value['itdescr'];

                                    $ithash = md5($mdlhashy . $value['itid'] . '+' . $value['itstatus'] . $mbrstr['id']);
                                    $itsbuynow = "../" . MBRFOLDER_NAME . "/index.php?hal=orderpay&l={$ithash}&itid={$value['itid']}";

                                    $itpricenow = get_itpricebyplan($value, $mbrstr['mppid']);
                                    $itshits = $value['itview'];

                                    $itsuserlist .= <<<INI_HTML
    <div class="col-sm-12 col-md-6">
        <div class="card card-large-icons">
            <div class="card-icon bg-light text-white mx-auto text-center">
                <img src='{$itsimgstr}' alt='[^-^]' class='mr-3 img-fluid rounded mx-auto d-block' width='{$cfgrow['mbrmax_image_width']}' height='{$cfgrow['mbrmax_image_height']}'></i>
            </div>
            <div class="card-body">
                <h4>{$value['itname']}</h4>
                <h6><span class="badge badge-info">{$value['grtitle']}</span></h6>
                <p>{$itsdesc}</p>
                <div class='float-right'>
                <small class="text-muted">{$bpprow['currencysym']}{$itpricenow} {$bpprow['currencycode']}</small>&nbsp;
                <a href="javascript:;" onclick="location.href = '{$itsbuynow}'" class="btn btn-sm btn-primary"><i class="fas fa-shopping-bag"></i></a>
                </div>
            </div>
        </div>
    </div>
INI_HTML;
                                    $itscount++;
                                }

                                if ($itscount < 1) {
                                    $itsuserlist = <<<INI_HTML
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="empty-state">
                        <div class="empty-state-icon bg-info">
                            <i class="fas fa-unlink"></i>
                        </div>
                        <h2>{$LANG['g_nosite']}</h2>
                        <p class="lead">
                            {$LANG['g_nositenote']}
                        </p>
                    </div>
                </div>
            </div>
        </div>
INI_HTML;
                                }

                                echo myvalidate($itsuserlist);
                                ?>

                            </div>
                        </div>
                    </section>
                </div>
                <div class="simple-footer">
                    <!--
                    You are not allowed to remove this credit link unless you have right to do so
                    -->
                    <div class="text-small"><?php echo myvalidate($LANG['g_builtwith']); ?> <i class="fa fa-fw fa-heart"></i> <?php echo "{$thisyear} {$site_subname}{$cfgrow['_isnocreditstr']}"; ?>
                    </div>

                </div>      
            </div>
        </div>

        <!-- General JS Scripts -->
        <script src="../assets/js/jquery-3.4.1.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery.nicescroll.min.js"></script>
        <script src="../assets/js/moment.min.js"></script>
        <script src="../assets/js/pace.min.js"></script>

        <!-- JS Libraies -->
        <script src="../assets/js/stisla.js"></script>


        <!-- Template JS File -->
        <script src="../assets/js/scripts.js"></script>
        <script src="../assets/js/custom.js"></script>

        <!-- Page Specific JS File -->
    </body>
</html>
