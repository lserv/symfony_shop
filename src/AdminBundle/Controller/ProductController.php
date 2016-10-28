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
     * @Route(
     *     "/products",
     *     name="admin_products",
     *     options={"expose"=true}
     * )
     */
    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && $action = $request->get('action')) {
            switch ($action) {
                case 'delete_item':
                    $this->get('core.manager.product')->delete($request->request->get('id'));
            
                    return $this->json(['success' => true]);
                case 'save_item':
                    return $this->saveItem($request);
                case 'edit_item':
                    $product = $this->handleEntity($request, $this->get('core.repository.product'), Product::class);
                    $form = $this->createForm(ProductType::class, $product, ["method" => "POST"]);
            
                    return $this->json([
                        'modal' => $this->renderView('AdminBundle:Product:modal.html.twig', [
                            'product'  => $product,
                            'form'     => $form->createView(),
                        ])
                    ]);
                    break;
                case 'upload_image':
                    return $this->json([
                        'success' => true,
                        'filename' => $this->get('core.services_file')->upload($request->files->get('file_data'))
                    ]);
                case 'delete_img':
                    if ($old_img = $request->request->get('old_img')) {
                        $this->get('core.services_file')->delete($old_img);
                    }

                    return $this->json(['success' => true]);
                    break;
                case 'items_list':
                    return $this->json([
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
        /** @var Product $product */
        $product = $this->handleEntity($request, $this->get('core.repository.product'), Product::class);
        $form = $this->createForm(ProductType::class, $product, ["method" => "POST"]);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->get('core.manager.product')->save($product);
            return $this->json([
                'success' => true,
                'message' => $request->request->get('id') ? 'Updated' : 'Created'
            ]);
        } else {
            return $this->json([
                'success' => false,
                'message' => $form->getErrors()
            ]);
        }
    }
    
    private function getAllProducts()
    {
        return $this
            ->get('core.repository.product')
            ->findAll();
    }
}
