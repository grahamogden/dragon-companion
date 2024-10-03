<?php

use App\Enums\MonsterChallengeRating;
use App\Enums\MonsterSize;
use App\Enums\RolePermissionEnum;
use App\Models\Campaign;
use App\Models\Monster;
use App\Models\RolePermission;
use App\Models\Species;
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
        Schema::create(table: Monster::TABLE_NAME, callback: function (Blueprint $table): void {
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
            $table->string(column: Monster::FIELD_NAME, length: 250)
                ->index();
            $table->text(column: Monster::FIELD_DESCRIPTION)
                ->nullable()
                ->default(value: null);
            $table->enum(column: Monster::FIELD_SIZE, allowed: MonsterSize::values())
                ->default(value: MonsterSize::Unknown);
            $table->integer(column: Monster::FIELD_DEFAULT_HIT_POINTS)
                ->nullable()
                ->unsigned()
                ->default(value: null);
            $table->tinyInteger(column: Monster::FIELD_CALCULATED_HIT_POINTS_DICE_COUNT)
                ->nullable()
                ->unsigned()
                ->default(value: null);
            $table->tinyInteger(column: Monster::FIELD_CALCULATED_HIT_POINTS_DICE_TYPE)
                ->nullable()
                ->unsigned()
                ->default(value: null);
            $table->tinyInteger(column: Monster::FIELD_CALCULATED_HIT_POINTS_MODIFIER)
                ->nullable()
                ->unsigned()
                ->default(value: null);
            $table->tinyInteger(column: Monster::FIELD_ARMOUR_CLASS)
                ->nullable()
                ->default(value: null);
            $table->tinyInteger(column: Monster::FIELD_SPEED)
                ->nullable()
                ->default(value: null);
            $table->enum(column: Monster::FIELD_CHALLENGE_RATING, allowed: MonsterChallengeRating::values())
                ->nullable()
                ->default(value: null);
            $table->foreignIdFor(model: Species::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::table(table: RolePermission::TABLE_NAME, callback: function (Blueprint $table): void {
            $table->tinyInteger(
                column: RolePermission::FIELD_MONSTER_PERMISSIONS,
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
                RolePermission::FIELD_MONSTER_PERMISSIONS,
            ]
        );
        Schema::dropIfExists(table: Monster::TABLE_NAME);
    }
};
