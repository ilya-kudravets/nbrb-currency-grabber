<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Currencies;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Currencies>
 */
final class CurrenciesFactory extends Factory
{
    /**
     * @return array{
     *     cur_id: int,
     *     cur_official_rate: float,
     * }
     */
    public function definition(): array
    {
        return [
            'cur_id' => fake()->randomNumber(3),
            'created_at' => Carbon::now(),
            'Cur_Abbreviation' => fake()->currencyCode(),
            'Cur_Scale' => fake()->randomNumber(2),
            'Cur_Name' => fake()->text(10),
            'cur_official_rate' => fake()->randomFloat(2, 1, 100),
        ];
    }
}
