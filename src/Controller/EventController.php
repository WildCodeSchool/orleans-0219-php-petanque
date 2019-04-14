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
use App\Service\PostData;
use Nette\Utils\DateTime;

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

        return $this->twig->render('Event/index.html.twig', ['events' => $events]);
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

        return $this->twig->render('Event/show.html.twig', ['event' => $event]);
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

        return $this->twig->render('Event/edit.html.twig', ['event' => $event]);
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
        $erroreventdatas=[];
        $eventdatas=[];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postdata =new PostData($_POST);
            $eventdatas=$postdata->cleanValues();
            var_dump($postdata);

            $erroreventdatas = $this->checkErrorsPostData($eventdatas);
            var_dump($erroreventdatas);
            $eventManager = new EventManager();
            /*            $event = [
            'eventitle' => $_POST['eventitle'],
            ];*/
            /*
            $id = $eventManager->insert($event);
            header('Location:/event/show/' . $id);*/
        }

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

        return $this->twig->render('Event/add.html.twig', [
            'event' => $eventdatas,
            'errors' => $erroreventdatas,
            'departements' => $departements,
            'levels' => $levels,
            'genders'=> $genders,
            'categories' => $categories,
            'types' => $types,
        ]);
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

    /**
     * Check errors from postdata array and return an errors array
     * Before add or update event
     *
     * @param array $postDatas
     * @return array
     * @throws \Exception
     */
    private function checkErrorsPostData(array $postDatas) : array
    {
        $errors=[];
        if (empty($postDatas['title'])) {
            $errors['title'] = "Un titre pour l'évènement est requis.";
        } elseif (strlen(($postDatas['title'])) > 200) {
            $errors['title'] = "Le titre ne doit pas avoir plus de 200 car.";
        };

        $today = new DateTime();

        if (empty($postDatas['date_begin'])) {
            $errors['date_begin'] = "Une date de début d'évènement est requis.";
        } elseif ($postDatas['date_begin']) {
            $dateBegin = DateTime::createFromFormat('Y-m-d', $postDatas['date_begin']);
            if ($dateBegin && $dateBegin->format('Y-m-d') !==  $postDatas['date_begin']) {
                $errors['date_begin'] = "Une date de début d'évènement doit êre correctement rentrée.";
            } elseif ($dateBegin < $today) {
                $errors['date_begin'] = "La date de début d'évènement doit êre postérieure à aujourd'hui.";
            } elseif (empty($postDatas['date_end'])) {
                $postDatas['date_end'] = $postDatas['date_begin'];
            }
        }

        if (empty($postDatas['date_end'])) {
        } elseif ($postDatas['date_end']) {
            $dateBegin = DateTime::createFromFormat('Y-m-d', $postDatas['date_begin']);
            $dateEnd = DateTime::createFromFormat('Y-m-d', $postDatas['date_end']);
            if ($dateEnd && $dateEnd->format('Y-m-d') !== $postDatas['date_end']) {
                $errors['date_end'] = "Une date de fin d'évènement doit êre correctement rentrée.";
            } elseif ($dateEnd < $today || $dateBegin > $dateEnd) {
                $errors['date_end'] = "La date de fin doit êre postérieure à aujourd'hui et au début de l'évènement.";
            } elseif (empty($postDatas['date_end'])) {
                $postDatas['date_end'] = $postDatas['date_begin'];
            }
        }

        $departementManager = new DepartementManager();
        if (empty($postDatas['departement_id'])) {
            $errors['departement_id'] = "Un département est requis.";
        } elseif (empty($departementManager->selectOneById($postDatas['departement_id']))) {
            $errors['departement_id'] = "Un département valide est requis.";
        };

        $levelManager = new EventLevelManager();
        if (empty($postDatas['level_id'])) {
            $errors['level_id'] = "Un niveau de compétition est requis.";
        } elseif (empty($levelManager->selectOneById($postDatas['level_id']))) {
            $errors['level_id'] = "Un niveau de compétition valide est requis.";
        };

        $evtTypeManager = new EventTypeManager();
        if (empty($postDatas['type_id'])) {
            $errors['type_id'] = "Un type de compétition est requis.";
        } elseif (empty($evtTypeManager->selectOneById($postDatas['type_id']))) {
            $errors['type_id'] = "Un type de compétition valide est requis.";
        };

        $evtCategoryManager = new EventCategoryManager();
        if (empty($postDatas['category_id'])) {
            $errors['category_id'] = "Une catégorie de compétition est requis.";
        } elseif (empty($evtCategoryManager->selectOneById($postDatas['category_id']))) {
            $errors['category_id'] = "Une catégorie de compétition valide est requis.";
        };

        $genderManager = new EventGenderManager();
        $genders = $genderManager->selectall();
        if (empty($postDatas['gendermix_id'])) {
            $errors['level_id'] = "Un type de mixité de compétition est requis.";
        } elseif (empty($evtCategoryManager->selectOneById($postDatas['gendermix_id']))) {
            $errors['level_id'] = "Un type de mixité valide est requis.";
        };

        if (empty($postDatas['date_register'])) {
        } elseif ($postDatas['date_register']) {
            $dateBegin = DateTime::createFromFormat('Y-m-d', $postDatas['date_begin']);
            $dateRegister = DateTime::createFromFormat('Y-m-d', $postDatas['date_register']);
            if ($dateRegister && $dateRegister->format('Y-m-d') !==  $postDatas['date_register']) {
                $errors['date_register'] = "La date limite d'inscription doit êre correctement rentrée.";
            } elseif ($dateRegister < $today) {
                $errors['date_register'] = "La date de limite d'inscription doit êre postérieure à aujourd'hui.";
            } elseif ($dateRegister > $dateBegin) {
                $errors['date_register'] = "La date de limite d'inscription doit êre antérieure à la date de début.";
            }
        }

        return $errors;
    }
}
