<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("payments", function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id")->constrained("orders")->cascadeOnDelete();
            $table->string("idempotency_key")->unique(); // Idempotency Key
            $table->string("payment_method");
            $table->string("transaction_status")->default("pending");
            $table->bigInteger("gross_amount");
            $table->string("snap_token")->nullable();
            $table->timestamps();
        });

        Schema::create("payment_attempts", function (Blueprint $table) {
            $table->id();
            $table->foreignId("payment_id")->constrained("payments")->cascadeOnDelete();
            $table->string("attempt_reference")->unique();
            $table->string("status");
            $table->json("payload")->nullable();
            $table->timestamps();
        });

        Schema::create("payment_events", function (Blueprint $table) {
            $table->id();
            $table->foreignId("payment_id")->constrained("payments")->cascadeOnDelete();
            $table->string("event_type");
            $table->json("raw_response");
            $table->timestamps();
        });

        Schema::create("payment_refunds", function (Blueprint $table) {
            $table->id();
            $table->foreignId("payment_id")->constrained("payments")->cascadeOnDelete();
            $table->bigInteger("refund_amount");
            $table->string("reason");
            $table->string("status")->default("pending");
            $table->timestamps();
        });

        Schema::create("tenant_ledger_entries", function (Blueprint $table) {
            $table->id();
            $table->foreignId("tenant_id")->constrained("tenants")->cascadeOnDelete();
            $table->string("entry_type");
            $table->bigInteger("amount");
            $table->bigInteger("balance_after");
            $table->string("reference_id")->nullable();
            $table->timestamps();
        });

        Schema::create("outbox_events", function (Blueprint $table) {
            $table->id();
            $table->string("event_type");
            $table->text("payload");
            $table->timestamp("processed_at")->nullable();
            $table->timestamps();
        });

        Schema::create("notification_deliveries", function (Blueprint $table) {
            $table->id();
            $table->string("channel");
            $table->string("recipient");
            $table->text("content");
            $table->string("status")->default("pending");
            $table->timestamps();
        });

        Schema::create("audit_logs", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained("users")->nullOnDelete();
            $table->string("action");
            $table->string("entity_type");
            $table->string("entity_id");
            $table->text("old_values")->nullable();
            $table->text("new_values")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists("audit_logs");
        Schema::dropIfExists("notification_deliveries");
        Schema::dropIfExists("outbox_events");
        Schema::dropIfExists("tenant_ledger_entries");
        Schema::dropIfExists("payment_refunds");
        Schema::dropIfExists("payment_events");
        Schema::dropIfExists("payment_attempts");
        Schema::dropIfExists("payments");
    }
};
