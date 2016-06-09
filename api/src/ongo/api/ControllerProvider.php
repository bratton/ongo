<?php

namespace ongo\api;


use ongo\api\controller\BannerController;
use ongo\api\controller\DeeplinkController;
use ongo\api\controller\EmailController;
use ongo\api\controller\PartnerController;
use ongo\api\controller\PartnerDeepLinkController;
use ongo\api\controller\PartnerPaymentInfoController;
use ongo\api\controller\PartnerPaymentsController;
use ongo\api\controller\PhotographerController;
use ongo\api\controller\SessionController;
use ongo\api\controller\PartnerConversionController;
use ongo\api\controller\PartnerSummaryController;
use ongo\api\controller\PartnerUserController;
use ongo\api\controller\TextController;
use ongo\api\controller\VersionController;
use ongo\api\exception\AccessDelegationNotSupportedException;
use ongo\api\exception\InvalidDateException;
use ongo\shared\entity\PartnerEntity;
use ongo\shared\exception\InvalidApiKeyException;
use ongo\shared\exception\InvalidApiUserIdException;
use ongo\shared\exception\InvalidApiUserPasswordException;
use ongo\shared\exception\InvalidValueException;
use ongo\shared\exception\InvalidAuthenticationServiceVersionException;
use ongo\shared\exception\InvalidPartnerIdException;
use ongo\shared\exception\NotUniqueValueException;
use ongo\shared\exception\InvalidPartnerNameException;
use ongo\shared\exception\PartnerNameNotUniqueException;
use ongo\shared\exception\InvalidPartnerPaymentIdException;
use ongo\shared\exception\InvalidPasswordException;
use ongo\shared\exception\InvalidTokenException;
use ongo\shared\exception\InvalidUsernameException;
use ongo\shared\exception\MissingAuthenticationServiceVersionException;
use ongo\shared\exception\MissingKeyException;
use ongo\shared\exception\MissingTokenException;
use ongo\shared\exception\PartnerUsernameNotUniqueException;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app["controllers_factory"];
        $controllers->get("/", function (Application $app, Request $request) {
            return new Response("OK", 200);
        });
//        $controllers->get("/versions", function (Application $app) {
//            $controller = new VersionController($app["db"]);
//            return $controller->query();
//        });
//        $controllers->get("/versions/{id}", function (Application $app, $id) {
//            /** @var PartnerEntity $partner */
//            $partner = $app["auth"]->getPartner();
//
//            if ($partner->getI18nVersionId() != $id) {
//                throw new AccessDelegationNotSupportedException();
//            }
//            $controller = new VersionController($app["db"]);
//            return $controller->get($id);
//        });
//        $controllers->post("/sessions", function (Application $app, Request $request) {
//            $controller = new SessionController($app["cache"], $app["db"]);
//            return $controller->post($request->get("apikey"), $request->get("username"), $request->get("password"));
//        });
//        $controllers->get("/sessions/{token}", function (Application $app, Request $request, $token) {
//            $session = $app["auth"]->getSession();
//            if ($session->getToken() != $token)
//                throw new AccessDelegationNotSupportedException();
//            return new JsonResponse($session->serialize($app["db"]));
//        });
//        $controllers->put("/sessions/{token}", function (Application $app, Request $request, $token) {
//            $session = $app["auth"]->getSession();
//            if ($session->getToken() != $token)
//                throw new AccessDelegationNotSupportedException();
//            $controller = new SessionController($app["cache"], $app["db"]);
//            return $controller->put($token);
//        });
//        $controllers->delete("/sessions/{token}", function (Application $app, Request $request, $token) {
//            $session = $app["auth"]->getSession();
//            if ($session->getToken() != $token)
//                throw new AccessDelegationNotSupportedException();
//            $controller = new SessionController($app["cache"], $app["db"]);
//            return $controller->delete($token);
//        });


        $controllers->get("/photographers", function (Application $app) {
            $controller = new PhotographerController($app["db"]);
            return $controller->top();
        });

        $app->error(function (NotUniqueValueException $e) {
            return new Response("Not unique value", 409);
        });
        $app->error(function (InvalidValueException $e) {
            return new Response("Invalid value", 400);
        });

        return $controllers;
    }
}

?>