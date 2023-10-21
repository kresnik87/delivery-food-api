<?php

namespace Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BussinesController extends UserController
{


    public function registerAction(Request $request)
    {
        try {
            $user = parent::registerAction($request);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            return new JsonResponse(["error" => "register.register_error"]);
        }


    }


}
