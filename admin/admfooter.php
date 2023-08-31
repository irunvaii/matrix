<?php

if (!defined('OK_LOADME')) {
    die('o o p s !');
}

$dotoaster = $_SESSION['dotoaster'];
$_SESSION['dotoaster'] = '';

$thisyear = date("Y");
$site_subname = ($cfgtoken['site_subname'] != '') ? "<a href='{$cfgrow['site_url']}'>{$cfgtoken['site_subname']}</a>" : "<a href='{$ssysout('SSYS_URL')}/id/{$cfgrow['envacc']}' target='_blank'>{$cfgrow['site_name']}</a>";
$admcustomstr = ($cfgtoken['istoastactvty'] == '1') ? '<script src="../assets/js/admcustom.js"></script>' : '';

if ($cfgtoken['isdarkthemeopt'] > 0) {
    $turnonofflink = "index.php?hal={$FORM['hal']}&turnto=";
    $turnonofficon = ($cfgtoken['isdarktheme'] != 1) ? "<a href='{$turnonofflink}on' data-toggle='tooltip' title='{$LANG['g_turntodark']}'><i class='fas fa-fw fa-lightbulb'></i></a>" : "<a href='{$turnonofflink}off' data-toggle='tooltip' title='{$LANG['g_turntolight']}'><i class='far fa-fw fa-lightbulb'></i></a>";
} else {
    
}
$admin_content = <<<INI_HTML
<footer class="main-footer">
    <div class="d-none d-sm-block footer-left">
        {$LANG['g_builtwith']} <i class="fa fa-fw fa-heart"></i> {$thisyear} <div class="bullet"></div> {$site_subname}{$cfgrow['_isnocreditstr']}
    </div>
    <div class="footer-right text-sm-left">
        {$turnonofficon}
    </div>
</footer>
</div>
</div>

        <!-- Template JS File -->
        <script src="../assets/js/scripts.js"></script>
        <script src="../assets/js/custom.js"></script>
        {$admcustomstr}
        <script src="../assets/js/notifytoast.js"></script>

        <!-- Page Specific JS File -->
        <script type="text/javascript">
        toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "preventDuplicates": true,
        "onclick": null
        }
        {$dotoaster}
        </script>

</body>
</html>
INI_HTML;
echo myvalidate($admin_content);
