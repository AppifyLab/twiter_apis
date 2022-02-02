<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Twitter;
use App\Common\Customhelper;

use App\Jobs\ProcessPodcast;


class PostingToTheInstagram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PostingToTheInstagram';
    private $customHelper;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Featch twits from twits list and post into the instagram';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Customhelper $customHelper )
    {
        
        parent::__construct();
        $this->customHelper = $customHelper;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
            $allposts =   User::where('is_ins_scheduled',1)->where('counter','<=',2)->with('post')->whereHas('post')->get();
            $ids = [];
            foreach ($allposts as $key => $value) {
                $this->customHelper->processImageAndUploadInstagram($value);
                return 1;
            }
              
          
    }
}
