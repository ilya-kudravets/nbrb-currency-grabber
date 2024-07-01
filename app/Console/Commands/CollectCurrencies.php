<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\Carbon;
use Database\Factories\CurrenciesFactory;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use Psr\Log\LoggerInterface;

final class CollectCurrencies extends Command
{
    protected const API_URL = 'https://api.nbrb.by/exrates/rates?periodicity=0';

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

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CurrenciesFactory $currenciesFactory,
    ) {
        parent::__construct();
    }

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

            foreach ($response->json() as $currency) {
                $model = $this->currenciesFactory->newModel([
                    'cur_id' => $currency['Cur_ID'],
                    'cur_official_rate' => $currency['Cur_OfficialRate'],
                    'created_at' => Carbon::parse($currency['Date']),
                ]);
                $model->save();
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
