<?php
// templates/include/header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Examination System</title>

    <!-- SB Admin 2 CSS -->
    <link href="<?= BASE_URL ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?php include TEMPLATE_PATH . '/include/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <!-- Topbar -->
            <?php include TEMPLATE_PATH . '/include/navbar.php'; ?>
            <!-- End of Topbar -->

            <div class="container-fluid">
