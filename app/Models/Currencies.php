<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $cur_id
 * @property string $created_at
 * @property string $cur_abbreviation
 * @property int $cur_scale
 * @property string $cur_name
 * @property float $cur_official_rate
 */
final class Currencies extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    public $timestamps = ['created_at'];

    protected $fillable = [
        'cur_id',
        'cur_official_rate',
    ];

    protected $hidden = ['id'];

    protected $appends = ['abbreviation', 'scale', 'name'];

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
            'Cur_Abbreviation' => $this->getAbbreviationAttribute(),
            'Cur_Scale' => $this->getScaleAttribute(),
            'Cur_Name' => $this->getNameAttribute(),
            'Cur_OfficialRate' => $this->cur_official_rate,
        ];
    }

    private function getAbbreviationAttribute(): ?string
    {
        $config = config('currency');

        return array_key_exists($this->cur_id, $config) ? $config[$this->cur_id]['abbreviation'] : null;
    }

    private function getScaleAttribute(): ?int
    {
        $config = config('currency');

        return array_key_exists($this->cur_id, $config) ? $config[$this->cur_id]['scale'] : null;
    }

    private function getNameAttribute(): ?string
    {
        $config = config('currency');

        return array_key_exists($this->cur_id, $config) ? $config[$this->cur_id]['name'] : null;
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
