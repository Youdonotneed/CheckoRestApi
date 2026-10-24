<?php

namespace App\Service;

class CompanyClient {

    private string $apiKey;
    private string $baseUrl = 'https://api.checko.ru';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getCompanyByInn (string $inn): array {

        $url = $this->baseUrl . "/v2/company?key=" . $this->apiKey . "&inn=" . $inn;
        $request = curl_init($url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($request);

        if ($response === FALSE) {
            $errorMessage = curl_error($request);
            curl_close($request);
            throw new \Exception("Не удалось выполнить запрос: " .  $errorMessage);
        }

        $resultData = json_decode($response, true);

        if (isset($resultData['error'])) {
            throw new \Exception("Ошибка Checko: " . $resultData['error']);
        }

        curl_close($request);
        return $resultData;
    }

    public function getContractsByInn (string $inn): array {
        $params = [
            'key' => $this->apiKey,
            'inn' => $inn,
            'law' => '44'
        ];
        $url = $this->baseUrl . "/v2/contracts?" . http_build_query($params);
        $request = curl_init($url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($request);

        if ($response === FALSE) {
            $errorMessage = curl_error($request);
            curl_close($request);
            throw new \Exception("Не удалось выполнить запрос: " .  $errorMessage);
        }

        $resultData = json_decode($response, true);

        if (isset($resultData['error'])) {
            throw new \Exception("Ошибка Checko: " . $resultData['error']);
        }

        curl_close($request);
        return $resultData;
    }

    public function getArbitrationsByInn(string $inn, bool $actual = true): array {
        $params = [
            'key' => $this->apiKey,
            'inn' => $inn,
            'actual' => $actual ? 'true' : 'false'
        ];

        $url = $this->baseUrl . "/v2/legal-cases?" . http_build_query($params);
        $request = curl_init($url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($request);

        if ($response === FALSE) {
            $errorMessage = curl_error($request);
            curl_close($request);
            throw new \Exception("Не удалось выполнить запрос: " .  $errorMessage);
        }

        $resultData = json_decode($response, true);

        if (isset($resultData['error'])) {
            throw new \Exception("Ошибка Checko: " . $resultData['error']);
        }

        curl_close($request);
        return $resultData;
    }
}
