<?php

namespace Alimianesa\SmartAuth\Jobs;

use Alimianesa\SmartAuth\AliveFile;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VideoFaceRecognitionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $video;
    protected $registerFile;
    protected $percent;
    protected $speechPercent;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param $video
     */
    public function __construct(User $user , $video)
    {
        $this->video = $video;
        $this->user = $user;
        $this->percent = config('face-recognition.percent');
        $this->speechPercent = config('speech-recognition.percent');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('try to run Video Face & Sound Recognition Job');
        // TODO : refactor job
        // Find Files
        $files = $this->user->files()->with('tags')->get();

        // Find Registration Office Card Image
        $this->findImage($files, 'registration');

        // Speech Recognition
        $speechValidation = $this->speechValidation($this->video);
        if (!$speechValidation) {
            // Send Sms
            return;
        }
        $this->user->speech_verified_at = now();
        $this->user->save();

        // Validate Card Image and Video
        $faceRecognitionResponse = $this->validateCardImage($this->video , $this->registerFile);
        // Video Recognition
        $validate = $this->faceRecognitionPercent(preg_split ("/,/", $faceRecognitionResponse));

        if (!$validate){
            // Send Sms
            return;
        }

        Log::info('Video Successfully verified');
        // Complete Validation
        $this->user->video_verified_at = now();
        $this->user->save();
    }
    /**
     * @param AliveFile $video
     * @param AliveFile $registrationImage
     * @return bool|string|null
     */
    public function validateCardImage(AliveFile $video ,AliveFile $registrationImage)
    {
        if (!is_null($video) && !is_null($registrationImage)) {
            return shell_exec('cd vendor/alimianesa/smartauth/src/python && python3 project-video-face-recognition.py '.
                "\"../../../../../storage/app/{$video->uri}\"" .' '.
                "\"../../../../../storage/app/{$registrationImage->uri}\"");
        }
        return false;
    }

    /**
     * @param $files
     * @param $key
     *
     */
    public function findImage($files , $key)
    {
        foreach ($files as $file) {
            foreach ($file->tags as $tag) {
                if ($tag->key == $key) {
                    $this->registerFile = $file;
                }
            }
        }
    }

    /**
     * @param $faceRecognitionResponse
     * @return bool
     */
    public function faceRecognitionPercent($faceRecognitionResponse):bool
    {
        if (!isset($faceRecognitionResponse[0])
            or !isset($faceRecognitionResponse[1])
            or $faceRecognitionResponse[1]<10
        ) {
            return false;
        }

        // Validate OpenCV Response with predefined percent
        $responsePercent = ((int) $faceRecognitionResponse[1])*100/((int) $faceRecognitionResponse[0]);
        Log::info('python face recognition percent: '. $responsePercent);

        if ($responsePercent >= $this->percent) {
            return true;
        }
        return false;
    }

    /**
     * @param AliveFile $video
     * @return bool
     */
    public function speechValidation(AliveFile $video) : bool
    {
        if (!is_null($video)) {
            // mp4 To wav
            $format = str_replace(".mp4", '.wav', $video->uri);
            $wavUri = str_replace('videos', 'voices', $format);
            shell_exec("ffmpeg -i storage/app/{$video->uri} -vn storage/app/{$wavUri}");

            // Convert Speech To Text
            $voiceToText = shell_exec('cd vendor/alimianesa/smartauth/src/python && python3 project-video-voice-recognition.py '.
                "\"../../../../../storage/app/{$wavUri}\"");
            Log::info('python speech recognition response: ' . $voiceToText);

            // Get assigned Text
            $text = $video->speechTexts()->first()->speech_text;
            similar_text($text, $voiceToText, $percent);
            Log::info("similarity: " . $percent);

            // Validate
            if ($percent >= $this->speechPercent) {
                return true;
            }
            return false;
        }
        return false;
    }
}
