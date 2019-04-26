<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ScheduleManager;
use App\Model\PartnerManager;

class HomeController extends AbstractController
{

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
        $partnerManager = new PartnerManager();
        $partners = $partnerManager->getPartners();


        return $this->twig->render('Home/index.html.twig', [
            'schedules' => $schedules,
            'partners' => $partners,
        ]);
    }
}
