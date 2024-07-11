<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationRoles extends Model
{
    use HasFactory;
    protected $table = 'local_idm_table_with_users_and_roles';
}
