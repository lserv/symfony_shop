<?php

namespace Shop\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    protected function handleEntity(Request $request, $repository, $entity)
    {
        if ($id = $request->request->get('id')) {
            return $repository->find($id);
        } else {
            return new $entity();
        }
    }
}
