<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("canteens", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug")->unique();
            $table->text("description")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("tenants", function (Blueprint $table) {
            $table->id();
            $table->foreignId("canteen_id")->constrained("canteens")->cascadeOnDelete();
            $table->string("name");
            $table->string("slug");
            $table->boolean("is_active")->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(["canteen_id", "slug"]);
        });

        Schema::create("users", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email")->unique();
            $table->timestamp("email_verified_at")->nullable();
            $table->string("password");
            $table->string("role")->default("tenant_owner");
            $table->string("status")->default("active");
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create("password_reset_tokens", function (Blueprint $table) {
            $table->string("email")->primary();
            $table->string("token");
            $table->timestamp("created_at")->nullable();
        });

        Schema::create("tenant_users", function (Blueprint $table) {
            $table->foreignId("tenant_id")->constrained("tenants")->cascadeOnDelete();
            $table->foreignId("user_id")->constrained("users")->cascadeOnDelete();
            $table->string("role_in_tenant")->default("staff");
            $table->timestamps();
            $table->primary(["tenant_id", "user_id"]);
        });

        Schema::create("tenant_balances", function (Blueprint $table) {
            $table->foreignId("tenant_id")->primary()->constrained("tenants")->cascadeOnDelete();
            $table->bigInteger("current_balance")->default(0);
            $table->bigInteger("pending_clearance")->default(0);
            $table->timestamps();
        });

        Schema::create("tenant_bank_accounts", function (Blueprint $table) {
            $table->id();
            $table->foreignId("tenant_id")->constrained("tenants")->cascadeOnDelete();
            $table->string("bank_code");
            $table->string("account_number");
            $table->string("account_holder");
            $table->boolean("is_verified")->default(false);
            $table->timestamps();
        });

        Schema::create("withdrawal_requests", function (Blueprint $table) {
            $table->id();
            $table->foreignId("tenant_id")->constrained("tenants")->cascadeOnDelete();
            $table->foreignId("bank_account_id")->constrained("tenant_bank_accounts");
            $table->bigInteger("amount");
            $table->string("status")->default("pending");
            $table->text("rejection_reason")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists("withdrawal_requests");
        Schema::dropIfExists("tenant_bank_accounts");
        Schema::dropIfExists("tenant_balances");
        Schema::dropIfExists("tenant_users");
        Schema::dropIfExists("password_reset_tokens");
        Schema::dropIfExists("users");
        Schema::dropIfExists("tenants");
        Schema::dropIfExists("canteens");
    }
};
