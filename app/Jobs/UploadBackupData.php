<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\DataBackupHelpers\UploadHelper;
use Mail;
use App\Mail\NotifyUploadComplete;
use App\Models\Config;

class UploadBackupData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $table;
    public $rows;
    public $prune;
    public $complete;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $helper = new UploadHelper;
        $helper->prune();
        $backup_rows = Config::where('id', 'like', 'data-backup-%')->get();

        foreach ($backup_rows as $backup_row) {
            $data = json_decode(gzinflate(base64_decode($backup_row->configs['data'])), true);
            $helper->setGlobals($data['table'], $data['rows']);
            $helper->upload();
        }

        foreach ($backup_rows as $row) {
            $row->delete();
        }

        Mail::to('mobashirmonim@gmail.com')->send(new NotifyUploadComplete());
    }
}
