<?php
include_once('../common/init.loader.php');

$page_header = $LANG['g_registration'];
include('../common/pub.header.php');

if (isset($FORM['dosubmit']) && $FORM['dosubmit'] == '1') {
    extract($FORM);

    $redirto = $_SESSION['redirto'];
    $_SESSION['redirto'] = '';

    $firstname = mystriptag($firstname);
    $lastname = mystriptag($lastname);
    $username = mystriptag($username, 'user');
    $email = mystriptag($email, 'email');

    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['show_msg'] = showalert('danger', $LANG['g_error'], $LANG['g_invalidinput']);
        $redirval = "?res=errinstr";
        redirpageto($redirval);
        exit;
    }

    if ($cfgtoken['isdupemail'] != 1) {
        $condition = ' AND email LIKE "' . $email . '" ';
        $sql = $db->getRecFrmQry("SELECT * FROM " . DB_TBLPREFIX . "_mbrs WHERE 1 " . $condition . "");
        if (count($sql) > 0) {
            $_SESSION['show_msg'] = showalert('danger', $LANG['g_error'], $LANG['g_erremailreg']);
            $redirval = "?res=emexist";
            redirpageto($redirval);
            exit;
        }
    }

    if ($cfgtoken['isautoregplan'] != 1 && $FORM['ppid'] < 1) {
        $_SESSION['show_msg'] = showalert('danger', $LANG['g_error'], $LANG['g_errneedplan']);
        $redirval = "?res=errplanreg";
        redirpageto($redirval);
        exit;
    }

    if ($FORM['isagree'] != '1') {
        $_SESSION['show_msg'] = showalert('danger', $LANG['g_error'], $LANG['g_termagree']);
        $redirval = "?res=erragrr";
        redirpageto($redirval);
        exit;
    }

    $isrecapv3 = 1;
    if ($cfgrow['isrecaptcha'] == 1 && $cfgtoken['isrcapcregin'] == 1 && isset($FORM['g-recaptcha-response'])) {
        $secret = $cfgrow['rc_securekey'];
        $response = $FORM['g-recaptcha-response'];
        $remoteIp = $_SERVER['REMOTE_ADDR'];
        // call curl to POST request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $secret, 'response' => $response, 'remoteip' => $remoteIp), '', '&'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($response, true);

        // verify the response
        if ($arrResponse["success"] == '1' && $arrResponse["score"] >= 0.5) {
            // valid submission
        } else {
            $isrecapv3 = 0;
        }
    }

    // reserved username
    $isunexist = is_unamereserved($username);

    // if new username exist, keep using old username
    $condition = ' AND username LIKE "' . $username . '" ';
    $sql = $db->getRecFrmQry("SELECT * FROM " . DB_TBLPREFIX . "_mbrs WHERE 1 " . $condition . "");

    if ($isrecapv3 == 0) {
        $_SESSION['show_msg'] = showalert('warning', $LANG['g_error'], $LANG['g_errcaptcha']);
        $redirval = "?res=rcapt";
    } elseif (count($sql) > 0 || $isunexist) {
        $_SESSION['show_msg'] = showalert('danger', $LANG['g_error'], $LANG['g_erruserexist']);
        $redirval = "?res=exist";
    } else {

        if (!dumbtoken($dumbtoken)) {
            $_SESSION['show_msg'] = showalert('danger', $LANG['g_error'], $LANG['g_invalidtoken']);
            $redirval = "?res=errtoken";
            redirpageto($redirval);
            exit;
        }

        $in_date = date('Y-m-d H:i:s', time() + (3600 * $cfgrow['time_offset']));

        $passres = passmeter($password);
        if ($password != $passwordconfirm) {
            $_SESSION['show_msg'] = showalert('danger', $LANG['g_error'], $LANG['g_errpassnotsame']);
            $redirval = "?res=errpass";
        } elseif ($passres == 1) {
            // stages
            $stgId = intval($FORM['ppid']);
            if ($stgId < 1 || $stgId > $frlmtdcfg['mxstages']) {
                $stgId = $bpprow['ppid'];
            }
            // if manual entering sponsor
            if ($cfgtoken['ismanspruname'] == 1) {
                $sesrefcek = getmbrinfo($myspruname, 'username');
                if ($sesrefcek['mpid'] > 0) {
                    $sesref = $sesrefcek;
                    $_SESSION['ref_sess_un'] = $sesrefcek['username'];
                }
            }

            // insert new registered
            $log_ip = get_userip();
            $country = get_countrycode($log_ip);
            $hashedpassword = getpasshash($password);
            $data = array(
                'in_date' => $in_date,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'username' => $username,
                'email' => $email,
                'password' => $hashedpassword,
                'log_ip' => $log_ip,
                'country' => $country,
                'mylang' => '',
            );

            if ($cfgtoken['ismbrneedconfirm'] == 1) {
                $data['isconfirm'] = 0;
                $data['mbrtoken'] = "|tempupw:" . base64_encode($passwordconfirm) . "|, |refidmbr:{$sesref['id']}|, |stgId:{$stgId}|";
            }
            $insert = $db->insert(DB_TBLPREFIX . '_mbrs', $data);
            $newmbrid = $db->lastInsertId();

            $_SESSION['firstname'] = $_SESSION['lastname'] = $_SESSION['username'] = $_SESSION['email'] = '';

            if ($insert) {
                if ($cfgtoken['ismbrneedconfirm'] != 1) {
                    do_regandnotif($newmbrid, $stgId, $sesref['id'], $firstname . ' ' . $lastname, $passwordconfirm);
                }

                addlog_sess($username, 'member');
                $redirval = $cfgrow['site_url'] . "/" . MBRFOLDER_NAME;
            } else {
                $redirval = "?res=errsql";
            }
        } else {
            $_SESSION['show_msg'] = showalert('warning', 'Password Hint', $passres);
            $redirval = "?res=errpass";
        }
    }
    redirpageto($redirval);
    exit;
}

