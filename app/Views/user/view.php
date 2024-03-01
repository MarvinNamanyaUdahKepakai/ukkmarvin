<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span><?=$title?></h4>

        <section class="section">
            <div class="card">
            <div class="card-header">

        <section class="section">
            <div class="card">
            <div class="card-header">
					<a href="<?php echo base_url('/user/tambah/')?>"><button class="btn btn-primary mt-2"><i class="fa-solid fa-plus"></i>
					Tambah</button></a>
				</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto Profil</th>
                                    <th>Username</th>       
                                    <th>Level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php
                            $no=1;
                            foreach ($jojo as $riz) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td style="width: 100px; height: 100px; overflow: hidden; border-radius: 5px;">
                                        <img src="<?php echo base_url('images/' . $riz->foto) ?>" style="width: 100%; height: 100%; object-fit: contain;" alt="Foto">
                                    </td>
                                    <td><?php echo $riz->username ?></td>   
                                    <td><?php echo $riz->nama_level?></td>
                                    <td>
                                        <a class="btn btn-primary" href="<?php echo base_url('user/reset_password/'. $riz->id_user) ?>"><i class="faj-button fa-solid fa-key"></i>Reset Password</a>
                                        <a class="btn btn-warning" href="<?php echo base_url('user/edit/'. $riz->id_user) ?>"><i class="faj-button fa-solid fa-pencil"></i>Edit</a>
                                        <a class="btn btn-danger" href="<?php echo base_url('user/delete/'. $riz->id_user) ?>"><i class="faj-button fa-solid fa-trash"></i>Delete</a>
                                    </td>

                                <?php   }
                                ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>