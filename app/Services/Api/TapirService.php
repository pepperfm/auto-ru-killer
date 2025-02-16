<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Data\Api\Responses\NewCarResponse;
use App\Data\Api\Responses\OldCarResponse;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class TapirService
{
    protected const string BASE_RUL = 'https://tapir.ws/';

    protected PendingRequest $http;

    public function __construct()
    {
        $this->http = Http::asJson()->acceptJson()->baseUrl(static::BASE_RUL);
    }

    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     *
     * @return \Illuminate\Support\Collection<array-key, NewCarResponse>
     */
    public function new(): \Illuminate\Support\Collection
    {
        $response = $this->http->get('files/new_cars.json');
        $data = collect();
        foreach ($response->json() as $item) {
            $data->push(new NewCarResponse(
                brand: $item['brand'],
                model: $item['model'],
                vin: $item['vin'],
                price: $item['price'],
            ));
        }

        return $data;
    }

    /**
     * @throws \JsonException
     *
     * @return \Illuminate\Support\Collection<array-key, OldCarResponse>
     */
    public function used(): \Illuminate\Support\Collection
    {
        $xmlString = file_get_contents(static::BASE_RUL . 'files/used_cars.xml');
        $xmlObject = simplexml_load_string($xmlString);

        $json = json_encode($xmlObject, JSON_THROW_ON_ERROR);
        $phpArray = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $data = collect();
        foreach ($phpArray['vehicle'] as $item) {
            $data->push(new OldCarResponse(
                brand: $item['brand'],
                model: $item['model'],
                vin: $item['vin'],
                price: $item['price'],
                year: $item['year'],
                mileage: $item['mileage'],
            ));
        }

        return $data;
    }
}
