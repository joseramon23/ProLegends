<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransfersResource extends JsonResource
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
            'player' => (new PlayersResource($this->player))->player(),
            'last_team' => (new TeamsResource($this->lastTeam))->reducedTeam(),
            'new_team' => (new TeamsResource($this->newTeam))->reducedTeam(),
            'start' => $this->start,
            'end' => $this->end,
            'description' => $this->description,
        ];
    }
}
