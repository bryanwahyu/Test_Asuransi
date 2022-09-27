<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FriendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $list_of_friend=[];
        foreach($request as $teman){
           array_push($list_of_friend,$teman->to);
        }
        $json['friend']=$list_of_friend;
        return $json;
    }
}
