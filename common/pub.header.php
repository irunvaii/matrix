<?php

if (!defined('OK_LOADME')) {
    die('o o p s !');
}

if ($cfgrow['site_status'] != 1 && $loadcallbyadm != 1) {
    redirpageto($cfgrow['site_url'] . '/' . MBRFOLDER_NAME . '/offline.php');
    exit;
}

$goglacode = base64_decode($cfgtoken['goglacode']);

$page_content = <<<INI_HTML
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>{$page_header}</title>
        <meta name="description" content="{$cfgrow['site_descr']}">
        <meta name="keywords" content="{$cfgrow['site_keywrd']}">
        <meta name="author" content="{$ssysout('SSYS_AUTHOR')}">

        <link rel="shortcut icon" type="image/png" href="../assets/image/favicon.png"/>

        <!-- General CSS Files -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/fellow/fontawesome5121/css/all.min.css">

        <!-- CSS Libraries -->
        <link rel="stylesheet" href="../assets/css/pace-theme-minimal.css">

        <!-- Template CSS -->
        <link rel="stylesheet" href="../assets/css/fontmuli.css">
        {$stylecolor_css}
        <link rel="stylesheet" href="../assets/css/custom.css">
        {$customdark_css}

        <!-- include summernote css/js -->
        <link href="../assets/css/summernote-bs4.css" rel="stylesheet">

        {$goglacode}

    </head>

    <body>
        <div id="app">
INI_HTML;
echo myvalidate($page_content, 1);
