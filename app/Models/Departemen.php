<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Departemen extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'departemen';

    protected $fillable = ['kode', 'nama'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('departemen')
            ->setDescriptionForEvent(fn (string $eventName) => "Departemen {$this->nama} {$eventName}");
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class);
    }
}
