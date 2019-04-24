<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\MemberManager;
use App\Model\SponsorrManager;

class MemberController extends AbstractController
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
        $member = $memberManager->selectAll();
        $sponsorManager = new SponsorrManager();
        $sponsors = $sponsorManager->selectAll();

        return $this->twig->render('Member/index.html.twig', [
            'members' => $member,
            'sponsors' => $sponsors,
        ]);
    }
}
