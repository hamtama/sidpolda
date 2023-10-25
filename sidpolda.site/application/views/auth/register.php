<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="login.html">
                    <img src="assets/login/images/polda.svg" alt="">
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    <!-- <li><a href='auth/registration' class="btn btn-link top_register"><i class="dw dw-logout" aria-hidden="true"></i> <b>Sign Out</b></a></li> -->
                    <li><a href='auth/index' class="btn btn-link top_login"><i class="dw dw-login"
                                aria-hidden="true"></i> Sign In</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <!-- <img class="pic_login" src="assets/login/images/login.png" alt=""> -->
                    <img class="pic_register" src="assets/login/images/reg_sipolda.png" alt="">
                </div>
                <div class="col-md-6 col-lg-5">
                    <!-- FORM REGISTER -->
                    <div class="login-box bg-white box-shadow border-radius-10 tampil_register">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Register To Apps</h2>
                        </div>
                        <form method="post" action="auth/registration" autocomplete="off">
                            <div class="form-group">
                                <?php (empty(form_error('nama')) ? $c_name = 'is-valid' : $c_name = 'is-invalid'); ?>
                                <input type="text" id="nama" name="nama"
                                    class="form-control form-control-lg <?= $c_name; ?>" placeholder="Nama Lengkap"
                                    value="<?= set_value('nama'); ?>">
                                <?= form_error('nama', '<small id="" class="text-danger pl-3">', '</small>'); ?>
                            </div>


                            <div class=" form-group">
                                <?php (empty(form_error('email')) ? $c_email = 'is-valid' : $c_email = 'is-invalid'); ?>
                                <input type="email" name="email" class="form-control form-control-lg <?= $c_email; ?>"
                                    placeholder="Email" value="<?= set_value('email'); ?>">
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class=" form-group ">
                                <?php (empty(form_error('username')) ? $c_user = 'is-valid' : $c_user = 'is-invalid'); ?>
                                <input type="text" name="username" class="form-control form-control-lg <?= $c_user; ?>"
                                    placeholder="Username" value="<?= set_value('username'); ?>">
                                <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class=" form-group ">
                                <?php (empty(form_error('password')) ? $c_pass = 'is-valid' : $c_pass = 'is-invalid'); ?>
                                <input type="password" name="password"
                                    class="form-control form-control-lg <?= $c_pass; ?>" placeholder="Password">
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class=" form-group ">
                                <?php (empty(form_error('password2')) ? $c_pass2 = 'is-valid' : $c_pass2 = 'is-invalid'); ?>
                                <input type="password" name="password2"
                                    class="form-control form-control-lg <?= $c_pass2; ?>"
                                    placeholder="Confirm Password">
                                <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class=" row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <input class="btn btn-success btn-lg btn-block" id="register" name="register"
                                            type="submit" value="Register">
                                    </div>
                                    <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR
                                    </div>
                                    <div class="input-group mb-0">
                                        <a href='auth/index' class="btn btn-outline-primary btn-lg btn-block"
                                            id="login"><i class="dw dw-login"></i> Login</a>
                                        <!-- <a class="btn btn-outline-primary btn-lg btn-block " href="register.html">Sudah Memiliki Akun / Login</a> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>