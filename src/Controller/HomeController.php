<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\MemberManager;
use App\Model\ScheduleManager;

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
        $memberManager = new MemberManager();
        $members = $memberManager->getTopMembers();
        $scheduleManager = new ScheduleManager();
        $schedules = $scheduleManager->selectAll();

        return $this->twig->render('Home/index.html.twig', [
            'schedules' => $schedules,
            'members' => $members,
        ]);
    }
}
