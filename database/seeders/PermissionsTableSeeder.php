<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 60,
                'title' => 'documents_management_access',
            ],
            [
                'id'    => 61,
                'title' => 'document_type_create',
            ],
            [
                'id'    => 62,
                'title' => 'document_type_edit',
            ],
            [
                'id'    => 63,
                'title' => 'document_type_show',
            ],
            [
                'id'    => 64,
                'title' => 'document_type_delete',
            ],
            [
                'id'    => 65,
                'title' => 'document_type_access',
            ],
            [
                'id'    => 66,
                'title' => 'document_create',
            ],
            [
                'id'    => 67,
                'title' => 'document_edit',
            ],
            [
                'id'    => 68,
                'title' => 'document_show',
            ],
            [
                'id'    => 69,
                'title' => 'document_delete',
            ],
            [
                'id'    => 70,
                'title' => 'document_access',
            ],
            [
                'id'    => 71,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
