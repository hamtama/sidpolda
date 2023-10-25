<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?= base_url(); ?>">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/login/images/polda180.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/login/images/polda32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/login/images/polda16.png">
    <!-- Bootstrap -->
    <link href="assets/user/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/user/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Datatables -->
    <link href="assets/user/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="assets/user/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="assets/user/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="assets/user/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="assets/user/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="assets/user/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="assets/user/build/css/custom.min.css" rel="stylesheet">
    <!-- map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="assets/user/vendors/leaflet/leaflet.js"></script>
    <link rel="stylesheet" href="assets/user/vendors/leaflet/leaflet.css">
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" /> -->

    <style>
        #map {
            position: "center";
            top: 0;
            bottom: 0;
            height: 100%;
            width: 100%;
        }



        .legend {
            position: relative;
            bottom: 20px;
            left: 8px;
            z-index: 999;
            background-color: white;
            padding: 10px;
            border-radius: 5px;
        }

        .legend-item {
            margin-bottom: -5px;
        }

        .legend-color {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }

        .info {
            background-color: white;
            padding: 10px;
            border-radius: 10px;
        }

        #info-container {
            position: absolute;
            top: 290px;
            right: 18px;
            width: 300px;
            background-color: white;
            border: 1px solid #ccc;
            z-index: 1000;
            /* padding: 10px; */
            display: none;
        }

        /* .leaflet-popup-content-wrapper,
        .leaflet-popup-tip {
            background: none;
            color: #333;
            box-shadow: none;
        } */

        .card-img-top-2 {
            width: 100%;
            height: 5vw;
            object-fit: cover;
        }


        /* .leaflet-container {
    height: "600px";
    width: "1200px";
    max-width: "100%";
    max-height: "100%";
    } */
    </style>
</head>