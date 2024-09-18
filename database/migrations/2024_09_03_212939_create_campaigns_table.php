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
            $table->string(column: 'name', length: 250);
            $table->text(column: 'synopsis')->nullable()->default(value: null);
            $table->unsignedBigInteger(column: 'user_id');

            $table->foreign(columns: 'user_id')
                ->references(columns: 'id')
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
