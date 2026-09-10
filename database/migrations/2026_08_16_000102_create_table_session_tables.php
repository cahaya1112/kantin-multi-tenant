<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("tables", function (Blueprint $table) {
            $table->id();
            $table->foreignId("canteen_id")->constrained("canteens")->cascadeOnDelete();
            $table->string("table_number");
            $table->timestamps();
            $table->unique(["canteen_id", "table_number"]);
        });

        Schema::create("table_qr_codes", function (Blueprint $table) {
            $table->id();
            $table->foreignId("table_id")->constrained("tables")->cascadeOnDelete();
            $table->binary("qr_code_hash", 32)->unique();
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });

        Schema::create("customer_sessions", function (Blueprint $table) {
            $table->id();
            $table->foreignId("canteen_id")->constrained("canteens")->cascadeOnDelete();
            $table->foreignId("table_id")->nullable()->constrained("tables")->nullOnDelete();
            $table->string("session_token")->unique();
            $table->timestamp("expires_at");
            $table->timestamps();
        });

        Schema::create("tenant_operating_hours", function (Blueprint $table) {
            $table->id();
            $table->foreignId("tenant_id")->constrained("tenants")->cascadeOnDelete();
            $table->unsignedTinyInteger("day_of_week");
            $table->time("open_time");
            $table->time("close_time");
            $table->boolean("is_closed")->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists("tenant_operating_hours");
        Schema::dropIfExists("customer_sessions");
        Schema::dropIfExists("table_qr_codes");
        Schema::dropIfExists("tables");
    }
};
