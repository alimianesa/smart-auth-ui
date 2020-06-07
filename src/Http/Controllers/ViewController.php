<?php

namespace Alimianesa\SmartAuth\Http\Controllers;

use Alimianesa\SmartAuth\Controllers\ValidateUserController;
use Alive2212\LaravelMobilePassport\Http\Controllers\MobilePassportAuthController;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ViewController extends Controller
{
    protected $tokenValidator = [
        'token' => 'required|max:4|min:4'
    ];
    // Auth
    public function register()
    {
        return view('register');
    }

    public function requestRegister(Request $request)
    {
        Cache::put('phone_number', $request->phone_number);
        Cache::put('card_number', $request->card_number);

        $validateUser = new ValidateUserController;
        $validateUser->phoneCard($request);
        return redirect('/token');
    }


    public function token()
    {
        return view('token');
    }

    public function requestToken(Request $request)
    {
        $request->validate($this->tokenValidator);
        $request->request->add([
            'phone_number' => Cache::get('phone_number'),
            'country_code' => '+98'
        ]);
        $auth =new MobilePassportAuthController;
        $auth->confirmOtp($request);
        $user = User::where('phone_number' , Cache::get('phone_number'))
            ->where('card_number' , Cache::get('card_number'))
            ->latest()->first();

        auth()->loginUsingId($user->id);
        return redirect('password');
    }

    public function password()
    {
        return view('password');
    }

    public function requestPassword(Request $request)
    {
        $validateUser = new ValidateUserController;
        $validateUser->setPassword($request);
        return redirect('pics');
    }

    // Photos
    public function pics()
    {
        return view('sendPics');
    }

    public function requestPics(Request $request)
    {
        $fileController = new ImageController();
        $response = $fileController->store($request);
        return redirect('video');
    }

    // Get Text and send video
    public function text()
    {
        $text = new ValidateVideoController;
        $response = $text->getText();
        if (isset($response->getData()->results->speech_text)) {
            $speechText = $response->getData()->results->speech_text;
            return view('getText', compact('speechText'));
        }
        return redirect('pics');
    }

    // Validate Video
    public function video(Request $request)
    {
        $video = new ValidateVideoController;
        $video->videoValidation($request);
        return redirect('done');
    }

    // Done Message
    public function done()
    {
        return view('done');
    }

}
