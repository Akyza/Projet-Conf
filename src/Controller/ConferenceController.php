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
            $conferences = $repository->getConferences(0);
        } else {
            $conferences = $repository->getConferences(($page - 1) * 10);
        }

        return $this->render('conference/index.html.twig', ['conferences' => $conferences, 'page' => $page, 'isOk' => true]);
    }

    /**
     * @return Response
     * @param Conference $conference
     * @Route("/conference/view/{id}", name="conference_view")
    */
    public function viewArticle(Conference $conference): Response
    {
        $repository = $this->getDoctrine()->getRepository(Conference::class);
        $viewConference = $repository->find($conference);
        if (!empty($viewConference)) {
            return $this->render('conference/view.html.twig', ['conference' => $viewConference]);
        }
        return $this->redirectToRoute('conference_list', ['articles' => $repository->findAll(), 'isOk' => false]);
    }

    /**
     * @return Response
     * @Route("/topConference/", name="conference_top")
    */
    public function topVoteConference(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Conference::class);
        $conferences = $repository->getTopConferences();
        return $this->render('conference/listTopVote.html.twig', ['conferences' => $conferences]);

    }
}
