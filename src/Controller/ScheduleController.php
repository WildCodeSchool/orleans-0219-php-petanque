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

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cleanData = [];

            foreach ($_POST as $key => $cleanDatum) {
                $cleanData[$key] = trim($cleanDatum);

                if (empty($cleanData[$key])) {
                    $errors['schedule'] = 'Tous les champs doivent être remplis.';
                }
            }

            if (empty($errors)) {
                foreach ($schedules as $key => $schedule) {
                    $scheduleToInsert['id'] = $schedule['id'];
                    $scheduleToInsert['morning'] = $cleanData['morning' . $schedule['id']];
                    $scheduleToInsert['afternoon'] = $cleanData['afternoon' . $schedule['id']];

                    $scheduleManager->update($scheduleToInsert);
                }
            }
        }

        return $this->twig->render('Schedule/edit.html.twig', [
            'schedules' => $schedules,
            'errors' => $errors,
        ]);
    }
}
