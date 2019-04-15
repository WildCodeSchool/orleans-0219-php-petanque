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
            $erroreventdatas = $this->checkErrorsPostData($eventdatas);

            $eventManager = new EventManager();

            if (empty($erroreventdatas)) {
                $id = $eventManager->insertEvent($eventdatas);
                header('Location:/event/show/' . $id);
            }
            $eventdatas = $_POST;
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
            'mainTitle' => "Gestion des évènements sportifs",
            'mainSubTitle' => "Ajout d'un évènement",
        ]);
    }

    private function checkErrorsPostData(array &$postDatas) : array
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
        if (empty($postDatas['gendermix_id'])) {
            $errors['gendermix_id'] = "Un type de mixité de compétition est requis.";
        } elseif (empty($evtCategoryManager->selectOneById($postDatas['gendermix_id']))) {
            $errors['gendermix_id'] = "Un type de mixité valide est requis.";
        };

        if (empty($postDatas['date_register'])) {
            $postDatas['date_register'] = $postDatas['date_begin'];
        } elseif ($postDatas['date_register']) {
            $dateBegin = DateTime::createFromFormat('Y-m-d', $postDatas['date_begin']);
            $dateRegister = DateTime::createFromFormat('Y-m-d', $postDatas['date_register']);
            if ($dateRegister && $dateRegister->format('Y-m-d') !==  $postDatas['date_register']) {
                $errors['date_register'] = "La date limite d'inscription doit êre correctement rentrée.";
            } elseif ($dateRegister < $today) {
                $errors['date_register'] = "La date de limite d'inscription doit êre postérieure à aujourd'hui.";
            } elseif ($dateRegister > $dateBegin) {
                $errors['date_register'] = "La date de limite d'inscription doit êre antérieure à la date de début.";
            } else {
                $postDatas['date_register'] = $postDatas['date_begin'];
            }
        }

        return $errors;
    }
}
