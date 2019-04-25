<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\EventManager;
use App\Model\ScheduleManager;

class HomeController extends AbstractController
{
    /**
     *
     */
    const LIMIT_LAST_EVENTS = 3;

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $scheduleManager = new ScheduleManager();
        $schedules = $scheduleManager->selectAll();

        $eventManager = new EventManager();
        $topEvents = $eventManager->selectAllEvents(self::LIMIT_LAST_EVENTS);
        return $this->twig->render('Home/index.html.twig', [
            'schedules' => $schedules,
            'events' => $topEvents,
        ]);
    }
}
