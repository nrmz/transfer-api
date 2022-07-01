<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function depositTransactions()
    {
        return $this->hasManyDeep(Transaction::class, [Account::class, Card::class], [
            'user_id','account_id', 'destination_card_id'
        ]);
    }

    public function withdrawTransactions()
    {
        return $this->hasManyDeep(Transaction::class, [Account::class, Card::class], [
            'user_id','account_id', 'source_card_id'
        ]);
    }

}
