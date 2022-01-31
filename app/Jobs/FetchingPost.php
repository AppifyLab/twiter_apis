<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Twitter;
use Carbon\Carbon;

class FetchingPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
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
        $array_data = [];
        foreach($this->data as $key => $value){
            if(isset($value) && isset($value->entities) && isset($value->entities->urls[0]) && isset($value->entities->urls[0]->url)){
                $value->text = str_replace( $value->entities->urls[0]->url, '', $value->text);
            }
            $like = 0;
            if($value->public_metrics){
               if(isset($value->public_metrics->like_count)){
                    $like =$value->public_metrics->like_count;
                }
            }
           
            array_push($array_data,[
                'text'=>$value->text,
                'twitter_id'=>$value->id,
                'like'=>$like,
                'created_at'=>Carbon::now(),
                'create_time'=>$value->created_at,
                'updated_at'=>Carbon::now()

            ]);       
        }
        $sorted_array = $this->sortArrayByName($array_data);
    
        return Twitter::insert($sorted_array);
        //
    }
}
