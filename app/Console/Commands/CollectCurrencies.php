<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Currencies;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class CollectCurrencies extends Command
{
    private const API_URL = 'https://api.nbrb.by/exrates/rates?periodicity=0';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:collect-currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect currencies';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $response = Http::get(self::API_URL);

            if (! $response->successful()) {
                throw new HttpClientException('Failed to fetch data from API');
            }
            $values = [];
            foreach ($response->json() as $currency) {
                $values[] = [
                    'cur_id' => $currency['Cur_ID'],
                    'cur_abbreviation' => $currency['Cur_Abbreviation'],
                    'cur_scale' => $currency['Cur_Scale'],
                    'cur_name' => $currency['Cur_Name'],
                    'cur_official_rate' => $currency['Cur_OfficialRate'],
                    'created_at' => Carbon::parse($currency['Date']),
                ];

            }
            Currencies::insert($values);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
