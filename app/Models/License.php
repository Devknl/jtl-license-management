<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="License",
 *     type="object",
 *     title="License",
 *     description="Lizenz Modell",
 *     required={"license_key", "customer_name", "product_name", "valid_until", "license_type"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Eindeutige ID der Lizenz",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="license_key",
 *         type="string",
 *         description="Lizenzschlüssel im Format JTL-XXX-12345",
 *         example="JTL-DEMO-12345",
 *         maxLength=20
 *     ),
 *     @OA\Property(
 *         property="customer_name",
 *         type="string",
 *         description="Name des Kunden",
 *         example="Mustermann GmbH",
 *         maxLength=100
 *     ),
 *     @OA\Property(
 *         property="product_name",
 *         type="string",
 *         description="Name des Produkts",
 *         example="JTL-Warenwirtschaft",
 *         maxLength=50
 *     ),
 *     @OA\Property(
 *         property="license_type",
 *         type="string",
 *         description="Typ der Lizenz",
 *         enum={"perpetual", "subscription"},
 *         example="subscription"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Aktueller Status der Lizenz",
 *         enum={"active", "expired", "suspended"},
 *         example="active"
 *     ),
 *     @OA\Property(
 *         property="valid_until",
 *         type="string",
 *         format="date",
 *         description="Gültigkeitsdatum der Lizenz",
 *         example="2024-12-31"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Erstellungsdatum",
 *         example="2024-01-01T12:00:00.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Letztes Aktualisierungsdatum",
 *         example="2024-01-01T12:00:00.000000Z"
 *     )
 * )
 */
class License extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'license_key',
        'customer_name',
        'product_name',
        'valid_until',
        'status',
        'license_type'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'valid_until' => 'date',
    ];

    /**
     * Scope a query to only include active licenses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include expired licenses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /**
     * Scope a query to only include subscription licenses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubscription($query)
    {
        return $query->where('license_type', 'subscription');
    }

    /**
     * Scope a query to only include perpetual licenses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePerpetual($query)
    {
        return $query->where('license_type', 'perpetual');
    }

    /**
     * Scope a query to only include licenses expiring soon.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('valid_until', '<=', now()->addDays($days))
                     ->where('status', 'active');
    }

    /**
     * Check if the license is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->valid_until->isPast() || $this->status === 'expired';
    }

    /**
     * Check if the license is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'active' && !$this->isExpired();
    }

    /**
     * Get the remaining days until expiration.
     *
     * @return int
     */
    public function getDaysRemainingAttribute()
    {
        if ($this->isExpired()) {
            return 0;
        }

        return now()->diffInDays($this->valid_until, false);
    }

    /**
     * Automatically update status if license is expired.
     *
     * @return void
     */
    public function updateStatusIfExpired()
    {
        if ($this->valid_until->isPast() && $this->status !== 'expired') {
            $this->update(['status' => 'expired']);
        }
    }
}