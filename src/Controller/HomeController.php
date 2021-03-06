<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\MemberManager;
use App\Model\EventManager;
use App\Model\ScheduleManager;
use App\Model\PartnerManager;
use App\Model\ArticleManager;

class HomeController extends AbstractController
{
    /**
     *
     */
    const LIMIT_LAST_EVENTS = 3;

    const LIMIT_LAST_ARTICLES = 3;

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
        $partnerManager = new PartnerManager();
        $partners = $partnerManager->getPartners();

        $articleManager = new ArticleManager();
        $articles = $articleManager->selectAllArticles(self::LIMIT_LAST_ARTICLES);
        $eventManager = new EventManager();
        $eventFilters=[];

        $topEvents = $eventManager->selectEventsToCome($eventFilters, self::LIMIT_LAST_EVENTS);
        return $this->twig->render('Home/index.html.twig', [
            'schedules' => $schedules,
            'events' => $topEvents,
            'partners' => $partners,
            'articles' => $articles,
            'members' => $members,
        ]);
    }
}
