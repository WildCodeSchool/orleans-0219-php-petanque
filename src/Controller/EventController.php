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
     * Display event informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $eventManager = new EventManager();
        $event = $eventManager->selectOneEventToComeById($id);

        return $this->twig->render('Event/show.html.twig', [
            'event' => $event,
            ]);
    }
}
