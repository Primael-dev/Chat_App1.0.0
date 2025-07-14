-- Script de mise à jour de la base de données pour le système d'invitation
-- Exécutez ce script si vous avez déjà une base de données existante
USE chatapp;

-- Ajouter les nouveaux champs à la table messages
ALTER TABLE messages
ADD COLUMN is_first_message TINYINT (1) DEFAULT 0 AFTER msg,
ADD COLUMN invitation_status ENUM ('pending', 'accepted', 'declined') DEFAULT 'pending' AFTER is_first_message;

-- Mettre à jour les messages existants pour marquer le premier message entre chaque paire d'utilisateurs
UPDATE messages m1
SET
    is_first_message = 1
WHERE
    m1.msg_id = (
        SELECT
            MIN(m2.msg_id)
        FROM
            messages m2
        WHERE
            (
                (
                    m2.outgoing_msg_id = m1.outgoing_msg_id
                    AND m2.incoming_msg_id = m1.incoming_msg_id
                )
                OR (
                    m2.outgoing_msg_id = m1.incoming_msg_id
                    AND m2.incoming_msg_id = m1.outgoing_msg_id
                )
            )
            AND m2.msg_id = m1.msg_id
    );

-- Afficher un message de confirmation
SELECT
    'Base de données mise à jour avec succès pour le système d\'invitation!' as message;

-- Création de la table posts pour la gestion des publications avec images
CREATE TABLE
    IF NOT EXISTS posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        content TEXT,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
    );