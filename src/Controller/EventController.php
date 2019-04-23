<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\DepartementManager;
use App\Model\EventCategoryManager;
use App\Model\EventGenderManager;
use App\Model\EventLevelManager;
use App\Model\EventManager;
use App\Model\EventTypeManager;
use App\Service\PostDatum;
use Nette\Utils\DateTime;

/**
* Class EventController
*
* @return string
* @throws \Twig\Error\LoaderError
* @throws \Twig\Error\RuntimeError
* @throws \Twig\Error\SyntaxError
*/
class EventController extends AbstractController
{
    /**
    * Display event listing
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
            ]);
    }

    /**
    * Display event informations specified by $id
    *
    * @param int $id
    *
    * @return string
    * @throws \Twig\Error\LoaderError
    * @throws \Twig\Error\RuntimeError
    * @throws \Twig\Error\SyntaxError
    */
    public function show(int $id)
    {
        $eventManager = new EventManager();
        $event = $eventManager->selectOneEventToComeById($id);

        $alertResult=false;
        $adminStatus=false;
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $postDatum =new PostDatum($_GET);
            $getData=$postDatum->cleanValues();
            if (!empty($getData['status'])) {
                if ($getData['status'] == 'success') {
                    $alertResult= true;
                }
            }
            if (!empty($getData['type'])) {
                if ($getData['type'] == 'admin') {
                    $adminStatus= true;
                }
            }
        }

        return $this->twig->render('Event/show.html.twig', [
            'event' => $event,
            'statusAlert' => $alertResult,
            'adminStatus' => $adminStatus,
        ]);
    }

    /**
     * Display past events listing
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function indexresults()
    {
        $eventManager = new EventManager();
        $events = $eventManager->selectEventsPasts();

        return $this->twig->render('Event/indexresults.html.twig', [
            'events' => $events,
        ]);
    }
}
