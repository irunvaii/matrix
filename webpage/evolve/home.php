<?php
if (!defined('OK_LOADME')) {
    die("<title>Error!</title><body>Cannot access the file directly.</body>");
}

$websrcbaseurl = (isset($iswebbaseurl) && $iswebbaseurl == 1) ? "" : "../../";
$websrcbasepath = (isset($websrcbasepath) && $websrcbasepath) ? $websrcbasepath : "../../assets";
$websrcpagepath = (isset($websrcpagepath) && $websrcpagepath) ? $websrcpagepath : "";
?>

﻿<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" name="viewport">
        <meta name="description" content="The UniMatrix script will help you to speed up build your membership or network marketing program, unilevel or matrix plan with digital download store and multi vendor features for SaaS.">
        <meta name="keywords" content="UniMatrix, membership, network marketing, unilevel, matrix plan, digital download, multi vendor">
        <meta name="author" content="UniMatrix">

        <title>UniMatrix Frontpage Example</title>
        <link rel="shortcut icon" href="<?php echo myvalidate($websrcbasepath); ?>image/favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="<?php echo myvalidate($websrcbasepath); ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo myvalidate($websrcbasepath); ?>fellow/fontawesome5121/css/all.min.css">

        <link rel="stylesheet" href="<?php echo myvalidate($websrcbasepath); ?>css/fontmuli.css">
        <link rel="stylesheet" href="<?php echo myvalidate($websrcbasepath); ?>css/style.css">
        <link rel="stylesheet" href="<?php echo myvalidate($websrcbasepath); ?>css/components.css">
        <link rel="stylesheet" href="<?php echo myvalidate($websrcbasepath); ?>css/custom.css">

        <link rel="stylesheet" href="<?php echo myvalidate($websrcpagepath); ?>lpassets/lpstylegdbg1.css">
        <link rel="stylesheet" href="<?php echo myvalidate($websrcpagepath); ?>lpassets/lpstyle.css">
    </head>

    <body class="">


        <nav class="navbar navbar-reverse navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand smooth" href="<?php echo myvalidate($websrcbaseurl); ?>">Your Website Title</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto ml-lg-3 align-items-lg-center">
                        <li class="nav-item"><a href="<?php echo myvalidate($websrcbaseurl); ?>store" class="nav-link">Store</a></li>
                        <li class="nav-item"><a href="<?php echo myvalidate($websrcbaseurl); ?>listing" class="nav-link">Directory</a></li>
                        <li class="nav-item"><a href="<?php echo myvalidate($websrcbaseurl); ?>member/contact.php" class="nav-link">Contact</a></li>
                        <li class="nav-item d-lg-none d-md-block"><a href="<?php echo myvalidate($websrcbaseurl); ?>member" class="nav-link smooth" target="_blank">Login</a></li>
                    </ul>
                    <ul class="navbar-nav ml-auto align-items-lg-center d-none d-lg-block">
                        <li class="ml-lg-3 nav-item">
                            <a href="<?php echo myvalidate($websrcbaseurl); ?>member" class="btn btn-round smooth btn-icon icon-left" target="_blank">
                                <i class="fas fa-lock-open"></i> Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="hero-wrapper" id="top"> 
            <div class="hero">
                <div class="container">
                    <div class="text text-center text-lg-left">
                        <a href="<?php echo myvalidate($websrcbaseurl); ?>member/register.php" class="headline">
                            <div class="badge badge-success">Referred by</div>
                            <?php echo (isset($_SESSION['ref_sess_un']) && $_SESSION['ref_sess_un'] != '') ? $_SESSION['ref_sess_un'] : '[username]'; ?> <i class="fas fa-chevron-right"></i>
                        </a>
                        <h1>Start Your Own Membership Business Now!</h1>
                        <p class="lead">
                            The UniMatrix script will help you to speed up build your membership or network marketing program, unilevel or matrix plan with digital download store and multi vendor features for SaaS.
                        </p>
                        <div class="cta">
                            <a class="btn btn-lg btn-warning btn-icon icon-right" href="<?php echo myvalidate($websrcbaseurl); ?>member/register.php">Register <i class="fas fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                    <div class="image d-none d-lg-block">
                        <img src="<?php echo myvalidate($websrcpagepath); ?>lpassets/images/hero-header.png" alt="img">
                    </div>
                </div>
            </div>
        </div>
        <div class="callout container">
            <div class="row mb-4 mb-lg-0">
                <div class="col-md-6">
                    <div class="text-job text-muted text-14">at glance</div>
                    <div class="h1 mb-0 font-weight-bold"><span class="font-weight-500">in </span>progress</div>
                </div>
                <div class="col-md-6">
                    <div class="row mt-4 mt-lg-0">
                        <div class="col-md-3 text-center">
                            <div class="h2 font-weight-bold">8500+</div>
                            <div class="text-uppercase font-weight-bold ls-2 text-primary">Members</div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="h2 font-weight-bold">195</div>
                            <div class="text-uppercase font-weight-bold ls-2 text-primary">Countries</div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="h2 font-weight-bold">$3,650,000+</div>
                            <div class="text-uppercase font-weight-bold ls-2 text-primary">Payout</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section id="features">
            <div class="container">
                <div class="row mb-5 text-center">
                    <div class="col-lg-10 offset-lg-1">
                        <h2>UniMatrix is <span class="text-primary">created</span> for you and for <span class="text-primary">your success</span></h2>
                        <p class="lead">Powerful and Reliable System.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="features">
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-award"></i>
                                </div>
                                <h5>One Time Fee</h5>
                                <p>Buy the license once and you can use the script on your site thereafter. One license for one domain or installation.</p>
                            </div>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-desktop"></i>
                                </div>
                                <h5>Dashboard</h5>
                                <p>Admin and Member control panel are provided with all necessary features and at the same time, it is also easy to manage and use.</p>
                            </div>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <h5>Multiple Packages</h5>
                                <p>Setup multiple packages or levels for your users, with a different membership fee and benefits of each package or level.</p>
                            </div>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-link"></i>
                                </div>
                                <h5>Website Replication</h5>
                                <p>The system will dynamically generate replicated site for the user automatically, complete with user information such as username and name.</p>
                            </div>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <h5>Referrer Bonus</h5>
                                <p>Configure and generate a reward for the referrer when their personal referrals register or when their member structure growing.</p>
                            </div>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-mouse-pointer"></i>
                                </div>
                                <h5>Convenient Approval</h5>
                                <p>Effortlessly provision and manage user payments using the automated system or manually by administrator approval.</p>
                            </div>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-download"></i>
                                </div>
                                <h5>Download System</h5>
                                <p>The script comes with built-in download system where you can upload product files and make it available only for your users.</p>
                            </div>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <h5>Marketing Tools</h5>
                                <p>Configure marketing materials for users to use, including banner, and referral link.</p>
                            </div>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-shopping-basket"></i>
                                </div>
                                <h5>Digital Store</h5>
                                <p>Set up your own digital store, sell digital download or service, video tutorial, and more.</p>
                            </div>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-store"></i>
                                </div>
                                <h5>Vendor System</h5>
                                <p>Allow users to become a vendor and sell their own products, and you can enable vendor fee to generate more profits.</p>
                            </div>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <h5>Responsive Design</h5>
                                <p>Based on Bootstrap 4 and written with HTML5 and CSS3. UniMatrix is suitable for every platform with most modern browsers.</p>
                            </div>
                            <div class="feature">
                                <div class="feature-icon">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <h5>And more</h5>
                                <p>Please try our online demo to experience the system live.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="design" class="section-design">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block">
                        <img src="<?php echo myvalidate($websrcpagepath); ?>lpassets/images/getstats.png" alt="user flow" class="img-fluid">
                    </div>
                    <div class="col-lg-7 pl-lg-5 col-md-12">
                        <div class="badge badge-primary mb-3">Our preciously done works</div>
                        <h2>The script come with great navigation experience, <span class="text-primary">responsive</span> control panels, clean and <span class="text-primary">easy to use</span> interface.</h2>
                        <p class="lead">The script is enriched with features and options that are needed for smooth working of membership system and can be extended by custom additional features to meet your unique network marketing plan.</p>
                        <div class="mt-4">
                            <a href="<?php echo myvalidate($websrcbaseurl); ?>" class="link-icon">
                                Start Using UniMatrix <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="dashboard" class="section-skew">
            <div class="container">
                <div class="row mb-5 text-center">
                    <div class="col-lg-10 offset-lg-1">
                        <h2>Demo Simple <span class="text-primary">Pricing</span></h2>
                        <p class="lead">Please refer to the price comparison below to see what benefits you will get for each package.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="pricing">
                                    <div class="pricing-title">
                                        Personal
                                    </div>
                                    <div class="pricing-padding">
                                        <div class="pricing-price">
                                            <div>$59</div>
                                            <div>one time</div>
                                        </div>
                                        <div class="pricing-details">
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">Core features</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">10 downloads</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">5 video tutorials</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">Personal bonus</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">Referral bonus</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon bg-danger text-white"><i class="fas fa-times"></i></div>
                                                <div class="pricing-item-label">Active bonus</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon bg-danger text-white"><i class="fas fa-times"></i></div>
                                                <div class="pricing-item-label">Rank bonus</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon bg-danger text-white"><i class="fas fa-times"></i></div>
                                                <div class="pricing-item-label">As a Vendor</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pricing-cta">
                                        <a href="<?php echo myvalidate($websrcbaseurl); ?>member/register.php?go=1">Register <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="pricing pricing-highlight">
                                    <div class="pricing-title">
                                        Agent
                                    </div>
                                    <div class="pricing-padding">
                                        <div class="pricing-price">
                                            <div>$269</div>
                                            <div>one time</div>
                                        </div>
                                        <div class="pricing-details">
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">Core features</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">20 downloads</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">15 video tutorials</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">Personal bonus</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">Referral bonus</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">Active bonus</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon bg-danger text-white"><i class="fas fa-times"></i></div>
                                                <div class="pricing-item-label">Rank bonus</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon bg-danger text-white"><i class="fas fa-times"></i></div>
                                                <div class="pricing-item-label">As a Vendor</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pricing-cta">
                                        <a href="<?php echo myvalidate($websrcbaseurl); ?>member/register.php?go=2">Register <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="pricing">
                                    <div class="pricing-title">
                                        Distributor
                                    </div>
                                    <div class="pricing-padding">
                                        <div class="pricing-price">
                                            <div>$699</div>
                                            <div>one time</div>
                                        </div>
                                        <div class="pricing-details">
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">Core features</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">All downloads</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">All video tutorials</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">Personal bonus</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">Referral bonus</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">Active bonus</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">Rank bonus</div>
                                            </div>
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">As a Vendor</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pricing-cta">
                                        <a href="<?php echo myvalidate($websrcbaseurl); ?>member/register.php?go=3">Register <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12 col-lg-8 offset-lg-2 text-center">
                        <h4 class="text-danger font-weight-bold">Demo Only!</h4>
                        <div>The above pricing is for demo purpose, you can change the benefits and pricing according to your membership.</div>
                    </div>
                </div>
            </div>
        </section>

        <section id="components" class="section-design section-design-right">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 pr-lg-5 pr-0">
                        <div class="badge badge-primary mb-3">Greet Your Success</div>
                        <h2>Focus on your <span class="text-primary">goal</span>, let <span class="text-primary">UniMatrix</span> help you to <span class="text-primary">build</span> the system</h2>
                        <p class="lead">The UniMatrix script has many essential features, you only need to enable and configure it. Save your time and make profits early.</p>
                        <div class="mt-4">
                            <a href="<?php echo myvalidate($websrcbaseurl); ?>" class="link-icon">
                                Explore Features <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="abs-images">
                            <img src="<?php echo myvalidate($websrcpagepath); ?>lpassets/images/stackedimg1.png" alt="user flow" class="img-fluid rounded dark-shadow">
                            <img src="<?php echo myvalidate($websrcpagepath); ?>lpassets/images/stackedimg2.png" alt="user flow" class="img-fluid rounded dark-shadow">
                            <img src="<?php echo myvalidate($websrcpagepath); ?>lpassets/images/stackedimg3.png" alt="user flow" class="img-fluid rounded dark-shadow">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="try" class="section-dark">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <h2>Want to try?</h2>
                        <p class="lead">We are happy if you would like to see an online demo of this system and find what you are looking for, we want to save you time on building a successful membership site.</p>
                        <div class="mt-4">
                            <a href="https://www.mlmscript.net/demo/unimatrix" class="btn">Go to the Online Demo</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="support-us" class="support-us">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 d-none d-lg-block pr-lg-5 pr-sm-0">
                        <div class="d-flex align-items-center h-100 justify-content-center abs-images-2">
                            <img src="<?php echo myvalidate($websrcpagepath); ?>lpassets/images/sshorz1.png" alt="image" class="img-fluid rounded dark-shadow">
                            <img src="<?php echo myvalidate($websrcpagepath); ?>lpassets/images/sshorz2.png" alt="image" class="img-fluid rounded dark-shadow">
                            <img src="<?php echo myvalidate($websrcpagepath); ?>lpassets/images/sshorz3.png" alt="image" class="img-fluid rounded dark-shadow">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <h2>A top leader <span class="text-primary">needs</span> UniMatrix. <span class="text-primary">Yes</span>, you too!</h2>
                        <p class="lead">Not only make profits from the membership fees and your own products, but you can also make profits from your users' products. Yes, UniMatrix comes with a vendor system or SaaS (Software as a Service) features.</p>
                        <ul class="list-icons">
                            <li>
                                <span class="card-icon bg-primary text-white">
                                    <i class="fas fa-user-tie"></i>
                                </span>
                                <span>Allow to configure one time or interval based membership for a different package.</span>
                            </li>
                            <li>
                                <span class="card-icon bg-primary text-white">
                                    <i class="fas fa-receipt"></i>
                                </span>
                                <span>Set up different fee and commission for initial and renewal payments.</span>
                            </li>
                            <li>
                                <span class="card-icon bg-primary text-white">
                                    <i class="fas fa-wallet"></i>
                                </span>
                                <span>Built-in wallet system for deposit fund and internal payments.</span>
                            </li>
                            <li>
                                <span class="card-icon bg-primary text-white">
                                    <i class="fas fa-shield-alt"></i>
                                </span>
                                <span>Provide secure contents for members based on their package.</span>
                            </li>
                            <li>
                                <span class="card-icon bg-primary text-white">
                                    <i class="fas fa-folder-open"></i>
                                </span>
                                <span>Allow members to list their web site in the directory to get a more exposure.</span>
                            </li>
                            <li>
                                <span class="card-icon bg-primary text-white">
                                    <i class="fas fa-crown"></i>
                                </span>
                                <span>Rank system to offer unique badge and benefits for members.</span>
                            </li>
                            <li>
                                <span class="card-icon bg-primary text-white">
                                    <i class="fas fa-database"></i>
                                </span>
                                <span>Automatically back up your database and keep peace of mind.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="download-section bg-white">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h2>Build Your <span class="text-primary">Very Own</span> Membership Now</h2>
                        <p class="lead">Start your amazing program with UniMatrix, a network marketing system with SaaS features.</p>
                    </div>
                    <div class="col-md-5 text-right">
                        <a href="https://peppy.link/EAure" class="btn btn-primary btn-lg">Get UniMatrix Now</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="before-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card long-shadow">
                            <div class="card-body d-flex p-45">
                                <div class="card-icon bg-primary text-white">
                                    <i class="far fa-file"></i>
                                </div>
                                <div>
                                    <h5>Explore The Docs</h5>
                                    <p class="lh-sm">Find out how to use UniMatrix in the documentation.</p>
                                    <div class="mt-4 text-right">
                                        <a href="https://peppy.link/r6Ysc" class="link-icon">Documentation <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card long-shadow">
                            <div class="card-body p-45 d-flex">
                                <div class="card-icon bg-primary text-white">
                                    <i class="far fa-life-ring"></i>
                                </div>
                                <div>
                                    <h5>Professional Support</h5>
                                    <p class="lh-sm">Get paid support services and save your time.</p>
                                    <div class="mt-4 text-right">
                                        <a href="https://peppy.link/nTS6G" class="link-icon">Support <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="text-capitalize">UniMatrix</h3>
                        <div class="pr-lg-5">
                            <p>UniMatrix is a <a href="https://www.mlmscript.net">PHP MLM script</a> to build a successful membership or affiliate program using the Unilevel plan or Forced Matrix plan. The script comes with essential features to run a successful referral system or network marketing program, and a digital online store with SaaS (software as a service) features.</p>
                            <p>&copy; UniMatrix. With <i class="fas fa-heart text-danger"></i> to the World.</p>
                            <div class="mt-4 social-links">
                                <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
                                <a href="https://linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                                <a href="https://facebook.com/"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4>Company</h4>
                        <ul>
                            <li><a href="<?php echo myvalidate($websrcbaseurl); ?>store">Store</a></li>
                            <li><a href="<?php echo myvalidate($websrcbaseurl); ?>member/register.php">Register</a></li>
                            <li><a href="<?php echo myvalidate($websrcbaseurl); ?>member/login.php">Login</a></li>
                            <li><a href="<?php echo myvalidate($websrcbaseurl); ?>listing">Directory</a></li>
                            <li><a href="<?php echo myvalidate($websrcbaseurl); ?>member/contact.php">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <script src="<?php echo myvalidate($websrcbasepath); ?>js/jquery-3.4.1.min.js"></script>
        <script src="<?php echo myvalidate($websrcbasepath); ?>js/popper.min.js"></script>
        <script src="<?php echo myvalidate($websrcbasepath); ?>js/bootstrap.min.js"></script>
        <script src="<?php echo myvalidate($websrcbasepath); ?>js/stisla.js"></script>

        <script src="<?php echo myvalidate($websrcpagepath); ?>lpassets/tooltip.js"></script>
        <script src="<?php echo myvalidate($websrcpagepath); ?>lpassets/script.js"></script>

    </body>
</html>
