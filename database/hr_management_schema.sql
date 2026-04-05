-- ============================================================
-- HR MANAGEMENT SYSTEM — FULL DATABASE SCHEMA
-- Updated: Added created_by / updated_by on ALL tables
--          client_locations expanded with GPS + Radius + Work Hours
-- Database: MySQL / MariaDB  |  Charset: utf8mb4
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET NAMES utf8mb4;

-- ============================================================
-- 1. USERS (Auth & System Access)
-- ============================================================

-- ============================================================
-- 2. DIVISIONS / DEPARTMENTS
-- ============================================================
CREATE TABLE `divisions` (
  `id`                CHAR(36) NOT NULL,
  `division_code`     VARCHAR(20) NOT NULL COMMENT 'e.g. ENG, MRK, FIN',
  `name`              VARCHAR(100) NOT NULL,
  `parent_id`         CHAR(36) NULL DEFAULT NULL,
  `head_employee_id`  CHAR(36) NULL DEFAULT NULL,
  `head_title`        VARCHAR(100) NULL DEFAULT NULL,
  `cost_center`       VARCHAR(50) NULL DEFAULT NULL,
  `description`       TEXT NULL DEFAULT NULL,
  `billing_type`      ENUM('internal','billable') NOT NULL DEFAULT 'internal',
  `max_headcount`     SMALLINT UNSIGNED NULL DEFAULT NULL,
  `is_active`         TINYINT(1) NOT NULL DEFAULT 1,
  -- Audit
  `created_by`        CHAR(36) NULL DEFAULT NULL,
  `updated_by`        CHAR(36) NULL DEFAULT NULL,
  `created_at`        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `divisions_code_unique` (`division_code`),
  KEY `divisions_parent_id_fk` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 3. EMPLOYEES (Core entity)
-- ============================================================
CREATE TABLE `employees` (
  `id`                      CHAR(36) NOT NULL,
  `user_id`                 CHAR(36) NULL DEFAULT NULL,
  `employee_number`         VARCHAR(20) NOT NULL COMMENT 'e.g. EMP-1025',
  `full_name`               VARCHAR(150) NOT NULL,
  `profile_photo`           VARCHAR(255) NULL DEFAULT NULL,

  -- Position & Record
  `job_title`               VARCHAR(100) NOT NULL,
  `division_id`             CHAR(36) NULL DEFAULT NULL,
  `manager_id`              CHAR(36) NULL DEFAULT NULL,
  `work_email`              VARCHAR(150) NULL DEFAULT NULL,
  `work_location`           VARCHAR(100) NULL DEFAULT NULL,
  `employment_status`       ENUM('active','probation','contract','internship','inactive') NOT NULL DEFAULT 'active',
  `join_date`               DATE NOT NULL,
  `contract_end_date`       DATE NULL DEFAULT NULL,
  `is_remote`               TINYINT(1) NOT NULL DEFAULT 0,

  -- Personal Info
  `gender`                  ENUM('male','female') NULL DEFAULT NULL,
  `religion`                ENUM('Islam','Kristen Protestan','Kristen Katolik','Hindu','Buddha','Konghucu') NULL DEFAULT NULL,
  `place_of_birth`          VARCHAR(100) NULL DEFAULT NULL,
  `date_of_birth`           DATE NULL DEFAULT NULL,
  `marital_status`          ENUM('single','married','divorced','widowed') NULL DEFAULT NULL,
  `dependents_count`        TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `personal_email`          VARCHAR(150) NULL DEFAULT NULL,
  `phone_number`            VARCHAR(20) NULL DEFAULT NULL,
  `ktp_address`             TEXT NULL DEFAULT NULL,
  `domicile_address`        TEXT NULL DEFAULT NULL,
  `last_education`          ENUM('SMA/SMK','D1/D2/D3','S1/D4','S2','S3') NULL DEFAULT NULL,
  `field_of_study`          VARCHAR(100) NULL DEFAULT NULL,
  `blood_type`              ENUM('A','B','AB','O') NULL DEFAULT NULL,
  `nationality`             VARCHAR(50) NOT NULL DEFAULT 'Indonesian',

  -- Audit
  `created_by`              CHAR(36) NULL DEFAULT NULL,
  `updated_by`              CHAR(36) NULL DEFAULT NULL,
  `created_at`              TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`              TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_number_unique` (`employee_number`),
  KEY `employees_user_id_fk` (`user_id`),
  KEY `employees_division_id_fk` (`division_id`),
  KEY `employees_manager_id_fk` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 4. EMPLOYEE OFFICIAL IDs
-- ============================================================
CREATE TABLE `employee_identities` (
  `id`                      CHAR(36) NOT NULL,
  `employee_id`             CHAR(36) NOT NULL,
  `nik_ktp`                 CHAR(16) NULL DEFAULT NULL,
  `npwp`                    VARCHAR(25) NULL DEFAULT NULL,
  `bpjs_ketenagakerjaan`    VARCHAR(30) NULL DEFAULT NULL,
  `bpjs_kesehatan`          VARCHAR(30) NULL DEFAULT NULL,
  `passport_number`         VARCHAR(20) NULL DEFAULT NULL,
  `passport_expiry`         DATE NULL DEFAULT NULL,
  `tax_status_ptkp`         ENUM('TK0','TK1','TK2','TK3','K0','K1','K2','K3','KI0') NULL DEFAULT NULL,
  `tax_method`              ENUM('gross','net','gross_up') NOT NULL DEFAULT 'net',
  `ktp_document_path`       VARCHAR(255) NULL DEFAULT NULL,
  `npwp_document_path`      VARCHAR(255) NULL DEFAULT NULL,
  -- Audit
  `created_by`              CHAR(36) NULL DEFAULT NULL,
  `updated_by`              CHAR(36) NULL DEFAULT NULL,
  `created_at`              TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`              TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_identities_employee_unique` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 5. EMPLOYEE BANK ACCOUNTS
-- ============================================================
CREATE TABLE `employee_bank_accounts` (
  `id`                  CHAR(36) NOT NULL,
  `employee_id`         CHAR(36) NOT NULL,
  `bank_name`           VARCHAR(100) NOT NULL,
  `bank_branch`         VARCHAR(100) NULL DEFAULT NULL,
  `account_number`      VARCHAR(30) NOT NULL,
  `account_holder_name` VARCHAR(150) NOT NULL,
  `is_primary`          TINYINT(1) NOT NULL DEFAULT 1,
  -- Audit
  `created_by`          CHAR(36) NULL DEFAULT NULL,
  `updated_by`          CHAR(36) NULL DEFAULT NULL,
  `created_at`          TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`          TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `employee_bank_employee_fk` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 6. EMERGENCY CONTACTS
-- ============================================================
CREATE TABLE `emergency_contacts` (
  `id`              CHAR(36) NOT NULL,
  `employee_id`     CHAR(36) NOT NULL,
  `contact_name`    VARCHAR(150) NOT NULL,
  `relationship`    VARCHAR(50) NOT NULL,
  `phone_number`    VARCHAR(20) NOT NULL,
  `is_primary`      TINYINT(1) NOT NULL DEFAULT 0,
  `notes`           VARCHAR(255) NULL DEFAULT NULL,
  -- Audit
  `created_by`      CHAR(36) NULL DEFAULT NULL,
  `updated_by`      CHAR(36) NULL DEFAULT NULL,
  `created_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `emergency_contacts_employee_fk` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 7. SALARY STRUCTURES
-- ============================================================
CREATE TABLE `salary_structures` (
  `id`                      CHAR(36) NOT NULL,
  `employee_id`             CHAR(36) NOT NULL,
  `effective_date`          DATE NOT NULL,
  `basic_salary`            BIGINT NOT NULL DEFAULT 0,
  `allowance_position`      BIGINT NOT NULL DEFAULT 0 COMMENT 'Tunjangan Jabatan',
  `allowance_meal`          BIGINT NOT NULL DEFAULT 0 COMMENT 'Tunjangan Makan',
  `allowance_transport`     BIGINT NOT NULL DEFAULT 0 COMMENT 'Tunjangan Transport',
  `allowance_other`         BIGINT NOT NULL DEFAULT 0 COMMENT 'Tunjangan Lainnya',
  `pay_frequency`           ENUM('monthly','bi-weekly','weekly') NOT NULL DEFAULT 'monthly',
  `notes`                   TEXT NULL DEFAULT NULL,
  `is_current`              TINYINT(1) NOT NULL DEFAULT 1,
  -- Audit
  `created_by`              CHAR(36) NULL DEFAULT NULL,
  `updated_by`              CHAR(36) NULL DEFAULT NULL,
  `created_at`              TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`              TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `salary_structures_employee_fk` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 8. PAYROLL SLIPS (Monthly)
-- ============================================================
CREATE TABLE `payrolls` (
  `id`                  CHAR(36) NOT NULL,
  `employee_id`         CHAR(36) NOT NULL,
  `period_year`         SMALLINT UNSIGNED NOT NULL,
  `period_month`        TINYINT UNSIGNED NOT NULL COMMENT '1-12',
  `basic_salary`        BIGINT NOT NULL DEFAULT 0,
  `allowance_total`     BIGINT NOT NULL DEFAULT 0,
  `overtime_pay`        BIGINT NOT NULL DEFAULT 0,
  `bonus`               BIGINT NOT NULL DEFAULT 0,
  `gross_pay`           BIGINT NOT NULL DEFAULT 0,
  `deduction_pph21`     BIGINT NOT NULL DEFAULT 0,
  `deduction_bpjs_kes`  BIGINT NOT NULL DEFAULT 0 COMMENT 'BPJS Kesehatan 1%',
  `deduction_bpjs_jht`  BIGINT NOT NULL DEFAULT 0 COMMENT 'BPJS JHT 2%',
  `deduction_bpjs_jp`   BIGINT NOT NULL DEFAULT 0 COMMENT 'BPJS JP 1%',
  `deduction_other`     BIGINT NOT NULL DEFAULT 0,
  `total_deductions`    BIGINT NOT NULL DEFAULT 0,
  `net_pay`             BIGINT NOT NULL DEFAULT 0 COMMENT 'Take Home Pay',
  `transfer_date`       DATE NULL DEFAULT NULL,
  `status`              ENUM('draft','processed','paid') NOT NULL DEFAULT 'draft',
  `notes`               TEXT NULL DEFAULT NULL,
  -- Audit
  `created_by`          CHAR(36) NULL DEFAULT NULL,
  `updated_by`          CHAR(36) NULL DEFAULT NULL,
  `created_at`          TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`          TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payrolls_employee_period_unique` (`employee_id`, `period_year`, `period_month`),
  KEY `payrolls_employee_fk` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 9. CONTRACTS (PKWT / PKWTT / Internship)
-- ============================================================
CREATE TABLE `contracts` (
  `id`                CHAR(36) NOT NULL,
  `employee_id`       CHAR(36) NOT NULL,
  `contract_type`     ENUM('PKWT','PKWTT','Internship','Probation') NOT NULL,
  `start_date`        DATE NOT NULL,
  `end_date`          DATE NULL DEFAULT NULL COMMENT 'NULL = permanent',
  `status`            ENUM('active','expired','expiring_soon','renewed','terminated') NOT NULL DEFAULT 'active',
  `document_path`     VARCHAR(255) NULL DEFAULT NULL,
  `notes`             TEXT NULL DEFAULT NULL,
  -- Audit
  `created_by`        CHAR(36) NULL DEFAULT NULL,
  `updated_by`        CHAR(36) NULL DEFAULT NULL,
  `created_at`        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `contracts_employee_fk` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 10. ATTENDANCE
-- ============================================================
CREATE TABLE `attendances` (
  `id`              CHAR(36) NOT NULL,
  `employee_id`     CHAR(36) NOT NULL,
  `attendance_date` DATE NOT NULL,
  `clock_in`        TIME NULL DEFAULT NULL,
  `clock_out`       TIME NULL DEFAULT NULL,
  `working_minutes` SMALLINT UNSIGNED NULL DEFAULT NULL,
  `status`          ENUM('on_time','late_in','early_out','absent','leave','holiday','wfh') NOT NULL DEFAULT 'absent',
  `location_note`   VARCHAR(100) NULL DEFAULT NULL,
  `ip_address`      VARCHAR(45) NULL DEFAULT NULL,
  `notes`           VARCHAR(255) NULL DEFAULT NULL,
  -- Audit
  `created_by`      CHAR(36) NULL DEFAULT NULL,
  `updated_by`      CHAR(36) NULL DEFAULT NULL,
  `created_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendances_employee_date_unique` (`employee_id`, `attendance_date`),
  KEY `attendances_employee_fk` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 11. LEAVE BALANCES
-- ============================================================
CREATE TABLE `leave_balances` (
  `id`                  CHAR(36) NOT NULL,
  `employee_id`         CHAR(36) NOT NULL,
  `year`                SMALLINT UNSIGNED NOT NULL,
  `annual_leave_quota`  TINYINT UNSIGNED NOT NULL DEFAULT 12,
  `annual_leave_used`   TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `sick_leave_quota`    TINYINT UNSIGNED NOT NULL DEFAULT 14,
  `sick_leave_used`     TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `unpaid_leave_quota`  TINYINT UNSIGNED NOT NULL DEFAULT 5,
  `unpaid_leave_used`   TINYINT UNSIGNED NOT NULL DEFAULT 0,
  -- Audit
  `created_by`          CHAR(36) NULL DEFAULT NULL,
  `updated_by`          CHAR(36) NULL DEFAULT NULL,
  `created_at`          TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`          TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `leave_balances_employee_year_unique` (`employee_id`, `year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 12. LEAVE REQUESTS
-- ============================================================
CREATE TABLE `leaves` (
  `id`              CHAR(36) NOT NULL,
  `employee_id`     CHAR(36) NOT NULL,
  `leave_type`      ENUM('annual','sick','unpaid','maternity','paternity','special') NOT NULL DEFAULT 'annual',
  `start_date`      DATE NOT NULL,
  `end_date`        DATE NOT NULL,
  `duration_days`   TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `reason`          TEXT NOT NULL,
  `attachment`      VARCHAR(255) NULL DEFAULT NULL,
  `status`          ENUM('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `approved_by`     CHAR(36) NULL DEFAULT NULL,
  `approved_at`     TIMESTAMP NULL DEFAULT NULL,
  `rejection_note`  TEXT NULL DEFAULT NULL,
  -- Audit
  `created_by`      CHAR(36) NULL DEFAULT NULL,
  `updated_by`      CHAR(36) NULL DEFAULT NULL,
  `created_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `leaves_employee_fk` (`employee_id`),
  KEY `leaves_approved_by_fk` (`approved_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 13. OVERTIME
-- ============================================================
CREATE TABLE `overtimes` (
  `id`                CHAR(36) NOT NULL,
  `employee_id`       CHAR(36) NOT NULL,
  `overtime_date`     DATE NOT NULL,
  `start_time`        TIME NOT NULL,
  `end_time`          TIME NOT NULL,
  `duration_minutes`  SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `description`       VARCHAR(255) NULL DEFAULT NULL,
  `overtime_pay`      BIGINT NOT NULL DEFAULT 0,
  `status`            ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by`       CHAR(36) NULL DEFAULT NULL,
  `approved_at`       TIMESTAMP NULL DEFAULT NULL,
  -- Audit
  `created_by`        CHAR(36) NULL DEFAULT NULL,
  `updated_by`        CHAR(36) NULL DEFAULT NULL,
  `created_at`        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `overtimes_employee_fk` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 14. REIMBURSEMENT
-- ============================================================
CREATE TABLE `reimburses` (
  `id`                CHAR(36) NOT NULL,
  `employee_id`       CHAR(36) NOT NULL,
  `reimburse_date`    DATE NOT NULL,
  `category`          VARCHAR(100) NOT NULL,
  `description`       TEXT NOT NULL,
  `amount`            BIGINT NOT NULL,
  `receipt_path`      VARCHAR(255) NULL DEFAULT NULL,
  `status`            ENUM('pending','approved','rejected','paid') NOT NULL DEFAULT 'pending',
  `approved_by`       CHAR(36) NULL DEFAULT NULL,
  `approved_at`       TIMESTAMP NULL DEFAULT NULL,
  `notes`             TEXT NULL DEFAULT NULL,
  -- Audit
  `created_by`        CHAR(36) NULL DEFAULT NULL,
  `updated_by`        CHAR(36) NULL DEFAULT NULL,
  `created_at`        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `reimburses_employee_fk` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 15. PERFORMANCE REVIEWS
-- ============================================================
CREATE TABLE `performances` (
  `id`                    CHAR(36) NOT NULL,
  `employee_id`           CHAR(36) NOT NULL,
  `reviewer_id`           CHAR(36) NULL DEFAULT NULL,
  `review_period_start`   DATE NOT NULL,
  `review_period_end`     DATE NOT NULL,
  `kpi_score`             DECIMAL(5,2) NULL DEFAULT NULL,
  `attitude_score`        DECIMAL(5,2) NULL DEFAULT NULL,
  `skills_score`          DECIMAL(5,2) NULL DEFAULT NULL,
  `overall_score`         DECIMAL(5,2) NULL DEFAULT NULL,
  `rating_label`          ENUM('Excellent','Good','Average','Below Average','Poor') NULL DEFAULT NULL,
  `strengths`             TEXT NULL DEFAULT NULL,
  `improvements`          TEXT NULL DEFAULT NULL,
  `notes`                 TEXT NULL DEFAULT NULL,
  `status`                ENUM('draft','submitted','acknowledged') NOT NULL DEFAULT 'draft',
  -- Audit
  `created_by`            CHAR(36) NULL DEFAULT NULL,
  `updated_by`            CHAR(36) NULL DEFAULT NULL,
  `created_at`            TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`            TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `performances_employee_fk` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 16. CLIENT LOCATIONS  ★ DIPERLUAS — semua field dari form
--     "Tambah Lokasi Klien" termasuk GPS Maps, Radius, Work Hours
-- ============================================================
--
--  MAPPING FORM → DATABASE COLUMN:
--
--  [Identitas Klien]
--  Nama Perusahaan / Klien   → client_name
--  Kode Klien                → client_code
--  Industri                  → industry
--  Nama PIC Klien            → pic_name
--  No. Telp PIC              → pic_phone
--  Email PIC                 → pic_email
--  Status Aktif (toggle)     → is_active
--
--  [Alamat Lokasi]
--  Nama Gedung / Lokasi      → building_name
--  Alamat Lengkap            → address
--  Kota                      → city
--  Provinsi                  → province
--  Kode Pos                  → postal_code
--  Lantai / Unit             → floor_unit
--
--  [GPS Maps — Koordinat & Radius Absensi]
--  Latitude (dari klik peta) → latitude        ← inilah yang disimpan dari MAPS
--  Longitude (dari klik peta)→ longitude       ← inilah yang disimpan dari MAPS
--  Radius slider (meter)     → attendance_radius_meter
--
--  [Jam Kerja Lokasi]
--  Jam Masuk                 → work_start_time
--  Jam Pulang                → work_end_time
--  Hari Kerja (checkbox)     → work_days       ← disimpan sebagai JSON/string
--  Catatan Tambahan          → notes
-- ============================================================
CREATE TABLE `client_locations` (
  `id`                       CHAR(36) NOT NULL,

  -- Identitas Klien
  `client_name`              VARCHAR(150) NOT NULL COMMENT 'Nama perusahaan / klien',
  `client_code`              VARCHAR(20) NULL DEFAULT NULL  COMMENT 'e.g. CNBC-01',
  `industry`                 VARCHAR(100) NULL DEFAULT NULL COMMENT 'e.g. Perbankan & Keuangan',

  -- PIC Klien
  `pic_name`                 VARCHAR(100) NULL DEFAULT NULL COMMENT 'Nama penanggung jawab',
  `pic_phone`                VARCHAR(20) NULL DEFAULT NULL,
  `pic_email`                VARCHAR(150) NULL DEFAULT NULL,

  -- Alamat Lokasi
  `building_name`            VARCHAR(150) NULL DEFAULT NULL COMMENT 'Nama gedung / lokasi',
  `address`                  TEXT NOT NULL COMMENT 'Alamat lengkap: jalan, kelurahan, kecamatan',
  `city`                     VARCHAR(100) NULL DEFAULT NULL COMMENT 'Kota, e.g. Jakarta Pusat',
  `province`                 VARCHAR(100) NULL DEFAULT NULL COMMENT 'e.g. DKI Jakarta',
  `postal_code`              CHAR(5) NULL DEFAULT NULL,
  `floor_unit`               VARCHAR(50) NULL DEFAULT NULL COMMENT 'e.g. Lt. 5, Unit B',

  -- ★ GPS / Maps — field yang diisi dan disimpan dari peta Leaflet
  `latitude`                 DECIMAL(10,6) NULL DEFAULT NULL COMMENT 'Titik GPS latitude dari klik peta',
  `longitude`                DECIMAL(10,6) NULL DEFAULT NULL COMMENT 'Titik GPS longitude dari klik peta',
  `attendance_radius_meter`  SMALLINT UNSIGNED NOT NULL DEFAULT 100 COMMENT 'Radius absensi (slider 50–500 m)',

  -- Jam Kerja Lokasi
  `work_start_time`          TIME NULL DEFAULT NULL COMMENT 'Jam Masuk, e.g. 08:00',
  `work_end_time`            TIME NULL DEFAULT NULL COMMENT 'Jam Pulang, e.g. 17:00',
  `work_days`                VARCHAR(50) NULL DEFAULT NULL COMMENT 'Hari kerja, e.g. Mon,Tue,Wed,Thu,Fri',

  -- Meta
  `is_active`                TINYINT(1) NOT NULL DEFAULT 1,
  `notes`                    TEXT NULL DEFAULT NULL COMMENT 'Dress code, akses parkir, prosedur khusus',

  -- Audit
  `created_by`               CHAR(36) NULL DEFAULT NULL,
  `updated_by`               CHAR(36) NULL DEFAULT NULL,
  `created_at`               TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`               TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (`id`),
  UNIQUE KEY `client_locations_code_unique` (`client_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 17. PLACEMENTS / ASSIGNMENTS
-- ============================================================
CREATE TABLE `placements` (
  `id`                    CHAR(36) NOT NULL,
  `employee_id`           CHAR(36) NOT NULL,
  `client_location_id`    CHAR(36) NOT NULL,
  `sk_number`             VARCHAR(50) NULL DEFAULT NULL COMMENT 'Surat Keputusan No.',
  `position_at_client`    VARCHAR(100) NOT NULL,
  `start_date`            DATE NOT NULL,
  `end_date`              DATE NULL DEFAULT NULL,
  `placement_type`        ENUM('new_placement','mutation','extension','withdrawal') NOT NULL DEFAULT 'new_placement',
  `status`                ENUM('active','pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `notes`                 TEXT NULL DEFAULT NULL,
  -- Audit
  `created_by`            CHAR(36) NULL DEFAULT NULL,
  `updated_by`            CHAR(36) NULL DEFAULT NULL,
  `created_at`            TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`            TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `placements_employee_fk` (`employee_id`),
  KEY `placements_client_location_fk` (`client_location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 18. EMPLOYEE PROFILES (Bio / extended info)
-- ============================================================
CREATE TABLE `profiles` (
  `id`            CHAR(36) NOT NULL,
  `employee_id`   CHAR(36) NOT NULL,
  `bio`           TEXT NULL DEFAULT NULL,
  `linkedin_url`  VARCHAR(255) NULL DEFAULT NULL,
  `skills`        TEXT NULL DEFAULT NULL,
  `languages`     VARCHAR(255) NULL DEFAULT NULL,
  -- Audit
  `created_by`    CHAR(36) NULL DEFAULT NULL,
  `updated_by`    CHAR(36) NULL DEFAULT NULL,
  `created_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `profiles_employee_unique` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 19. ACTIVITY LOG / AUDIT TRAIL
-- ============================================================
CREATE TABLE `activity_logs` (
  `id`            CHAR(36) NOT NULL,
  `user_id`       CHAR(36) NULL DEFAULT NULL,
  `action`        VARCHAR(100) NOT NULL COMMENT 'e.g. employee.update, leave.approve',
  `model_type`    VARCHAR(100) NULL DEFAULT NULL,
  `model_id`      CHAR(36) NULL DEFAULT NULL,
  `description`   TEXT NULL DEFAULT NULL,
  `ip_address`    VARCHAR(45) NULL DEFAULT NULL,
  `user_agent`    VARCHAR(255) NULL DEFAULT NULL,
  `created_at`    TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_fk` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- RE-ENABLE FK CHECK
-- ============================================================
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- SAMPLE SEED DATA
-- ============================================================

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_by`, `updated_by`) VALUES
('45048f8c-531d-48ca-822c-54003cca6544', 'Admin HRistopher', 'admin@hrmanagement.com', '$2y$12$placeholder', 'admin', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('6dfbc3a2-95c0-407c-b7eb-24e9a6624bd1', 'Sarah Williams',   'sarah.williams@company.com', '$2y$12$placeholder', 'employee', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('61527aa2-f4d9-4c09-8d50-f2a6696ea6ec', 'Michael Chen',     'michael.chen@company.com',   '$2y$12$placeholder', 'manager', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544');

INSERT INTO `divisions` (`id`, `division_code`, `name`, `description`, `is_active`, `created_by`, `updated_by`) VALUES
('a4a32fd8-a840-4bb8-b9d9-6ea6c70e1070', 'ENG',  'Engineering & Tech',    'Software development and technical infrastructure', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('b2b3c4d5-e6f7-8901-2345-6789abcdef', 'MRK',  'Marketing',             'Brand, content, and growth marketing', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('c3d4e5f6-7890-1234-5678-90abcdef12', 'FIN',  'Finance & Accounting',  'Financial management and reporting', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('d4e5f6a7-8901-2345-6789-0abcdef123', 'HR',   'Human Resources',       'People operations and talent management', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('e5f6a7b8-9012-3456-7890-abcdef1234', 'SLS',  'Sales',                 'B2B and B2C sales operations', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('f6a7b8c9-0123-4567-8901-bcdef12345', 'OPS',  'Operations',            'General operations and logistics', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('d5eb519c-8d07-4a7a-a482-42c290be35f4', 'LGL',  'Legal & Compliance',    'Legal counsel and regulatory compliance', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('e6f7a8b9-0123-4567-8901-cdef123456', 'SPT',  'Customer Support',      'Customer success and support', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544');

INSERT INTO `employees` (`id`, `user_id`, `employee_number`, `full_name`, `job_title`, `division_id`, `employment_status`, `join_date`, `gender`, `phone_number`, `nationality`, `created_by`, `updated_by`) VALUES
('b13cffb1-a1c5-427a-a2c2-3c73edc03da5', '6dfbc3a2-95c0-407c-b7eb-24e9a6624bd1', 'EMP-1025', 'Sarah Williams',   'Senior Frontend Developer', 'a4a32fd8-a840-4bb8-b9d9-6ea6c70e1070', 'active',     '2020-01-15', 'female', '081201234567', 'Indonesian', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('d6d8d8dd-dcf8-45d8-8371-338ff31e9166', '61527aa2-f4d9-4c09-8d50-f2a6696ea6ec', 'EMP-0842', 'Michael Chen',     'Marketing Director',        'b2b3c4d5-e6f7-8901-2345-6789abcdef', 'active',     '2019-03-01', 'male',   '081299887766', 'Indonesian', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('f362cc1a-15a8-4f95-b5a8-3588eba8d801', NULL, 'EMP-0512', 'Budi Santoso',  'Sales Manager',             5, 'active',     '2019-03-01', 'male',   '082145678901', 'Indonesian', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('8c4b25ea-e166-4490-88a8-25f0dfd1a2fe', NULL, 'EMP-0398', 'Lisa Keuangan', 'Finance Lead',              3, 'active',     '2018-02-20', 'female', '085156789012', 'Indonesian', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('6be2768b-ee39-410f-88a9-5b4286ef7319', NULL, 'EMP-0756', 'Ahmad Fauzi',   'Backend Developer',         1, 'active',     '2022-09-15', 'male',   '081312345678', 'Indonesian', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('b1a9a99d-a0a7-4a4d-b856-0e0903e16c17', NULL, 'EMP-0890', 'Rina Wati',     'UI/UX Designer',            1, 'contract',   '2025-07-01', 'female', '087823456789', 'Indonesian', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('0b25e43e-9fde-4609-87d1-b7f12a315022', NULL, 'EMP-0245', 'Dewi Legalitas','Legal Counsel',             7, 'active',     '2017-08-10', 'female', '081934567890', 'Indonesian', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('ebbe09d2-06bf-43ea-809a-15e6abd68f10', NULL, 'EMP-0901', 'Siti Layanan',  'Customer Success Lead',     8, 'active',     '2021-06-05', 'female', '089045678901', 'Indonesian', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('e30c7e7a-44a4-4e2a-aafb-b4052e02ba49', NULL, 'EMP-0634', 'Hendra Gunawan','Project Manager',           1, 'contract',   '2025-11-01', 'male',   '082156789012', 'Indonesian', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('a629ae82-9912-4576-b1f9-0b4492f757fb',NULL, 'EMP-0950', 'Putri Ayu',     'Data Analyst',              1, 'internship', '2026-02-15', 'female', '083267890123', 'Indonesian', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544');

INSERT INTO `contracts` (`id`,`employee_id`, `contract_type`, `start_date`, `end_date`, `status`, `created_by`, `updated_by`) VALUES
('1e718936-aa43-40a2-a2fc-6c54d04747de', 'b13cffb1-a1c5-427a-a2c2-3c73edc03da5', 'PKWTT',      '2020-01-15', NULL,         'active', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('a2c31068-c668-4964-b940-289626d30cef', '6dfbc3a2-95c0-407c-b7eb-24e9a6624bd1', 'PKWTT',      '2019-03-01', NULL,         'active', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('777e3c9d-8f8d-403d-bb9e-451e68ed9fd8', '61527aa2-f4d9-4c09-8d50-f2a6696ea6ec', 'PKWTT',      '2019-03-01', NULL,         'active', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('1f750948-6670-4303-8f5a-9af1b2d27ad4', 'f362cc1a-15a8-4f95-b5a8-3588eba8d801', 'PKWTT',      '2018-02-20', NULL,         'active', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('79639912-4843-43fe-85c8-1c7d7e3d5c67', '6be2768b-ee39-410f-88a9-5b4286ef7319', 'PKWT',       '2025-09-15', '2026-09-14', 'active', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('2943d527-9338-452a-b0c5-92d40d7f5305', 'b1a9a99d-a0a7-4a4d-b856-0e0903e16c17', 'PKWT',       '2025-07-01', '2027-06-30', 'active', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('31c42230-0e4c-4fa2-a595-54f40cf593c6', 'e30c7e7a-44a4-4e2a-aafb-b4052e02ba49', 'PKWT',       '2025-11-01', '2026-10-31', 'active', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
('b71c81ad-8e15-4fb1-b8a1-f6ccb3e8c78e', 'a629ae82-9912-4576-b1f9-0b4492f757fb', 'Internship', '2026-02-15', '2026-08-14', 'active', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544');

INSERT INTO `leave_balances` (`id`, `employee_id`, `year`, `annual_leave_quota`, `annual_leave_used`, `sick_leave_quota`, `sick_leave_used`, `unpaid_leave_quota`, `unpaid_leave_used`, `created_by`, `updated_by`) VALUES
(UUID(), 'b13cffb1-a1c5-427a-a2c2-3c73edc03da5', 2026, 12, 4, 14, 0, 5, 0, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
(UUID(), '6dfbc3a2-95c0-407c-b7eb-24e9a6624bd1', 2026, 12, 2, 14, 0, 5, 0, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
(UUID(), '61527aa2-f4d9-4c09-8d50-f2a6696ea6ec', 2026, 12, 0, 14, 0, 5, 0, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544');

-- ★ Client Locations termasuk koordinat GPS dari peta
INSERT INTO `client_locations`
  (`id`, `client_name`, `client_code`, `industry`, `pic_name`, `building_name`, `address`, `city`, `province`,
   `latitude`, `longitude`, `attendance_radius_meter`, `work_start_time`, `work_end_time`, `work_days`, `is_active`, `created_by`, `updated_by`)
VALUES
('eaaf1077-fdb2-4dd3-ba5f-639e49f9866a', 'CNBC Indonesia',   'CNBC-01', 'Media & Broadcasting',  'Andi Wijaya', 'Gedung Trans Media',
   'Jl. Kebon Sirih No. 17-19, Gambir', 'Jakarta Pusat', 'DKI Jakarta',
   -6.186486, 106.830010, 100, '08:00', '17:00', 'Mon,Tue,Wed,Thu,Fri', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),

('7fe2ebfc-1d90-4e07-9603-572e4bd8becd', 'Bank Mandiri',     'MNDRI-01', 'Perbankan & Keuangan', 'Reni Kusuma', 'Plaza Mandiri',
   'Jl. Jend. Gatot Subroto Kav. 36-38', 'Jakarta Selatan', 'DKI Jakarta',
   -6.229770, 106.821520, 150, '08:00', '17:00', 'Mon,Tue,Wed,Thu,Fri', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),

('e53e61c7-2f09-4ee6-b85e-5a3e7fead8bc', 'BRI',              'BRI-01',   'Perbankan & Keuangan', 'Hasan Nawawi', 'Gedung BRI 1',
   'Jl. Jend. Sudirman Kav. 44-46',    'Jakarta Pusat', 'DKI Jakarta',
   -6.208760, 106.818680, 100, '08:00', '17:00', 'Mon,Tue,Wed,Thu,Fri', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),

('45048f8c-531d-48ca-822c-54003cca6544', 'Kompas Gramedia', 'KG-01',    'Media & Penerbitan',   'Sari Dewi',   'Gedung Kompas Gramedia',
   'Jl. Palmerah Selatan No. 22-28',   'Jakarta Barat', 'DKI Jakarta',
   -6.205360, 106.793210, 100, '08:00', '17:00', 'Mon,Tue,Wed,Thu,Fri', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),

('3a0983b5-f2b9-4b4d-b719-a49e7be1f4e5', 'Telkom Indonesia', 'TLKM-01', 'Telekomunikasi',       'Bima Sakti',  'Gedung Telkom',
   'Jl. Gatot Subroto No. 52',         'Jakarta Selatan', 'DKI Jakarta',
   -6.235410, 106.827190, 200, '08:00', '17:00', 'Mon,Tue,Wed,Thu,Fri', 1, '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544');

INSERT INTO `placements`
  (`id`, `employee_id`, `client_location_id`, `sk_number`, `position_at_client`, `start_date`, `end_date`, `placement_type`, `status`, `created_by`, `updated_by`)
VALUES
(UUID(), 'b13cffb1-a1c5-427a-a2c2-3c73edc03da5', 'eaaf1077-fdb2-4dd3-ba5f-639e49f9866a', 'SK/HR/04-2026/012', 'Video Editor',       '2026-04-01', '2027-03-31', 'new_placement', 'active', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544'),
(UUID(), '6dfbc3a2-95c0-407c-b7eb-24e9a6624bd1', '7fe2ebfc-1d90-4e07-9603-572e4bd8becd', 'SK/HR/03-2026/008', 'IT Support Analyst', '2026-03-15', '2027-03-14', 'mutation',       'active', '45048f8c-531d-48ca-822c-54003cca6544', '45048f8c-531d-48ca-822c-54003cca6544');
