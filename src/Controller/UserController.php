<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use App\Form\UserLoginType;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    /**
     * @Route("/user/login", name="user_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $user = new User();
        $form = $this->createForm(UserLoginType::class, $user);
        $error =  $authenticationUtils->getLastAuthenticationError();
        return $this->render('user/login.html.twig', [
            'error' => $error,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/register", name="user_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $user = new User();
        $form=$this->createForm(UserRegisterType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $password = $userPasswordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('home', [
                'id' => $user->getId(),
            ]);

        }
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/user/logout", name="user_logout")
     */
    public function logout()
    {
        throw new Exception("Déconnecté");
    }


    /**
     * @return Response
     * @Route("/user/list/{page}", name="user_list", defaults={"page"=1})
     */
    public function list($page): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        if ($page == 1){
            $user = $repository->getUser(0);
        }else{
            $user = $repository->getUser(($page - 1) * 10);
        }

        return $this->render('user/list.html.twig', ['user' => $user, 'page' => $page, 'isOk' => true]);
    }


    /**
     * @return Response
     * @Route("/view/{id}", name="user_view")
     */
    public function viewUser(User $user): Response
    {
        return $this->render('user/view.html.twig', ['user' => $user]);

        /*$repository = $this->getDoctrine()->getRepository(User::class);
        $viewUser = $repository->find($user);
        dump($user);
        if (!empty($viewUser)){
            return $this->render('user/view.html.twig', ['user' => $viewUser]);
        }
        return $this->redirectToRoute('user_list', ['users' => $repository->findAll(), 'isOk' => false]);*/
    }

    /**
     * @Route(path="/delete/{id}", name="user_delete")
     */
    public function delete(User $users): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($users);
        $em->flush();
        return $this->redirectToRoute('user_list');
    }


}
