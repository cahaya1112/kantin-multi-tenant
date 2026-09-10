<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("categories", function (Blueprint $table) {
            $table->id();
            $table->foreignId("tenant_id")->constrained("tenants")->cascadeOnDelete();
            $table->string("name");
            $table->timestamps();
        });

        Schema::create("menus", function (Blueprint $table) {
            $table->id();
            $table->foreignId("tenant_id")->constrained("tenants")->cascadeOnDelete();
            $table->foreignId("category_id")->constrained("categories")->cascadeOnDelete();
            $table->string("name");
            $table->text("description")->nullable();
            $table->bigInteger("price_amount");
            $table->boolean("is_available")->default(true);
            $table->timestamps();

            $table->unique(["tenant_id", "id"]);
            $table->index(["tenant_id", "is_available"]); // Index Query Katalog/KDS
        });

        Schema::create("menu_modifiers", function (Blueprint $table) {
            $table->id();
            $table->foreignId("tenant_id")->constrained("tenants")->cascadeOnDelete();
            $table->foreignId("menu_id");
            $table->string("name");
            $table->bigInteger("price_delta")->default(0);
            $table->timestamps();

            // Composite FK: Memastikan modifier terikat pada tenant_id & menu_id yang sama
            $table->foreign(["tenant_id", "menu_id"])
                  ->references(["tenant_id", "id"])
                  ->on("menus")
                  ->cascadeOnDelete();
        });

        Schema::create("menu_stocks", function (Blueprint $table) {
            $table->foreignId("menu_id")->primary()->constrained("menus")->cascadeOnDelete();
            $table->integer("stock_quantity")->default(0);
            $table->boolean("is_unlimited")->default(true);
            $table->timestamps();
        });

        Schema::create("tenant_commissions", function (Blueprint $table) {
            $table->id();
            $table->foreignId("tenant_id")->constrained("tenants")->cascadeOnDelete();
            $table->decimal("rate_percentage", 5, 2);
            $table->timestamp("effective_from")->useCurrent();
            $table->timestamp("effective_to")->nullable();
            $table->timestamps();

            $table->index(["tenant_id", "effective_from", "effective_to"]);
        });
    }

    public function down(): void {
        Schema::dropIfExists("tenant_commissions");
        Schema::dropIfExists("menu_stocks");
        Schema::dropIfExists("menu_modifiers");
        Schema::dropIfExists("menus");
        Schema::dropIfExists("categories");
    }
};
