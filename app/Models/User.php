<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Role constants
     */
    const ROLE_ADMIN = 1;
    const ROLE_WAITER = 2;
    const ROLE_CHEF = 3;
    const ROLE_CUSTOMER = 4;

    /**
     * Role names for display
     */
    const ROLE_NAMES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_WAITER => 'Waiter',
        self::ROLE_CHEF => 'Chef',
        self::ROLE_CUSTOMER => 'Customer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function users(){
        return $this->hasMany(User::class,'user_id');
    }

    public function categories(){
        return $this->hasMany(Category::class,'user_id');
    }

    public function subCategory(){
        return $this->hasMany(subCategory::class,'user_id');
    }
    
    public function foods(){
        return $this->hasMany(Food::class,'user_id');
    }

    public function tables(){
        return $this->hasMany(Table::class,'user_id');
    }

    public function reservations(){
        return $this->hasMany(Reservation::class,'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Role check methods
    public function isAdmin(){
        return $this->role == self::ROLE_ADMIN;
    }

    public function isWaiter(){
        return $this->role == self::ROLE_WAITER;
    }

    public function isChef(){
        return $this->role == self::ROLE_CHEF;
    }

    public function isCustomer(){
        return $this->role == self::ROLE_CUSTOMER;
    }

    // Alias for backward compatibility
    public function isServer(){
        return $this->isWaiter();
    }

    /**
     * Get the role name
     */
    public function getRoleNameAttribute(){
        return self::ROLE_NAMES[$this->role] ?? 'Unknown';
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasRole(...$roles){
        return in_array($this->role, $roles);
    }
}
