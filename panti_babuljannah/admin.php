<?php
session_start();
include 'config/koneksi.php';
if (!isset($_SESSION['admin_babuljannah'])) {
    header("Location: login.php");
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Panti Asuhan Babul Jannah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { background-color: #f1f5f9; display: flex; height: 100vh; overflow: hidden; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: #17382c; color: white; display: flex; flex-direction: column; padding: 25px 20px; }
        .sidebar-logo { text-align: center; margin-bottom: 25px; }
        .sidebar-logo img { width: 65px; height: 65px; object-fit: contain; border-radius: 50%; background: white; padding: 3px; margin-bottom: 8px; }
        .sidebar-logo h2 { font-size: 12px; font-weight: 800; color: #ffffff; }
        .sidebar-logo p { font-size: 8px; color: #86efac; font-weight: 700; text-transform: uppercase; margin-top: 2px; }
        
        .nav-links { list-style: none; display: flex; flex-direction: column; gap: 6px; flex-grow: 1; }
        .nav-links a { color: #cbd5e1; text-decoration: none; font-size: 11px; font-weight: 600; padding: 9px 12px; border-radius: 8px; display: block; transition: 0.2s; }
        .nav-links a:hover, .nav-links a.active { background: #234e3e; color: #ffffff; }
        .nav-links a.logout { color: #fca5a5; margin-top: auto; }

        /* Main Content */
        .main-content { flex-grow: 1; padding: 25px; overflow-y: auto; }
        
        /* Top Header */
        .top-header { background: white; padding: 15px 20px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.03); }
        .top-header h2 { font-size: 15px; color: #1e293b; font-weight: 800; text-transform: uppercase; }
        .breadcrumb { font-size: 11px; color: #64748b; font-weight: 600; }

        /* General Card & Table Style */
        .content-card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .search-add-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; gap: 15px; }
        .search-input { width: 250px; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 11px; }
        .btn-add { background: #17382c; color: white; border: none; padding: 8px 14px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th { background: #f8fafc; color: #475569; font-size: 11px; font-weight: 700; text-align: left; padding: 10px; border-bottom: 2px solid #e2e8f0; }
        table td { padding: 10px; font-size: 11px; color: #334155; border-bottom: 1px solid #f1f5f9; }

        /* Profil Panti Layout */
        .profile-banner { width: 100%; height: 150px; background: #0f241d; border-radius: 8px; overflow: hidden; margin-bottom: 15px; border: 2px solid #e2e8f0; }
        .profile-banner img { width: 100%; height: 100%; object-fit: cover; display: block; }
        
        .profile-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .section-box { background: white; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; }
        .section-title { background: #17382c; color: white; padding: 8px 15px; border-radius: 6px; font-size: 12px; font-weight: 700; display: inline-block; margin-bottom: 15px; text-transform: uppercase; }
        
        .profile-text p { font-size: 12px; color: #475569; line-height: 1.7; margin-bottom: 12px; text-align: justify; }
        
        .stat-sidebar-box { display: flex; align-items: center; gap: 12px; background: #f8fafc; padding: 12px; border-radius: 8px; margin-bottom: 10px; border: 1px solid #e2e8f0; }
        .stat-sidebar-box div.icon-placeholder { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: #17382c; color: white; border-radius: 50%; font-size: 14px; }
        .stat-sidebar-box .info h4 { font-size: 11px; color: #64748b; font-weight: 600; }
        .stat-sidebar-box .info p { font-size: 12px; color: #1e293b; font-weight: 800; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="assets/logo.jpeg" alt="Logo Panti" onerror="this.src='assets/logo.jpg'">
            <h2>PANTI ASUHAN</h2>
            <p>BABUL JANNAH</p>
        </div>
        <ul class="nav-links">
            <li><a href="admin.php?page=dashboard" class="<?php echo ($page == 'dashboard') ? 'active' : ''; ?>">Dashboard</a></li>
            <li><a href="admin.php?page=profil" class="<?php echo ($page == 'profil') ? 'active' : ''; ?>">Profil Panti</a></li>
            <li><a href="admin.php?page=kegiatan" class="<?php echo ($page == 'kegiatan') ? 'active' : ''; ?>">Kelola Kegiatan</a></li>
            <li><a href="admin.php?page=galeri" class="<?php echo ($page == 'galeri') ? 'active' : ''; ?>">Kelola Galeri</a></li>
            <li><a href="admin.php?page=informasi" class="<?php echo ($page == 'informasi') ? 'active' : ''; ?>">Informasi Panti / Donasi</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        
        <?php if ($page == 'dashboard'): ?>
            <div class="top-header">
                <h2>Dashboard Admin</h2>
                <span class="breadcrumb">Dashboard</span>
            </div>
            <div class="content-card">
                <h3>Selamat Datang di Panel Pengelola Panti Asuhan Babul Jannah</h3>
                <p style="margin-top: 10px; font-size: 12px; color: #64748b;">Gunakan menu di sebelah kiri untuk mengelola data profil, kegiatan, galeri, serta informasi donasi panti.</p>
            </div>

        <?php elseif ($page == 'profil'): ?>
            <div class="top-header">
                <h2>Profil Panti Asuhan</h2>
                <span class="breadcrumb">Dashboard > Profil Panti</span>
            </div>

            <!-- Banner Foto Depan Panti -->
            <div class="profile-banner">
                <img src="assets/panti_depan.jpeg" alt="Gedung Panti Asuhan" onerror="this.src='assets/panti_depan.jpg'">
            </div>

            <div class="profile-grid">
                <!-- Kolom Kiri: Sejarah -->
                <div class="section-box">
                    <div class="section-title">Sejarah</div>
                    <div class="profile-text">
                        <p>Panti Asuhan Babul Jannah didirikan pada tanggal 13 Mei 1986. Panti asuhan ini hadir sebagai tempat pengasuhan, pendidikan, dan pembinaan bagi anak-anak yatim dan dhuafa.</p>
                        <p>Sejak berdiri hingga saat ini, Panti Asuhan Babul Jannah terus berupaya memberikan kasih sayang, perhatian, serta pendidikan yang baik bagi anak-anak binaan. Selain pendidikan umum, anak-anak juga mendapatkan pembinaan keagamaan, seperti belajar sholat, mengaji Al-Qur'an, serta mempelajari perilaku, sikap, dan nilai-nilai moral dalam kehidupan sehari-hari.</p>
                        <p>Pada tahun 2026, Panti Asuhan Babul Jannah membina 35 anak. Dalam menjalankan kegiatannya, panti memperoleh dukungan dari para donatur dan hubungan masyarakat (Humas). Melalui berbagai kegiatan pengasuhan dan pendidikan, Panti Asuhan Babul Jannah berharap dapat membantu anak-anak tumbuh menjadi pribadi yang mandiri, berakhlak mulia, serta mampu memberikan manfaat bagi masyarakat.</p>
                    </div>
                </div>

                <!-- Kolom Kanan: Statistik / Info Singkat -->
                <div>
                    <div class="section-box" style="margin-bottom: 15px;">
                        <div class="stat-sidebar-box">
                            <div class="icon-placeholder">📅</div>
                            <div class="info">
                                <h4>Berdiri sejak</h4>
                                <p>13 Mei 1986</p>
                            </div>
                        </div>
                        <div class="stat-sidebar-box">
                            <div class="icon-placeholder">👶</div>
                            <div class="info">
                                <h4>Jumlah anak</h4>
                                <p>binaan 35 anak</p>
                            </div>
                        </div>
                        <div class="stat-sidebar-box" style="margin-bottom: 0;">
                            <div class="icon-placeholder">🤝</div>
                            <div class="info">
                                <h4>Sumber dana</h4>
                                <p>Donatur & Humas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($page == 'kegiatan'): ?>
            <div class="top-header">
                <h2>Kelola Kegiatan</h2>
                <span class="breadcrumb">Dashboard > Kelola Kegiatan</span>
            </div>
            <div class="content-card">
                <div class="search-add-bar">
                    <input type="text" class="search-input" placeholder="Cari kegiatan...">
                    <button class="btn-add">+ Tambah Kegiatan</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mengaji bersama</td>
                            <td>10 Oktober 2026</td>
                            <td><a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a> | <a href="#" style="color: #dc2626; text-decoration: none; font-weight: 600;">Hapus</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Pembagian sembako</td>
                            <td>8 Oktober 2026</td>
                            <td><a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a> | <a href="#" style="color: #dc2626; text-decoration: none; font-weight: 600;">Hapus</a></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Pengajian</td>
                            <td>6 Oktober 2026</td>
                            <td><a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a> | <a href="#" style="color: #dc2626; text-decoration: none; font-weight: 600;">Hapus</a></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Literasi</td>
                            <td>4 Oktober 2026</td>
                            <td><a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a> | <a href="#" style="color: #dc2626; text-decoration: none; font-weight: 600;">Hapus</a></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Bakti sosial</td>
                            <td>2 Oktober 2026</td>
                            <td><a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a> | <a href="#" style="color: #dc2626; text-decoration: none; font-weight: 600;">Hapus</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <?php elseif ($page == 'galeri'): ?>
            <div class="top-header">
                <h2>Kelola Galeri</h2>
                <span class="breadcrumb">Dashboard > Kelola Galeri</span>
            </div>
            <div class="content-card">
                <div class="search-add-bar">
                    <input type="text" class="search-input" placeholder="Cari foto galeri...">
                    <button class="btn-add">+ Tambah Foto</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Foto</th>
                            <th>Tanggal Unggah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Dokumentasi Santunan Anak Yatim</td>
                            <td>10 Oktober 2026</td>
                            <td><a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a> | <a href="#" style="color: #dc2626; text-decoration: none; font-weight: 600;">Hapus</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <?php elseif ($page == 'informasi'): ?>
            <div class="top-header">
                <h2>Kelola Informasi</h2>
                <span class="breadcrumb">Dashboard > Kelola Informasi</span>
            </div>
            <div class="content-card">
                <div class="search-add-bar">
                    <input type="text" class="search-input" placeholder="Cari kegiatan...">
                    <button class="btn-add">+ Tambah Kegiatan</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mengaji bersama</td>
                            <td>10 Oktober 2026</td>
                            <td><a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a> | <a href="#" style="color: #dc2626; text-decoration: none; font-weight: 600;">Hapus</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Pembagian sembako</td>
                            <td>8 Oktober 2026</td>
                            <td><a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a> | <a href="#" style="color: #dc2626; text-decoration: none; font-weight: 600;">Hapus</a></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Pengajian</td>
                            <td>6 Oktober 2026</td>
                            <td><a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a> | <a href="#" style="color: #dc2626; text-decoration: none; font-weight: 600;">Hapus</a></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Literasi</td>
                            <td>4 Oktober 2026</td>
                            <td><a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a> | <a href="#" style="color: #dc2626; text-decoration: none; font-weight: 600;">Hapus</a></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Bakti sosial</td>
                            <td>2 Oktober 2026</td>
                            <td><a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600;">Edit</a> | <a href="#" style="color: #dc2626; text-decoration: none; font-weight: 600;">Hapus</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>