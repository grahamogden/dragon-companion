<?php

use App\Enums\RolePermissionEnum;
use App\Models\Campaign;
use App\Models\Item;
use App\Models\RolePermission;
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
        Schema::create(table: Item::TABLE_NAME, callback: function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(model: Campaign::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(model: User::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string(column: Item::FIELD_NAME, length: 250)
                ->index();
            $table->text(column: Item::FIELD_DESCRIPTION)
                ->nullable()
                ->default(value: null);
        });

        Schema::table(table: RolePermission::TABLE_NAME, callback: function (Blueprint $table): void {
            $table->tinyInteger(
                column: RolePermission::FIELD_ITEM_PERMISSIONS,
                unsigned: true,
            )
                ->comment(comment: '[bitwise] deny:0,read:1,write:2,delete:4. For example, 3 means the role has read + write permissions but not delete. 5 Would mean read + delete but not write. 7 means that the role has read + write + delete permissions.')
                ->default(value: RolePermissionEnum::Deny);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns(
            table: RolePermission::TABLE_NAME,
            columns: [
                RolePermission::FIELD_ITEM_PERMISSIONS,
            ]
        );
        Schema::dropIfExists(table: Item::TABLE_NAME);
    }
};
