<?php

namespace SON;

use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements TableInterface
{
    use Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_TEACHER = 2;
    const ROLE_STUDENT = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'enrolment'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function createFully($data){
       $password = str_random(6);
       $data['password'] = $password;
       parent::create($data + ['enrolment'=>str_random(6)]);

       self::assignEnrolment($user, self::ROLE_ADMIN);

       $user->save();
       return $user;
    }

    public static function assignEnrolment(User $user, $type){
        $types = [
            self::ROLE_ADMIN => 100000,
            self::ROLE_ADMIN => 400000,
            self::ROLE_ADMIN => 700000,
        ];
        $user->enrolment = $types[$type] + $user->id; //recebe o valor do array + o seu id
        return $user->enrolment;
    }

    public function getTableHeaders(){
        return ['ID', 'Nome', 'Email'];
    }

    public function getValueForHeader($header){
        switch($header){
            case 'ID':
                return $this->id;
            case 'Nome':
                return $this->name;
            case 'Email':
                return $this->email;
        }
    }
}
