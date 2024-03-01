<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span><?=$title?></h4>
<section class="content">

    <h2>Data Produk</h2>

    <div class="container-fluid">
        
        <div class="row">

            <div class="col-lg-12">

                <h4>Cari Produk</h4>
                
                <form>
                    <div class="form-group">
                        <select id="produk" class="choices form-select" name="produk">
                            <option disabled selected>- Pilih -</option>
                            <?php foreach ($produk_list as $p) { ?>
                                <option value="<?=$p->ProdukID?>"><?= $p->NamaProduk .' - ' . $p->Harga ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </form>
                
            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <h4>Pembayaran</h4>

                <form id="form-pembayaran" action="<?= base_url('kasir/aksi_create') ?>" method="post">
                    <div class="form-group">
                        <label>Tanggal :</label>
                        <input type="text" class="form-control" readonly="readonly" name="tanggal" value="<?= date('d M Y') ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Customer :</label>
                        <select class="form-select" name="pelanggan" required>
                            <option>- Pilih -</option>
                            <?php foreach ($pelanggan_list as $p) { ?>
                                <option value="<?= $p->PelangganID ?>"><?= $p->NamaPelanggan ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Input hidden untuk menyimpan ProdukID -->
                    <input type="hidden" name="produk_id[]">

                    <!-- Input hidden untuk menyimpan total harga -->
                    <input type="hidden" name="total_harga" id="total_harga_hidden">

                    <div class="form-group">
                        <label>Total Harga :</label>
                        <input type="text" id="total_harga" class="form-control" readonly="readonly" disabled>
                    </div>

                    <div class="form-group">
                    <span id="pesan-kurang-bayar"></span>
                        <label>Bayar :</label>
                        <input type="number" id="bayar" class="form-control" name="bayar" required>
                    </div>

                    <div class="form-group">
                        <label>Kembali :</label>
                        <input type="number" class="form-control" name="kembalian" readonly="readonly" id="kembalian">
                       
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <h4>Detail Pembayaran</h4>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="keranjang">
                            <!-- Data produk akan ditambahkan di sini -->
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>

</section>
<!-- Tambahkan link Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- Tambahkan link jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<script>

$(document).ready(function() {
        
        // Variabel untuk nomor urut
        var nomorUrut = 1;
    
        // Fungsi untuk memformat harga sebagai mata uang dan menghapus .00 di belakangnya
        function formatCurrency(amount) {
            // Mengubah tipe data harga menjadi mata uang
            var currency = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
            // Menghapus .00 di belakangnya
            return currency.replace(/\,00$/, '');
        }
    
        // Hitung total harga
        function hitungTotalHarga() {
            var total = 0;
            $('#keranjang tr').each(function() {
                var subtotalText = $(this).find('.subtotal').text();
                var subtotal = parseFloat(subtotalText.replace(/[^\d]/g, ''));
                total += subtotal;
            });
            return total;
        }
    
        // Tampilkan total harga
        function tampilkanTotalHarga(total) {
            $('#total_harga_hidden').val(total);
            $('#total_harga').val(formatCurrency(total));
        }
    
        // Tangani perubahan pada pilihan produk
        $('#produk').on('change', function() {
            var produkId = $(this).val();
    
            // Kirim permintaan AJAX
            $.ajax({
                type: 'POST',
                url: 'kasir/tambah_ke_keranjang', // Ganti dengan URL yang sesuai
                data: { produk_id: produkId },
                success: function(response) {
                    // Tambahkan item ke tabel pembayaran
                    var item = response.item;
                    var formattedHarga = formatCurrency(item.harga); // Format harga dengan tanda pemisah ribuan dan menghapus .00 di belakangnya
                    var newRow = '<tr>' +
                        '<td>' + nomorUrut++ + '</td>' + // Nomor urut
                        '<td>' + item.nama_produk + '</td>' +
                        '<td>' + formattedHarga + '</td>' + // Harga yang diperoleh dari respons AJAX
                        '<td><input type="number" class="form-control jumlah" value="1" min="1" name="jumlah" id="jumlah"></td>' + // Tambahkan input jumlah
                        '<td class="subtotal">' + formattedHarga + '</td>' + // Tambahkan tempat untuk subtotal
                        '<td><input type="hidden" name="produk_id[]" value="' + produkId + '">' + // Tambahkan input hidden untuk ProdukID
                        '<button class="btn btn-danger hapus-item">Hapus<i class="fa-solid fa-trash"></i></button></td>' +
                        '</tr>';
    
                    $('#keranjang').append(newRow);
    
                    // Hitung dan tampilkan total harga setelah menambahkan produk baru
                    var totalHarga = hitungTotalHarga();
                    tampilkanTotalHarga(totalHarga);
                }
            });
        });
    
        // Tangani perubahan jumlah produk
        $('#keranjang').on('change', '.jumlah', function() {
            var row = $(this).closest('tr');
            var jumlah = $(this).val();
            var hargaText = row.find('td:eq(2)').text(); // Ambil harga dari kolom ke-3 (indeks dimulai dari 0)
    
            // Hapus karakter non-angka dari harga dan konversi ke angka
            var harga = parseFloat(hargaText.replace(/[^\d]/g, ''));
    
            // Hitung subtotal
            var subtotal = jumlah * harga;
    
            // Format subtotal menjadi mata uang rupiah
            var formattedSubtotal = 'Rp ' + subtotal.toLocaleString('id-ID');
    
            // Update kolom subtotal dengan subtotal yang baru
            row.find('.subtotal').text(formattedSubtotal);
    
            // Hitung dan tampilkan total harga setelah perubahan jumlah produk
            var totalHarga = hitungTotalHarga();
            tampilkanTotalHarga(totalHarga);
        });
    
        // Tangani klik pada tombol hapus item
        $('#keranjang').on('click', '.hapus-item', function() {
            $(this).closest('tr').remove();
    
            // Hitung dan tampilkan total harga setelah menghapus item
            var totalHarga = hitungTotalHarga();
            tampilkanTotalHarga(totalHarga);
        });
    
        // Tangani perubahan pada kolom pembayaran
        $('#bayar').on('input', function() {
            var bayar = parseFloat($(this).val());
            var totalHarga = parseFloat($('#total_harga_hidden').val());
            var kembalian = bayar - totalHarga;
            if (kembalian < 0) {
                // Jika pembayaran kurang dari total harga, tampilkan pesan kesalahan
                $('#kembalian').val('Pembayaran kurang dari Total Harga');
                $('#pesan-kurang-bayar').text('Pembayaran kurang dari Total Harga');
            } else {
                // Jika pembayaran cukup, hitung dan tampilkan kembalian
                $('#kembalian').val(kembalian.toFixed(2)); // Menggunakan toFixed(2) untuk menampilkan dua digit desimal
                $('#pesan-kurang-bayar').text(''); // Kosongkan pesan jika pembayaran cukup
            }
        });
    
        // Tangani klik tombol submit
        $('#form-pembayaran').on('submit', function(e) {
            e.preventDefault(); // Mencegah perilaku default formulir
    
            // Persiapkan array untuk menyimpan data
            var dataToSend = [];
    
            // Iterasi melalui setiap baris tabel
            $('#keranjang tr').each(function() {
                var rowData = {};
                // Ambil data dari setiap input dan select dalam baris, kecuali input dengan type submit
                $(this).find('input, select').each(function() {
                    var columnName = $(this).attr('name');
                    var columnValue = $(this).val();
                    rowData[columnName] = columnValue;
                });
    
                // Ambil ProdukID dari input hidden
                var produkId = $(this).find('input[name="produk_id[]"]').val();
    
                // Tambahkan ProdukID ke dalam rowData
                rowData['produk_id'] = produkId;
    
                // Ambil nama produk dari kolom kedua dan harga dari kolom ketiga
                var namaProduk = $(this).find('td:eq(1)').text();
                var harga = $(this).find('td:eq(2)').text();
    
                // Tambahkan nilai item.nama_produk dan formattedHarga ke dalam rowData
                rowData['nama_produk'] = namaProduk;
                rowData['formattedHarga'] = harga;
    
                // Ambil nilai subtotal dari kolom keempat dan hapus simbol "Rp" serta tanda pemisah ribuan
                var subtotal = $(this).find('td:eq(4)').text().replace('Rp ', '').replace(/\./g, '');
                rowData['subtotal'] = subtotal;
    
                // Tambahkan data baris ke array
                dataToSend.push(rowData);
            });
    
            // Tambahkan data ke input tersembunyi sebelum mengirimkan formulir
            $('#form-pembayaran').append('<input type="hidden" name="data_table" value=\'' + JSON.stringify(dataToSend) + '\' />');
    
            // Hitung total harga dan tambahkan ke dalam data sebelum mengirimkan formulir
            var totalHarga = hitungTotalHarga();
            $('#form-pembayaran').append('<input type="hidden" name="total_harga" value="' + totalHarga + '" />');
    
            // Lanjutkan dengan pengiriman formulir
            this.submit();
        });
    });
    
</script>
