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
     * Get one row from database by ID. Override Abstract Method
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
     * Get all row from database - Event Coming soon
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
}
