<?php
// Fungsi untuk menyambungkan ke database
function connectDatabase($host, $username, $password, $dbname) {
    $conn = new mysqli($host, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    return $conn;
}

// Fungsi untuk melakukan insert ke database
function insertData($table, $data) {
    // Koneksi ke database
    $conn = connectDatabase('localhost', 'root', '', 'db_handphone');

    // Memisahkan kolom dan nilai dari array data
    $columns = implode(", ", array_keys($data));
    $values = implode(", ", array_map(function($value) use ($conn) {
        return "'" . $conn->real_escape_string($value) . "'";
    }, array_values($data)));

    // Membuat query SQL
    $sql = "INSERT INTO $table ($columns) VALUES ($values)";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dimasukkan";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
}

// Contoh penggunaan fungsi insertData

if(isset($_POST['nama'])){
    $data = [
        'nama' => $_POST['nama'],
        'kamera' => $_POST['kamera'],
        'baterai' => $_POST['baterai'],
        'harga'=> $_POST['harga'],
        'layak'=> $_POST['layak'],
    ];
    insertData('handphone', $data);
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../css/admin.css" />
    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DATA TRAINING</title>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class="bx bx-category"></i>
            <span class="logo_name">Naive Bayes</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="index-training.php" class="active">
                    <i class="bx bx-grid-alt"></i>
                    <span class="links_name">Data Training</span>
                </a>
            </li>
            <li>
                <a href="../data-test/test-entry.php">
                    <i class="bx bx-box"></i>
                    <span class="links_name">Data Test</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
            </div>
        </nav>

        <div class="home-content">
            <h3>Inputkan data Training</h3>
        <div>
        <form action="" method="post" enctype="multipart/form-data" style="background: #f7f7f7; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 1000px; margin: 20px auto; display: flex; flex-direction: column;">
    <div style="display: flex; flex-wrap: nowrap; gap: 20px; width: 100%; margin-bottom: 20px;">
        <div style="flex: 1; min-width: 150px;">
            <label for="nama" style="display: block; margin-bottom: 8px; font-weight: bold;">Jenis Handphone</label>
            <input type="text" name="nama" id="nama" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 16px;">
        </div>

        <div style="flex: 1; min-width: 150px;">
            <label for="kamera" style="display: block; margin-bottom: 8px; font-weight: bold;">Kamera</label>
            <select name="kamera" id="kamera" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 16px;">
                <option></option>
                <option value="kuat">Kuat</option>
                <option value="cukup">Cukup</option>
                <option value="lemah">Lemah</option>
            </select>
        </div>

        <div style="flex: 1; min-width: 150px;">
            <label for="baterai" style="display: block; margin-bottom: 8px; font-weight: bold;">Baterai</label>
            <select name="baterai" id="baterai" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 16px;">
                <option></option>
                <option value="tinggi">Tinggi</option>
                <option value="sedang">Sedang</option>
                <option value="rendah">Rendah</option>
            </select>
        </div>

        <div style="flex: 1; min-width: 150px;">
            <label for="harga" style="display: block; margin-bottom: 8px; font-weight: bold;">Harga</label>
            <select name="harga" id="harga" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 16px;">
                <option></option>
                <option value="mahal">Mahal</option>
                <option value="murah">Murah</option>
            </select>
        </div>

        <div style="flex: 1; min-width: 150px;">
            <label for="layak" style="display: block; margin-bottom: 8px; font-weight: bold;">Layak</label>
            <select name="layak" id="layak" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 16px;">
                <option></option>
                <option value="ya">Ya</option>
                <option value="tidak">Tidak</option>
            </select>
        </div>
    </div>

    <div style="width: 100%; text-align: right;">
        <button type="submit" name="submit" style="background-color: #28a745; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Submit</button>
    </div>
</form>
</div>
            <h3>DATA TRAINING</h3>
            <table class="table-data">
                <thead>
                    <tr>
                        <th style="width: 20%">Merk</th>
                        <th style="width: 20%">Kamera</th>
                        <th style="width: 20%">Baterai</th>
                        <th style="width: 20%">Harga</th>
                        <th style="width: 20%">Layak</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../koneksi.php';
                    $sql = "SELECT * FROM handphone";
                    $result = mysqli_query($con, $sql);
                    if (mysqli_num_rows($result) == 0) {
                        echo "
			   <tr>
				<td colspan='5' align='center'>
                           Data Kosong
                        </td>
			   </tr>
				";
                    }
                    while ($data = mysqli_fetch_assoc($result)) {
                        echo "
                    <tr>
                      <td>$data[nama]</td>
                      <td>$data[kamera]</td>
                      <td>$data[baterai]</td>
                      <td>$data[harga]</td>
                      <td>$data[layak]</td>
                    </tr>
                  ";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function() {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        };
    </script>
</body>

</html>