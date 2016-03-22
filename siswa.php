 <!-- Aplikasi CRUD
 ************************************************
 * Developer    : Indra Styawantoro
 * Company      : Indra Studio
 * Release Date : 1 Maret 2016
 * Website      : http://www.indrasatya.com, http://www.kulikoding.net
 * E-mail       : indra.setyawantoro@gmail.com
 * Phone        : +62-856-6991-9769
 * BBM          : 7679B9D9
 -->

<?php
        
/* class siswa */
class siswa {

    /* method untuk menampilkan data siswa */
    function view() {
        // memanggil file database.php
        require_once "config/database.php";

        // membuat objek db dengan nama $db
        $db = new database();

        // membuka koneksi ke database
        $mysqli = $db->connect();

        // sql statement untuk mengambil semua data siswa
        $query = "SELECT * FROM is_siswa ORDER BY nis DESC";
        
        // membuat prepared statements
        $stmt = $mysqli->prepare($query);

        //cek query
        if (!$stmt) {
          die('Query Error: '.$mysqli->errno.'-'.$mysqli->error);
        }

        // jalankan query: execute
        $stmt->execute();

        // ambil hasil query
        $result = $stmt->get_result();

        while ($data = $result->fetch_assoc()) {
            $hasil[] = $data;
        }

        /* tutup statement */
        $stmt->close();

        // menutup koneksi database
        $mysqli->close();

        // nilai kembalian dalam bentuk array
        return $hasil;
    }

    /* Method untuk menyimpan data ke tabel siswa */
    function insert($nis, $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $alamat, $no_telepon) {
        // memanggil file database.php
        require_once "config/database.php";

        // membuat objek db dengan nama $db
        $db = new database();

        // membuka koneksi ke database
        $mysqli = $db->connect();

        // sql statement untuk insert data ke tabel is_siswa
        $query = "INSERT INTO is_siswa(nis, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, alamat, no_telepon) 
                  VALUES (?,?,?,?,?,?,?,?)";

        // membuat prepared statements
        $stmt = $mysqli->prepare($query);

        // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssssss", $nis, $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $alamat, $no_telepon);

        // jalankan query: execute
        $stmt->execute();

        // cek hasil query
        if (!$stmt) {
            // jika gagal tampilkan pesan kesalahan
            header('location: index.php?alert=1');
        } 
        else {
            // jika berhasil tampilkan pesan berhasil insert data
            header('location: index.php?alert=2');
        }

        /* tutup statement */
        $stmt->close();

        // menutup koneksi database
        $mysqli->close();
    }

    /* Method untuk menampilkan data siswa berdasarkan nis */
    function get_siswa($nis) {
        // memanggil file database.php
        require_once "config/database.php";

        // membuat objek db dengan nama $db
        $db = new database();

        // membuka koneksi ke database
        $mysqli = $db->connect();

        // sql statement untuk menampilkan data dari tabel is_siswa
        $query = "SELECT * FROM is_siswa WHERE nis=?";

        // membuat prepared statements
        $stmt = $mysqli->prepare($query);

        //cek query
        if (!$stmt) {
          die('Query Error: '.$mysqli->errno.'-'.$mysqli->error);
        }

        // hubungkan "data" dengan prepared statements
        $stmt->bind_param("s", $nis);

        // jalankan query: execute
        $stmt->execute(); 

        // ambil hasil query
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        /* tutup statement */
        $stmt->close();

        // menutup koneksi database
        $mysqli->close();
        
        // nilai kembalian dalam bentuk array
        return $data;
    }
    
    /* Method untuk mengubah data pada tabel siswa */
    function update($nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $alamat, $no_telepon, $nis) {
        // memanggil file database.php
        require_once "config/database.php";

        // membuat objek db dengan nama $db
        $db = new database();

        // membuka koneksi ke database
        $mysqli = $db->connect();

        // sql statement untuk update data ke tabel is_siswa
        $query = "UPDATE is_siswa SET nama          = ?,
                                      tempat_lahir  = ?,
                                      tanggal_lahir = ?,
                                      jenis_kelamin = ?,
                                      agama         = ?,
                                      alamat        = ?,
                                      no_telepon    = ?
                                WHERE nis           = ?";
        // membuat prepared statements
        $stmt = $mysqli->prepare($query);

        // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssssss", $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $alamat, $no_telepon, $nis);

        // jalankan query: execute
        $stmt->execute();

        // cek hasil query
        if (!$stmt) {
            // jika gagal tampilkan pesan kesalahan
            header('location: index.php?alert=1');
        } 
        else {
            // jika berhasil tampilkan pesan berhasil update data
            header('location: index.php?alert=3');
        }

        /* tutup statement */
        $stmt->close();

        // menutup koneksi database
        $mysqli->close();
    }
    
    /* Method untuk menghapus data pada tabel siswa */
    function delete($nis) {
        // memanggil file database.php
        require_once "config/database.php";

        // membuat objek db dengan nama $db
        $db = new database();

        // membuka koneksi ke database
        $mysqli = $db->connect();

        // sql statement untuk delete data ke tabel is_siswa
        $query = "DELETE FROM is_siswa WHERE nis=?";
        // membuat prepared statements
        $stmt = $mysqli->prepare($query);

        // hubungkan "data" dengan prepared statements
        $stmt->bind_param("s", $nis);

        // jalankan query: execute
        $stmt->execute();

        // cek hasil query
        if (!$stmt) {
            // jika gagal tampilkan pesan kesalahan
            header('location: index.php?alert=1');
        } 
        else {
            // jika berhasil tampilkan pesan berhasil delete data
            header('location: index.php?alert=4');
        }   

        /* tutup statement */
        $stmt->close();
        
        // menutup koneksi database
        $mysqli->close();
    }
}
?>
