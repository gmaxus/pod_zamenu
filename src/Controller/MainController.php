<?php

namespace App\Controller;

use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use GuzzleHttp\Client;

class MainController extends AbstractController
{
    private const API_KEY = 'zH2IpHt3HIt6PB-63ZJy7Sakrhn9D6IlW4y8d_tKQeNLTum63MNM34wgNw4jpWqAjyCSCyAaekJbNB8GKNAx_Y6cdDtPtQNWT4KopDa8q09m5sFhHonJo7DduEZp6_XeK1QkOO5-rdbYC5WoXHwVB58MXg2ZyjlYHRGvckYAwn6-v4nDHGbSG5W14e9TNISvVNV-npiXR3A9l1--wRv0Wbruwbpjf194ewjv7hBdsaJx0zrCFNI3KVOJlN-w61gvOYvGH_ErrE-N3mN51OGeZhY-smtkcNdkZiQ-0HEI7VTac-sFBvfAmYi2ona1dWPTE3yLEaRiPbvFg2266OCkHdluKEa6k1MHeL0OeuR8pJlBbPE-RaVnkchq6F_yB-y7mD_5RGVR2a1_0RzYQyesVnu_i7_TDHKHLWhh30CF0AfOU-AIkRI25RF28qi3XzIJHEGx1Ifs8TxFnL7TpwSSRuvD4bNuyknsr50zGUO2W8WdZdhzl5b4S8-yLCQM99Vl';

    /**
     * @throws GuzzleException
     */
    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {

        $answer = null;
        $answerCode = 0;
        if ($request->get('vendor_code') !== null) {
            try {

                $client = new Client();
                $additionalUrl = 'JSONparameter=' . json_encode(['Article' => $request->get('vendor_code')]);

                $res = $client->get('http://api.tmparts.ru/api/ArticleBrandList?' . $additionalUrl,
                    [
                        'headers' => ['Authorization' => 'Bearer ' . self::API_KEY],
                    ]);

                $answerCode = $res->getStatusCode();
                $answer = $res->getBody()->getContents();

            } catch (GuzzleException $exception) {
                $answerCode = $exception->getCode();
                $answer = $exception->getMessage();
            }

        }

        return $this->render('main/index.html.twig',
            [
                'answerCode' => $answerCode,
                'answer' => $answer,
            ]);
    }
}
