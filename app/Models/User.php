<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user'; // указываем название таблицы

    protected $primaryKey = 'id_user'; //указываем первичный ключ

    public $timestamps = false; // использовать ли created_at и updated_at в таблице, по умолчанию true, если у вас нету эти полей в базе то ставьте на false

    protected $fillable = [ // перечисляем поля нашей таблицы
        'id_user',
        'id_role',
        'name',
        'surname',
        'patronymic',
        'login',
        'email',
        'phone',
        'password',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [ // перечисляем поля нашей таблицы, которые будут скрыты для фронта, т.е. если вы попытаетесь вывести данные на страницу то поле password не будет на странице, но внутри приложения на сервере он будет доступен
        'password',
    ];

    // проверка на админа
    public function isAdmin() {
        if ($this->id_role === 2) return true;
        return false;
    }
}
