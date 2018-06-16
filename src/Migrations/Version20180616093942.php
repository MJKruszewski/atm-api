<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180616093942 extends AbstractMigration
{

    public function postUp(Schema $schema)
    {
        $this->connection->executeQuery('
CREATE OR REPLACE FUNCTION atm.account_balance(account_id VARCHAR(255)) RETURNS DECIMAL 
NOT DETERMINISTIC
READS SQL DATA
BEGIN 
  DECLARE sum decimal;
  SELECT IFNULL(SUM(amount), 0) INTO sum FROM atm.transaction WHERE transaction.account_id = account_id;
  RETURN sum;
END
');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP FUNCTION IF EXISTS atm.account_balance;');
    }

    public function up(Schema $schema)
    {
    }
}
