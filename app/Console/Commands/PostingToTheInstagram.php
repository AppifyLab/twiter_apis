<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Twitter;

use App\Jobs\ProcessPodcast;


class PostingToTheInstagram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PostingToTheInstagram';

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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("running..2");
        return 1;
  
            $allposts =   User::where('is_ins_scheduled',1)->with('post')->whereHas('post')->get();
            $ids = [];
            foreach ($allposts as $key => $value) {
                if(isset($value['post'])){
                    ProcessPodcast::dispatch($value);
                    array_push($ids,$value['post']->id);
                }
            }
            return Twitter::whereIn('id',$ids)->where('is_published','!=','Completed')->update(['is_published'=>'Processing']);
            // $this->socialService->updateTwitesStatus($ids,'Processing');
              
          
    }
}
