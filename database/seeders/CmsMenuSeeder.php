<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CmsMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::submasterMenu();
    }

    public function submasterMenu() {

        $this->command->info('Please wait updating the data...');
        DB::table('cms_menus')->updateOrInsert(
            [
                'name'              => 'Submaster',
            ],
            [
                'name'              => 'Submaster',
                'type'              => 'URL',
                'path'              => '#',
                'color'             => 'normal',
                'icon'              => 'fa fa-list',
                'parent_id'         => 0,
                'is_active'         => 1,
                'is_dashboard'      => 0,
                'id_cms_privileges' => 1,
                'sorting'           => 100
            ]
        );
        $submaster = DB::table('cms_menus')->where('name','Submaster')->first();
        $data = [
            [
                'name' => 'Store',
                'type' => 'Route',
                'path' => 'AdminCompanyStoresControllerGetIndex',
                'parent_id' => $submaster->id,
                'sorting' => 1
            ],
            [
                'name' => 'Store Access',
                'type' => 'Route',
                'path' => 'AdminPrivilegeStoreAccessesControllerGetIndex',
                'parent_id' => $submaster->id,
                'sorting' => 2
            ],
            [
                'name' => 'User Folders',
                'type' => 'Route',
                'path' => 'AdminUserFoldersControllerGetIndex',
                'parent_id' => $submaster->id,
                'sorting' => 3
            ],
        ];

        foreach ($data as $k => $d) {
            $data[$k] += [
                'created_at' => date('Y-m-d H:i:s'),
                'type' => 'Route',
                'icon' => 'fa fa-circle-o',
                'is_dashboard' => 0,
                'is_active' => 1,
                'id_cms_privileges' => 1,
            ];

            if (DB::table('cms_menus')->where('name', $d['name'])->count()) {
                unset($data[$k]);
            }
        }

        DB::table('cms_menus')->insert($data);

        $this->command->info("Create menu completed");
    }
}
