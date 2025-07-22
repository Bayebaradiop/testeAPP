1. Crée la table users
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    numerocarteidentite VARCHAR(50)  NULL UNIQUE,
    photorecto VARCHAR(255),
    photoverso VARCHAR(255),
    adresse TEXT,
    typeuser VARCHAR(20) NOT NULL CHECK (typeuser IN ('client', 'service_commercial')) 
);

CREATE TABLE compte (
    id SERIAL PRIMARY KEY,
    numero VARCHAR(20) NOT NULL UNIQUE,
    datecreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    solde DECIMAL(15, 2) DEFAULT 0.00,
    numerotel VARCHAR(20) NOT NULL,
    typecompte VARCHAR(20) NOT NULL CHECK (typecompte IN ('principal', 'secondaire')), 
    userid INTEGER NOT NULL,
    FOREIGN KEY (userid) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE transaction (
    id SERIAL PRIMARY KEY,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    typetransaction VARCHAR(20) NOT NULL CHECK (typetransaction IN ('depot', 'retrait', 'paiement')), 
    montant DECIMAL(15, 2) NOT NULL,
    compteid INTEGER NOT NULL,
    FOREIGN KEY (compteid) REFERENCES compte(id) ON DELETE CASCADE
);

-- CREATE INDEX idx_compte_numerotel ON compte (numerotel);
-- CREATE INDEX idx_compte_userid ON compte (userid);
-- CREATE INDEX idx_transaction_compteid ON transaction (compteid);
-- CREATE INDEX idx_transaction_date ON transaction (date);




INSERT INTO compte (numero, datecreation, solde, numerotel, typecompte, userid) VALUES
('CP001',        '2025-07-09 23:49:48.697688', 1000.00, '0612345678',    'principal',   1),
('CS001',        '2025-07-09 23:49:48.697688',  500.00, '0623456789',    'secondaire',  1),
('CP002',        '2025-07-09 23:49:48.697688',    0.00, '0634567890',    'principal',   2),
('23333333',     '2025-07-10 23:12:08',        65000.00, '771719742',    'principal',   3),
('23333111',     '2025-07-10 23:22:42',        65000.00, '77677773',     'principal',   7),
('2333311144',   '2025-07-10 23:40:45',        65000.00, '1919191919',   'principal',   8),
('2802673749',   '2025-07-11 00:58:40',        65000.00, '771719743',    'principal',  10),
('3828038445',   '2025-07-11 01:37:42',        65000.00, '333333333',    'principal',  11),
('6784615609',   '2025-07-11 10:01:56',        65000.00, '771719741',    'principal',  19),
('6349013393',   '2025-07-11 15:10:01',        65000.00, '771719745',    'principal',  20),
('6412503659',   '2025-07-11 18:04:38',        65000.00, '771719749',    'principal',  21),
('1265214282',   '2025-07-11 18:05:18',        65000.00, '771719712',    'principal',  22),
('8967230057',   '2025-07-11 18:31:59',        65000.00, '771719740',    'principal',  23);



INSERT INTO transaction (date, typetransaction, montant, compteid) VALUES
('2024-07-01 09:00:00', 'depot',    100000, 1),
('2024-07-02 10:00:00', 'retrait',  -20000, 1),
('2024-07-03 11:00:00', 'paiement', -50000, 1),
('2024-07-04 12:00:00', 'depot',     30000, 1),
('2024-07-05 13:00:00', 'retrait',  -15000, 1),
('2024-07-06 14:00:00', 'paiement', -25000, 1),
('2024-07-07 15:00:00', 'depot',     40000, 1),
('2024-07-08 16:00:00', 'retrait',  -12000, 1),
('2024-07-09 17:00:00', 'paiement', -8000,  1),
('2024-07-10 18:00:00', 'depot',     50000, 1),
('2024-07-11 09:00:00', 'retrait',  -22000, 1),
('2024-07-12 10:00:00', 'paiement', -35000, 1),
('2024-07-13 11:00:00', 'depot',     60000, 1),
('2024-07-14 12:00:00', 'retrait',  -18000, 1),
('2024-07-15 13:00:00', 'paiement', -27000, 1),
('2024-07-16 14:00:00', 'depot',     70000, 1),
('2024-07-17 15:00:00', 'retrait',  -25000, 1),
('2024-07-18 16:00:00', 'paiement', -12000, 1),
('2024-07-19 17:00:00', 'depot',     80000, 1),
('2024-07-20 18:00:00', 'retrait',  -30000, 1);



