# Database Design for Wedding Invitation Website

## Overview
This document outlines the database design for a wedding invitation website containing information about clients, couples, event details, gallery, stories, and guest interactions.

## Entity Relationship Diagram (ERD)
```
[Client] 1----* [Couple]
[Couple] 1----* [Person]
[Person] 1----1 [PersonParent]
[Couple] 1----* [WeddingEvent]
[WeddingEvent] 1----* [GalleryImage]
[WeddingEvent] 1----1 [Location]
[Couple] 1----* [TimelineEvent]
[WeddingEvent] 1----* [BankAccount]
[WeddingEvent] 1----* [GuestMessage]
[Guest] 1----* [Invitation]
[Invitation] 1----1 [QRCode]
[Couple] 1----* [Transaction]
[Transaction] 1----1 [Package]
[Transaction] 1----* [PaymentTransaction]
[PaymentTransaction] 1----1 [PaymentMethod]
[WeddingEvent] 1----* [Invitation]
[Guest] 1----* [GuestMessage]
```

## Tables Schema

### 1. Clients Table
Stores information about account owners (clients).

```sql
CREATE TABLE clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_name VARCHAR(100) NOT NULL,
    address VARCHAR(100),
    nik VARCHAR(50),
    phone VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 2. Couples Table
Stores information about the wedding couple.

```sql
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
```

### 3. Persons Table
Stores detailed information about each person (groom and bride).

```sql
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
```

### 4. Person Parents Table
Stores information about the parents of each person.

```sql
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
```

### 5. Wedding Events Table
Stores information about the wedding event.

```sql
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
```

### 6. Locations Table
Stores location information for wedding events.

```sql
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
```

### 7. Gallery Images Table
Stores gallery images for the wedding.

```sql
CREATE TABLE gallery_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    wedding_event_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    thumbnail_url VARCHAR(255),
    description TEXT,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (wedding_event_id) REFERENCES wedding_events(id) ON DELETE CASCADE
);
```

### 8. Timeline Events Table
Stores timeline events for the couple's story.

```sql
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
```

### 9. Bank Accounts Table
Stores bank account information for wedding gifts.

```sql
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
```

### 10. Guests Table
Stores information about invited guests.

```sql
CREATE TABLE guests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 11. Invitations Table
Stores invitation information for guests.

```sql
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
```

### 12. QR Codes Table
Stores QR code information for invitations.

```sql
CREATE TABLE qr_codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    invitation_id INT NOT NULL,
    qr_data TEXT NOT NULL,
    qr_image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (invitation_id) REFERENCES invitations(id) ON DELETE CASCADE
);
```

### 13. Guest Messages Table
Stores messages and wishes from guests.

```sql
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
```

### 14. Packages Table
Stores information about different wedding packages.

```sql
CREATE TABLE packages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(12,2) NOT NULL,
    duration_days INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 15. Transactions Table
Stores transaction information for package bookings.

```sql
CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    couple_id INT NOT NULL,
    package_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'pending',
    total_amount DECIMAL(12,2) NOT NULL,
    paid_at TIMESTAMP NULL,
    expired_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
    FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE CASCADE
);
```

### 16. Payment Methods Table
Stores information about available payment methods.

```sql
CREATE TABLE payment_methods (
    id INT PRIMARY KEY AUTO_INCREMENT,
    payment_method_name VARCHAR(100) NOT NULL,
    description TEXT,
    provider_admin_fee DECIMAL(12,2) DEFAULT 0.00,
    provider_merchant_fee DECIMAL(12,2) DEFAULT 0.00,
    admin_fee DECIMAL(12,2) DEFAULT 0.00,
    merchant_fee DECIMAL(12,2) DEFAULT 0.00,
    m_key VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 17. Payment Transactions Table
Stores payment transaction history.

```sql
CREATE TABLE payment_transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    transaction_id INT NOT NULL,
    payment_method_id INT NOT NULL,
    payment_method_name VARCHAR(50),
    provider_admin_fee DECIMAL(12,2) DEFAULT 0.00,
    provider_merchant_fee DECIMAL(12,2) DEFAULT 0.00,
    admin_fee DECIMAL(12,2) DEFAULT 0.00,
    merchant_fee DECIMAL(12,2) DEFAULT 0.00,
    status_code VARCHAR(20),
    status_message VARCHAR(200),
    payment_other_reff VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id) ON DELETE CASCADE
);
```

## Relationships Summary

1. **Clients** - Account owners who can manage multiple weddings
2. **Couples** - Central entity representing the wedding couple, linked to a client
3. **Persons** - Detailed information about the bride and groom
4. **Person Parents** - Parent information for each person
5. **Wedding Events** - Different events related to the wedding (main ceremony, reception, etc.)
6. **Locations** - Venues for wedding events
7. **Gallery Images** - Photos from the wedding
8. **Timeline Events** - Story timeline of the couple
9. **Bank Accounts** - Accounts for wedding gifts
10. **Guests** - People invited to the wedding
11. **Invitations** - Specific invitations sent to guests
12. **QR Codes** - QR codes for invitations
13. **Guest Messages** - Messages from guests
14. **Packages** - Available wedding packages
15. **Transactions** - Package bookings by couples
16. **Payment Methods** - Available payment methods
17. **Payment Transactions** - History of payment transactions

This updated database design supports all features of the wedding invitation website with proper relationships between entities and includes additional functionality for package management and payment processing.