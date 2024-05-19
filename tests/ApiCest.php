<?php
namespace Tests;

use Tests\Support\ApiTester;

class ApiCest 
{
    protected $id = 0;
    public function addLoan(ApiTester $I) // Выполняется перед тестированием
    {
        $I->sendPOST('/add', [
            "value" => 999,
            "term" => 10,
            "interest_rate" => 15
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse(), true);
        $this->id = $response['id'];
    }

    public function tryGetAll(ApiTester $I)
    {
        $I->sendGet('/all');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'value' => 'integer',
            'term' => 'integer',
            'interest_rate' => 'integer',
            'amount_paid' => 'integer|null'
        ]);
    }

    public function tryToUpdateLoan(ApiTester $I)
    {
        $I->sendPut("/update/{$this->id}", [
            'amount_paid' => 100,
        ]);
        $I->seeResponseCodeIs(200);
//        $I->seeResponseIsJson();

        $I->sendGet("/{$this->id}");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'id' => $this->id,
            'value' => 999,
            'term' => 10,
            'interest_rate' => 15,
            'amount_paid' => 100
        ]);
    }

    public function tryToDeleteLoan(ApiTester $I)
    {
        $I->sendDELETE("/delete/{$this->id}");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}