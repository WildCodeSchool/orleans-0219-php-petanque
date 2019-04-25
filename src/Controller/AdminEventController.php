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
 * Class EventAdminController
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
    public function index()
    {
        $alertResult = isset($_GET['status']);
        $eventManager = new EventManager();
        $events = $eventManager->selectAllEvents();

        return $this->twig->render('Event/indexadmin.html.twig', [
            'events' => $events,
            'statusAlert' => $alertResult,
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
        $errorEventData=[];
        $eventData=[];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postDatum =new PostDatum($_POST);
            $eventData=$postDatum->cleanValues();
            $errorEventData = $this->checkErrorsPostData($eventData);

            $eventManager = new EventManager();

            if (empty($errorEventData)) {
                $id = $eventManager->insertEvent($eventData);
                header('Location:/event/show/' . $id);
            }
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
            'event' => $eventData,
            'errors' => $errorEventData,
            'departements' => $departements,
            'levels' => $levels,
            'genders'=> $genders,
            'categories' => $categories,
            'types' => $types,
        ]);
    }

    /**
     * UPDATE event informations
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id)
    {
        $errorEventData=[];
        $eventData=[];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postDatum = new PostDatum($_POST);
            $eventData=$postDatum->cleanValues();
            $errorEventData = $this->checkErrorsPostData($eventData);

            $eventManager = new EventManager();
            if (empty($id)) {
                $errorEventData['id'] = "Un problème est survenu lors de la mise à jour de l'évènement.";
            } elseif (empty($eventManager->selectOneById($id))) {
                $errorEventData['id'] = "L'identifiant demandé de l'évènement n'existe pas dans la base de données";
            }

            if (empty($errorEventData)) {
                $eventManager->updateEvent($eventData, $id);
                $events=$eventManager->selectAllEvents();
                header('Location:/event/show/' . $id . '/?status=success&type=admin');
                exit();
            }
        } else {
            $eventManager = new EventManager();
            $eventData = $eventManager->selectOneById($id);
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

        return $this->twig->render('Event/edit.html.twig', [
            'event' => $eventData,
            'errors' => $errorEventData,
            'departements' => $departements,
            'levels' => $levels,
            'genders'=> $genders,
            'categories' => $categories,
            'types' => $types,
        ]);
    }

    private function checkErrorsPostData(array $postData) : array
    {
        $errors=[];
        if (empty($postData['title'])) {
            $errors['title'] = "Un titre pour l'évènement est requis.";
        } elseif (strlen(($postData['title'])) > 200) {
            $errors['title'] = "Le titre ne doit pas avoir plus de 200 car.";
        };

        $today = new DateTime();

        if (empty($postData['date_begin'])) {
            $errors['date_begin'] = "Une date de début d'évènement est requis.";
        } elseif ($postData['date_begin']) {
            $dateBegin = DateTime::createFromFormat('Y-m-d', $postData['date_begin']);
            if ($dateBegin && $dateBegin->format('Y-m-d') !==  $postData['date_begin']) {
                $errors['date_begin'] = "Une date de début d'évènement doit être correctement rentrée.";
            } elseif ($dateBegin < $today) {
                $errors['date_begin'] = "La date de début d'évènement doit être postérieure à aujourd'hui.";
            } elseif (empty($postData['date_end'])) {
                $postData['date_end'] = $postData['date_begin'];
            }
        }

        if (empty($postData['date_end'])) {
            $errors['date_begin'] = "Une date de fin d'évènement est requis.";
        } elseif ($postData['date_end']) {
            $dateBegin = DateTime::createFromFormat('Y-m-d', $postData['date_begin']);
            $dateEnd = DateTime::createFromFormat('Y-m-d', $postData['date_end']);
            if ($dateEnd && $dateEnd->format('Y-m-d') !== $postData['date_end']) {
                $errors['date_end'] = "Une date de fin d'évènement doit être correctement rentrée.";
            } elseif ($dateEnd < $today || $dateBegin > $dateEnd) {
                $errors['date_end'] = "La date de fin doit être postérieure à aujourd'hui et au début de l'évènement.";
            }
        }

        $departementManager = new DepartementManager();
        if (empty($postData['departement_id'])) {
            $errors['departement_id'] = "Un département est requis.";
        } elseif (empty($departementManager->selectOneById($postData['departement_id']))) {
            $errors['departement_id'] = "Un département valide est requis.";
        };

        $levelManager = new EventLevelManager();
        if (empty($postData['level_id'])) {
            $errors['level_id'] = "Un niveau de compétition est requis.";
        } elseif (empty($levelManager->selectOneById($postData['level_id']))) {
            $errors['level_id'] = "Un niveau de compétition valide est requis.";
        };

        $evtTypeManager = new EventTypeManager();
        if (empty($postData['type_id'])) {
            $errors['type_id'] = "Un type de compétition est requis.";
        } elseif (empty($evtTypeManager->selectOneById($postData['type_id']))) {
            $errors['type_id'] = "Un type de compétition valide est requis.";
        };

        $evtCategoryManager = new EventCategoryManager();
        if (empty($postData['category_id'])) {
            $errors['category_id'] = "Une catégorie de compétition est requis.";
        } elseif (empty($evtCategoryManager->selectOneById($postData['category_id']))) {
            $errors['category_id'] = "Une catégorie de compétition valide est requis.";
        };

        $genderManager = new EventGenderManager();
        if (empty($postData['gendermix_id'])) {
            $errors['gendermix_id'] = "Un type de mixité de compétition est requis.";
        } elseif (empty($evtCategoryManager->selectOneById($postData['gendermix_id']))) {
            $errors['gendermix_id'] = "Un type de mixité valide est requis.";
        };

        if (empty($postData['date_register'])) {
            $errors['date_register'] = "Une date d'inscription à l'évènement est requis.";
        } elseif ($postData['date_begin']) {
            $dateBegin = DateTime::createFromFormat('Y-m-d', $postData['date_begin']);
            $dateRegister = DateTime::createFromFormat('Y-m-d', $postData['date_register']);
            if ($dateRegister && $dateRegister->format('Y-m-d') !==  $postData['date_register']) {
                $errors['date_register'] = "La date limite d'inscription doit être correctement rentrée.";
            } elseif ($dateRegister < $today) {
                $errors['date_register'] = "La date de limite d'inscription doit être postérieure à aujourd'hui.";
            } elseif ($dateRegister > $dateBegin) {
                $errors['date_register'] = "La date de limite d'inscription doit être antérieure à la date de début.";
            }
        }

        return $errors;
    }

    /**
     * Delete an event
     */
    public function delete()
    {
        $eventManager = new EventManager();
        $errors=[];
        $id=0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postDatum =new PostDatum($_POST);
            $postData=$postDatum->cleanValues();
            $id = $postData['id'];
            if (empty($id)) {
                $errors[] = 'L évènement n existe pas';
            } elseif (empty($eventManager->selectOneById($id))) {
                $errors[] = 'L évènement n existe pas dans la base de données';
            }
        }
        if (empty($errors)) {
            $eventManager->delete($id);
            header('Location:/adminEvent/index/?status=success');
            exit();
        }
    }
}
