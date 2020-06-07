<?php

use Alive2212\LaravelMobilePassport\AliveMobilePassportRole;
use App\Tag;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{

    protected $texts = [
        [
            'uuid' =>'eejdn21' ,
            'speech_text'=> 'من تمایل به ساخت حساب دارم',
            'active'=> 1,
            'weight'=>0
        ],
        [
            'uuid' => 'eejdan2',
            'speech_text'=>'سلام وقتتون بخیر',
            'active'=> 1,
            'weight'=>0
        ],
    ];

    protected $tags = [
        [
            'key'=>'sign',
            'title'=>'sign',
            'description'=>'sign image',
            'active'=>1
        ],
        [
            'key'=>'card',
            'title'=>'card',
            'description'=>'card image',
            'active'=>1
        ],
        [
            'key'=>'registration',
            'title'=>'registration',
            'description'=>'registration',
            'active'=>1
        ],
        [
            'key'=>'video',
            'title'=>'video',
            'description'=>'video',
            'active'=>1
        ],
    ];

    protected $role = [
        'author_id'=>1,
        "title" => 'customer',
        'subtitle'=>'customer',
        'description'=> 'customer',
        'level' =>1,
        'is_otp'=>1,
        'revoked'=>0
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert($this->tags);
        DB::table('speech_texts')->insert($this->texts);

        $user = (new User())->firstOrCreate(
            [
                'country_code' => '+98',
                'card_number' =>'0022825029',
                'phone_number' => '9216042179',
                'email' =>'ali.salimiansas2@gmail.com',
                'password' => 'salimian'
            ]
        );
        $role = new AliveMobilePassportRole;
        $role->author_id=1;
        $role->title ='customer';
        $role->subtitle ='customer';
        $role-> description= 'customer';
        $role->level =1;
        $role->is_otp = 1;
        $role->revoked=0;

        $user->roles()->save($role);
    }
}
