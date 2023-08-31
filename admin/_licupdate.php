<?php
define('IS_UPDATER', 1);
include_once('../common/init.db.php');
include_once('../common/umver.php');

if ($FORM['key'] != '') {
    $key = base64_encode($FORM['key']);
    echo '<pre>';
    $result = dosupdate($key, $cfgrow['softversion'], $umbasever);

    if ($result) {
        echo ' [ok]';
        @unlink("_licupdate.php");
    }
    echo '</pre>';
    $destinationurl = 'index.php?hal=dashboard';
    echo "<meta http-equiv='refresh' content='1;url={$destinationurl}'>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Manual Updater</title>
        <meta name="author" content="<?php echo myvalidate($ssysout('SSYS_AUTHOR')); ?>">

        <link rel="shortcut icon" type="image/png" href="../assets/image/favicon.png"/>

        <!-- General CSS Files -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/fellow/fontawesome5121/css/all.min.css">

        <!-- CSS Libraries -->
        <link rel="stylesheet" href="../assets/css/pace-theme-minimal.css">

        <!-- Template CSS -->
        <link rel="stylesheet" href="../assets/css/fontmuli.css">
        <?php echo myvalidate($stylecolor_css); ?>
        <link rel="stylesheet" href="../assets/css/custom.css">

    </head>

    <body>
        <div id="app">

            <section class="section">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                            <div class="login-brand">
                                <img src="<?php echo myvalidate($site_logo); ?>" alt="logo" width="100" class="shadow-light<?php echo myvalidate($weblogo_style); ?>">
                            </div>

                            <div class="card card-warning">
                                <div class="card-header">
                                    <h4><?php echo $cfgrow['site_name']; ?></h4>
                                    <div class="card-header-action text-small text-light">
                                        <?php echo myvalidate($cfgrow['softversion'] . '.' . $umbasever); ?>
                                    </div>
                                </div>

                                <div class="card-body">

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <form method="get" id='umupdater' class="wizard-content mt-2">
                                                <div class="wizard-pane">

                                                    <div class="form-group">
                                                        <input type="text" name="key" id="key" class="form-control" value="" placeholder="License key or purchase code" autocomplete="off" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="text-center">
                                                            <button type="reset" name="reset" value="reset" id="reset" class="btn btn-warning">
                                                                <i class="fa fa-fw fa-undo"></i> Reset
                                                            </button>
                                                            <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary">
                                                                Continue <i class="fas fa-arrow-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="text-center text-small">
                Powered by <i class="fa fa-fw fa-heart"></i> <a href="<?php echo myvalidate(SSYS_URL); ?>"><?php echo myvalidate(SSYS_NAME); ?></a>
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

        <!-- Page Specific JS File -->

    </body>
</html>