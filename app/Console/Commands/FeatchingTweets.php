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
    public  function sortArrayByName($inputArr) {

        $n = sizeof($inputArr);
        for ($i = 1; $i < $n; $i++) {
            // Choosing the first element in our unsorted subarray
            $current = $inputArr[$i];
            $like = $inputArr[$i]['like'];
            // return 1;
            // The last element of our sorted subarray
            $j = $i-1;

            while (($j > -1) && isset($inputArr[$j]['like']) && ($like > $inputArr[$j]['like'])) {
                $inputArr[$j+1] = $inputArr[$j];
                $j--;
            }
            $inputArr[$j+1] = $current;
        }
        return $inputArr;
        
    }
    public function handle()
    {
        $all_twetter_users =  Category::select('id','twitter_user_id','last_updatetime','user_id')->get();
        foreach($all_twetter_users as $key => $user ){
            $tdate = Carbon::now();
            $end_time =$tdate->format('Y-m-d\TH:i:s\Z');
            $start_time = $user['last_updatetime'];
            
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

            $data = $alldata->data;
            $array_data = [];
            foreach($data as $key => $value){
               
                if(isset($value) && isset($value->entities) && isset($value->entities->urls[0]) && isset($value->entities->urls[0]->url)){
                    continue;
                    // $value->text = str_replace( $value->entities->urls[0]->url, '', $value->text);
                }
                if(isset($value) && isset($value->attachments)){
                    continue;
                }

                $like = 0;
                if($value->public_metrics){
                   if(isset($value->public_metrics->like_count)){
                        $like =$value->public_metrics->like_count;
                    }
                }
                \Log::info(['twits'=>$value]);
                array_push($array_data,[
                    'user_id'=>$user['user_id'],
                    'text'=>$value->text,
                    'twitter_id'=>$value->id,
                    'like'=>$like,
                    'create_time'=>$value->created_at
                ]); 
            }
            $sorted_array = $this->sortArrayByName($array_data);
            $i=0;
            foreach($array_data as $key => $value){
                FetchingPost::dispatch($value);
                $i++;
                if($i>25){
                    break;
                }
            }
            return "sucess";

            
        }
        return 0;
    }
}
