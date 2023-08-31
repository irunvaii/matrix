<?php
if (!defined('OK_LOADME')) {
    die('o o p s !');
}

// verify has valid
$itid = intval($FORM['itid']);
$itemStr = get_iteminfo($itid);
$ithash = md5($mdlhashy . $itid . '+' . $itemStr['itstatus'] . $mbrstr['id']);
$lhash = $FORM['l'];
$afhash = md5($mdlhashy . '1' . $mbrstr['id']);

if (($itid > 1 && $ithash != $lhash) || ($itid <= 1 && $afhash != $lhash)) {
    ?>
    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <article class="article article-style-b">
                    <div class="article-details">
                        <div class="article-title">
                            <h5 class="text-danger">Product not found</h5>
                        </div>
                        <p>You will be redirected to the store page within few seconds.</p>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <?php
    $hal = 'store';
    redirpageto('index.php?hal=' . $hal);
    die();
}

$itemstr = get_iteminfo($itid);

$condition = " AND txfromid = '{$mbrstr['id']}' AND txitid = '{$itid}' ORDER BY txid DESC";
$txrow = $db->getAllRecords(DB_TBLPREFIX . '_transactions', '*', $condition);
$txid = $txrow[0]['txid'];
$txtoken = $txrow[0]['txtoken'];

// get price based on plan
$addamount = floatval($FORM['addamount']);
$itpricenow = get_itpricebyplan($itemstr, $mbrstr['mppid'], $addamount);

// get transaction details
$unpaidtxid = get_unpaidtxid($mbrstr, $itid);
if ($unpaidtxid > 0) {
    $txidstr = $unpaidtxid;
    $data = array(
        'txdatetm' => $cfgrow['datetimestr'],
        'txamount' => (float) $itpricenow,
        'txmemo' => 'Order ' . $itemstr['itname'],
        'txtoken' => "|TXTYPE:ORDER|, |STORE:{$itemstr['itsku']}|",
    );

    $db->update(DB_TBLPREFIX . '_transactions', $data, array('txid' => $txidstr));
} else {
    if ($itpricenow > 0) {
        $data = array(
            'txdatetm' => $cfgrow['datetimestr'],
            'txfromid' => $mbrstr['id'],
            'txamount' => (float) $itpricenow,
            'txmemo' => 'Order ' . $itemstr['itname'],
            'txppid' => $mbrstr['mppid'],
            'txitid' => $itid,
            'txtoken' => "|TXTYPE:ORDER|, |STORE:{$itemstr['itsku']}|",
        );
        $insert = $db->insert(DB_TBLPREFIX . '_transactions', $data);
        $txidstr = $db->lastInsertId();
    }
}
// -----

$pgdatatokenarr = get_optionvals($payrow['pgdatatoken']);

$pgdatatoken = $mbrstr['pgdatatoken'];
$pgmbrtokenarr = get_optionvals($pgdatatoken);

$coinpaymentscfg = get_optarr($pgdatatokenarr['coinpaymentscfg']);
$mbrcoinpaymentscfg = get_optarr($pgmbrtokenarr['coinpaymentscfg']);

$paypalcfg = get_optarr($pgdatatokenarr['paypalcfg']);
$mbrpaypalcfg = get_optarr($pgmbrtokenarr['paypalcfg']);

$ewalletcfg = get_optarr($pgdatatokenarr['ewalletcfg']);
$mbrewalletcfg = get_optarr($pgmbrtokenarr['ewalletcfg']);

// ---

$txitid = $txidstr . '-' . $itid;
$itemprice = $totewallet = $totcoinpayments = $totmanualpay = $totpaypal = $tottestpay = $itpricenow;

// ---

$isppsandbox = $paypalcfg['paypalsbox'];

$ispayg = 0;
$paygatearr = array('coinpayments', 'ewallet', 'manualpay', 'paypal', 'testpay');
foreach ($paygatearr as $key => $value) {
    if ($payrow[$value . 'on'] == 1) {
        if ($payrow[$value . 'fee'] > 0) {
            ${'fee' . $value} = getamount($payrow[$value . 'fee'], $itemprice);
            ${'tot' . $value} = $itemprice + ${'fee' . $value};
        } else {
            ${'fee' . $value} = 0;
        }
        $ispayg++;
    }
    if ($pgdatatokenarr[$value . 'on'] == 1) {
        $valdatatoken = get_optarr($pgdatatokenarr[$value . 'cfg']);
        if ($valdatatoken[$value . 'fee'] > 0) {
            ${'fee' . $value} = getamount($valdatatoken[$value . 'fee'], $itemprice);
            ${'tot' . $value} = $itemprice + ${'fee' . $value};
        } else {
            ${'fee' . $value} = 0;
        }
        $ispayg++;
    }
}

