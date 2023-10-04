<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\Teams;
use App\Models\Transfers;
use App\Http\Resources\TransfersResource;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $transfers = Transfers::get();

            if(!$transfers) {
                throw new ApiException("Transfers not found", 404);
            }

            return TransfersResource::collection($transfers);

        } catch (\Exception $error) {
            throw new ApiException($error->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'last_team_id' => 'required',
                'new_team_id' => 'required',
                'player_id' => 'required',
                'start' => 'required|date',
                'end' => 'required|date',
                'description' => 'string|max:300'
            ]);

            $transfer = Transfers::create([
                'last_team_id' => $request->last_team_id,
                'new_team_id' => $request->new_team_id,
                'player_id' => $request->player_id,
                'start' => $request->start,
                'end' => $request->end,
                'description' => $request->description
            ]);

            $player = Players::findOrFail($request->player_id);
            $player->update([
                'teams_id' => $request->new_team_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Transfer has been added',
                'transfer' => $transfer,
                'player' => $player
            ], 200);

            
        } catch (\Exception $error) {
            throw new ApiException($error->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $transfer = Transfers::findOrFail($id);
            if(!$transfer) {
                throw new ApiException("Transfer not found", 404);
            }
            
            return new TransfersResource($transfer);

        } catch (\Exception $error) {
            throw new ApiException($error->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $transfer = Transfers::find($id);

            if(!$transfer) {
                return response()->json([
                    'success' => false,
                    'message' => "Transfer not found"
                ], 404);
            }

            $request->validate([
                'last_team_id' => 'number',
                'new_team_id' => 'number',
                'player_id' => 'number',
                'start' => 'date',
                'end' => 'date',
                'description' => 'string|max:300'
            ]);

            $transfer->update([
                'last_team_id' => $request->input('last_team_id', $transfer->last_team_id),
                'new_team_id' => $request->input('new_team_id', $transfer->new_team_id),
                'player_id' => $request->input('player_id', $transfer->player_id),
                'start' => $request->input('start', $transfer->start),
                'end' => $request->input('end', $transfer->end),
                'description' => $request->input('description', $request->description)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Transfer updated successfully',
                'transfer' => $transfer->fresh()
            ]);

        } catch (\Exception $error) {
            throw new ApiException($error->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $transfer = Transfers::destroy($id);

            if(!$transfer) {
                throw new ApiException("Transfer not found", 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Team has been deleted'
           ]);

        } catch (\Exception $error) {
            throw new ApiException($error->getMessage(), 500);
        }
    }
}
