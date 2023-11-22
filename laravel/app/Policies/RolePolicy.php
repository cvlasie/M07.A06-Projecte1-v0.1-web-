<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        // Altres policies...
    ];
    
    public function boot()
    {
        $this->registerPolicies();
    
        // ...
    }
}
