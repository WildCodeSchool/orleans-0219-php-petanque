<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *Sport event manager
 *
 */
class EventManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'evenement';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Insert an Event
     * @param array $events
     * @return int
     */
    public function insertEvent(array $events): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
        VALUES (NULL, :title, :descr, :date_begin, :date_begin, :departement_id, :location, 
        :level_id, :category_id, :type_id, :gendermix_id, :date_register, :rulesfile_id, :article_id)");
        $statement->bindValue('title', $events['title'], \PDO::PARAM_STR);
        $statement->bindValue('descr', $events['descr'], \PDO::PARAM_STR);
        $statement->bindValue('date_begin', $events['date_begin'], \PDO::PARAM_STR);
        $statement->bindValue('date_begin', $events['date_begin'], \PDO::PARAM_STR);
        $statement->bindValue('departement_id', $events['departement_id'], \PDO::PARAM_INT);
        $statement->bindValue('location', $events['location'], \PDO::PARAM_STR);
        $statement->bindValue('level_id', $events['level_id'], \PDO::PARAM_INT);
        $statement->bindValue('category_id', $events['category_id'], \PDO::PARAM_INT);
        $statement->bindValue('type_id', $events['type_id'], \PDO::PARAM_INT);
        $statement->bindValue('gendermix_id', $events['gendermix_id'], \PDO::PARAM_INT);
        $statement->bindValue('date_register', $events['date_register'], \PDO::PARAM_STR);
        $statement->bindValue('rulesfile_id', $events['rulesfile_id'], \PDO::PARAM_INT);
        $statement->bindValue('article_id', $events['article_id'], \PDO::PARAM_INT);
        echo "<br>";
        $statement->debugDumpParams();
        echo "<br>";
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
