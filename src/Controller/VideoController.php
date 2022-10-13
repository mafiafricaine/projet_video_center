<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\VideoRepository;
use App\Entity\Video;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Form\VideoType;
use Doctrine\ORM\EntityManagerInterface;
class VideoController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(VideoRepository $repo): Response
    {
        return $this->render('video/index.html.twig', ['videos' => $repo->findAll()]);
    }

    /**
     * @Route("/video/create", name = "app_video_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): Response{
        if (!$this->getUser()) {
            //&& $this->getUser()->isVerified() == false
            $this->addFlash('error', 'You must confirm your mail to create a video');
            return $this->redirectToRoute('app_home');
        }
        $video = new Video;
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $video->setUser($this->getUser());
            $em->persist($video);
            $em->flush();
            $this->addFlash('success', 'Video successfuly created !');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('video/create.html.twig', ['monForm' => $form->createView()]);
    }

    /**
     * @Route("/video/{id<[0-9]+>}", name = "app_video_show", methods="GET")
     */
    public function show(Video $video): Response{
        //$user=$this->getUser();
        if ($video->isPremiumVideo()){
            if ( !$this->getUser()){
                $this->addFlash('error', 'You must to Log or Register, if you want to see a premium video !');
                return $this->redirectToRoute('app_login');
            }else if ($this->getUser()->isVerified() == false) {
                $this->addFlash('error', 'You must to confirm your mail if you want to see a premium video !');
                return $this->redirectToRoute('app_home');
            }
        }
        
        return $this->render('video/show.html.twig', compact('video'));
    }

    /**
     * @Route("/video/{id<[0-9]+>}/edit", name="app_video_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Video $video, EntityManagerInterface $em): Response{
        if ($this->getUser()->isVerified() == false) {
            $this->addFlash('error', 'You must to confirm your mail if you want to edit a video !');
            return $this->redirectToRoute('app_home');
        }else if ($video->getUser()->getEmail() !== $this->getUser()->getEmail()){
            $this->addFlash('error', 'You can\'t edit this video because you are not the creator of this !');
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'Video successfuly updated !');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('video/edit.html.twig', [
                    'video' => $video,
                    'monForm' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/video/{id<[0-9]+>}/delete", name="app_video_delete")
     */
    public function delete(Video $video, EntityManagerInterface $em): Response{
        if ($this->getUser()->isVerified() == false) {
            $this->addFlash('error', 'You must to confirm your mail if you wantto delete a video !');
            return $this->redirectToRoute('app_home');
        }else if ($video->getUser()->getEmail() !== $this->getUser()->getEmail()){
            $this->addFlash('error', "To delete a video, you must be the creator of this video !");
            return $this->redirectToRoute('app_home');
        }
        $em->remove($video);
        $em->flush();
        $this->addFlash('info', 'Video successfuly deleted !');
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/account", name="app_account")
     */
    public function account(VideoRepository $repo): Response
    {
        if ( !$this->getUser()){
            $this->addFlash('error', 'You must to Log in, if you want to go to your account !');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('video/account.html.twig', ['videos' => $repo->findAll()]);
    }

    /**
     * @Route("/account/{id<[0-9]+>}", name="app_accountTrue")
     */
    public function accountTrue(VideoRepository $repo): Response
    {

        return $this->render('video/accountTrue.html.twig', ['videos' => $repo->findByUser($this->getUser())]);
    }

}
