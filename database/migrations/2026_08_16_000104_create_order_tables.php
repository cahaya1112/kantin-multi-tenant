<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Induk Checkout (Tanpa tenant_id)
        Schema::create("orders", function (Blueprint $table) {
            $table->id();
            $table->foreignId("canteen_id")->constrained("canteens")->cascadeOnDelete();
            $table->foreignId("customer_session_id")->constrained("customer_sessions")->cascadeOnDelete();
            $table->string("order_number")->unique();
            $table->bigInteger("total_amount");
            $table->string("status")->default("pending");
            $table->timestamps();
        });

        // Sub-order per Tenant (Tempat tenant_id & snapshot komisi)
        Schema::create("tenant_orders", function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id")->constrained("orders")->cascadeOnDelete();
            $table->foreignId("tenant_id")->constrained("tenants")->cascadeOnDelete();
            $table->bigInteger("subtotal");
            $table->decimal("commission_rate_snapshot", 5, 2);
            $table->bigInteger("commission_amount");
            $table->string("status")->default("pending");
            $table->timestamps();
        });

        Schema::create("order_items", function (Blueprint $table) {
            $table->id();
            $table->foreignId("tenant_order_id")->constrained("tenant_orders")->cascadeOnDelete();
            $table->foreignId("menu_id")->constrained("menus")->cascadeOnDelete();
            $table->integer("quantity");
            $table->bigInteger("unit_price");
            $table->bigInteger("subtotal");
            $table->timestamps();
        });

        Schema::create("order_item_modifiers", function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_item_id")->constrained("order_items")->cascadeOnDelete();
            $table->foreignId("menu_modifier_id")->constrained("menu_modifiers")->cascadeOnDelete();
            $table->bigInteger("price_delta");
            $table->timestamps();
        });

        Schema::create("order_state_histories", function (Blueprint $table) {
            $table->id();
            $table->foreignId("tenant_order_id")->constrained("tenant_orders")->cascadeOnDelete();
            $table->string("from_state")->nullable();
            $table->string("to_state");
            $table->text("note")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists("order_state_histories");
        Schema::dropIfExists("order_item_modifiers");
        Schema::dropIfExists("order_items");
        Schema::dropIfExists("tenant_orders");
        Schema::dropIfExists("orders");
    }
};