$modalcontent = file_get_contents(INSTALL_PATH . "/common/terms.html");
$refbystr = ($sesref['username'] != '') ? "<div class='card-header-action'><span class='badge badge-info'>| {$sesref['username']}</span></div>" : '';

$show_msg = $_SESSION['show_msg'];
$_SESSION['show_msg'] = '';
?>
<section class="section">
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
                <div class="login-brand">
                    <img src="<?php echo myvalidate($site_logo); ?>" alt="logo" width="100" class="shadow-light<?php echo myvalidate($weblogo_style); ?>">
                    <div><?php echo myvalidate($cfgrow['site_name']); ?></div>
                </div>

                <?php echo myvalidate($show_msg); ?>

                <div class="card card-primary">
                    <form method="POST" class="needs-validation" id="regmbrform">
                        <div class="card-header">
                            <h4><?php echo myvalidate($LANG['g_registration']); ?></h4>
                            <?php
                            if ($cfgtoken['ismanspruname'] != 1) {
                                echo myvalidate($refbystr);
                            } else {
                                ?>
                                <div class='card-header-action'>
                                    <div class="card-header-form ">
                                        <div class="input-group">
                                            <input type="text" name="myspruname" value="<?php echo myvalidate($sesref['username']); ?>" class="form-control" placeholder="Sponsor Username" onBlur="checkMember('unexrev', this.value, '1')">
                                            <div class="input-group-btn">
                                                <span id="resultGetMbr1"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>

                        <div class="card-body">
                            <?php
                            if ($cfgrow['join_status'] != 1) {
                                echo showalert('danger', 'Oops!', $LANG['g_noregister']);
                            } elseif ($cfgrow['validref'] == 1 && $sesref['id'] < 1) {
                                echo showalert('warning', 'Oops!', $LANG['g_noreferrer']);
                            } else {
                                if ($cfgrow['isrecaptcha'] == 1 && $cfgtoken['isrcapcregin'] == 1) {
                                    echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
                                    $isrecaptcha_content = <<<INI_HTML
                                    <script type="text/javascript">
                                        function onSubmit(token) {
                                            document.getElementById('regmbrform').submit();
                                        }
                                    </script>
INI_HTML;
                                    echo myvalidate($isrecaptcha_content);
                                }

                                $condition = " AND planstatus = '1' AND ppname != ''";
                                $userData = $db->getRecFrmQry("SELECT * FROM " . DB_TBLPREFIX . "_payplans WHERE 1" . $condition . " ORDER BY ppid LIMIT 6");
                                $planlist_content = "<input type='hidden' name='ppid' value='1'>";
                                if ($cfgtoken['isautoregplan'] == 1) {
                                    if (count($userData) > 1) {
                                        $planlist_content = <<<INI_HTML
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label class="form-label">{$LANG['g_regplanlist']}</label>
                                        <div class="selectgroup w-100">
INI_HTML;
                                        foreach ($userData as $val) {
                                            $intrvalstr = get_periodintervalstr($val['expday']);
                                            $regamount = ($val['regfee'] > 0) ? $bpprow['currencysym'] . $val['regfee'] . ' ' . $bpprow['currencycode'] : $LANG['g_free'];
                                            $doselected = ($val['ppid'] == $FORM['go']) ? ' checked' : '';
                                            $planinfo = strip_tags($val['planinfo']);
                                            $pptitlepop = ($planinfo != '') ? $planinfo : $regamount . ' / ' . $intrvalstr;
                                            $planlist_content .= <<<INI_HTML
                                            <label class="selectgroup-item">
                                                <input type="radio" name="ppid" value="{$val['ppid']}" class="selectgroup-input"{$doselected} required>
                                                <div class="selectgroup-button" data-toggle="tooltip" title="{$pptitlepop}">{$val['ppname']}</div>
                                            </label>
INI_HTML;
                                        }
                                        $planlist_content .= <<<INI_HTML
                                        </div>
                                    </div>
                                </div>
INI_HTML;
                                    } else {
                                        $planlist_content = "<input type='hidden' name='ppid' value='{$userData[0]['ppid']}'>";
                                    }
                                }
                                ?>
                                <?php echo myvalidate($planlist_content); ?>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="firstname"><?php echo myvalidate($LANG['g_firstname']); ?></label>
                                        <input id="firstname" type="text" class="form-control" name="firstname" value="<?php echo myvalidate($_SESSION['firstname']); ?>" minlength="3" autofocus required>
                                        <div class="invalid-feedback">
                                            <?php echo myvalidate($LANG['g_enterfirstname']); ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="lastname"><?php echo myvalidate($LANG['g_lastname']); ?></label>
                                        <input id="lastname" type="text" class="form-control" name="lastname" value="<?php echo myvalidate($_SESSION['lastname']); ?>" minlength="3" required>
                                        <div class="invalid-feedback">
                                            <?php echo myvalidate($LANG['g_enterlastname']); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="username"><?php echo myvalidate($LANG['g_username']); ?> <span id="resultGetMbr"></span></label>
                                        <input id="username" type="text" class="form-control" name="username" value="<?php echo myvalidate($_SESSION['username']); ?>" minlength="4" maxlength="16" onBlur="checkMember('unex', this.value, '')" required>
                                        <div class="invalid-feedback">
                                            <?php echo myvalidate($LANG['g_regusername']); ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="email"><?php echo myvalidate($LANG['g_email']); ?></label>
                                        <input id="email" type="email" class="form-control" name="email" value="<?php echo myvalidate($_SESSION['email']); ?>" minlength="8" required>
                                        <div class="invalid-feedback">
                                            <?php echo myvalidate($LANG['g_regemail']); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="password" class="d-block"><?php echo myvalidate($LANG['m_accpass']); ?></label>
                                        <input id="password" type="password" class="form-control" data-indicator="pwindicator" name="password" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="passwordconfirm" class="d-block"><?php echo myvalidate($LANG['m_accpassconfirm']); ?></label>
                                        <input id="password2" type="password" class="form-control" name="passwordconfirm">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="isagree" value="1" class="custom-control-input" id="isagree" required>
                                        <label class="custom-control-label" for="isagree"><?php echo myvalidate($LANG['g_agreeterms']); ?><a href="javascript:;" data-toggle="modal" data-target="#myModalterm"><i class="fas fa-fw fa-question-circle"></i></a></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button data-sitekey="<?php echo myvalidate($cfgrow['rc_sitekey']); ?>" data-callback='onSubmit' class="btn btn-primary btn-lg btn-block g-recaptcha">
                                        <?php echo myvalidate($LANG['g_regbutton']); ?>
                                    </button>
                                    <input type="hidden" name="dosubmit" value="1">
                                    <input type="hidden" name="dumbtoken" value="<?php echo myvalidate($_SESSION['dumbtoken']); ?>">
                                </div>
                                <?php
                            }
                            ?>
                            <div class="mt-4 text-muted text-center">
                                <?php echo myvalidate($LANG['g_haveacc']); ?> <a href="login.php"><?php echo myvalidate($LANG['g_loginhere']); ?></a><br />
                                <?php echo myvalidate($LANG['g_havequestion']); ?> <a href="contact.php"><?php echo myvalidate($LANG['g_contactus']); ?></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModalterm" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo myvalidate($LANG['g_termscon']); ?></h5>
            </div>
            <div class="modal-body">
                <div class="text-muted"><?php echo myvalidate($modalcontent); ?></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
$_SESSION['firstname'] = $_SESSION['lastname'] = $_SESSION['username'] = $_SESSION['email'] = '';
include('../common/pub.footer.php');
