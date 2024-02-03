<?php

namespace Benaaacademy\Roles;

use Auth;
use Navigation;
use URL;

class Roles extends \Benaaacademy\Platform\Plugin
{

    protected $route_middlewares = [
        'role' => \Benaaacademy\Roles\Middlewares\RoleMiddleware::class,
        'permission' => \Benaaacademy\Roles\Middlewares\PermissionMiddleware::class
    ];

    function boot()
    {

        parent::boot();

        // Roles for superadmins only

        $this->gate->define("roles.manage", function ($user, $profile = false) {
            if($profile){
                return $user->hasRole("superadmin") and $user->id != $profile->id;
            }else{
                return $user->hasRole("superadmin");
            }
        });

        Navigation::menu("sidebar", function ($menu) {
            if (Auth::user()->hasRole('superadmin')) {
                $menu->item('permissions', trans("admin::common.permissions"), route("admin.roles.show"))->icon("fa-unlock-alt")->order(17);
            }
        });
    }
}
