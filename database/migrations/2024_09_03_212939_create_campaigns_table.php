<?php

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(table: Campaign::TABLE_NAME, callback: function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->string(column: Campaign::FIELD_NAME, length: 250);
            $table->text(column: Campaign::FIELD_SYNOPSIS)->nullable()->default(value: null);
            $table->unsignedBigInteger(column: Campaign::FIELD_USER_ID);

            $table->foreign(columns: Campaign::FIELD_USER_ID)
                ->references(columns: User::FIELD_ID)
                ->on(table: User::TABLE_NAME)
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: Campaign::TABLE_NAME);
    }
};
