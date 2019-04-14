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
    public function selectAll(): array
    {
        $selectStatement = "
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
WHERE date_begin >= NOW()
ORDER BY evenement.date_begin ASC, level.id, evtcategory.id,evttype.id, gendermix.id;";

        return $this->pdo->query($selectStatement . $this->table)->fetchAll();
    }


    /**
     * @param array $events
     * @return int
     */
    public function insert(array $events): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`title`) VALUES (:title)");
        $statement->bindValue('title', $events['title'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
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


    /**
     * @param array $events
     * @return bool
     */
    public function update(array $events):bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $events['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $events['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function selectOneById(int $id)
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
WHERE WHERE id=:id";

        // prepared request
        $statement = $this->pdo->prepare($statement);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
