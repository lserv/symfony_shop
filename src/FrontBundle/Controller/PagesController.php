<?php

namespace Shop\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;

use Shop\FrontBundle\Form\ContactType;

class PagesController extends Controller
{
    /**
     * @Route("/", name="front_main_page")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/contact.html", name="front_page_contact")
     * @Template()
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($this->get("core.provider.mail_contact")->sendEmail($form->getData())) {
                $request->getSession()->getFlashBag()->set('success', 'Message sent!');
            } else {
                $request->getSession()->getFlashBag()->set('danger', 'Message not sent!');
            }
        }

        return ['form' => $form->createView()];
    }
    
    /**
     * @Route("/{page}.html", name="front_page")
     *
     * @param $page
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function pageAction($page)
    {
        $finder = new Finder();
        $dir = $this->get('kernel')->locateResource('@FrontBundle').'Resources/views/Pages/';

        if ($finder->files()->name($page.'.html.twig')->in($dir)->count()) {
            return $this->render('FrontBundle:Pages:'.$page.'.html.twig');
        } else {
            throw $this->createNotFoundException('The page not found!');
        }
    }
}
