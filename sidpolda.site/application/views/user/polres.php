<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Data Polres</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <?php
                if ($this->session->flashdata('message')) : ?>
                <div class="alert alert-danger alert-dismissible " role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span>
                    </button>
                    <strong><?= $this->session->flashdata('message'); ?>.</strong>
                </div>
                <?php
                endif;
                ?>
                <div class="col-md-12 col-sm-12 text-left">
                    <a href="polres/polres_add" class="btn btn-success tambah"><i class="icon-copy dw dw-add"></i>
                        Tambah</a>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="datatable-responsive"
                                    class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>No.</th>
                                            <th>Nama Polres</th>
                                            <th>Alamat</th>
                                            <th>Kontak</th>
                                            <th>Email</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $queryData = "SELECT *, (ROW_NUMBER() OVER (Order by id_polres)) as nomor FROM tb_polres";
                                        $data = $this->db->query($queryData)->result_array();
                                        foreach ($data as $row) :
                                            $i = $row['id_polres'];
                                        ?>
                                        <tr>
                                            <td width="10%">
                                                <a href="polres/update/<?=$row['id_polres']?>"
                                                    class="btn btn-xs btn-outline-info editBtn"
                                                    id="<?= $row['id_polres'] ?>"><i
                                                        class=" fa fa-pencil-square"></i></a>
                                                <a href="polres/delete/<?=$row['id_polres'] ?>"
                                                    onclick="return confirm('Yakin Ingin Mengapus Data');"
                                                    class="btn btn-xs btn-outline-info deleteBtn"
                                                    id="<?= $row['id_polres'] ?>"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td><?= $row['nomor'] ?></td>
                                            <td><?= $row['nama_polres'] ?></td>
                                            <td><?= $row['alamat'] ?></td>
                                            <td><?= $row['kontak'] ?></td>
                                            <td><?= $row['email'] ?></td>
                                            <td><?= $row['latitude']?></td>
                                            <td><?= $row['longitude']?></td>
                                            <td><?= $row['deskripsi']?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>