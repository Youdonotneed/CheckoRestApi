<?php

namespace App\Controller;

use App\Service\CompanyClient;

class CompanyController {

    private CompanyClient $client;

    public function __construct(CompanyClient $client)
    {
        $this->client = $client;
    }

    private function showErrorMessage(int $statusCode, string $message): void {
        http_response_code($statusCode);
        echo json_encode(['error' => $message], JSON_UNESCAPED_UNICODE);
    }

    public function getCompanyInfo(): void {
        header('Content-Type: application/json; charset=utf-8');
        $inn = $_GET['inn'] ?? '';

        if ($inn === '') {
            $this->showErrorMessage(400, 'Введите ИНН компании');
            return;
        }

        try {
            $companyDataRaw = $this->client->getCompanyByInn($inn);
            echo json_encode($companyDataRaw, JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            $this->showErrorMessage(500, $e->getMessage());
        }
        return;
    }

    public function getCompanyContracts(): void {
        header('Content-Type: application/json; charset=utf-8');
        $inn = $_GET['inn'] ?? '';

        if ($inn === '') {
            $this->showErrorMessage(400, 'Введите ИНН компании');
            return;
        }

        try {
            $contractsRaw = $this->client->getContractsByInn($inn);
            echo json_encode($contractsRaw, JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            $this->showErrorMessage(500, $e->getMessage());
        }
        return;
    }

    public function getCompanyArbitrations(): void {
        header('Content-Type: application/json; charset=utf-8');
        $inn = $_GET['inn'] ?? '';

        if ($inn === '') {
            $this->showErrorMessage(400, 'Введите ИНН компании');
            return;
        }

        try {
            $arbitrationsRaw = $this->client->getArbitrationsByInn($inn, true);
            echo json_encode($arbitrationsRaw, JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            $this->showErrorMessage(500, $e->getMessage());
        }
        return;
    }
}