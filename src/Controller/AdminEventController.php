<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\EventManager;

/**
 * Class EventController
 *
 */
class AdminEventController extends AbstractController
{

    /**
     * Display event listing admin
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function eventsadmin()
    {
        $eventManager = new EventManager();
        $events = $eventManager->selectAllEvents();

        return $this->twig->render('Event/eventsadmin.html.twig', [
            'events' => $events,
        ]);
    }
}
