<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Coin;
use AppBundle\Entity\CoinSnapshot;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CoinSnapshotApiController extends Controller
{
    /**
     * @Route("/coinList")
     */
    public function coinListAction()
    {
        $coins = $this->getDoctrine()->getRepository(Coin::class)
            ->createQueryBuilder('c')
            ->orderBy('name', 'ASC')
            ->getQuery()
            ->getArrayResult();

        return $this->json($coins);
    }

    /**
     * @Route("/coinsnapshot/{coinSymbol}", name="coin_snapshot_api")
     */
    public function coinSnapshotAction($coinSymbol)
    {
        $coinSnapshotsQB = $this->getDoctrine()->getRepository(CoinSnapshot::class)
            ->createQueryBuilder('cs')
            ->select('cs.close, cs.time')
            ->where('cs.coinSymbol = :coin_symbol')
            ->setParameter('coin_symbol', $coinSymbol);

        $endTime = new DateTime('now', new \DateTimeZone('UTC'));
        $startTime = new DateTime('now', new \DateTimeZone('UTC'));
        $startTime->sub(new \DateInterval('P1D'));

        $coinSnapshots = $coinSnapshotsQB->andWhere('cs.time BETWEEN :start_time AND :end_time')
            ->setParameter('start_time', $startTime)
            ->setParameter('end_time', $endTime)
            ->orderBy('cs.time', 'DESC')
            ->getQuery()
            ->getArrayResult();


        $results = [
            'time' => [],
            'close' => []
        ];
        foreach ($coinSnapshots as $cs) {
            $results['time'][] = $cs['time']->format('c');
            $results['close'][] = $cs['close'];
        }

        return $this->json($results);
    }

}
