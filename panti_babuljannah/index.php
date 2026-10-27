<?php 
include 'config/koneksi.php'; 

$page = isset($_GET['page']) ? $_GET['page'] : 'beranda';

// Fungsi otomatis membaca gambar dari folder assets
function sumber_gambar($nama_tanpa_ekstensi) {
    $ekstensi = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'];
    foreach ($ekstensi as $ext) {
        $path = "assets/" . $nama_tanpa_ekstensi . "." . $ext;
        if (file_exists($path)) {
            return $path;
        }
    }
    return "assets/" . $nama_tanpa_ekstensi;
}

$notif_donasi = "";
if (isset($_POST['kirim_donasi'])) {
    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan']);
    
    $query = "INSERT INTO tb_donasi (nama, email, pesan) VALUES ('$nama', '$email', '$pesan')";
    if (mysqli_query($koneksi, $query)) {
        $notif_donasi = "Terima kasih! Konfirmasi donasi berhasil dikirim.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panti Asuhan Babul Jannah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { background-color: #234e3e; color: #1e293b; min-height: 100vh; padding-bottom: 20px; }
        
        /* HEADER STYLING */
        header {
            background-color: #17382c;
            padding: 15px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand { font-weight: 800; font-size: 15px; color: #ffffff; display: flex; align-items: center; gap: 10px; letter-spacing: 0.5px; }
        .brand img { width: 38px; height: 38px; border-radius: 50%; object-fit: contain; background: white; }
        .nav-btn { display: flex; gap: 18px; }
        .nav-btn a { text-decoration: none; color: #ffffff; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; }
        .nav-btn a:hover, .nav-btn a.active { color: #86efac; border-bottom: 2px solid #86efac; padding-bottom: 2px; }

        /* MAIN CONTAINER */
        .main-wrapper { max-width: 950px; margin: 20px auto; background: #e8ece9; border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        
        /* HERO SECTION */
        .hero { display: flex; gap: 20px; align-items: center; background: #ffffff; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
        .hero-text { flex: 1; }
        .hero-text h3 { font-size: 11px; color: #475569; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
        .hero-text h2 { font-size: 20px; font-weight: 800; color: #17382c; line-height: 1.2; margin-bottom: 8px; }
        .hero-text p { font-size: 11px; color: #64748b; line-height: 1.4; margin-bottom: 15px; }
        .btn-green { background: #17382c; color: white; padding: 7px 16px; border-radius: 6px; text-decoration: none; font-size: 11px; font-weight: 700; display: inline-block; }
        .hero-img img { width: 320px; height: 150px; object-fit: cover; border-radius: 8px; }

        /* CATEGORY CARDS (BERANDA) */
        .cat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; }
        .cat-card { background: #d3ded7; border-radius: 10px; padding: 15px; text-align: center; text-decoration: none; color: #17382c; }
        .cat-icon { font-size: 24px; margin-bottom: 5px; }
        .cat-card span { font-size: 11px; font-weight: 700; }

        /* SECTION TITLE */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .section-title-btn { background: #17382c; color: white; padding: 6px 14px; border-radius: 4px; font-size: 12px; font-weight: 700; display: inline-block; text-transform: uppercase; }
        .link-all { text-decoration: none; font-size: 11px; color: #17382c; font-weight: 700; }

        /* GRID CONTENT */
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px; }
        .card-item { background: white; border-radius: 8px; overflow: hidden; text-align: center; padding-bottom: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .card-item img { width: 100%; height: 120px; object-fit: cover; }
        .card-item h4 { font-size: 11px; font-weight: 700; margin-top: 8px; color: #1e293b; }

        /* BANNER TOP PAGE */
        .page-banner { background: white; border-radius: 10px; padding: 15px; display: flex; align-items: center; gap: 20px; margin-bottom: 20px; }
        .page-banner img { width: 280px; height: 100px; object-fit: cover; border-radius: 6px; }
        .page-banner h2 { font-size: 18px; font-weight: 800; color: #17382c; text-transform: uppercase; }
        .page-banner p { font-size: 11px; color: #64748b; }

        /* FORM STYLING */
        .form-box { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: 0 auto; }
        .form-group { margin-bottom: 12px; text-align: left; }
        .form-group label { display: block; font-size: 11px; font-weight: 700; margin-bottom: 4px; color: #1e293b; }
        .form-group input, .form-group textarea { width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 11px; }

        /* FOOTER */
        footer { background: #17382c; color: white; text-align: center; padding: 10px; font-size: 10px; font-weight: 600; margin-top: 20px; border-radius: 0 0 8px 8px; letter-spacing: 0.5px; }
    </style>
</head>
<body>

    <header>
        <div class="brand">
            <img src="<?= sumber_gambar('logo'); ?>" alt="Logo Panti">
            <span>PANTI ASUHAN BABUL JANNAH</span>
        </div>
        <div class="nav-btn">
            <a href="index.php?page=beranda" class="<?= ($page=='beranda')?'active':'' ?>">BERANDA</a>
            <a href="index.php?page=profil" class="<?= ($page=='profil')?'active':'' ?>">PROFIL</a>
            <a href="index.php?page=kegiatan" class="<?= ($page=='kegiatan')?'active':'' ?>">KEGIATAN</a>
            <a href="index.php?page=galeri" class="<?= ($page=='galeri')?'active':'' ?>">GALERI</a>
            <a href="index.php?page=donasi" class="<?= ($page=='donasi')?'active':'' ?>">DONASI</a>
            <a href="index.php?page=kontak" class="<?= ($page=='kontak')?'active':'' ?>">KONTAK</a>
            <a href="login.php" style="color: #facc15;">ADMIN</a>
        </div>
    </header>

    <div class="main-wrapper">
        <!-- 1. BERANDA -->
        <?php if ($page == 'beranda') : ?>
            <div class="hero">
                <div class="hero-text">
                    <h3>SELAMAT DATANG DI</h3>
                    <h2>PANTI ASUHAN<br>BABUL JANNAH</h2>
                    <p>Bersama kita wujudkan masa depan yang lebih baik untuk anak-anak yatim dan dhuafa, melalui pendidikan, kasih sayang, dan nilai-nilai keagamaan.</p>
                    <a href="index.php?page=profil" class="btn-green">Kenali kami -></a>
                </div>
                <div class="hero-img">
                    <img src="<?= sumber_gambar('panti_depan'); ?>" alt="Panti Asuhan">
                </div>
            </div>

            <div class="cat-grid">
                <a href="index.php?page=profil" class="cat-card"><div class="cat-icon">👤</div><span>Profil panti</span></a>
                <a href="index.php?page=kegiatan" class="cat-card"><div class="cat-icon">📅</div><span>Kegiatan</span></a>
                <a href="index.php?page=galeri" class="cat-card"><div class="cat-icon">🖼️</div><span>Galeri</span></a>
                <a href="index.php?page=donasi" class="cat-card"><div class="cat-icon">💚</div><span>Donasi</span></a>
            </div>

            <div class="section-header">
                <h3 style="font-size: 14px; font-weight: 800; color: #17382c;">Kegiatan terbaru</h3>
                <a href="index.php?page=kegiatan" class="link-all">Lihat semua -></a>
            </div>

            <div class="grid-4">
                <?php 
                $q_keg = mysqli_query($koneksi, "SELECT * FROM tb_kegiatan ORDER BY id_kegiatan DESC LIMIT 4");
                if(mysqli_num_rows($q_keg) > 0):
                    while($k = mysqli_fetch_assoc($q_keg)):
                ?>
                    <div class="card-item">
                        <img src="assets/<?= $k['foto']; ?>" alt="Kegiatan" onerror="this.src='<?= sumber_gambar('panti_depan'); ?>'">
                        <h4><?= $k['judul_kegiatan']; ?></h4>
                    </div>
                <?php endwhile; else: ?>
                    <div class="card-item"><img src="<?= sumber_gambar('panti_depan'); ?>" alt=""><h4>Mengaji bersama</h4></div>
                    <div class="card-item"><img src="<?= sumber_gambar('panti_depan'); ?>" alt=""><h4>Sholat bersama</h4></div>
                    <div class="card-item"><img src="<?= sumber_gambar('panti_depan'); ?>" alt=""><h4>Makan bersama</h4></div>
                    <div class="card-item"><img src="<?= sumber_gambar('panti_depan'); ?>" alt=""><h4>Makan bersama</h4></div>
                <?php endif; ?>
            </div>

        <!-- 2. PROFIL -->
        <?php elseif ($page == 'profil') : ?>
            <div class="page-banner">
                <img src="<?= sumber_gambar('papan_panti'); ?>" alt="Papan Panti">
                <div>
                    <h2>PROFIL PANTI</h2>
                    <p>Mengenal lebih dekat tentang panti asuhan babul jannah</p>
                </div>
            </div>

            <div style="background: white; padding: 20px; border-radius: 10px;">
                <div class="section-title-btn" style="margin-bottom: 15px;">SEJARAH</div>
                <div style="display: flex; gap: 20px;">
                    <div style="flex: 2;">
                        <img src="<?= sumber_gambar('panti_depan'); ?>" style="width: 100%; height: 140px; object-fit: cover; border-radius: 6px; margin-bottom: 10px;" alt="">
                        <p style="font-size: 11px; color: #475569; line-height: 1.6;">
                            Panti Asuhan Babul Jannah didirikan pada tanggal 13 Mei 1986. Panti asuhan ini hadir sebagai tempat pengasuhan, pendidikan, dan pembinaan bagi anak-anak yatim dan dhuafa.<br><br>
                            Sejak berdiri hingga saat ini, Panti Asuhan Babul Jannah terus berupaya memberikan kasih sayang, perhatian, serta pendidikan yang baik bagi anak-anak binaan. Selain pendidikan umum, anak-anak juga mendapatkan pembinaan keagamaan, seperti belajar sholat, mengaji Al-Qur'an, serta mempelajari perilaku, sikap, dan nilai-nilai moral dalam kehidupan sehari-hari.<br><br>
                            Pada tahun 2026, Panti Asuhan Babul Jannah membina 35 anak. Dalam menjalankan kegiatannya, panti memperoleh dukungan dari para donatur dan hubungan masyarakat (Humas).
                        </p>
                    </div>
                    <div style="flex: 1; background: #d3ded7; padding: 15px; border-radius: 8px; text-align: center; height: fit-content;">
                        <div style="margin-bottom: 15px;">
                            <div style="font-size: 20px;">📅</div>
                            <b style="font-size: 11px; display: block;">Berdiri sejak</b>
                            <span style="font-size: 10px; color: #475569;">13 Mei 1986</span>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <div style="font-size: 20px;">👤</div>
                            <b style="font-size: 11px; display: block;">Jumlah anak binaan</b>
                            <span style="font-size: 10px; color: #475569;">35 anak</span>
                        </div>
                        <div>
                            <div style="font-size: 20px;">💚</div>
                            <b style="font-size: 11px; display: block;">Sumber dana</b>
                            <span style="font-size: 10px; color: #475569;">Donatur & Humas</span>
                        </div>
                    </div>
                </div>
            </div>

        <!-- 3. KEGIATAN -->
        <?php elseif ($page == 'kegiatan') : ?>
            <div class="page-banner">
                <img src="<?= sumber_gambar('papan_panti'); ?>" alt="Papan Panti">
                <div>
                    <h2>KEGIATAN</h2>
                    <p>Berbagai kegiatan pendidikan dan pembinaan anak-anak panti</p>
                </div>
            </div>

            <div style="background: white; padding: 20px; border-radius: 10px;">
                <div class="section-title-btn" style="margin-bottom: 15px;">KEGIATAN</div>
                <div class="grid-3">
                    <?php 
                    $q_keg_all = mysqli_query($koneksi, "SELECT * FROM tb_kegiatan ORDER BY id_kegiatan DESC");
                    if(mysqli_num_rows($q_keg_all) > 0):
                        while($ka = mysqli_fetch_assoc($q_keg_all)):
                    ?>
                        <div class="card-item">
                            <img src="assets/<?= $ka['foto']; ?>" alt="Kegiatan" onerror="this.src='<?= sumber_gambar('panti_depan'); ?>'">
                            <h4><?= $ka['judul_kegiatan']; ?></h4>
                        </div>
                    <?php endwhile; else: ?>
                        <div class="card-item"><img src="<?= sumber_gambar('panti_depan'); ?>" alt=""><h4>Pembagian sembako</h4></div>
                        <div class="card-item"><img src="<?= sumber_gambar('panti_depan'); ?>" alt=""><h4>Hari raya idul adha</h4></div>
                        <div class="card-item"><img src="<?= sumber_gambar('panti_depan'); ?>" alt=""><h4>Sholat bersama</h4></div>
                    <?php endif; ?>
                </div>
            </div>

        <!-- 4. GALERI -->
        <?php elseif ($page == 'galeri') : ?>
            <div class="page-banner">
                <img src="<?= sumber_gambar('papan_panti'); ?>" alt="Papan Panti">
                <div>
                    <h2>GALERI</h2>
                    <p>Dokumentasi kegiatan dan momen berharga anak-anak panti</p>
                </div>
            </div>

            <div style="background: white; padding: 20px; border-radius: 10px;">
                <div class="section-title-btn" style="margin-bottom: 15px;">GALERI</div>
                <div class="grid-3">
                    <?php 
                    $q_gal = mysqli_query($koneksi, "SELECT * FROM tb_kegiatan ORDER BY id_kegiatan DESC");
                    if(mysqli_num_rows($q_gal) > 0):
                        while($g = mysqli_fetch_assoc($q_gal)):
                    ?>
                        <div class="card-item" style="padding-bottom: 0;">
                            <img src="assets/<?= $g['foto']; ?>" style="height: 140px;" alt="Galeri" onerror="this.src='<?= sumber_gambar('panti_depan'); ?>'">
                        </div>
                    <?php endwhile; else: ?>
                        <div class="card-item"><img src="<?= sumber_gambar('panti_depan'); ?>" style="height: 140px;" alt=""></div>
                    <?php endif; ?>
                </div>
            </div>

        <!-- 5. DONASI -->
        <?php elseif ($page == 'donasi') : ?>
            <div class="page-banner">
                <img src="<?= sumber_gambar('papan_panti'); ?>" alt="Papan Panti">
                <div>
                    <h2>DONASI</h2>
                    <p>Dukung pendidikan, fasilitas dan kebutuhan anak-anak panti</p>
                </div>
            </div>

            <div style="background: white; padding: 25px; border-radius: 10px; text-align: center;">
                <div style="font-size: 30px; margin-bottom: 5px;">🤝💚</div>
                <h3 style="font-size: 14px; font-weight: 800; color: #17382c;">Donasi anda sangat berarti !</h3>
                <p style="font-size: 11px; color: #64748b; margin-bottom: 20px;">Dukung pendidikan, fasilitas, dan kebutuhan anak-anak panti melalui rekening berikut...</p>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; max-width: 450px; margin: 0 auto 20px; text-align: left;">
                    <b style="font-size: 12px; color: #17382c; display: block; margin-bottom: 8px;">REKENING DONASI</b>
                    <div style="display: flex; gap: 15px; font-size: 11px; margin-bottom: 6px;"><b>BRI</b> <span>: 1234-01-000000-53-0 (a.n Panti Babul Jannah)</span></div>
                    <div style="display: flex; gap: 15px; font-size: 11px;"><b>BSI</b> <span>: 7123456789 (a.n Panti Babul Jannah)</span></div>
                </div>

                <?php if($notif_donasi): ?><p style="color: green; font-weight: bold; font-size: 11px; margin-bottom: 10px;"><?= $notif_donasi; ?></p><?php endif; ?>

                <div class="form-box">
                    <form action="" method="POST">
                        <div class="form-group"><label>NAMA</label><input type="text" name="nama" required></div>
                        <div class="form-group"><label>EMAIL</label><input type="email" name="email" required></div>
                        <div class="form-group"><label>PESAN / BUKTI DONASI</label><textarea name="pesan" rows="3" required></textarea></div>
                        <button type="submit" name="kirim_donasi" class="btn-green" style="width: 100%; cursor: pointer;">KONFIRMASI DONASI</button>
                    </form>
                </div>
            </div>

        <!-- 6. KONTAK -->
        <?php elseif ($page == 'kontak') : ?>
            <div class="page-banner">
                <img src="<?= sumber_gambar('papan_panti'); ?>" alt="Papan Panti">
                <div>
                    <h2>KONTAK</h2>
                    <p>Hubungi kami untuk informasi lebih lanjut</p>
                </div>
            </div>

            <div style="background: white; padding: 25px; border-radius: 10px;">
                <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                    <div style="flex: 1; font-size: 11px; color: #334155;">
                        <b style="display: block; color: #17382c; margin-bottom: 3px;">NAMA</b>
                        <p style="margin-bottom: 10px;">RUSMAWATI DEWI ABADI</p>
                        <b style="display: block; color: #17382c; margin-bottom: 3px;">TELEPON</b>
                        <p style="margin-bottom: 10px;">081234567890</p>
                        <b style="display: block; color: #17382c; margin-bottom: 3px;">EMAIL</b>
                        <p>babuljannah@gmail.com</p>
                    </div>
                    <div style="flex: 1; background: #d3ded7; border-radius: 8px; padding: 15px; font-size: 10px; text-align: center; display: flex; align-items: center; justify-content: center;">
                        📍 Q7FF+HQJ, Buntu Kanna, Kec. Ponrang, Kabupaten Luwu, Sulawesi Selatan 91999
                    </div>
                </div>

                <div class="form-box" style="max-width: 100%;">
                    <form action="" method="POST">
                        <div class="form-group"><label>NAMA</label><input type="text" name="nama_k" required></div>
                        <div class="form-group"><label>EMAIL</label><input type="email" name="email_k" required></div>
                        <div class="form-group"><label>PESAN</label><textarea name="pesan_k" rows="3" required></textarea></div>
                        <button type="button" class="btn-green" style="width: 100%;">KIRIM PESAN</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <footer>
            ©2026 PANTI ASUHAN BABUL JANNAH | BUNTU NANNA
        </footer>
    </div>

</body>
</html>