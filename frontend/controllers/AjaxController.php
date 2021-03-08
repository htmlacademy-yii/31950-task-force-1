<?php


namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class AjaxController extends Controller
{
    public function actionCoords($value)
    {

        $this->layout = false;
        $client = new Client([
            'base_uri' => 'http://geocode-maps.yandex.ru/1.x/',
        ]);
        try {
            $coords = null;
            $request = new Request('GET', '');
            $coords = Yii::$app->cache->get(md5($value));
            if (!$coords) {
                $response = $client->send($request, [
                    'query' => ['geocode' => $value, 'apikey' => Yii::$app->params['geo-coder-apiKey'], 'format' => 'json']
                ]);

                if ($response->getStatusCode() !== 200) {
                    throw new BadResponseException("Response error: " . $response->getReasonPhrase(), $request);
                }
                $content = $response->getBody()->getContents();
                $response_data = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new ServerException("Invalid json format", $request);
                }
                if ($error = ArrayHelper::getValue($response_data, 'error.info')) {
                    throw new BadResponseException("API error: " . $error, $request);
                }
                if ($response_data['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found'] > 0) {
                    $items = $response_data['response']['GeoObjectCollection']['featureMember'];
                    foreach ($items as $item) {
                        $pieces = explode(" ", $item['GeoObject']['Point']['pos']);
                        $coords[] = [
                            'name' => $item['GeoObject']['name'],
                            'latitude' => $pieces[1],
                            'longitude' => $pieces[0],
                        ];
                    }
                    Yii::$app->cache->set(md5($value), $coords, 86400);
                    return json_encode(['coords' => $coords, 'success' => true]);
                } else {
                    return json_encode(['message' => 'Ничего не найдено', 'success' => false]);
                }
            } else {
                return json_encode(['coords' => $coords, 'success' => true]);
            }
        } catch (RequestException $e) {
            return json_encode(['message' => $e->getMessage(), 'success' => false]);
        }

    }
}
