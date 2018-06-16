<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180616121540 extends AbstractMigration
{
    public function postUp(Schema $schema)
    {
        $this->connection->executeQuery('
CREATE OR REPLACE TRIGGER balance_check 
	BEFORE INSERT ON atm.transaction
	FOR EACH ROW
BEGIN
	DECLARE balance DECIMAL;
    SELECT atm.account_balance(account_id) INTO balance;

    IF (balance + NEW.amount < 0) THEN
		SIGNAL SQLSTATE \'45000\' SET MESSAGE_TEXT = \'Insufficient funds\';
	END IF;
END
');
    }

    public function up(Schema $schema): void
    {
    }

    public function down(Schema $schema): void
    {
    }
}
