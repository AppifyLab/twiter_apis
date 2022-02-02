<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Common\Customhelper;

class FeatchingTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FeatchingTweets';
    private $customHelper;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Featching Tweets every five munutes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Customhelper $customHelper)
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
        \Log::info("calling twiter");
        $this->customHelper->getAllTweets();
         
        return 1;
    }
}
