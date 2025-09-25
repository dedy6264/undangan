1. pada invitation, buatkan buttonn send invitation by invitation id untuk kirim melakukan kirim undangan ke whatsapp dengan spesifikasi seperti berikut
request:
{
	"target":"",//no telepon guest
	"message":""//link untuk mengakses undangan reference ke invitation
}
url:https://api.fonnte.com/send
token: LyfkJ2o1LA8wER8RiMBe
jika sukses merikan notif atau alert sukses
2. buat api untuk open invitasi by invitation id untuk menampilkan undangan digital, untuk template sudah ada di wedding-dashboard/resource/view/invitation_layout

1. Struktur database:
-- =========================
-- Clients (pemilik akun)
-- =========================
CREATE TABLE clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_name VARCHAR(100) NOT NULL,
    address VARCHAR(100),
    nik VARCHAR(50),
    phone VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =========================
-- Couples (pasangan yang diundang)
-- =========================
CREATE TABLE couples (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    groom_name VARCHAR(100) NOT NULL,
    bride_name VARCHAR(100) NOT NULL,
    wedding_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
);

-- =========================
-- Persons (detail mempelai)
-- =========================
CREATE TABLE persons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    couple_id INT NOT NULL,
    role ENUM('groom','bride') NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    image_url VARCHAR(255),
    additional_info TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE
);

-- =========================
-- Person Parents (orang tua mempelai)
-- =========================
CREATE TABLE person_parents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    person_id INT NOT NULL,
    father_name VARCHAR(100),
    father_status ENUM('alive','deceased') DEFAULT 'alive',
    mother_name VARCHAR(100),
    mother_status ENUM('alive','deceased') DEFAULT 'alive',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (person_id) REFERENCES persons(id) ON DELETE CASCADE
);

-- =========================
-- Wedding Events (acara)
-- =========================
CREATE TABLE wedding_events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    couple_id INT NOT NULL,
    event_name VARCHAR(100) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME,
    end_time TIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE
);

-- =========================
-- Locations
-- =========================
CREATE TABLE locations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    wedding_event_id INT NOT NULL,
    venue_name VARCHAR(150) NOT NULL,
    address TEXT NOT NULL,
    map_embed_url TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (wedding_event_id) REFERENCES wedding_events(id) ON DELETE CASCADE
);

-- =========================
-- Gallery Images
-- =========================
CREATE TABLE gallery_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    wedding_event_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    thumbnail_url VARCHAR(255),
    description TEXT,
    sort_order INT DEFAULT 0,
    is_background VARCHAR(1) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (wedding_event_id) REFERENCES wedding_events(id) ON DELETE CASCADE
);

-- =========================
-- Timeline Events (cerita perjalanan)
-- =========================
CREATE TABLE timeline_events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    couple_id INT NOT NULL,
    title VARCHAR(100),
    event_date DATE,
    description TEXT,
    image_url VARCHAR(255),
    sort_order INT DEFAULT 0,
    is_inverted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE
);

-- =========================
-- Bank Accounts (rekening hadiah)
-- =========================
CREATE TABLE bank_accounts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    wedding_event_id INT NOT NULL,
    bank_name VARCHAR(100) NOT NULL,
    account_number VARCHAR(50) NOT NULL,
    account_holder_name VARCHAR(100) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (wedding_event_id) REFERENCES wedding_events(id) ON DELETE CASCADE
);

-- =========================
-- Guests
-- =========================
CREATE TABLE guests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =========================
-- Invitations
-- =========================
CREATE TABLE invitations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    guest_id INT NOT NULL,
    wedding_event_id INT NOT NULL,
    invitation_code VARCHAR(50) UNIQUE NOT NULL,
    is_attending BOOLEAN DEFAULT NULL,
    responded_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (guest_id) REFERENCES guests(id) ON DELETE CASCADE,
    FOREIGN KEY (wedding_event_id) REFERENCES wedding_events(id) ON DELETE CASCADE
);

-- =========================
-- QR Codes
-- =========================
CREATE TABLE qr_codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    invitation_id INT NOT NULL,
    qr_data TEXT NOT NULL,
    qr_image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (invitation_id) REFERENCES invitations(id) ON DELETE CASCADE
);

-- =========================
-- Guest Messages (ucapan tamu)
-- =========================
CREATE TABLE guest_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    guest_id INT NOT NULL,
    wedding_event_id INT NOT NULL,
    guest_name VARCHAR(100),
    message TEXT NOT NULL,
    is_approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (guest_id) REFERENCES guests(id) ON DELETE CASCADE,
    FOREIGN KEY (wedding_event_id) REFERENCES wedding_events(id) ON DELETE CASCADE
);

-- =========================
-- Packages (jenis paket)
-- =========================
CREATE TABLE packages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(12,2) NOT NULL,
    duration_days INT NOT NULL, -- masa aktif dalam hari
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =========================
-- Transactions (pemesanan)
-- =========================
CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    couple_id INT NOT NULL,
    package_id INT NOT NULL,
    reference_no VARCHAR(13) NOT NULL UNIQUE,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'pending', -- pending, paid, expired, cancelled
    total_amount DECIMAL(12,2) NOT NULL,
    paid_at TIMESTAMP NULL,
    expired_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
    FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE CASCADE
);

-- =========================
-- Payment Methods (metode pembayaran)
-- =========================
CREATE TABLE payment_methods (
    id INT PRIMARY KEY AUTO_INCREMENT,
    payment_method_name VARCHAR(100) NOT NULL, -- e.g. bank_transfer, gopay, credit_card
    description TEXT,
    provider_admin_fee DECIMAL(12,2) DEFAULT 0.00,   -- biaya dari provider ke admin
    provider_merchant_fee DECIMAL(12,2) DEFAULT 0.00,-- biaya dari provider ke merchant
    admin_fee DECIMAL(12,2) DEFAULT 0.00,            -- biaya admin internal
    merchant_fee DECIMAL(12,2) DEFAULT 0.00,         -- biaya merchant internal
    m_key VARCHAR(255),                              -- API/merchant key
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =========================
-- Payment Transactions (riwayat pembayaran)
-- =========================
CREATE TABLE payment_transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    transaction_id INT NOT NULL,
    payment_method_id INT NOT NULL,
    payment_method_name VARCHAR(50),                 -- duplikasi untuk log cepat
    provider_admin_fee DECIMAL(12,2) DEFAULT 0.00,
    provider_merchant_fee DECIMAL(12,2) DEFAULT 0.00,
    admin_fee DECIMAL(12,2) DEFAULT 0.00,
    merchant_fee DECIMAL(12,2) DEFAULT 0.00,
    status_code VARCHAR(20),                         -- kode dari payment gateway
    status_message VARCHAR(200),                     -- pesan dari payment gateway
    payment_other_reff VARCHAR(200),                 -- reference dari provider (VA, trx id, dsb)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id) ON DELETE CASCADE
);
