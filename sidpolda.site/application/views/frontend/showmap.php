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
    <style>
        #map {
            position: "center";
            top: 0;
            bottom: 0;
            height: 100%;
            width: 100%;
        }



        .info {
            background-color: white;
            padding: 10px;
            border-radius: 10px;
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

        /* .leaflet-container {
        height: "600px";
        width: "1200px";
        max-width: "100%";
        max-height: "100%";
    } */
    </style>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <?php
                        // if ($user['role'] == 'Administrator') {
                        //     $index = 'admin';
                        // } else {
                        //     $index = 'user';
                        // }
                        ?>
                        <a href="" class="site_title"><img src="assets/login/images/polda32.png" alt="">
                            <span>SIDPOLDA</span></a>
                    </div>
                    <div class="clearfix"></div>
                    <br />
                    <!-- JOIN TABLE MENU KE MENU ACCESS -->
                    <?php
                    $id_role = $this->session->userdata('id_role');
                    $queryMenu = "SELECT a.id_menu, menu, icon FROM user_menu a JOIN user_access_menu b ON a.id_menu = b.id_menu WHERE b.id_role = '$id_role' AND a.is_active ='1' ORDER BY urutan ASC";
                    $menu = $this->db->query($queryMenu)->result_array();
                    ?>
                    <!-- LOOPING MENU -->

                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <!-- <h3><?php ?></h3> -->
                            <ul class="nav side-menu">
                                <li><a href="user"><i class="fa fa-area-chart"></i> Info Grafik </a></li>
                                <li><a href="user/showmap"><i class="fa fa-map"></i>Sebaran Data Kejahatan </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="auth" class="user-profile" aria-expanded="false">
                                    <i class="fa fa-sign-out pull-right"> Login</i>
                                </a>

                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="x_panel">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h2><b>Filter Data</b></h2>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group mb-3">
                                                <label class="col-form-label label-align  pl-0">Bulan</label>
                                                <div class="col-sm-12 p-0">
                                                    <input type="month" class="form-control" placeholder="Bulan" id="bulan" name="bulan">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group mb-3">
                                                <label class=" col-form-label label-align pl-0">Tahun</label>
                                                <div class="col-sm-12 p-0">
                                                    <?php
                                                    $tanggal = date('Y');
                                                    $mulai_tanggal = 2000;
                                                    $hinggal_tanggal = date('Y');
                                                    print '<select class="form-control" id="tahun" name="tahun_cetak">';
                                                    print '<option value ="">-- Pilih Tahun --</option>';
                                                    foreach (range($hinggal_tanggal, $mulai_tanggal) as $cetak_tahun) {
                                                        print '<option value="' . $cetak_tahun . '"' . ($cetak_tahun === $tanggal ? ' selected="selected"' : '') . '>' . $cetak_tahun . '</option>';
                                                    }
                                                    print '</select>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button onclick="fullScreenView()">View in full screen</button>
                            <div class="coordinate"></div>
                            <div id="maps"></div>
                            <div id="info-container">
                                <div class="card" style="width: 18rem;">
                                    <button type="button" class="close position-absolute p-1" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <img id="img_show" class="card-img-top" src="" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 id="location-name" class="card-title">Card title</h5>
                                        <p id="address" class="card-text"></p>
                                        <p id="additional-info" class="card-text"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="assets/user/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/user/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="assets/user/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="assets/user/vendors/nprogress/nprogress.js"></script>
    <!-- Datatables -->
    <script src="assets/user/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/user/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="assets/user/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/user/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="assets/user/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/user/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <!-- Chat -->
    <script src="assets/user/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="assets/user/build/js/custom.min.js"></script>
    <!-- Switchery -->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <!-- map -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
</body>

</html>