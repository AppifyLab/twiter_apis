<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchingPost;
use App\Models\User;
use App\Models\Twitter;
use App\Models\Category;
use App\Common\Customhelper;
use Carbon\Carbon;
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
         $all_twetter_users =  Category::select('id','twitter_user_id','last_updatetime','user_id')->get();
        foreach($all_twetter_users as $key => $user ){
            $tdate = Carbon::now();
            $end_time =$tdate->format('Y-m-d\TH:i:s\Z');
            $start_time = $user['last_updatetime'];

            \Log::info(['st'=>$start_time,'end'=>$end_time]);
           
            Category::select('id',$user['id'])->update(['last_updatetime'=>$end_time]);
           
            $limit = 25;
            $client2 = new \GuzzleHttp\Client();
            $url = 'https://api.twitter.com/2/users/'.$user->twitter_user_id.'/tweets?tweet.fields=public_metrics,entities,attachments,created_at&max_results='. $limit.'&start_time='.$start_time.'&end_time='.$end_time;
            $request2 = (string) $client2->get($url,
            ['headers' => 
                [
                    'Authorization' => "Bearer AAAAAAAAAAAAAAAAAAAAAOWNYgEAAAAAD1NQJpQfL98Al2lJAYWojnmeOJY%3D9tOPIa1RUfdwVOfrEqSUw0Hmr9v6RWxyES06AcwAY3dXvkUdM6"
                ]
            ]
            )->getBody();

            $alldata =json_decode($request2);
           

            if(isset($alldata->meta) && isset($alldata->meta->result_count)){
                if($alldata->meta->result_count==0) {
                    \Log::info("false");
                    return false;
                }
            }
            \Log::info(['all'=>$alldata]);

           
            $data = $alldata->data;
            // \Log::info(['all'=>$alldata]);
            $this->customHelper->insertTweetIntoTheDatabase($data,$user);
            // return ;
            return "sucess";

            
        }
        return 0;
    }
}
