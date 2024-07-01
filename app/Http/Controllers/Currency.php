<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Carbon\Carbon;
use Database\Factories\CurrenciesFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

final class Currency extends Controller
{
    public function __construct(private readonly CurrenciesFactory $currenciesFactory) {}

    public function index(): JsonResponse
    {
        $curFactory = $this->currenciesFactory->makeOne();
        $records = $curFactory->getAllRecords();

        return response()->json(data: $records, options: JSON_UNESCAPED_UNICODE);
    }

    public function show(string $date): JsonResponse
    {
        $validator = Validator::make(['date' => $date], [
            'date' => 'date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $date = Carbon::parse($validator->getValue('date'));
        $curFactory = $this->currenciesFactory->makeOne();
        $record = $curFactory->getRecordForDay($date);

        if ($record->isEmpty()) {
            return response()->json(['error' => 'Record not found for specified date'], 404);
        }

        return response()->json(data: $record, options: JSON_UNESCAPED_UNICODE);
    }
}
