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
    public function update(array $schedule):bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $schedule['id'], \PDO::PARAM_INT);
        $statement->bindValue('day', $schedule['day'], \PDO::PARAM_INT);
        $statement->bindValue('morning_schedule', $schedule['morning_schedule'], \PDO::PARAM_INT);
        $statement->bindValue('evening_schedule', $schedule['evening_schedule'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
