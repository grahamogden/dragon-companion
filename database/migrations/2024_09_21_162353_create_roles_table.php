<?php

use App\Enums\RolePermissionEnum;
use App\Models\Campaign;
use App\Models\Role;
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
        Schema::create(table: Role::TABLE_NAME, callback: function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->string(column: Role::FIELD_NAME, length: 250);

            $table->foreignIdFor(model: Campaign::class)
                ->index()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::create(table: RolePermission::TABLE_NAME, callback: function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(model: Role::class)
                ->index()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
            $table->tinyInteger(
                column: RolePermission::FIELD_CAMPAIGN_PERMISSIONS,
                unsigned: true,
            )
                ->comment(comment: '[bitwise] deny:0,read:1,write:2,delete:4. For example, 3 means the role has read + write permissions but not delete. 5 Would mean read + delete but not write. 7 means that the role has read + write + delete permissions.')
                ->default(value: RolePermissionEnum::Deny);
        });

        Schema::create(table: Role::PIVOT_TABLE_ROLE_USER, callback: function (Blueprint $table): void {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(model: Role::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(model: User::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: Role::PIVOT_TABLE_ROLE_USER);
        Schema::dropIfExists(table: RolePermission::TABLE_NAME);
        Schema::dropIfExists(table: Role::TABLE_NAME);
    }
};
