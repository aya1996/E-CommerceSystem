<?php

namespace App\Models;


use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{

    public $guard_name = 'admin';

    protected $hidden = ['pivot'];

}