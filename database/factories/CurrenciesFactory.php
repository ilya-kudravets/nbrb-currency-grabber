<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Currencies;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Currencies>
 */
final class CurrenciesFactory extends Factory
{
    /**
     * @return array{
     *     cur_id: int,
     *     cur_abbreviation: string,
     *     cur_scale: int,
     *     cur_name: string,
     *     cur_official_rate: float,
     * }
     */
    public function definition(): array
    {
        return [
            'cur_id' => fake()->randomNumber(4),
            'cur_abbreviation' => fake()->currencyCode,
            'cur_scale' => fake()->randomNumber(2),
            'cur_name' => Str::random(3),
            'cur_official_rate' => fake()->randomFloat(2, 1, 100),
        ];
    }
}
