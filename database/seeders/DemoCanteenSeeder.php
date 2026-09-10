<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Canteen;
use App\Models\Tenant;
use App\Models\User;
use App\Models\DiningTable;
use App\Models\MenuCategory;
use App\Models\Menu;
use App\Models\ModifierGroup;
use App\Models\CommissionScheme;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DemoCanteenSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $canteen = Canteen::firstOrCreate(
                ["slug" => "kantin-utama"],
                ["name" => "Kantin Utama Kampus", "description" => "Pusat kuliner mahasiswa"]
            );

            $tenantA = Tenant::firstOrCreate(
                ["canteen_id" => $canteen->id, "slug" => "warung-berkah"],
                ["name" => "Warung Berkah", "is_active" => true]
            );

            $tenantB = Tenant::firstOrCreate(
                ["canteen_id" => $canteen->id, "slug" => "kedai-kopi-senja"],
                ["name" => "Kedai Kopi Senja", "is_active" => true]
            );

            $user = User::firstOrCreate(
                ["email" => "owner@kantin.com"],
                [
                    "name" => "Pemilik Stand",
                    "password" => Hash::make("password123"),
                    "role" => "tenant_owner",
                    "status" => "active"
                ]
            );

            DB::table("tenant_users")->updateOrInsert(
                ["tenant_id" => $tenantA->id, "user_id" => $user->id],
                ["role_in_tenant" => "owner", "created_at" => now(), "updated_at" => now()]
            );

            for ($i = 1; $i <= 5; $i++) {
                DiningTable::firstOrCreate([
                    "canteen_id" => $canteen->id,
                    "table_number" => "M-" . sprintf("%02d", $i)
                ]);
            }

            $category = MenuCategory::firstOrCreate([
                "tenant_id" => $tenantA->id,
                "name" => "Makanan Berat"
            ]);

            $menu = Menu::firstOrCreate(
                ["tenant_id" => $tenantA->id, "name" => "Nasi Goreng Spesial"],
                [
                    "category_id" => $category->id,
                    "price_amount" => 18000,
                    "is_available" => true
                ]
            );

            ModifierGroup::firstOrCreate([
                "tenant_id" => $tenantA->id,
                "menu_id" => $menu->id,
                "name" => "Extra Telur Mata Sapi"
            ], [
                "price_delta" => 4000
            ]);

            CommissionScheme::firstOrCreate([
                "tenant_id" => $tenantA->id,
                "rate_percentage" => 10.00
            ], [
                "effective_from" => now(),
                "effective_to" => null
            ]);
        });
    }
}
