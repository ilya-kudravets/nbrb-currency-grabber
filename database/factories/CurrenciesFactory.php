<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Currencies;
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
        $config = config('currency');
        return [
            'cur_id' => fake()->randomKey($config),
            'cur_official_rate' => fake()->randomFloat(2, 1, 100),
        ];
    }
}