if ($ispayg <= 1) {
    $colmdclass = "col-md-12";
} elseif ($ispayg <= 2) {
    $colmdclass = "col-md-6";
} else {
    $colmdclass = "col-md-4";
}

$tagsarr = array("[[currencysym]]" => $bpprow['currencysym'], "[[currencycode]]" => $bpprow['currencycode'], "[[feeamount]]" => $feemanualpay, "[[amount]]" => $itemprice, "[[totamount]]" => $totmanualpay, "[[payplan]]" => $itemstr['itname']);
$manualpayipn = base64_decode($payrow['manualpayipn']);
$manualpayipn = strtr($manualpayipn, $tagsarr);
$manualpayipn64 = base64_encode($manualpayipn . '<button type="button" class="btn btn-warning btn-lg mt-4" onclick="location.href = \'index.php?hal=feedback&ispaidconfirm=' . base64_encode($txitid) . '\'">Confirm Payment</button>');
//$manualpayipn64 = base64_encode($manualpayipn . '<div class="float-right"><a href="javascript:;" class="btn btn-warning btn-lg mt-4" data-dismiss="modal">Close</a></div>');
//$manualpayipn64 = base64_encode($manualpayipn . '<div class="float-right"><a href="index.php?hal=historylist" class="btn btn-warning btn-lg mt-4">Close</a></div>');
?>

