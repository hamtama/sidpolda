<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <?php
                        if ($user['role'] == 'Administrator') {
                            $index = 'admin';
                        } else {
                            $index = 'user';
                        }
                        ?>
                        <a href="<?= $index?>" class="site_title"><img src="assets/login/images/polda32.png" alt="">
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
                            <h3><?= $user['role']; ?></h3>
                            <ul class="nav side-menu">
                                <?php foreach ($menu as $m) : ?>
                                <li><a><i class="<?= $m['icon'] ?>"></i> <?= $m['menu'] ?> <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <?php
                                            $id_menu = $m['id_menu'];
                                            $querySubMenu = "SELECT * FROM user_sub_menu WHERE id_menu = '$id_menu' AND is_active=1";
                                            $submenu = $this->db->query($querySubMenu)->result_array();
                                            foreach ($submenu as $sm) :
                                            ?>
                                        <li><a href="<?= $sm['url']?>"><?= $sm['title']; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>