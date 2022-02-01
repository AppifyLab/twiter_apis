<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchingPost;
use App\Models\User;
use App\Models\Twitter;
use App\Models\Category;
use Carbon\Carbon;
class FeatchingTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FeatchingTweets';
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
        \Log::info("running..1");
        return 1;
     

        $all_twetter_users =  Category::select('id','twitter_user_id')->get();
        try {

        foreach($all_twetter_users as $key => $value ){

            $date = Carbon::createFromFormat('Y-m-d H:i:s', $request->date)->format('d-m-Y');
            // date('Y-m-d h:i:s', strtotime($date));
            // $start_time = $date.'T00:00:00Z';
            // $end_time = $date.'T23:59:00Z';

            // // $start_time = Carbon::parse($date);
            \Log::info(['s'=>$date]);
            return "hello";
            // Category::select('id',$value['id'])->update(['last_updatetime']);

            $limit = 25;
            $client2 = new \GuzzleHttp\Client();
            $url = 'https://api.twitter.com/2/users/'.$value->twitter_user_id.'/tweets?tweet.fields=public_metrics,entities,created_at&max_results='. $limit.'&start_time='.$start_time.'&end_time='.$end_time;
            $request2 = (string) $client2->get($url,
            ['headers' => 
                [
                    'Authorization' => "Bearer AAAAAAAAAAAAAAAAAAAAAOWNYgEAAAAAD1NQJpQfL98Al2lJAYWojnmeOJY%3D9tOPIa1RUfdwVOfrEqSUw0Hmr9v6RWxyES06AcwAY3dXvkUdM6"
                ]
            ]
            )->getBody();
            $alldata =json_decode($request2);
            if($alldata->meta->result_count==0) {
                return response()->json([
                    'message' => "No result found!",
                ], 401);
            }

            $data = $alldata->data;

            FetchingPost::dispatch($data);
            return "sucess";

            
        }


           
            
          
        
        
       
        } catch (\Exception $e) {
            return $e;
            return response()->json([
                'message' => "Invalied twitter username!",
            ], 401);
        }


        return 0;
    }
}
