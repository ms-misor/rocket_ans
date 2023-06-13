<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Permission\Entities\Permission;
use Modules\Role\Entities\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'General'                => [

            ],
            'User'                   => [
                'user_management',
                'role_management',
                'permission_management',
            ],
            'Template Configuration' => [
                'template_category_management',
                'template_management',
                'template_print_setup_management',
            ],
            'Dashboard'              => [
                'overall_count_report',
            ],
            'Open Ai Configuration'  => [
                'openai_language_management',
                'openai_resolution_management',
                'openai_tone_management',
                'openai_creativity_level_management',
                'openai_model_management',
            ],
            'Open Ai'                => [
                'template_list',
                'openai_image_generate_management',
                'openai_image_editor_management',
            ],
            'Document'               => [
                'workbook_management',
                'document_management',
            ],
            'Setting'                => [
                'setting_management',
                'mail_setting_management',
                'recaptcha_setting_management',
                'openai_setting_management',
                'module_setting_management',
                'env_setting_management',
                'language_setting_management',
            ],
            'Backup'                 => [
                'backup_management',
            ],
        ];
        $roles       = [
            'User' => [
                'template_print_setup_management',
                'template_list',
                'openai_image_generate_management',
                'openai_image_editor_management',
                'workbook_management',
                'document_management',

            ],
        ];

        $administrator = Role::create(['name' => 'Administrator']);
        foreach ($permissions as $group => $groups) {
            foreach ($groups as $permission) {
                Permission::create([
                    'name'  => $permission,
                    'group' => $group,
                ])->assignRole($administrator);
            }
        }
        foreach ($roles as $role => $permissions) {
            $role = Role::create(['name' => $role]);
            $role->givePermissionTo($permissions);
        }
        $users = [
            [
                'name'              => 'Admin',
                'email'             => 'admin@gmail.com',
                'password'          => Hash::make('admin'),
                'email_verified_at' => now(),
                'status'            => 'Active',
            ], [
                'name'              => 'User',
                'email'             => 'user@gmail.com',
                'password'          => Hash::make('user'),
                'email_verified_at' => now(),
                'status'            => 'Active',
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
        User::find(1)->assignRole('Administrator');
        User::find(2)->assignRole('User');
    }
}