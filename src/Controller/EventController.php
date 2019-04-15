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
class EventController extends AbstractController
{


    /**
     * Display event listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $eventManager = new EventManager();
        $events = $eventManager->selectEventsToCome();

        return $this->twig->render('Event/index.html.twig', [
            'events' => $events,
            'mainTitle' => 'Vie du club',
            'mainSubTitle' => 'Evènements sportifs à venir',
            ]);
    }

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
        $events = $eventManager->selectEventsToCome();

        return $this->twig->render('Event/eventsadmin.html.twig', [
            'events' => $events,
            'mainTitle' => 'Gestion des évènements sportifs',
            'mainSubTitle' => 'Liste des évènements',
        ]);
    }
}
