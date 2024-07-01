<?php

declare(strict_types=1);

namespace Domains\Company\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    use HasFactory, HasUuids;

    /**
     * @return BelongsTo<Company, Branch>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
