<?php

namespace App\Controller;

use App\Entity\Conference;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * @return Response
     * @Route("/conference/{page}", name="conference_list" , defaults={"page"=1})
     */
    public function index($page): Response
    {
        $repository = $this->getDoctrine()->getRepository(Conference::class);
        if ($page == 1) {
            $articles = $repository->getConference(0);
        } else {
            $articles = $repository->getConference(($page - 1) * 10);
        }

        return $this->render('home/index.html.twig', ['articles' => $articles, 'page' => $page, 'isOk' => true]);
    }
}
