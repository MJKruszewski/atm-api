<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180616104333 extends AbstractMigration
{

    public function postUp(Schema $schema)
    {
        $this->connection->executeQuery('
CREATE OR REPLACE FUNCTION atm.withdraw(account_id VARCHAR(255), atm_card_id VARCHAR(255), withdraw_amount DECIMAL)  RETURNS BOOL
NOT DETERMINISTIC
MODIFIES SQL DATA
BEGIN
	DECLARE balance DECIMAL;
    DECLARE card_account_id VARCHAR(255);
    
    SELECT atm.account_balance(account_id) INTO balance;
    
    IF (withdraw_amount > balance) THEN
		SIGNAL SQLSTATE \'45001\' SET MESSAGE_TEXT = \'Insufficient funds\';
	END IF;
    
    SELECT atm_card.account_id INTO card_account_id FROM atm.atm_card WHERE atm_card.id = atm_card_id;
    
    IF (card_account_id != account_id) THEN
		SIGNAL SQLSTATE \'45002\' SET MESSAGE_TEXT = \'Wrong account for atm card\';
    END IF;
    
    INSERT INTO atm.transaction (id, atm_card_id, amount, date_add) VALUES (UUID(), atm_card_id, account_id, -withdraw_amount, NOW());

	RETURN TRUE;
END;
');
    }

    public function up(Schema $schema): void
    {
    }

    public function down(Schema $schema): void
    {
    }
}
