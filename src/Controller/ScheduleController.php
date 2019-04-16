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
            //   $schedules['morning'] = $_POST['morning'];
            //   $schedules['afternoon'] = $_POST['afternoon'];

            foreach ($schedules as $key => $schedule) {
                $scheduleToInsert['id'] = $schedule['id'];
                $scheduleToInsert['morning'] = $_POST['morning' . $schedule['id']];
                $scheduleToInsert['afternoon'] = $_POST['afternoon' . $schedule['id']];

                $scheduleManager->update($scheduleToInsert);
                print_r($scheduleToInsert);
            }
        }

        return $this->twig->render('Schedule/edit.html.twig', [
            'schedules' => $schedules,
        ]);
    }
}
