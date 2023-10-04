<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayersResource extends JsonResource
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
            'nickname' => $this->nickname,
            'birthdate' => $this->birthdate,
            'country' => $this->country,
            'image_url' => asset("images/players/".$this->image),
            'role' => $this->rol,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'team' => (new TeamsResource($this->team))->reducedTeam()
        ];
    }

    public function player() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'birthdate' => $this->birthdate,
            'country' => $this->country,
            'image_url' => asset("images/players/".$this->image),
            'role' => $this->rol,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function allPlayer() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'birthdate' => $this->birthdate,
            'country' => $this->country,
            'image_url' => asset("images/players/".$this->image),
            'role' => $this->rol,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'team' => new TeamsResource($this->team),
        ];
    }
}
