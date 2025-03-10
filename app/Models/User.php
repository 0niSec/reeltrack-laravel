<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'username_last_changed_at',
        'email_verified_at',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
    // End Relationships

    //region Helpers
// Helpers
    public function getRouteKeyName(): string
    {
        return 'username';
    }

    /**
     * Retrieve all reviews associated with the given model.
     *
     * @param  Model  $model  The model for which reviews are being fetched.
     * @return ?Collection A collection of reviews for the specified model, or null if none exists.
     */
    public function getReviewsFor(Model $model): ?Collection
    {
        return $this->reviews()
            ->where('reviewable_type', $model->getMorphClass())
            ->where('reviewable_id', $model->getKey())
            ->get();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function hasReviews(): bool
    {
        return $this->reviews()->exists();
    }
    //endregion

    //region Model Relationships

    /**
     * Get the current review for a specific reviewable model.
     */
    public function getCurrentReviewFor(Model $model): ?Review
    {
        return $this->reviews()
            ->where('reviewable_type', $model->getMorphClass())
            ->where('reviewable_id', $model->getKey())
            ->latest()
            ->first();
    }

    /**
     * Check if user has reviewed a specific model.
     */
    public function hasReviewedModel(Model $model): bool
    {
        return $this->reviews()
            ->where('reviewable_type', $model->getMorphClass())
            ->where('reviewable_id', $model->getKey())
            ->exists();
    }

    public function getIntreactionsFor(Model $model): Collection
    {
        return $this->userInteractions()
            ->where('interactable_type', $model->getMorphClass())
            ->where('interactable_id', $model->getKey())
            ->get();
    }

    public function userInteractions(): HasMany
    {
        return $this->hasMany(UserInteraction::class, 'user_id');
    }

// End Helpers

    public function reelEntries(): HasMany
    {
        return $this->hasMany(ReelEntry::class, 'user_id');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'user_id');
    }
    //endregion

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'username_last_changed_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
