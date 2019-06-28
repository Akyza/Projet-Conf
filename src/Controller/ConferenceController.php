<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function viewConference(Conference $conference): Response
    {
        $repository = $this->getDoctrine()->getRepository(Conference::class);
        $viewConference = $repository->find($conference);
        if (!empty($viewConference)) {
            return $this->render('conference/view.html.twig', ['conference' => $viewConference]);
        }
        return $this->redirectToRoute('conference_list', ['articles' => $repository->findAll(), 'isOk' => false]);
    }

    /**
     * @Route("/addConference/", name="conference_add")
    */
    public function addConference(Request $request): Response{
        $isOk = false;
        $newConferenceForm = $this->createForm(ConferenceType::class);
        $newConferenceForm->handleRequest($request);
        if ($newConferenceForm->isSubmitted() && $newConferenceForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newConferenceForm->getData());
            $em->flush();
            $isOk = true;
        }
        return $this->render('conference/add.html.twig', [
            'isOk' => $isOk,
            'conferenceForm' => $newConferenceForm->createView(),
        ]);
    }

    /**
     * @return Response
     * @Route("/conference/edit/{id}", name="conference_edit")
    */
    public function edit(Request $request, Conference $conference): Response
    {
        $isOk = false;
        $newConferenceForm = $this->createForm(ConferenceType::class, $conference);
        $newConferenceForm->handleRequest($request);
        if ($newConferenceForm->isSubmitted() && $newConferenceForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $isOk = true;
        }

        return $this->render('conference/edit.html.twig', [
            'conferenceForm' => $newConferenceForm->createView(),
            'isOk' => $isOk,
        ]);
    }

    /**
     * @Route("/conference/delete/{id}", name="conference_delete")
    */
    public function delete(Conference $conference): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($conference);
        $em->flush();
        return $this->redirectToRoute('conference_list');
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

    /**
     * @param $page
     * @return Response
     * @Route("/noVoteConference/{page}", name="noVoteConference_list" , defaults={"page"=1})
     */
    public function listNoVoteConference($page): Response
    {
        $repo = $this->getDoctrine()->getRepository(Conference::class);
        if ($page == 1) {
            $conferences = $repo->getNoVoteConferences(0);
        } else {
            $conferences = $repo->getNoVoteConferences(($page - 1) * 10);
        }

        dump($conferences);

        return $this->render('conference/noVote.html.twig', ['conferences' => $conferences, 'page' => $page, 'isOk' => true]);
    }

    /**
     * @param $page
     * @return Response
     * @Route("/voteConference/{page}", name="voteConference_list" , defaults={"page"=1})
     */
    public function listVoteConference($page): Response
    {
        $repo = $this->getDoctrine()->getRepository(Conference::class);
        if ($page == 1) {
            $conferences = $repo->getVoteConferences(0);
        } else {
            $conferences = $repo->getVoteConferences(($page - 1) * 10);
        }

        dump($conferences);

        return $this->render('conference/listVote.html.twig', ['conferences' => $conferences, 'page' => $page, 'isOk' => true]);
    }
}
