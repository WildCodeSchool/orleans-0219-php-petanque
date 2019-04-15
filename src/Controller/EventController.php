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
        $events = $eventManager->selectAll();

        return $this->twig->render('Event/index.html.twig', [
            'events' => $events,
            'mainTitle' => 'Vie du club',
            'mainSubTitle' => 'Evènements sportifs à venir',
        ]);
    }

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
        $event = $eventManager->selectOneById($id);

        return $this->twig->render('Event/show.html.twig', [
            'event' => $event,
            'mainTitle' => 'Vie du club',
            'mainSubTitle' => 'Détails de l\'évènement sportif',
            ]);
    }

    /**
     * Display event edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $eventManager = new EventManager();
        $event= $eventManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $event['title'] = $_POST['title'];
            $eventManager->update($event);
        }

        return $this->twig->render('Event/edit.html.twig', [
            'event' => $event
        ]);
    }


    /**
     * Display event creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventManager = new EventManager();
            $event = [
                'title' => $_POST['title'],
            ];
            $id = $eventManager->insert($event);
            header('Location:/event/show/' . $id);
        }

        return $this->twig->render('Event/add.html.twig');
    }


    /**
     * Handle event deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $eventManager = new EventManager();
        $eventManager->delete($id);
        header('Location:/event/index');
    }
}
