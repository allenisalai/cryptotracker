<?php

namespace AppBundle\Controller;

use AppBundle\Entity\HypeSource;
use AppBundle\Library\HypeSource\NewsArticle\CoinDeskAltParser;
use AppBundle\Library\HypeSource\NewsArticle\CoinDeskParser;
use AppBundle\Library\HypeSource\NewsArticle\CoinTelegraphParser;
use AppBundle\Library\HypeSource\NewsArticle\CryptoCoinsNewsParser;
use AppBundle\Library\HypeSource\NewsArticle\CryptoInsiderParser;
use AppBundle\Library\HypeSource\NewsArticle\HtmlSourceParserTemplate;
use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Crawler;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default_index")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }

    /**
     * @Route("/test", name="default_test")
     */
    public function testAction()
    {
        $client = new Client();
        $parser = new HtmlSourceParserTemplate($client, new Crawler());
        $ci = new CryptoInsiderParser();
        $hypeSources = $parser->getHypeSources($ci);

        dump($hypeSources);

        /*
        $em = $this->getDoctrine()->getManager();


        foreach($hypeSources as $hs) {
            $em->persist($hs);
        }

        $em->flush();
        */

        $html = '';
        return $this->render('AppBundle:Default:test.html.twig', [
            'html' => $html
        ]);
    }
}
