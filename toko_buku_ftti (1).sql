-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2025 at 07:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_buku_ftti`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `kode_menu` varchar(12) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` char(11) DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `stok` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `kode_menu`, `nama`, `harga`, `gambar`, `kategori`, `stok`) VALUES
(0, 'MN00', 'Buku Tanah Permai', '3500', 'bukutp.jpg', 'ATK', 1),
(1, 'MN01', 'Sampul Buku Tanah Permai', '2000', 'sampulbukutp.jpg', 'ATK', 1),
(2, 'MN02', 'Buku Pedoman', '8000', 'bukupedoman.jpg', 'ATK', 1),
(3, 'MN03', 'Buku Izin', '7000', 'bukuizin.jpg', 'ATK', 1),
(4, 'MN04', 'Buku Tutur Sabda', '9000', 'bukuts.jpg', 'ATK', 1),
(5, 'MN05', 'Buku Doa', '6000', 'bukudoa.jpg', 'ATK', 1),
(6, 'MN06', 'Buku Kejar Berita', '8000', 'bukukb.jpg', 'ATK', 1),
(7, 'MN07', 'Buku Kas', '4000', 'bukukas.jpg', 'ATK', 1),
(8, 'MN08', 'HYMNS', '305500', 'hymns.png', 'Buku Rohani', 1),
(9, 'MN09', 'Alkitab Perjanjian Baru Versi Inggris Dengan Catatan Kaki', '197500', 'ntrvev.jpg', 'Buku Rohani', 1),
(10, 'MN10', 'Alkitab Perjanjian Baru Versi Inggris Tanpa Catatan Kaki', '100000', 'ntrcevwfn.jpg', 'Buku Rohani', 1),
(11, 'MN11', 'Kidung Pemulihan', '207000', 'kidung.jpg', 'Buku Rohani', 1),
(12, 'MN12', 'Alkitab Versi Pemulihan Perjanjian Lama dan Perjanjian Baru', '350000', 'avpplpb.jpeg', 'Buku Rohani', 1),
(13, 'MN13', 'Pen Hi-Tech Kenko Hitam Gel 0.28mm\r\n', '2000', 'penhi-techkenko.jpeg', 'ATK', 1),
(14, 'MN14', 'Pen Hi Tech C 0,3', '21000', 'pulpenhitechc0,3.jpg', 'ATK', 1),
(15, 'MN15', 'Pen I Tech Jocyo-2', '2500', 'itech2joyco.jpeg', 'ATK', 1),
(16, 'MN16', 'Refill Isi Pen Hi Tech C Pilot', '14000', 'refillisipenhitechcpilot.jpeg', 'ATK', 1),
(17, 'MN17', 'Pen Kokoro', '5000', 'pengelkokoro.JPEG', 'ATK', 1),
(18, 'MN18', 'Pen Uni Jestream Ballpoint 0,38mm', '21000', 'penunijetstreamballpoint0,38mm.jpg', 'ATK', 1),
(19, 'MN19', 'Refill Pen Uni Jetstream 0.38mm', '15000', 'refillisipenunijetstream0.38mm.jpeg', 'ATK', 1),
(20, 'MN20', 'Refill Pen I Tech Jocyo 0.28mm', '2000', 'refillisipenitechjoyco0.28mm.jpeg', 'ATK', 1),
(21, 'MN21', 'Penanda KENKO Highlighter Dreamliner', '3500', 'penandakenkohighlighterdreamliner.jpeg', 'ATK', 1),
(22, 'MN22', 'Penanda KENKO Highlighter Softliner', '3500', 'penandakenkohighlightersoftliner.jpeg', 'ATK', 1),
(23, 'MN23', 'Joyco Quaco 4 Warna 0.7', '5500', 'joykoquaco0.7.jpeg', 'ATK', 1),
(24, 'MN24', 'Mechanical Pencil Pensil Mekanik Joyko MP-54 0.5 mm', '6000', 'penciljoykomp540.5mm.jpeg', 'ATK', 1),
(25, 'MN25', 'Pulpen Gel Joyko Diamond Art', '2500', 'pulpengeljoykodiamondart.jpeg', 'ATK', 1),
(26, 'MN26', 'Snowman Coloring Marker', '1500', 'SnowmanColoringMarker.jpg', 'ATK', 1),
(27, 'MN27', 'Joyko Permanent Marker Spidol', '4000', 'joykopermanentmarkerspidol.jpeg', 'ATK', 1),
(28, 'MN28', 'PILOT - Pen Ballpoint BPT-P', '2000', 'penpilotbptp.JPG', 'ATK', 1),
(29, 'MN29', 'Ballpobalpoint Faster - Pulpen Faster C600', '2500', 'pulpenfasterc6.JPG', 'ATK', 1),
(30, 'MN30', 'Penggaris Butterfly 15cm', '2000', 'penggarisbutterfly15cm.jpeg', 'ATK', 1),
(31, 'MN31', 'Penggaris Butterfly 20cm', '3000', 'penggarisbutterfly20cm.jpeg', 'ATK', 1),
(32, 'MN32', 'Penggaris Butterfly 30cm', '4000', 'penggarisbutterfly30cm.jpeg', 'ATK', 1),
(33, 'MN33', 'Penggaris Joyko 15cm', '2000', 'penggarisjoyko15cm.jpeg', 'ATK', 1),
(34, 'MN34', 'Folder A4 Dua Resleting Jaring Mesh Transparan (Carrier)', '20000', 'tascarrier.jpeg', 'ATK', 1),
(35, 'MN35', 'Kertas Kado Gulung Bes Wag', '5000', 'kertaskadogulung.jpg', 'ATK', 1),
(36, 'MN36', 'Clear Holder Joyko DK-B20F4 Folio 20 Lbr Document Keeper Folder ', '19500', 'clearholder.JPEG', 'ATK', 1),
(37, 'MN37', 'Map Plastik Kancing folio f4', '4000', 'mapplastik.JPEG', 'ATK', 1),
(38, 'MN38', 'Dasi', '20000', 'dasi.JPG', 'Living', 1),
(39, 'MN39', '70 Gsm A4 Copy Paper - Color: White (HVS)', '200', 'hvs.jpg', 'ATK', 1),
(40, 'MN40', 'Jaket FTTI', '190000', '', 'Living', 1),
(41, 'MN41', 'Tokyo 1 Alas Gosok Ironing Cloth', '0', 'alasgosok.JPEG', 'Living', 1),
(42, 'MN42', 'Ganso Laundry Bag 50CM x 60CM - M369 ', '20000', 'laundrybags.JPEG', 'Living', 1),
(43, 'MN43', 'Nathalie Kaos dalam Katun Wanita NTA0027 Singlet Wanita', '21000', 'bajudalamwanita.JPEG', 'Living', 1),
(44, 'MN44', 'Kaos Dalam Swan Brand', '21000', 'bajudalampria.JPEG', 'Living', 1),
(45, 'MN45', 'Kaos Singlet Crocodile ', '36000', 'bajudalampriacrocodile.JPEG', 'Living', 1),
(46, 'MN46', 'Kertas Kado', '1500', 'kertaskado.JPEG', 'ATK', 1),
(47, 'MN47', 'Binder A5', '15000', 'bindera5.JPG', 'ATK', 1),
(48, 'MN48', 'Sidu Double Folio', '3000', 'sidudoublefolio.png', 'ATK', 1),
(49, 'MN49', 'Binder B5 Warna Cover Tebal Wengu Binder Plastik', '42000', 'binderb5.JPEG', 'ATK', 1),
(50, 'MN50', 'Bantex A5 Pastel Trendy Multi Ring Binder 20 Hole', '19000', 'bantexa5.JPEG', 'ATK', 1),
(51, 'MN51', 'Buku Tulis Sidu 38 Lembar ', '3500', 'bukutulissidu38.JPEG', 'ATK', 1),
(52, 'MN52', 'Loose Leaf B5 100 Lembar Putih Polos', '10000', 'looseleafb5polos.JPEG', 'ATK', 1),
(53, 'MN53', 'LOOSE LEAF BIG BOSS GARIS A5-50 PUTIH', '5000', 'looseleafa5bergaris.JPEG', 'ATK', 1),
(54, 'MN54', 'Loose Leaf Joyko A5-7020 kertas bergaris/putih (100lbr)', '9000', 'looseleafa5bergarisjoyko.JPEG', 'ATK', 1),
(55, 'MN55', 'Loose Leaf B5 Bergaris Big Boss', '5500', 'looseleafb5bergaris.JPEG', 'ATK', 1),
(56, 'MN56', 'Label Tom and Jerry No.99 ', '6000', 'labeltom&jerryno99.JPG', 'ATK', 1),
(57, 'MN57', 'Stabilo Combo Highlighter CHL 900', '2000', 'stabilocombohighlighter.JPEG', 'ATK', 1),
(58, 'MN58', 'Joyko Titi Twist Crayon TI-CP-12T', '2500', 'joykotititwistcrayonticp12t.JPG', 'ATK', 1),
(59, 'MN59', 'Botol Minum', '26000', 'botolminum.jpg', 'Living', 1),
(60, 'MN60', 'Botol Lion Star', '9000', 'lionstar.jpg', 'Living', 1),
(61, 'MN61', 'Sampul Gulung Cokelat 45cm', '12000', 'sampulgulungcokelat45cm.JPG', 'ATK', 1),
(62, 'MN62', 'Sampul Gulung Plastik', '0', 'sampulgulungplastik.JPEG', 'ATK', 1),
(63, 'MN63', 'M&G 5m x 5mm Gene Starter Correction Tape with Grip ACT51971', '6000', 'mgct.JPEG', 'ATK', 1),
(64, 'MN64', 'M&G 6m x 5mm Correction Tape Refill', '4500', 'refillctmg.JPEG', 'ATK', 1),
(65, 'MN65', 'Kenko Correction Tape', '5500', 'ctkenko.JPG', 'ATK', 1),
(66, 'MN66', 'Kenko Liquid', '5500', 'liquidkenko.png', 'ATK', 1),
(67, 'MN67', 'Index Mark Pembatas Buku Joyko IM-60 Tutty Fruity - Watermelon', '8000', 'indexmarkpembatasbukujoyko.JPG', 'ATK', 1),
(68, 'MN68', 'T&J LABEL FLAGS TRANSPARENT TJ 44-5', '4500', 't&jlabelflags.JPG', 'ATK', 1),
(69, 'MN69', 'Memo Stick / Memo Pelekat Stiker Mms-21 Joyko', '1', 'joykomemostick.JPEG', 'ATK', 1),
(70, 'MN70', 'Gunting lipat portabel mini joyko portable scissors SC-36', '12000', 'guntinglipatportableminijoyko.JPG', 'ATK', 1),
(71, 'MN71', 'M&G Sticky Notes Sakura Times', '7500', 'mgstickynotessakuratimes.JPG', 'ATK', 1),
(72, 'MN72', 'Washi Tape Coasters', '3000', 'washitapecoasters.JPEG', 'ATK', 1),
(73, 'MN73', 'PENGHAPUS HITAM JOYKO SOFT ERASER', '500', 'joykosofteraser.JPEG', 'ATK', 1),
(74, 'MN74', 'Isi pensil mekanik 0.5mm JOYKO PL 05', '2500', 'isipensilmekanik0.5mmjoykopl05.JPEG', 'ATK', -2);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('pending','diproses','selesai','dibatalkan') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_pesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `kode_pesanan` varchar(12) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `kode_pesanan`, `nama_pelanggan`, `waktu`) VALUES
(17, '67af4f84263f', 'awen', '2025-02-14 21:13:24'),
(18, '67af5117dec1', 'Awen', '2025-02-14 21:20:07'),
(19, '67af5c637d10', 'Agus', '2025-02-14 22:08:19'),
(20, '67af5c7e594b', 'Agus', '2025-02-14 22:08:46'),
(21, '67b0c39622b0', 'Awen', '2025-02-15 23:40:54'),
(22, '67b0c3ba7d41', 'Awen', '2025-02-15 23:41:30'),
(23, '67b0c5ccec54', 'Agus', '2025-02-15 23:50:20'),
(24, '67b0c5e76738', 'Agus', '2025-02-15 23:50:47'),
(25, '67b0c952a64a', 'Agus', '2025-02-16 00:05:22'),
(26, '67b0cace6faa', 'Agus', '2025-02-16 00:11:42'),
(27, '67b0caea0d40', 'Agus', '2025-02-16 00:12:10'),
(28, '67b0caf46375', 'agus', '2025-02-16 00:12:20'),
(29, '67b0cbdb12e8', 'agus', '2025-02-16 00:16:11'),
(30, '67b0cc6bc356', 'agus', '2025-02-16 00:18:35'),
(31, '67b0cc76e488', 'agus', '2025-02-16 00:18:46'),
(32, '67b0ccb670ed', 'a', '2025-02-16 00:19:50'),
(33, '67b0cec3d792', 'a', '2025-02-16 00:28:35'),
(34, '67b0ced3aa91', 'a', '2025-02-16 00:28:51'),
(35, '67b0cee60406', 'a', '2025-02-16 00:29:10'),
(36, '67b0cef0167a', 'a', '2025-02-16 00:29:20'),
(37, '67b0d3563e86', 'a', '2025-02-16 00:48:06'),
(38, '67b0d35b7b17', 'a', '2025-02-16 00:48:11'),
(39, '67b0d3805c52', 'a', '2025-02-16 00:48:48'),
(40, '67b0d4af9a64', 'b', '2025-02-16 00:53:51'),
(41, '67b0d4c44f12', 'b', '2025-02-16 00:54:12'),
(42, '67b0d4d7d44a', 'b', '2025-02-16 00:54:31'),
(43, '67b0d4e171ef', 'b', '2025-02-16 00:54:41'),
(44, '67b0d51c88ca', 'b', '2025-02-16 00:55:40'),
(45, '67b0d54aecb3', 'a', '2025-02-16 00:56:26');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`) VALUES
(1, 'serius', '7423dbeddc5588b4ec93fdcbb844836c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
