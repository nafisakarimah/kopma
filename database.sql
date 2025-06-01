CREATE TABLE `alamat_pengiriman` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `no_telp` VARCHAR(255) NOT NULL,
  `alamat` VARCHAR(255) NOT NULL,
  `utama` TINYINT NOT NULL DEFAULT 0 ,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`)
)
ENGINE = InnoDB;
CREATE TABLE `detail_transaksi` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `transaksi_id` BIGINT UNSIGNED NOT NULL,
  `produk_id` BIGINT UNSIGNED NOT NULL,
  `ukuran_produk_id` BIGINT UNSIGNED NULL,
  `jumlah` INT NOT NULL,
  `harga` BIGINT NOT NULL,
  `total` BIGINT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`)
)
ENGINE = InnoDB;
CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`),
  CONSTRAINT `failed_jobs_uuid_unique` UNIQUE (`uuid`)
)
ENGINE = InnoDB;
CREATE TABLE `faqs` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `judul` VARCHAR(255) NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `urutan` INT NOT NULL DEFAULT 0 ,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`)
)
ENGINE = InnoDB;
CREATE TABLE `feedback` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `masukan` VARCHAR(255) NOT NULL,
  `tampil` TINYINT NOT NULL DEFAULT 0 ,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`)
)
ENGINE = InnoDB;
CREATE TABLE `guskom` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `gambar` VARCHAR(255) NOT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `deskripsi` LONGTEXT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`)
)
ENGINE = InnoDB;
CREATE TABLE `kategori` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `ukuran` TINYINT NOT NULL DEFAULT 0 ,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`),
  CONSTRAINT `kategori_slug_unique` UNIQUE (`slug`)
)
ENGINE = InnoDB;
CREATE TABLE `keranjang` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `produk_id` BIGINT UNSIGNED NOT NULL,
  `jumlah` INT NOT NULL,
  `ukuran_produk_id` BIGINT UNSIGNED NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`)
)
ENGINE = InnoDB;
CREATE TABLE `migrations` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`)
)
ENGINE = InnoDB;
CREATE TABLE `password_resets` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL
)
ENGINE = InnoDB;
CREATE TABLE `personal_access_tokens` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `token` VARCHAR(64) NOT NULL,
  `abilities` TEXT NULL,
  `last_used_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`),
  CONSTRAINT `personal_access_tokens_token_unique` UNIQUE (`token`)
)
ENGINE = InnoDB;
CREATE TABLE `produk` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `kategori_id` BIGINT UNSIGNED NOT NULL,
  `gambar` VARCHAR(255) NOT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `harga` BIGINT NOT NULL,
  `stok` BIGINT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`)
)
ENGINE = InnoDB;
CREATE TABLE `transaksi` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `alamat_pengiriman_id` BIGINT UNSIGNED NOT NULL,
  `no_po` VARCHAR(255) NOT NULL,
  `total` BIGINT NOT NULL,
  `status` TINYINT NOT NULL DEFAULT 0  COMMENT '0 -> pesanan terkirim, 1 -> pesanan diterima, 2 -> pesanan selesai, 3 -> pesanan ditolak' ,
  `bukti_barang_sampai` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`)
)
ENGINE = InnoDB;
CREATE TABLE `ukuran_produk` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `produk_id` BIGINT UNSIGNED NOT NULL,
  `ukuran` VARCHAR(255) NOT NULL,
  `stok` BIGINT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`)
)
ENGINE = InnoDB;
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
  `foto` VARCHAR(255) NULL,
  `nama` VARCHAR(255) NOT NULL,
  `no_telp` VARCHAR(255) NOT NULL,
  `nak` VARCHAR(255) NULL,
  `alamat` VARCHAR(255) NULL,
  `email` VARCHAR(255) NOT NULL,
  `status` TINYINT NOT NULL DEFAULT 0  COMMENT '0 -> belum diverifikasi, 1 -> diverifikasi, 2 -> dalam pengawasan' ,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL,
  `role` TINYINT NOT NULL,
  `member` TINYINT NOT NULL DEFAULT 0 ,
  `member_poin` BIGINT NOT NULL DEFAULT 0 ,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`),
  CONSTRAINT `users_no_telp_unique` UNIQUE (`no_telp`),
  CONSTRAINT `users_email_unique` UNIQUE (`email`)
)
ENGINE = InnoDB;
INSERT INTO `alamat_pengiriman` (`id`, `user_id`, `nama`, `no_telp`, `alamat`, `utama`, `created_at`, `updated_at`) VALUES ('1', '5', 'Rizky Musthofa', '0895367330194', 'Jakarta', 1, '2025-02-08 15:27:27', '2025-02-08 15:27:27');
INSERT INTO `detail_transaksi` (`id`, `transaksi_id`, `produk_id`, `ukuran_produk_id`, `jumlah`, `harga`, `total`, `created_at`, `updated_at`) VALUES ('1', '1', '3', NULL, 4, '79000', '316000', NULL, NULL);
INSERT INTO `guskom` (`id`, `gambar`, `nama`, `slug`, `deskripsi`, `created_at`, `updated_at`) VALUES ('1', 'guskom/IMG-20250208-1739002199.jpg', 'nama guskom', 'nama-guskom-1', 'des', '2025-02-08 14:57:32', '2025-02-08 15:09:59');
INSERT INTO `guskom` (`id`, `gambar`, `nama`, `slug`, `deskripsi`, `created_at`, `updated_at`) VALUES ('2', 'guskom/IMG-20250208-1739001868.png', 'AI GUSKOM LAMA', 'ai-guskom-lama-1', 'DES OK', '2025-02-08 15:04:28', '2025-02-08 15:10:07');
INSERT INTO `kategori` (`id`, `nama`, `slug`, `ukuran`, `created_at`, `updated_at`) VALUES ('1', 'Gamashirt', 'gamashirt', 1, NULL, NULL);
INSERT INTO `kategori` (`id`, `nama`, `slug`, `ukuran`, `created_at`, `updated_at`) VALUES ('2', 'Swalayan', 'swalayan', 0, NULL, NULL);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5, '2023_01_23_092109_create_kategori_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6, '2023_01_23_092110_create_produk_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7, '2023_01_23_092111_create_ukuran_produk_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8, '2023_01_23_104947_create_alamat_pengiriman_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9, '2023_01_23_114100_create_keranjang_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10, '2023_01_23_115613_create_transaksi_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11, '2023_01_23_115629_create_detail_transaksi_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12, '2023_07_08_093635_create_guskom_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13, '2023_07_08_093715_create_faqs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14, '2023_07_08_103816_create_feedback_table', 1);
INSERT INTO `produk` (`id`, `kategori_id`, `gambar`, `nama`, `slug`, `deskripsi`, `harga`, `stok`, `created_at`, `updated_at`) VALUES ('1', '1', '/assets/img/product-2.jpg', 'Produk 1', 'produk-1', 'Deskripsi', '90000', NULL, '2025-01-10 15:35:16', '2025-01-10 15:35:16');
INSERT INTO `produk` (`id`, `kategori_id`, `gambar`, `nama`, `slug`, `deskripsi`, `harga`, `stok`, `created_at`, `updated_at`) VALUES ('2', '1', '/assets/img/product-7.jpg', 'Produk 2', 'produk-2', 'Deskripsi', '79000', NULL, '2025-01-10 15:35:16', '2025-01-10 15:35:16');
INSERT INTO `produk` (`id`, `kategori_id`, `gambar`, `nama`, `slug`, `deskripsi`, `harga`, `stok`, `created_at`, `updated_at`) VALUES ('3', '2', '/assets/img/product-1.jpg', 'Produk 3', 'produk-3', 'Deskripsi', '79000', '72', '2025-01-10 15:35:16', '2025-02-08 15:29:39');
INSERT INTO `produk` (`id`, `kategori_id`, `gambar`, `nama`, `slug`, `deskripsi`, `harga`, `stok`, `created_at`, `updated_at`) VALUES ('4', '2', '/assets/img/product-3.jpg', 'Produk 4', 'produk-4', 'Deskripsi', '50000', '70', '2025-01-10 15:35:16', '2025-01-10 15:35:16');
INSERT INTO `transaksi` (`id`, `user_id`, `alamat_pengiriman_id`, `no_po`, `total`, `status`, `bukti_barang_sampai`, `created_at`, `updated_at`) VALUES ('1', '5', '1', 'TRX-20250208-5-0001', '316000', 2, '/storage/transaksi/bukti/KByg5i1i8jffo2fRbImQcYt6Tv8vd9FaD8GXRUWS.jpg', '2025-02-08 15:27:45', '2025-02-08 15:29:50');
INSERT INTO `ukuran_produk` (`id`, `produk_id`, `ukuran`, `stok`, `created_at`, `updated_at`) VALUES ('1', '1', 'S', '10', NULL, NULL);
INSERT INTO `ukuran_produk` (`id`, `produk_id`, `ukuran`, `stok`, `created_at`, `updated_at`) VALUES ('2', '1', 'M', '10', NULL, NULL);
INSERT INTO `ukuran_produk` (`id`, `produk_id`, `ukuran`, `stok`, `created_at`, `updated_at`) VALUES ('3', '1', 'L', '10', NULL, NULL);
INSERT INTO `ukuran_produk` (`id`, `produk_id`, `ukuran`, `stok`, `created_at`, `updated_at`) VALUES ('4', '1', 'XL', '10', NULL, NULL);
INSERT INTO `ukuran_produk` (`id`, `produk_id`, `ukuran`, `stok`, `created_at`, `updated_at`) VALUES ('5', '1', 'XXL', '10', NULL, NULL);
INSERT INTO `ukuran_produk` (`id`, `produk_id`, `ukuran`, `stok`, `created_at`, `updated_at`) VALUES ('6', '2', 'S', '10', NULL, NULL);
INSERT INTO `ukuran_produk` (`id`, `produk_id`, `ukuran`, `stok`, `created_at`, `updated_at`) VALUES ('7', '2', 'M', '10', NULL, NULL);
INSERT INTO `ukuran_produk` (`id`, `produk_id`, `ukuran`, `stok`, `created_at`, `updated_at`) VALUES ('8', '2', 'L', '10', NULL, NULL);
INSERT INTO `ukuran_produk` (`id`, `produk_id`, `ukuran`, `stok`, `created_at`, `updated_at`) VALUES ('9', '2', 'XL', '10', NULL, NULL);
INSERT INTO `ukuran_produk` (`id`, `produk_id`, `ukuran`, `stok`, `created_at`, `updated_at`) VALUES ('10', '2', 'XXL', '10', NULL, NULL);
INSERT INTO `users` (`id`, `foto`, `nama`, `no_telp`, `nak`, `alamat`, `email`, `status`, `password`, `remember_token`, `role`, `member`, `member_poin`, `created_at`, `updated_at`) VALUES ('1', NULL, 'Admin', '99999999999', NULL, 'Alamat Admin', 'admin@gmail.com', 1, '$2y$10$o6yLkAzyPTKgbmj32MD.jO6b9QvTZAabx8wGXHh6dZF3C8iBq4BAy', NULL, 1, 0, '0', '2025-01-10 15:35:16', '2025-01-10 15:35:16');
INSERT INTO `users` (`id`, `foto`, `nama`, `no_telp`, `nak`, `alamat`, `email`, `status`, `password`, `remember_token`, `role`, `member`, `member_poin`, `created_at`, `updated_at`) VALUES ('2', NULL, 'User', '1234', NULL, 'Alamat User', 'user@gmail.com', 1, '$2y$10$o6yLkAzyPTKgbmj32MD.jO6b9QvTZAabx8wGXHh6dZF3C8iBq4BAy', NULL, 2, 0, '0', '2025-01-10 15:35:16', '2025-01-10 15:35:16');
INSERT INTO `users` (`id`, `foto`, `nama`, `no_telp`, `nak`, `alamat`, `email`, `status`, `password`, `remember_token`, `role`, `member`, `member_poin`, `created_at`, `updated_at`) VALUES ('3', NULL, 'Member', '123456', NULL, 'Alamat User', 'member@gmail.com', 1, '$2y$10$iA5O6paSd0jJbTEZyscKAeGM2Wf5bFrVQMky5Cy6PqMfQIaSdOkT2', NULL, 2, 1, '0', '2025-01-10 15:35:16', '2025-01-10 15:35:16');
INSERT INTO `users` (`id`, `foto`, `nama`, `no_telp`, `nak`, `alamat`, `email`, `status`, `password`, `remember_token`, `role`, `member`, `member_poin`, `created_at`, `updated_at`) VALUES ('4', NULL, 'Member2', '12322456', NULL, 'Alamat User', 'member2@gmail.com', 1, '$2y$10$Fr5HpIbbRdxpcAv7rjzZzefjd0pPzBn.l.6VFFg0yeJsfFe/1juIe', NULL, 2, 1, '0', '2025-01-10 15:35:16', '2025-01-10 15:35:16');
INSERT INTO `users` (`id`, `foto`, `nama`, `no_telp`, `nak`, `alamat`, `email`, `status`, `password`, `remember_token`, `role`, `member`, `member_poin`, `created_at`, `updated_at`) VALUES ('5', NULL, 'Rizky Musthofa', '0895367330194', NULL, 'Jl. Ampera Raya No.20, RT.3/RW.6
, Cilandak Tim., Kec. Cilandak, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12330', 'rizkymusthofa0509@gmail.com', 0, '$2y$10$2.ih2Pz/0iHORlm7P/7IXuHA6jLnLQ/SDVTHK3AdSdjtrK8amrMn2', NULL, 2, 1, '158', '2025-02-08 15:25:36', '2025-02-08 15:29:50');
