
 
 <?php
        if(session()->get('level')== 1){
          ?>
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span><?=$title?></h4>
 <div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
         <div class="card-header">
<!-- 					<a href="<?php echo base_url('/penjualan/view/')?>"><button class="btn btn-primary mt-2"><i class="fa-solid fa-eye"></i>
					 Data DiHapus</button></a> -->
				</div>
            <div class="card-body">
               <div class="table-responsive">
                  <table id="table1" class="table table-striped" data-toggle="data-table">
                     <thead>
                        <tr>
                           <th>No.</th>
                           <th>Nama Pelanggan</th>
                           <th>Total Harga</th>
                           <th>Tanggal Penjualan</th>
                           <th>Kasir</th>
                           <th>Pembayaran</th>
                           <th>Kembalian</th>
                           <th>Aksi</th>
                        </tr>
                     </thead>

                     <tbody>
                        <?php
                        $no=1;
                        foreach ($jojo as $riz) {
                         ?>
                         <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $riz->NamaPelanggan ?></td>
                          <td>Rp <?= number_format($riz->TotalHarga, 2, ',', '.') ?></td>
                          <td><?= date('d M Y', strtotime($riz->TanggalPenjualan)) ?></td>
                          <td><?= $riz->username ?></td>
                          <td><?= $riz->bayar ?></td>
                          <td><?= $riz->kembalian ?></td>
                          <td>
                           <a href="<?php echo base_url('detail_penjualan/'. $riz->PenjualanID)?>" class="btn btn-success my-1">Cetak<i class="fa-regular fa-circle-info"></i></a>
                           <a href="<?php echo base_url('penjualan/delete/'. $riz->PenjualanID)?>" class="btn btn-danger my-1">Hapus<i class="fa-solid fa-trash"></i></a>
                        </td>
                     </tr>
                  <?php } ?>
               </tbody>
              <!--  <tfoot>
                  <tr>
                     <th>No.</th>
                     <th>Foto</th>
                     <th>Username</th>
                     <th>Level</th>
                     <th style="min-width: 100px">Action</th>
                  </tr>
               </tfoot> -->

            </table>
         </div>
      </div>
   </div>
</div>
</div>
</div>

<!-- <script>
   $(document).ready(function() {
      $('#table2').DataTable({
      });
   });
</script> -->
<?php
        }else if(session()->get('level')== 2){
          ?>
       <div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span><?=$title?></h4>
 <div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
         <div class="card-header">
<!-- 					<a href="<?php echo base_url('/penjualan/view/')?>"><button class="btn btn-primary mt-2"><i class="fa-solid fa-eye"></i>
					 Data DiHapus</button></a> -->
				</div>
            <div class="card-body">
               <div class="table-responsive">
                  <table id="table1" class="table table-striped" data-toggle="data-table">
                     <thead>
                        <tr>
                           <th>No.</th>
                           <th>Nama Pelanggan</th>
                           <th>Total Harga</th>
                           <th>Tanggal Penjualan</th>
                           <th>Kasir</th>
                           <th>Pembayaran</th>
                           <th>Kembalian</th>
                           <th>Aksi</th>
                        </tr>
                     </thead>

                     <tbody>
                        <?php
                        $no=1;
                        foreach ($jojo as $riz) {
                         ?>
                         <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $riz->NamaPelanggan ?></td>
                          <td>Rp <?= number_format($riz->TotalHarga, 2, ',', '.') ?></td>
                          <td><?= date('d M Y', strtotime($riz->TanggalPenjualan)) ?></td>
                          <td><?= $riz->username ?></td>
                          <td><?= $riz->bayar ?></td>
                          <td><?= $riz->kembalian ?></td>
                          <td>
                           <a href="<?php echo base_url('detail_penjualan/'. $riz->PenjualanID)?>" class="btn btn-success my-1">Cetak<i class="fa-regular fa-circle-info"></i></a>
                         
                        </td>
                     </tr>
                  <?php } ?>
               </tbody>
              <!--  <tfoot>
                  <tr>
                     <th>No.</th>
                     <th>Foto</th>
                     <th>Username</th>
                     <th>Level</th>
                     <th style="min-width: 100px">Action</th>
                  </tr>
               </tfoot> -->

            </table>
         </div>
      </div>
   </div>
</div>
</div>
</div>

<!-- <script>
   $(document).ready(function() {
      $('#table2').DataTable({
      });
   });
</script> -->
<?php } ?>