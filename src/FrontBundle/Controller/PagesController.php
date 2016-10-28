<?php

namespace Shop\FrontBundle\Controller;

use Shop\CoreBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Shop\FrontBundle\Form\ContactType;

class PagesController extends Controller
{
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
     * @Route("/{slug}.html", name="front_page")
     */
    public function pageAction(Page $page)
    {
        return $this->render('@Front/Pages/page.html.twig', [
            'page' => $page
        ]);
    }

    public function pagesInFooterAction()
    {
        return $this->render('@Front/Pages/pages_footer.html.twig', [
            'pages' => $this->get('core.repository.page')->findBy(['active' => 1])
        ]);
    }
}
