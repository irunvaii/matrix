<?php
if (!defined('OK_LOADME')) {
    die('o o p s !');
}

if (isset($FORM['getId']) && $FORM['getId'] > 0) {
    $getId = intval($FORM['getId']);
    $getMpid = intval($FORM['getMpid']);

    // get array of current member
    $mbrmpidarr = array();
    $userData = $db->getRecFrmQry("SELECT * FROM " . DB_TBLPREFIX . "_mbrplans WHERE 1 AND idmbr = '{$mbrstr['id']}' AND mpstatus = '1'");
    if (count($userData) > 0) {
        foreach ($userData as $val) {
            $mbrmpidarr[] = ':' . $val['mpid'] . '|';
        }
    }
    // get target member details
    $rowstr = getmbrinfo($getId);
    $rowMpidstr = getmbrinfo('', '', $getMpid);

    if (($rowMpidstr['id'] != $rowstr['id'] && $rowMpidstr['idmbr'] > 0) || (str_replace($mbrmpidarr, '', $rowstr['sprlist']) == $rowstr['sprlist']) && $rowstr['idref'] != $mbrstr['id'] && $rowstr['idspr'] != $mbrstr['id']) {

        redirpageto('index.php?hal=userlist');
        exit;
    }

    $bpprow = ppdbplan($rowstr['mppid']);

    $mbr_sosmed = get_optionvals($rowstr['mbr_sosmed']);
    $mbr_twitter = $mbr_sosmed['mbr_twitter'];
    $mbr_facebook = $mbr_sosmed['mbr_facebook'];

    $status_arr = array('0' => $LANG['g_inactive'], '1' => $LANG['g_active'], '2' => $LANG['g_limited'], '3' => $LANG['g_pending']);
    $statusstr = select_opt($status_arr, $rowstr['mbrstatus'], 1);

    $mbr_imagestr = ($rowstr['mbr_image']) ? $rowstr['mbr_image'] : $cfgrow['mbr_defaultimage'];

    $countrystr = select_opt($country_array, $rowstr['country'], 1);
    $countrystr = strtolower($countrystr);
    $countrystr = ucwords($countrystr);

    $mbrsite_catstr = select_opt($webcategory_array, $rowstr['mbrsite_cat'], 1);

    $showsite_cekicon = ($rowstr['showsite'] == 1) ? '<i class="fa fa-fw fa-check-circle text-success"></i>' : '<i class="fa fa-fw fa-times-circle text-danger"></i>';
    $optinme_cekstr = checkbox_opt($rowstr['optinme'], $rowstr['optinme'], 1);

    if ($rowstr['mpid'] < 1) {
        $markstatus = "<span class='alert alert-dark text-uppercase'>{$LANG['g_registeredonly']}</span>";
    } else {
        if ($rowstr['mpstatus'] == 1) {
            $markstatus = "<span class='alert alert-success text-uppercase'>{$LANG['g_active']}</span>";
        } else {
            $markstatus = "<span class='alert alert-secondary text-uppercase'>{$LANG['g_inactive']}</span>";
        }
    }

    if ($rowstr['mbrstatus'] != 1) {
        $markstatus .= "<span class='alert alert-danger' data-toggle='tooltip' title='{$LANG['g_inactiveaccount']}'><i class='fa fa-fw fa-exclamation-triangle'></i></span>";
    }

    $condition = " AND sprlist LIKE '%:{$rowstr['mpid']}|%'";
    $row = $db->getAllRecords(DB_TBLPREFIX . '_mbrplans', 'COUNT(*) as totref', $condition);
    $myreftotal = $row[0]['totref'];

    $backpage = ($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "index.php?hal=userlist";

    $rowrefstr = getmbrinfo($rowstr['idref']);
    $rowsprstr = getmbrinfo($rowstr['idspr']);
} else {
    redirpageto('index.php?hal=dashboard');
    exit;
}
?>

<div class="section-header">
    <h1><i class="fa fa-fw fa-user-circle"></i> <?php echo myvalidate($LANG['g_memberprofile']); ?></h1>
</div>

<div class="section-body">

    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="<?php echo myvalidate($mbr_imagestr); ?>" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label"><?php echo myvalidate($LANG['g_hits']); ?></div>
                            <div class="profile-widget-item-value"><?php echo myvalidate($rowstr['hits']); ?></div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label"><?php echo myvalidate($LANG['g_referrals']); ?></div>
                            <div class="profile-widget-item-value"><?php echo myvalidate($myreftotal); ?></div>
                        </div>
                    </div>
                </div>
                <div class="profile-widget-description">
                    <div class="profile-widget-name">
                        <div class="text-muted d-inline text-small"><?php echo myvalidate($LANG['g_username']); ?>:</div> <?php echo myvalidate($rowstr['username']); ?> <div class="text-muted d-inline font-weight-normal text-small"><div class="slash"></div> <?php echo formatdate($rowstr['in_date'], 'dt'); ?></div>
                    </div>
                    <?php echo base64_decode($rowstr['mbr_intro']); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <a href="javascript:;" onclick="location.href = 'index.php?hal=userlist&dohal=filter&doval=<?php echo myvalidate($rowstr['id']); ?>&dompid=<?php echo myvalidate($rowstr['mpid']); ?>'" class="btn btn-sm btn-block btn-round btn-info" data-toggle="tooltip" title="<?php echo myvalidate($LANG['g_referrallist']); ?>"><i class="fa fa-fw fa-user-friends"></i> Referral</a>
                </div>
                <div class="col-sm-12 col-md-6">
                    <a href="javascript:;" onclick="location.href = 'index.php?hal=genealogyview&loadId=<?php echo myvalidate($rowstr['mpid']); ?>'" class="btn btn-sm btn-block btn-round btn-info" data-toggle="tooltip" title="Genealogy Structure"><i class="fa fa-fw fa-sitemap"></i> Structure</a>
                </div>
            </div>
            <div class="d-block d-sm-none">
                &nbsp;
            </div>

            <article class="article mt-4">
                <div class="article-header">
                    <div class="article-image" data-background="<?php echo myvalidate($bpprow['planimg']); ?>">
                    </div>
                    <div class="article-title">
                        <h2 class="badge badge-primary"><?php echo ($bpprow['ppname']) ? myvalidate($bpprow['ppname']) : $cfgrow['site_name']; ?> - <?php echo ($bpprow['regfee'] > 0) ? myvalidate($bpprow['currencysym'] . $bpprow['regfee'] . ' ' . $bpprow['currencycode']) : $LANG['g_free']; ?></h2>
                    </div>
                </div>
                <div class="article-details">
                    <div><?php echo ($bpprow['planinfo']) ? myvalidate($bpprow['planinfo']) : '-'; ?></div>
                    <div class='article-cta mt-4'>
                        <?php echo myvalidate($markstatus); ?>
                    </div>
                </div>
            </article>

        </div>

        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <form method="post" class="needs-validation" novalidate="">
                    <div class="card-header">
                        <h4><?php echo myvalidate($LANG['g_accoverview']); ?></h4>
                        <?php
                        if ($rowstr['mbrbiolink']) {
                            ?>
                            <div class="card-header-action">
                                <a class="btn btn-icon btn-info" href="<?php echo myvalidate($rowstr['mbrbiolink']); ?>" data-toggle="tooltip" title="Visit referral Bio Page" target="_blank"><i class="fas fa-user-tie"></i></a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label><?php echo myvalidate($LANG['g_referrer']); ?></label>
                                <h6 class="alert alert-light"><?php echo myvalidate($rowrefstr['username']); ?></h6>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label><?php echo myvalidate($LANG['g_sponsor']); ?></label>
                                <h6 class="alert alert-light"><?php echo myvalidate($rowsprstr['username']); ?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label><?php echo myvalidate($LANG['g_firstname']); ?></label>
                                <h6><?php echo myvalidate($rowstr['firstname']); ?></h6>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label><?php echo myvalidate($LANG['g_lastname']); ?></label>
                                <h6><?php echo myvalidate($rowstr['lastname']); ?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label><?php echo myvalidate($LANG['g_email']); ?></label>
                                <h6><?php echo maskmail($rowstr['email']); ?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label><?php echo myvalidate($LANG['m_phone']); ?></label>
                                <h6><?php echo myvalidate($rowstr['phone']); ?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label><?php echo myvalidate($LANG['m_address']); ?></label>
                                <h6><?php echo myvalidate($rowstr['address']); ?> <?php echo myvalidate($rowstr['state']); ?></h6>
                                <h6><?php echo myvalidate($countrystr); ?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label><?php echo myvalidate($LANG['g_website']); ?> <?php echo myvalidate($showsite_cekicon); ?></label>
                                <div class="text-muted font-weight-normal"><?php echo myvalidate($mbrsite_catstr); ?></div>
                                <h6><a href="<?php echo myvalidate($rowstr['mbrsite_url']); ?>" target="_blank"><?php echo myvalidate($rowstr['mbrsite_title']); ?></a></h6>
                                <div class="text-muted form-text">
                                    <?php echo base64_decode($rowstr['mbrsite_desc']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label><?php echo myvalidate($LANG['g_notifyoptin']); ?></label>
                                <h6><?php echo myvalidate($optinme_cekstr); ?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12"><?php
                                if ($mbr_twitter) {
                                    ?>
                                    <span class="badge badge-success">
                                        <i class="fab fa-fw fa-twitter"></i> <?php echo myvalidate($mbr_twitter); ?>
                                    </span>
                                    <?php
                                }
                                if ($mbr_facebook) {
                                    ?>
                                    <span class="badge badge-success">
                                        <i class="fab fa-fw fa-facebook-f"></i> <?php echo myvalidate($mbr_facebook); ?>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke text-right">
                        <a href="javascript:;" onclick="location.href = '<?php echo myvalidate($backpage); ?>'" class="btn btn-warning" data-toggle="tooltip" title="Back"><i class="fa fa-fw fa-undo-alt"></i> <?php echo myvalidate($LANG['g_back']); ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
