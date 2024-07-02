<?php

use App\Models\Currencies;

it('returns all records', function () {
    Currencies::factory()->count(3)->create();

    $response = $this->getJson('/fetch-rates/');

    $response->assertStatus(200);
    $response->assertJsonCount(3);
    $response->assertJsonStructure([
        '*' => [
            'Cur_ID',
            'Date',
            'Cur_Abbreviation',
            'Cur_Scale',
            'Cur_Name',
            'Cur_OfficialRate',
        ],
    ]);
});

it('returns one record', function () {
    Currencies::factory()->create([
        'cur_id' => 460,
        'created_at' => '2024-01-01',
        'cur_official_rate' => 1.23,
    ]);
    $response = $this->getJson('/fetch-rates/2024-01-01');
    $response->assertStatus(200);
    $response->assertJsonCount(1);
    $response->assertJsonFragment([
        'Cur_ID' => 460,
        'Date' => '2024-01-01T00:00:00.000000Z',
        'Cur_Abbreviation' => 'TRY',
        'Cur_Scale' => 10,
        'Cur_Name' => 'Турецких лир',
        'Cur_OfficialRate' => 1.23,
    ]);
});
