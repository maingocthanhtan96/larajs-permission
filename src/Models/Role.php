<?php

namespace LaraJS\Permission\Models;

use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use LaraJS\Permission\Enums\RoleEnum;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    /**
     * Check whether current role is admin
     */
    public function isAdmin(): bool
    {
        return $this->name === RoleEnum::ADMIN->name;
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return RoleFactory::new();
    }
}
