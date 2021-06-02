<?php

namespace App\Controller;

use App\Service\MessageGenerator;
use App\Service\SessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class IndexController extends AbstractController
{
    public function welcome(): Response
    {
        $url = $this->generateUrl('home_page', ['user' => 'raja']);
        $msg = "welcome <br> go to <a href='" . $url . "'>home</a>";

        return new Response($msg);
    }

    public static function getSubscribedServices()
    {
        return array_merge(
            parent::getSubscribedServices(),
            [
            'msgGenerator' => MessageGenerator::class,
            ]
        );
    }

    /**
     * @Route("/tmpl",name="temp_sample")
     */
    public function tmpl()
    {
        return $this->render('index/layout.html.twig', ['name' => 'welcome']);
    }

    public function yml(Request $request, $twig): Response
    {
        return new Response($twig->render('index/temp.html.twig', ['str' => 'yml']));
    }

    /**
     * @Route("ses", name = "sample_session")
     */
    public function ses(Request $request, SessionService $sessionService)
    {
        // $sessName = $request->getSession()->get('value', null);
        ini_set('session.save_handler', 'files');
        ini_set('session.save_path', '/tmp');
        session_start();
        $session = new Session(new PhpBridgeSessionStorage());
        $session->start();
        $sessName = $sessionService->getValue('value');
        if (null === $sessName) {
            return new Response('Session not set..!');
        }
        $sessName .= "<br> action : " . $_SESSION['action']; //$sessionService->getValue('action'); //. $_SESSION['action'];
        $msg = $request->getSession()->getFlashBag()->get('msg');
        $info = $request->getSession()->getFlashBag()->get('info');
        $msg = 'Message : ' . (array_key_exists(0, $msg) ? $msg[0] : null);
        $info = 'Info : ' . (array_key_exists(0, $info) ? $info[0] : null);
        $info .= '<br>Param : ' . $this->getParameter('param.sample');

        return new Response('Session value : ' . $sessName . "<br>$msg<br>$info");
    }

    // /**
    //  * @Route("/msg",name="random_message")
    //  */
    // public function messgae(MessageGenerator $generator)
    // {
    //     $message = $generator->generateMessage();
    //     return new Response($message);
    // }

    /**
     * @Route("/msg",name="random_message")
     */
    public function messgae()
    {
        $generator = $this->get('msgGenerator');
        $message = $this->getParameter("samp-param") . " ";
        $message .= $generator->generateMessage();
        return new Response($message);
    }

    /**
     * @Route("/json", name = "json_sample")
     */
    public function sampleJson()
    {
        return $this->json(['name' => 'raja', 'age' => 12]);
    }

    /**
     * @Route("/download", name="download_file")
     */
    public function download()
    {
        return $this->file('img/symfony.png', 'logo.png', ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("ses/{value}", name = "set_session")
     */
    public function setSes(Request $request, SessionService $sessionService)
    {
        $value = $request->attributes->get('value');
        ini_set('session.save_handler', 'files');
        ini_set('session.save_path', '/tmp');
        session_start();
        $session = new Session(new PhpBridgeSessionStorage());
        $session->start();
        $sessionService->setValue('value', $value);
        // $request->getSession()->set('value', $value);
        $this->addFlash('info', 'Flash Info...');
        $request->getSession()->getFlashBag()->add('msg', 'Flash Msg...');
        $_SESSION['action'] = 'set';

        return new Response('Session is set..!');
    }

    /**
     * @Route("/epage", name="error_page_404")
     */
    public function errPage()
    {
        throw $this->createNotFoundException('404 Page');
    }

    /**
     * @Route("/doc/{param}", methods={"GET", "POST"}, priority=2, requirements={"param"=".+"})
     */
    public function paramName(?string $param = null)
    {
        return new Response("Param $param is caught by paramName..!");
    }

    /**
     * @Route("/doc/{param<\d+>?}", methods={"GET", "POST"}, priority=3)
     */
    public function param(Request $request)
    {
        $atr = $request->attributes->get('param');

        return new Response("Param caught..!<br> $atr");
    }

    /**
     * @Route("/global", name="global_values")
     */
    public function global()
    {
        return $this->render('index/global.html.twig');
    }

    /**
     * @Route("/home", methods={"GET", "POST"}, name="home_page")//support only double quotes
     * [Route('/home', methods:['GET', 'POST'])]
     */
    public function home(Request $request): Response
    {
        $msg = 'Welcome to home '.$request->query->get('user');

        return new Response($msg);
    }

    /**
     * @Route("/temp")
     */
    public function temp(Environment $twig): Response
    {
        return new Response($twig->render('index/temp.html.twig', ['str' => 'Injected Template']));
    }

    /**
     * @Route("/sam",name="sam")
     */
    public function sam()
    {
        return $this->render('index/temp.html.twig', ['str' => 'sample']);
    }

    /**
     * @Route("/check/{name<.+>}")
     */
    public function checkTemplate(Environment $twig, $name)
    {
        $loader = $twig->getLoader();
        if ($loader->exists($name)) {
            return new Response("'$name' Exists");
        }

        return new Response("'$name' Not exists");
    }

    /**
     * @Route("/", name="home_page")
     */
    public function root()
    {
        return $this->forward('App\\Controller\\IndexController::global');
    }

    /**
     * @Route("/user/{user?}",name="user-name")
     */
    public function user(Request $request)
    {
        $res = dump($request);
        $user = $request->get('user');

        return new Response('welcome '.$user);
    }

    public function xml(Request $request)
    {
        return new Response('xml');
    }

    public function php(Request $request)
    {
        return new Response('php');
    }
}
