<?php

namespace App\Models;

use Spatie\Permission\Models\Role as RoleModel;


class Role extends RoleModel
{

    public  $guard_name = 'admin';
    protected $hidden = ['pivot'];


}