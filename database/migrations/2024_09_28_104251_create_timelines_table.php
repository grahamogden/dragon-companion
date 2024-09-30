<?php

use App\Models\Campaign;
use App\Models\RolePermission;
use App\Models\Timeline;
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
        Schema::create(table: Timeline::TABLE_NAME, callback: function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(model: Campaign::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->bigInteger(column: Timeline::FIELD_PARENT_ID)
                ->unsigned()
                ->nullable();
            // $table->integer(column: Timeline::FIELD_DEPTH)
            //     ->unsigned()
            //     ->nullable();
            // $table->integer(column: Timeline::FIELD_PATH)
            //     ->unsigned()
            //     ->nullable();
            $table->string(column: Timeline::FIELD_NAME, length: 250);
            $table->text(column: Timeline::FIELD_DESCRIPTION)
                ->nullable()
                ->default(value: null);
            $table->foreignIdFor(model: User::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table(table: RolePermission::TABLE_NAME, callback: function (Blueprint $table): void {
            $table->tinyInteger(
                column: RolePermission::FIELD_TIMELINE_PERMISSIONS,
                unsigned: true,
            )
                ->comment(comment: '[bitwise] deny:0,read:1,write:2,delete:4. For example, 3 means the role has read + write permissions but not delete. 5 Would mean read + delete but not write. 7 means that the role has read + write + delete permissions.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: Timeline::TABLE_NAME);
        Schema::dropColumns(
            table: RolePermission::TABLE_NAME,
            columns: [
                RolePermission::FIELD_TIMELINE_PERMISSIONS,
            ]
        );
    }
};
