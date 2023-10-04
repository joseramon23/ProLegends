<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaguesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'region' => $this->region,
            'founded' => $this->founded,
            'image_url' => asset("images/leagues/".$this->image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    public function teams() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'region' => $this->region,
            'founded' => $this->founded,
            'image_url' => asset("images/leagues/".$this->image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'teams' => TeamsResource::collection($this->teams)
            
        ];
    }

    public function reducedLeague() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image_url' => asset("images/leagues/".$this->image),
        ];
    }
}
