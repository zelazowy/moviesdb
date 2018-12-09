<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181209125941 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(
            "CREATE TABLE IF NOT EXISTS movies (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, original_title VARCHAR(255) DEFAULT NULL, budget INTEGER DEFAULT NULL, genres VARCHAR(255) DEFAULT NULL, homepage VARCHAR(255) DEFAULT NULL, original_language VARCHAR(255) DEFAULT NULL, tagline VARCHAR(255) DEFAULT NULL, overview CLOB DEFAULT NULL, popularity NUMERIC(10, 2) DEFAULT NULL, release_date DATE DEFAULT NULL, revenue INTEGER DEFAULT NULL, runtime INTEGER DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, vote_average NUMERIC(10, 2) DEFAULT NULL, vote_count INTEGER DEFAULT NULL);"
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE movies;');
    }
}
