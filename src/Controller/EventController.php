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
        $eventFilters=[];
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['level_id'])) {
                $eventFilters['level_id'] =  $_GET['level_id'];
            }
            if (isset($_GET['type_id'])) {
                $eventFilters['type_id'] =  $_GET['type_id'];
            }
            if (isset($_GET['category_id'])) {
                $eventFilters['category_id'] =  $_GET['category_id'];
            }
            if (isset($_GET['gendermix_id'])) {
                $eventFilters['gendermix_id'] =  $_GET['gendermix_id'];
            }
            if (isset($_GET['departement_id'])) {
                $eventFilters['departement_id'] =  $_GET['departement_id'];
            }
        }

        $eventManager = new EventManager();
        $events = $eventManager->selectEventsToCome($eventFilters);

        $departementManager = new DepartementManager();
        $departements = $departementManager->selectall();

        $levelManager = new EventLevelManager();
        $levels = $levelManager->selectall();

        $genderManager = new EventGenderManager();
        $genders = $genderManager->selectall();

        $evtCategoryManager = new EventCategoryManager();
        $categories = $evtCategoryManager->selectall();

        $evtTypeManager = new EventTypeManager();
        $types = $evtTypeManager->selectall();
        return $this->twig->render('Event/index.html.twig', [
            'events' => $events,
            'eventsfilters' => $eventFilters,
            'departements' => $departements,
            'levels' => $levels,
            'genders'=> $genders,
            'categories' => $categories,
            'types' => $types,
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

        return $this->twig->render('Event/show.html.twig', [
            'event' => $event,
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
