 

<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "db_barang";

$koneksi    = mysqli_connect($host, $user, $pass, $db);



$nama       = "";
$harga     = "";
$stok   = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from barang where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
//untuk ubah
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from barang where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nama       = $r1['nama'];
    $harga    = $r1['harga'];
    $stok   = $r1['stok'];

    if ($id == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nama       = $_POST['nama'];
    $harga     = $_POST['harga'];
    $stok   = $_POST['stok'];

    if ( $nama && $harga && $stok) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update barang set nama='$nama',harga = '$harga',stok='$stok' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into barang(nama,harga,stok) values ('$nama','$harga','$stok')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 70%;
			
        }
        .card {
            margin-top: 100px;
			margin-bottom:20px;
        }
    </style>
</head>

<body>
 <div class="card">
            <div class="card-header text-white bg-primary">
              buat data dan ubah
            </div>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
            <div class="card-body ">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:10;url=crud.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
             
                }
                ?>
                <form action="" method="POST">
                   
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="harga" class="col-sm-2 col-form-label">harga</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $harga ?>">
                        </div>
                    </div>
					 <div class="mb-3 row">
                        <label for="stok" class="col-sm-2 col-form-label">stok</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $stok ?>">
                        </div>
                    </div>
                  
                  
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
			
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card ">
            <div class="card-header text-white bg-primary ">
                Data Barang
            </div>
            <div class="card-body">
                <table class="table"><!--menampilkan-->
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">nama</th>
                            <th scope="col">harga</th>
                            <th scope="col">stok</th>
                            <th scope="col">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from barang order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['id'];
                            $nama       = $r2['nama'];
                            $harga     = $r2['harga'];
                            $stok   = $r2['stok'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $harga ?></td>
                                <td scope="row"><?php echo $stok ?></td>
                                <td scope="row">
                                    <a href="crud.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-primary">Ubah</button></a>
                                    <a href="crud.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Hapus</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>
</html>
                  
                    
						
	