<div class="section-header">
    <h1><i class="fa fa-fw fa-money-check"></i> <?php echo myvalidate($LANG['m_planpay']); ?></h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-md-12">
            <article class="article article-style-b">
                <div class="article-header">
                    <div class="article-image" data-background="<?php echo myvalidate($itemstr['itimage']); ?>">
                    </div>
                    <div class="article-badge">
                        <span class="article-badge-item bg-danger">
                            <?php echo myvalidate($bpprow['currencysym'] . $itemprice . ' ' . $bpprow['currencycode']); ?>
                        </span>
                        <?php
                        if ($sprstr['mpstatus'] == 1) {
                            ?>
                            <span class="article-badge-item bg-warning">
                                Sponsored by <?php echo myvalidate($sprstr['username']); ?>
                            </span>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="article-details">
                    <div class="article-title">
                        <h4><?php echo myvalidate($itemstr['itname']); ?></h4>
                    </div>
                    <p><?php echo myvalidate($itemstr['itdescr']); ?></p>
                    <div class="article-cta">
                        <span class="badge badge-danger">
                            UNPAID
                        </span>
                    </div>
                </div>
            </article>

        </div>
    </div>

    <a name="paythis"></a>
    <h2 class="section-title"><?php echo myvalidate($LANG['m_payoption']); ?></h2>
    <p class="section-lead"><?php echo myvalidate($LANG['m_payinfo']); ?></p>

    <div class="row">
        <?php
        if ($itid > 1 && $pgdatatokenarr['ewalleton'] == 1 && $pgdatatokenarr['ewallet4store'] == 1) {
            if ($totewallet <= $mbrstr['ewallet']) {
                $ewalletfrm = ' method="post" action="../common/sendbox.php" id="dopayform"';
                $ewalletbdg = 'success';
                $ewalletbtn = '';
            } else {
                $ewalletfrm = '';
                $ewalletbdg = 'danger';
                $ewalletbtn = ' disabled';
            }
            ?>
            <div class="<?php echo myvalidate($colmdclass); ?>">
                <div class="card card-primary">
                    <div class="card-body text-center">
                        <?php echo myvalidate($avalpaygateicon_array['ewalletlabel']); ?>
                        <h4><?php echo myvalidate($ewalletcfg['ewalletlabel']); ?></h4>
                        <div class="mt-4"><?php echo myvalidate($LANG['g_amount']); ?>: <?php echo myvalidate($bpprow['currencysym'] . $itemprice); ?></div>
                        <div><code><?php echo myvalidate($LANG['g_servicefee']); ?>: <?php echo myvalidate($bpprow['currencysym'] . $feeewallet); ?></code></div>
                        <h6>Total: <?php echo myvalidate($bpprow['currencysym'] . $totewallet . ' ' . $bpprow['currencycode']); ?></h6>

                        <div class="mt-4"><span class="badge badge-<?php echo myvalidate($ewalletbdg); ?>">Available: <?php echo myvalidate($bpprow['currencysym'] . $mbrstr['ewallet'] . ' ' . $bpprow['currencycode']); ?></span></div>
                        <form<?php echo myvalidate($ewalletfrm); ?>>
                            <input type="hidden" name="sb_type" value="payreg">
                            <input type="hidden" name="sb_txitid" value="<?php echo myvalidate($txitid); ?>">
                            <input type="hidden" name="sb_amount" value="<?php echo myvalidate($totewallet); ?>">
                            <input type="hidden" name="sb_batch" value="<?php echo myvalidate($paybatch); ?>">
                            <input type="hidden" name="sb_label" value="ewalletlabel">
                            <input type="hidden" name="sb_success" value="<?php echo myvalidate($cfgrow['site_url']) . '/' . MBRFOLDER_NAME . '/ipnhub.php?hal=orderlist'; ?>">
                            <input type="hidden" name="sb_tag" value="<?php echo myvalidate($ewalletcfg['ewalletlabel']); ?>">
                            <button type="submit" name="dopay" value="1" id="dopay" class="btn btn-primary btn-lg mt-4"<?php echo myvalidate($ewalletbtn); ?>>
                                <?php echo myvalidate($LANG['m_makepayment']); ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        if ($pgdatatokenarr['coinpaymentson'] == 1 && $pgdatatokenarr['coinpayments4store'] == 1) {
            ?>
            <div class="<?php echo myvalidate($colmdclass); ?>">
                <div class="card card-primary">
                    <div class="card-body text-center">
                        <?php echo myvalidate($avalpaygateicon_array['coinpaymentsmercid']); ?>
                        <h4>Coinpayments</h4>
                        <div class="mt-4"><?php echo myvalidate($LANG['g_amount']); ?>: <?php echo myvalidate($bpprow['currencysym'] . $itemprice); ?></div>
                        <div><code><?php echo myvalidate($LANG['g_servicefee']); ?>: <?php echo myvalidate($bpprow['currencysym'] . $feecoinpayments); ?></code></div>
                        <h6>Total: <?php echo myvalidate($bpprow['currencysym'] . $totcoinpayments . ' ' . $bpprow['currencycode']); ?></h6>
                        <form method="post" action="https://www.coinpayments.net/index.php" id="dopayform">
                            <input type="hidden" name="cmd" value="_pay_simple"> <!-- or _pay -->
                            <input type="hidden" name="reset" value="1">
                            <input type="hidden" name="merchant" value="<?php echo myvalidate(base64_decode($coinpaymentscfg['coinpaymentsmercid'])); ?>">
                            <input type="hidden" name="item_name" value="<?php echo myvalidate($itemstr['itname']); ?>">
                            <input type="hidden" name="item_number" value="<?php echo myvalidate($mbrstr['username']); ?>">
                            <input type="hidden" name="invoice" value="<?php echo myvalidate($txitid); ?>">
                            <input type="hidden" name="currency" value="<?php echo myvalidate($bpprow['currencycode']); ?>">
                            <input type="hidden" name="amountf" value="<?php echo myvalidate($totcoinpayments); ?>">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="allow_quantity" value="1">
                            <input type="hidden" name="want_shipping" value="0">
                            <input type="hidden" name="success_url" value="<?php echo myvalidate($cfgrow['site_url']) . '/' . MBRFOLDER_NAME . '/ipnhub.php?hal=orderlist'; ?>">
                            <input type="hidden" name="cancel_url" value="<?php echo myvalidate($cfgrow['site_url']) . '/' . MBRFOLDER_NAME . '/index.php?hal=orderpay&act=cancelpay'; ?>">
                            <input type="hidden" name="ipn_url" value="<?php echo myvalidate($cfgrow['site_url']) . '/common/sendbox.php'; ?>">
                            <input type="hidden" name="allow_extra" value="1">

                            <button type="submit" name="dopay" value="1" id="dopay" class="btn btn-primary btn-lg mt-4">
                                <?php echo myvalidate($LANG['m_makepayment']); ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        if ($pgdatatokenarr['paypalon'] == 1 && $pgdatatokenarr['paypal4store'] == 1) {
            $posturl = ($isppsendbox == 1) ? "https://ipnpb.sandbox.paypal.com/cgi-bin/webscr" : "https://ipnpb.paypal.com/cgi-bin/webscr";
            ?>
            <div class="<?php echo myvalidate($colmdclass); ?>">
                <div class="card card-primary">
                    <div class="card-body text-center">
                        <?php echo myvalidate($avalpaygateicon_array['paypalacc']); ?>
                        <h4>PayPal</h4>
                        <div class="mt-4"><?php echo myvalidate($LANG['g_amount']); ?>: <?php echo myvalidate($bpprow['currencysym'] . $itemprice); ?></div>
                        <div><code><?php echo myvalidate($LANG['g_servicefee']); ?>: <?php echo myvalidate($bpprow['currencysym'] . $feepaypal); ?></code></div>
                        <h6>Total: <?php echo myvalidate($bpprow['currencysym'] . $totpaypal . ' ' . $bpprow['currencycode']); ?></h6>
                        <form method="post" action="<?php echo myvalidate($posturl); ?>" id="dopayform">
                            <input type="hidden" name="cmd" value="_xclick">
                            <input type="hidden" name="amount" value="<?php echo myvalidate($totpaypal); ?>">
                            <input type="hidden" name="business" value="<?php echo myvalidate($paypalcfg['paypalacc']); ?>">
                            <input type="hidden" name="notify_url" value="<?php echo myvalidate($cfgrow['site_url']) . '/common/sendbox.php'; ?>">
                            <input type="hidden" name="return" value="<?php echo myvalidate($cfgrow['site_url']) . '/' . MBRFOLDER_NAME . '/ipnhub.php?hal=orderlist'; ?>">
                            <input type="hidden" name="cancel_return" value="<?php echo myvalidate($cfgrow['site_url']) . '/' . MBRFOLDER_NAME . '/index.php?hal=orderpay&act=cancelpay'; ?>">
                            <input type="hidden" name="currency_code" value="<?php echo myvalidate($bpprow['currencycode']); ?>">
                            <input type="hidden" name="item_name" value="<?php echo myvalidate($itemstr['itname']); ?>">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="rm" value="2">
                            <input type="hidden" name="no_shipping" value="1">
                            <input type="hidden" name="no_note" value="1">
                            <input type="hidden" name="custom" value="<?php echo myvalidate($txitid); ?>">

                            <button type="submit" name="dopay" value="1" id="dopay" class="btn btn-primary btn-lg mt-4">
                                <?php echo myvalidate($LANG['m_makepayment']); ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        if ($payrow['manualpayon'] == 1 && $payrow['manualpay4store'] == 1) {
            ?>
            <div class="<?php echo myvalidate($colmdclass); ?>">
                <div class="card card-primary">
                    <div class="card-body text-center">
                        <i class="fa fa-handshake fa-fw"></i>
                        <h4><?php echo myvalidate($payrow['manualpayname']); ?></h4>
                        <div class="mt-4"><?php echo myvalidate($LANG['g_amount']); ?>: <?php echo myvalidate($bpprow['currencysym'] . $itemprice); ?></div>
                        <div><code><?php echo myvalidate($LANG['g_servicefee']); ?>: <?php echo myvalidate($bpprow['currencysym'] . $feemanualpay); ?></code></div>
                        <h6>Total: <?php echo myvalidate($bpprow['currencysym'] . $totmanualpay . ' ' . $bpprow['currencycode']); ?></h6>
                        <button type="button" class="openPopup btn btn-primary btn-lg mt-4" data-encbase64="<?php echo myvalidate($manualpayipn64); ?>" data-poptitle="<i class='fa fa-fw fa-handshake'></i> <?php echo myvalidate($payrow['manualpayname']); ?>">
                            <?php echo myvalidate($LANG['m_makepayment']); ?>
                        </button>
                    </div>
                </div>
            </div>
            <?php
        }
        if ($payrow['testpayon'] == 1) {
            $paybatch = strtoupper(date("DmdH-is")) . $mbrstr['mpid'];
            ?>
            <div class="<?php echo myvalidate($colmdclass); ?>">
                <div class="card card-danger">
                    <div class="card-body text-center">
                        <i class="fa fa-cog fa-fw"></i>
                        <h4><?php echo myvalidate($payrow['testpaylabel']); ?></h4>
                        <div class="mt-4"><?php echo myvalidate($LANG['g_amount']); ?>: <?php echo myvalidate($bpprow['currencysym'] . $itemprice); ?></div>
                        <div><code><?php echo myvalidate($LANG['g_servicefee']); ?>: <?php echo myvalidate($bpprow['currencysym'] . $feetestpay); ?></code></div>
                        <h6>Total: <?php echo myvalidate($bpprow['currencysym'] . $tottestpay . ' ' . $bpprow['currencycode']); ?></h6>
                        <div class="mt-4"><?php echo myvalidate($LANG['m_testpayinfo']); ?></div>
                        <form method="post" action="../common/sendbox.php" id="dopayform">
                            <input type="hidden" name="sb_type" value="payreg">
                            <input type="hidden" name="sb_txitid" value="<?php echo myvalidate($txitid); ?>">
                            <input type="hidden" name="sb_amount" value="<?php echo myvalidate($tottestpay); ?>">
                            <input type="hidden" name="sb_batch" value="<?php echo myvalidate($paybatch); ?>">
                            <input type="hidden" name="sb_label" value="testpaylabel">
                            <input type="hidden" name="sb_success" value="<?php echo myvalidate($cfgrow['site_url']) . '/' . MBRFOLDER_NAME . '/ipnhub.php?hal=orderlist'; ?>">
                            <button type="submit" name="dopay" value="1" id="dopay" class="btn btn-danger btn-lg mt-4">
                                <?php echo myvalidate($LANG['m_makepayment']); ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

</div>
