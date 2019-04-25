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
     * Get all row from database - Override abstrast Method
     *
     * @return array
     */
    public function selectEventsToCome(): array
    {
        $statement = "
            SELECT evenement.id, 
                evenement.title, 
                evenement.descr,
                DATE_FORMAT(evenement.date_begin,'%d/%m/%Y') as date_begin,
                DATE_FORMAT(evenement.date_end,'%d/%m/%Y') as date_end,
                evenement.location, 
                DATE_FORMAT(evenement.date_register,'%d/%m/%Y') as date_register,
                evenement.rulesfile_id,
                evenement.article_id,
                departement.name as dept_name, departement.numdept as dept_num,
                level.name as level,
                gendermix.name as gendermix,
                evtcategory.name as category,
                evttype.name as type
             FROM evenement
            INNER JOIN departement ON evenement.departement_id = departement.id
            INNER JOIN level ON evenement.level_id = level.id
            INNER JOIN gendermix ON evenement.gendermix_id = gendermix.id
            INNER JOIN evtcategory ON evenement.category_id = evtcategory.id
            INNER JOIN evttype ON evenement.gendermix_id = evttype.id
            WHERE date_begin >= NOW()
            ORDER BY evenement.date_begin ASC, level.id, gendermix.id;";

        return $this->pdo->query($statement)->fetchAll();
    }
        
    /**
     * Get one row from database by ID.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectOneEventToComeById(int $id):array
    {
        $statement = "
        SELECT evenement.id, 
            evenement.title, 
            evenement.descr,
            DATE_FORMAT(evenement.date_begin,'%d/%m/%Y') as date_begin,
            DATE_FORMAT(evenement.date_end,'%d/%m/%Y') as date_end,
            evenement.location, 
            DATE_FORMAT(evenement.date_register,'%d/%m/%Y') as date_register,
            evenement.rulesfile_id,
            evenement.article_id,
            departement.name as dept_name, departement.numdept as dept_num,
            level.name as level,
            gendermix.name as gendermix,
            evtcategory.name as category,
            evttype.name as type
         FROM evenement
        LEFT JOIN departement ON evenement.departement_id = departement.id
        LEFT JOIN level ON evenement.level_id = level.id
        LEFT JOIN gendermix ON evenement.gendermix_id = gendermix.id
        LEFT JOIN evtcategory ON evenement.category_id = evtcategory.id
        LEFT JOIN evttype ON evenement.type_id = evttype.id
        WHERE evenement.id=:id";
        // prepared request
        $statement = $this->pdo->prepare($statement);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

     /**
     * Insert an event in database
     *
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

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    /**
     * Get all row from database
     *
     * @return array
     */
    public function selectEventsPasts(): array
    {
        $statement = "
            SELECT evenement.id, 
                evenement.title, 
                evenement.descr,
                DATE_FORMAT(evenement.date_begin,'%d/%m/%Y') as date_begin,
                DATE_FORMAT(evenement.date_end,'%d/%m/%Y') as date_end,
                evenement.location, 
                DATE_FORMAT(evenement.date_register,'%d/%m/%Y') as date_register,
                evenement.rulesfile_id,
                evenement.article_id,
                departement.name as dept_name, departement.numdept as dept_num,
                level.name as level,
                gendermix.name as gendermix,
                evtcategory.name as category,
                evttype.name as type
            FROM evenement
            INNER JOIN departement ON evenement.departement_id = departement.id
            INNER JOIN level ON evenement.level_id = level.id
            INNER JOIN gendermix ON evenement.gendermix_id = gendermix.id
            INNER JOIN evtcategory ON evenement.category_id = evtcategory.id
            INNER JOIN evttype ON evenement.gendermix_id = evttype.id
            WHERE date_begin < NOW()
            ORDER BY evenement.date_begin DESC, level.id, gendermix.id;";

        return $this->pdo->query($statement)->fetchAll();
    }

    /**
     * Get all Eventts from database
     *
     *
     *
     * @return array
     */
    public function selectAllEvents():array
    {
        $statement = "
        SELECT evenement.id, 
            evenement.title, 
            evenement.descr,
            DATE_FORMAT(evenement.date_begin,'%d/%m/%Y') as date_begin,
            DATE_FORMAT(evenement.date_end,'%d/%m/%Y') as date_end,
            evenement.location, 
            DATE_FORMAT(evenement.date_register,'%d/%m/%Y') as date_register,
            evenement.rulesfile_id,
            evenement.article_id,
            departement.name as dept_name, departement.numdept as dept_num,
            level.name as level,
            gendermix.name as gendermix,
            evtcategory.name as category,
            evttype.name as type
         FROM evenement
        LEFT JOIN departement ON evenement.departement_id = departement.id
        LEFT JOIN level ON evenement.level_id = level.id
        LEFT JOIN gendermix ON evenement.gendermix_id = gendermix.id
        LEFT JOIN evtcategory ON evenement.category_id = evtcategory.id
        LEFT JOIN evttype ON evenement.type_id = evttype.id
        ORDER BY evenement.date_begin DESC, level.id, gendermix.id;";

        return $this->pdo->query($statement)->fetchAll();
    }

    /**
     * @param array $event
     * @param int $id
     * @return bool
     */
    public function updateEvent(array $event, int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "UPDATE $this->table SET 
            `title` = :title,
            `descr` = :descr,
            `date_begin` = :date_begin,
            `date_end` = :date_end,
            `departement_id` = :departement_id,
            `location` = :location,
            `level_id` = :level_id,
            `category_id` = :category_id,
            `type_id` = :type_id,
            `gendermix_id` = :gendermix_id,
            `date_register` = :date_register,
            `rulesfile_id` = :rulesfile_id,
            `article_id` = :article_id             
            WHERE id=:id"
        );
        $statement->bindValue('title', $event['title'], \PDO::PARAM_STR);
        $statement->bindValue('descr', $event['descr'], \PDO::PARAM_STR);
        $statement->bindValue('date_begin', $event['date_begin'], \PDO::PARAM_STR);
        $statement->bindValue('date_end', $event['date_end'], \PDO::PARAM_STR);
        $statement->bindValue('departement_id', $event['departement_id'], \PDO::PARAM_INT);
        $statement->bindValue('location', $event['location'], \PDO::PARAM_STR);
        $statement->bindValue('level_id', $event['level_id'], \PDO::PARAM_INT);
        $statement->bindValue('category_id', $event['category_id'], \PDO::PARAM_INT);
        $statement->bindValue('type_id', $event['type_id'], \PDO::PARAM_INT);
        $statement->bindValue('gendermix_id', $event['gendermix_id'], \PDO::PARAM_INT);
        $statement->bindValue('date_register', $event['date_register'], \PDO::PARAM_STR);
        $statement->bindValue('rulesfile_id', $event['rulesfile_id'], \PDO::PARAM_INT);
        $statement->bindValue('article_id', $event['article_id'], \PDO::PARAM_INT);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        return $statement->execute();
    }
  
      /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
