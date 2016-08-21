<?php

namespace Shop\AdminBundle\Controller;

use Shop\CoreBundle\Entity\Category;
use Shop\CoreBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/categories", name="admin_categories")
     */
    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && $action = $request->request->get('action')) {
            switch ($action) {
                case 'delete_item':
                    $this->get('manager.category')->delete($request->request->get('id'));

                    return new JsonResponse(['success' => true]);
                case 'save_item':
                    return $this->saveItem($request);
                case 'edit_item':
                    $category = $this->handleCategory($request);
                    $form = $this->createForm(CategoryType::class, $category, ["method" => "POST"]);

                    return new JsonResponse([
                        'modal' => $this->renderView('AdminBundle:Category:modal.html.twig', [
                            'category'  => $category,
                            'form'      => $form->createView(),
                        ])
                    ]);
                    break;
                case 'items_list':
                    return new JsonResponse([
                        $this->renderView('AdminBundle:Category:list.html.twig', [
                            'categories' => $this->getAllCategories(),
                        ]),
                    ]);
            }
        } else {
            return $this->render("AdminBundle:Category:index.html.twig", [
                'categories' => $this->getAllCategories()
            ]);
        }
    }

    private function saveItem(Request $request)
    {
        $category = $this->handleCategory($request);
        $form = $this->createForm(CategoryType::class, $category, ["method" => "POST"]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('manager.category')->persistAndFlush($category);
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

    private function getAllCategories()
    {
        return $this
            ->get('manager.category')
            ->findAll();
    }

    private function handleCategory(Request $request)
    {
        if ($id = $request->request->get('id')) {
            return $this
                ->get('manager.category')
                ->getRepository()
                ->find($id);
        } else {
            return new Category();
        }
    }
}
