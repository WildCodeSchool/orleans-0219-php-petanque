<?php


namespace App\Controller;

use App\Model\ScheduleManager;

/**
 * Class ScheduleController
 * @package App\Controller
 */
class ScheduleController extends AbstractController
{

    /**
     * edit schedule index
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit()
    {
        $scheduleManager = new ScheduleManager();
        $schedules = $scheduleManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $schedules['day'] = $_POST['day'];
            $schedules['morning_schedule'] = $_POST['morning_schedule'];
            $schedules['evening_schedule'] = $_POST['evening_schedule'];
            $scheduleManager->update($schedules);
        }

        return $this->twig->render('Schedule/edit.html.twig', [
            'schedule' => $schedules,
        ]);
    }
}
