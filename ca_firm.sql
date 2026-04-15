-- ============================================================
-- CA Firm CRM — Database Schema
-- ============================================================

CREATE DATABASE IF NOT EXISTS ca_firm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ca_firm;

-- ── Admins ──────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS admins (
    id         INT UNSIGNED     NOT NULL AUTO_INCREMENT,
    name       VARCHAR(255)     NOT NULL,
    email      VARCHAR(255)     NOT NULL UNIQUE,
    password   VARCHAR(255)     NOT NULL,
    created_at TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Inquiries ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS inquiries (
    id          INT UNSIGNED                            NOT NULL AUTO_INCREMENT,
    full_name   VARCHAR(255)                            NOT NULL,
    email       VARCHAR(255)                            NOT NULL,
    mobile      VARCHAR(20)                             NOT NULL,
    city        VARCHAR(100)                            NOT NULL,
    service     VARCHAR(255)                            NOT NULL,
    message     TEXT                                    NOT NULL,
    status      ENUM('new', 'contacted', 'closed')      NOT NULL DEFAULT 'new',
    created_at  TIMESTAMP                               NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Seed Admin ───────────────────────────────────────────────
-- Email:    admin@cafirm.com
-- Password: Admin@123  (bcrypt, cost 10)
INSERT INTO admins (name, email, password) VALUES
(
    'Super Admin',
    'admin@cafirm.com',
    '$2y$10$eD4ZlLk5.JIErhW.iKQ3bO5Nb.2X5cR0aGLuixCqrQNTyKFmLK.eC'
)
ON DUPLICATE KEY UPDATE id = id;
