<?php

namespace Shop\AdminBundle\Controller;

use Shop\CoreBundle\Entity\Product;
use Shop\CoreBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class ProductController extends BaseController
{
    /**
     * @Route("/products", name="admin_products")
     */
    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && $action = $request->request->get('action')) {
            switch ($action) {
                case 'delete_item':
                    $this->get('manager.product')->delete($request->request->get('id'));
            
                    return new JsonResponse(['success' => true]);
                case 'save_item':
                    return $this->saveItem($request);
                case 'edit_item':
                    $product = $this->handleEntity($request, $this->get('repository.product'), Product::class);
                    $form = $this->createForm(ProductType::class, $product, ["method" => "POST"]);
            
                    return new JsonResponse([
                        'modal' => $this->renderView('AdminBundle:Product:modal.html.twig', [
                            'product'  => $product,
                            'form'     => $form->createView(),
                        ])
                    ]);
                    break;
                case 'items_list':
                    return new JsonResponse([
                        $this->renderView('AdminBundle:Product:list.html.twig', [
                            'products' => $this->getAllProducts(),
                        ]),
                    ]);
            }
    
        } else {
            return $this->render("AdminBundle:Product:index.html.twig", [
                'products' => $this->getAllProducts()
            ]);
        }
    }
    
    private function saveItem(Request $request)
    {
        $product = $this->handleEntity($request, $this->get('repository.product'), Product::class);
        $form = $this->createForm(ProductType::class, $product, ["method" => "POST"]);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->get('manager.product')->save($product);
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
    
    private function getAllProducts()
    {
        return $this
            ->get('repository.product')
            ->findAll();
    }
}
