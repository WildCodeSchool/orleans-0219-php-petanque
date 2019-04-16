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
class ScheduleManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'schedule';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * update schedule index
     *
     * @param array $schedule
     * @return bool
     */
    public function update(array $schedule): bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table
                                                    SET `morning` = :morning, `afternoon` = :afternoon
                                                    WHERE id=:id");

        $statement->bindValue('id', $schedule['id'], \PDO::PARAM_INT);
        $statement->bindValue('morning', $schedule['morning'], \PDO::PARAM_STR);
        $statement->bindValue('afternoon', $schedule['afternoon'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
