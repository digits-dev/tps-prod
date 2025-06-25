<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CmsModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->command->info('Please wait updating the data...');
        $data = [
            [
                'name' => 'Stores',
                'path' => 'company_stores',
                'table_name' => 'company_stores',
                'controller' => 'AdminCompanyStoresController',
            ],
            [
                'name' => 'Store Access',
                'path' => 'privilege_store_accesses',
                'table_name' => 'privilege_store_accesses',
                'controller' => 'AdminPrivilegeStoreAccessesController',
            ],
            [
                'name' => 'User Folders',
                'path' => 'user_folders',
                'table_name' => 'user_folders',
                'controller' => 'AdminUserFoldersController',
            ],
        ];

        foreach ($data as $k => $d) {

            $data[$k] += [
                'created_at' => date('Y-m-d H:i:s'),
                'icon' => 'fa fa-circle-o',
                'is_protected' => 0,
                'is_active' => 1
            ];

            if (DB::table('cms_moduls')->where('name', $d['name'])->count()) {
                unset($data[$k]);
            }
        }

        DB::table('cms_moduls')->insert($data);

        $this->command->info("Create submaster modules completed");
    }
}
