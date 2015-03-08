/**
 * @package marlag/codeigniter
 * @author Marcin L. <marlag@fr.pl>
 * @license MIT
 * @based On table schema for sessions (codeigniter) and tank_auth library
 */

-- -----------------------------------------------------
-- Schema security
-- -----------------------------------------------------

CREATE SCHEMA security;

-- -----------------------------------------------------
-- Table security.users
-- -----------------------------------------------------
CREATE TABLE security.users (
    id                      SERIAL PRIMARY KEY,
    username                varchar(50) NOT NULL,
    password                varchar(255) NOT NULL,
    email                   varchar(100) NOT NULL,
    role                    varchar(8) NOT NULL,
    activated               smallint NOT NULL DEFAULT '1',
    banned                  smallint NOT NULL DEFAULT '0',
    ban_reason              varchar(255) DEFAULT NULL,
    new_password_key        varchar(50) DEFAULT NULL,
    new_password_requested  timestamp DEFAULT NULL,
    new_email               varchar(100) DEFAULT NULL,
    new_email_key           varchar(50) DEFAULT NULL,
    last_ip                 varchar(40) NOT NULL,
    last_login              timestamp,
    created                 timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified                timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table security.sessions
-- -----------------------------------------------------
CREATE TABLE security.sessions (
    id          varchar(40) PRIMARY KEY,
    ip_address  varchar(45) NOT NULL,
    timestamp   bigint DEFAULT 0 NOT NULL,
    data text   DEFAULT '' NOT NULL
);

CREATE INDEX security_sessions_timestamp ON security.sessions( timestamp);

-- -----------------------------------------------------
-- Table security.login_attempts
-- -----------------------------------------------------
CREATE TABLE security.login_attempts (
    id          SERIAL PRIMARY KEY,
    ip_address  varchar(40) NOT NULL,
    login       varchar(50) NOT NULL,
    time        timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- Table security.user_autologin
-- -----------------------------------------------------
CREATE TABLE security.user_autologin (
    key_id      char(32) NOT NULL,
    user_id     INTEGER NOT NULL,
    user_agent  varchar(150),
    last_ip     varchar(40) NOT NULL,
    last_login  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (key_id, user_id),
    FOREIGN KEY (user_id) REFERENCES security.users(id)
);
-- --------------------------------------------------------
--
-- Table structure for table user_profiles
--
CREATE TABLE IF NOT EXISTS security.user_profiles (
    id          SERIAL PRIMARY KEY,
    user_id     INTEGER NOT NULL,
    country     varchar(20) DEFAULT NULL,
    website     varchar(255) DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES security.users(id)
);

