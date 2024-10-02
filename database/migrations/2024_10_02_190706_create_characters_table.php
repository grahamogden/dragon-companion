<?php

use App\Enums\RolePermissionEnum;
use App\Models\Campaign;
use App\Models\Character;
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
        Schema::create(table: Character::TABLE_NAME, callback: function (Blueprint $table): void {
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
            $table->string(column: Character::FIELD_NAME, length: 250)
                ->index();
            $table->integer(column: Character::FIELD_AGE)
                ->nullable()
                ->default(value: null);
            $table->smallInteger(column: Character::FIELD_MAX_HIT_POINTS)
                ->nullable()
                ->default(value: null);
            $table->tinyInteger(column: Character::FIELD_ARMOUR_CLASS)
                ->nullable()
                ->default(value: null);
            $table->tinyInteger(column: Character::FIELD_DEXTERITY_MODIFIER)
                ->nullable()
                ->default(value: null);
            $table->text(column: Character::FIELD_APPEARANCE)
                ->nullable()
                ->default(value: null);
            $table->text(column: Character::FIELD_NOTES)
                ->nullable()
                ->default(value: null);
        });

        Schema::table(table: RolePermission::TABLE_NAME, callback: function (Blueprint $table): void {
            $table->tinyInteger(
                column: RolePermission::FIELD_CHARACTER_PERMISSIONS,
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
                RolePermission::FIELD_CHARACTER_PERMISSIONS,
            ]
        );
        Schema::dropIfExists(table: Character::TABLE_NAME);
    }
};
