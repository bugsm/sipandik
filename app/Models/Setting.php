<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'description',
    ];

    /**
     * Get the setting value with proper type casting
     */
    public function getTypedValueAttribute()
    {
        return match($this->type) {
            'integer' => (int) $this->value,
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($this->value, true),
            'array' => json_decode($this->value, true),
            default => $this->value,
        };
    }

    /**
     * Set the value with proper type handling
     */
    public function setTypedValue($value): void
    {
        $this->value = match($this->type) {
            'boolean' => $value ? 'true' : 'false',
            'json', 'array' => json_encode($value),
            default => (string) $value,
        };
    }

    /**
     * Scope for filtering by group
     */
    public function scopeGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Get setting value by key
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        return $setting ? $setting->typed_value : $default;
    }

    /**
     * Set setting value by key
     */
    public static function setValue(string $key, $value): void
    {
        $setting = self::where('key', $key)->first();
        
        if ($setting) {
            $setting->setTypedValue($value);
            $setting->save();
        }
    }

    /**
     * Get all settings as array
     */
    public static function getAllSettings(?string $group = null): array
    {
        $query = self::query();
        
        if ($group) {
            $query->where('group', $group);
        }
        
        return $query->pluck('value', 'key')->toArray();
    }
}
