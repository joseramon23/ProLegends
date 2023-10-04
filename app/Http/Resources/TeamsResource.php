<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'founded' => $this->founded,
            'country' => $this->country,
            'image_url' => asset("images/teams/".$this->image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'league' => (new LeaguesResource($this->league))->reducedLeague(),
        ];
    }

    public function allTeam() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'founded' => $this->founded,
            'country' => $this->country,
            'image_url' => asset("images/teams/".$this->image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'league' => new LeaguesResource($this->league),
            'players' => PlayersResource::collection($this->players)->map(function($player) {
                return $player->player();
            })
        ];
    }

    public function reducedTeam() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image_url' => asset("images/teams/".$this->image)
        ];
    }
}
