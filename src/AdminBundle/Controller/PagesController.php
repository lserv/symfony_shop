<?php

namespace Shop\AdminBundle\Controller;

use Shop\AdminBundle\Form\PageType;
use Shop\CoreBundle\Entity\Page;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class PagesController extends BaseController
{
    /**
     * @Route("/pages", name="admin_pages")
     */
    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && $action = $request->request->get('action')) {
            switch ($action) {
                case 'delete_item':
                    $this->get('core.manager.page')->delete($request->request->get('id'));

                    return new JsonResponse(['success' => true]);
                case 'save_item':
                    return $this->saveItem($request);
                case 'edit_item':
                    $page = $this->handleEntity($request, $this->get('core.repository.page'), Page::class);
                    $form = $this->createForm(PageType::class, $page, ["method" => "POST"]);

                    return new JsonResponse([
                        'modal' => $this->renderView('AdminBundle:Page:modal.html.twig', [
                            'page'  => $page,
                            'form'  => $form->createView(),
                        ])
                    ]);
                    break;
                case 'items_list':
                    return new JsonResponse([
                        $this->renderView('AdminBundle:Page:list.html.twig', [
                            'pages' => $this->getAllPages(),
                        ]),
                    ]);
            }
        } else {
            return $this->render("AdminBundle:Page:index.html.twig", [
                'pages' => $this->getAllPages()
            ]);
        }
    }

    private function saveItem(Request $request)
    {
        $page = $this->handleEntity($request, $this->get('core.repository.page'), Page::class);
        $form = $this->createForm(PageType::class, $page, ["method" => "POST"]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('core.manager.page')->save($page);
            return new JsonResponse([
                'success' => true,
                'message' => $request->request->get('id') ? 'Updated' : 'Created'
            ]);
        } else {
            return new JsonResponse([
                'success' => false,
                'message' => $form->getErrors()
            ]);
        }
    }

    private function getAllPages()
    {
        return $this
            ->get('core.repository.page')
            ->findAll();
    }
}
