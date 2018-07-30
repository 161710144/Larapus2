<?php

namespace App;

use App\Book;
use App\BorrowLog;
use App\Exceptions\BookException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function borrow(Book $book)
    {
        // return $this->HasMany('App\BorrowLog','user_id');
    // cek apakah buku ini sedang dipinjam oleh user
    if($this->borrowLogs()->where('book_id',$book->id)->where('is_returned', 0)->count() > 0 ) {
    throw new BookException("Buku $book->title sedang Anda pinjam.");
    }
    $borrowLog = BorrowLog::create(['user_id'=>$this->id, 'book_id'=>$book->id]);
    return $borrowLog;
    }
    public function borrowLogs()
    {
    return $this->hasMany('App\BorrowLog');
    }


    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
