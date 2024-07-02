<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property int $cur_id
 * @property string $created_at
 * @property string $cur_abbreviation
 * @property int $cur_scale
 * @property string $cur_name
 * @property float $cur_official_rate
 */
#[OA\Schema(
    schema: 'CurrenciesFormat',
    title: 'Currencies',
    properties: [
        new OA\Property(
            property: 'Cur_ID',
            type: 'string',
        ),
        new OA\Property(
            property: 'Date',
            type: 'string',
        ),
        new OA\Property(
            property: 'Cur_Abbreviation',
            type: 'string',
        ),
        new OA\Property(
            property: 'Cur_Scale',
            type: 'int',
        ),
        new OA\Property(
            property: 'Cur_Name',
            type: 'string',
        ),
        new OA\Property(
            property: 'Cur_OfficialRate',
            type: 'int',
        ),
    ],
    type: 'object',
)]
final class Currencies extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    public $timestamps = ['created_at'];

    protected $fillable = [
        'cur_id',
        'cur_abbreviation',
        'cur_scale',
        'cur_name',
        'cur_official_rate',
        'created_at',
    ];

    protected $hidden = ['id'];

    /**
     * @return array{
     *     Cur_ID: int,
     *     Date: string,
     *     Cur_Abbreviation: string,
     *     Cur_Scale: int,
     *     Cur_Name: string,
     *     Cur_OfficialRate: float,
     * }
     */
    public function toArray(): array
    {
        return [
            'Cur_ID' => $this->cur_id,
            'Date' => $this->created_at,
            'Cur_Abbreviation' => $this->cur_abbreviation,
            'Cur_Scale' => $this->cur_scale,
            'Cur_Name' => $this->cur_name,
            'Cur_OfficialRate' => $this->cur_official_rate,
        ];
    }
    public function getAllRecords(): Collection
    {
        return $this->orderBy('created_at', 'desc')->get();
    }

    public function getRecordForDay(Carbon $day): Collection
    {
        return $this->whereDate('created_at', $day)->get();
    }
}
