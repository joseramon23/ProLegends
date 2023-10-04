<?php

namespace App\Http\Controllers;

use App\Models\Players_titles;
use App\Models\Players;

use App\Exceptions\ApiException;

use Illuminate\Http\Request;

class TitlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $titles = Players_titles::with(
                'player:id,name,nickname',
                'league:id,name',
                'team:id,name'
            )->get();

            if(!$titles) {
                throw new ApiException("Titles not found", 404);
            }

            $titles = $titles->map(function ($title) {
                return [
                    'id' => $title->id,
                    'name' => $title->name,
                    'player' => $title->player,
                    'team' => $title->team,
                    'league' => $title->league->name,
                    'date' => $title->date,
                    'created_at' => $title->created_at,
                    'updated_at' => $title->updated_at
                ];
            });

            return $titles;

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
                'name' => 'required|string|max:150',
                'player_id' => 'integer',
                'team_id' => 'integer',
                'league_id' => 'required',
                'date' => 'required|max:11'
            ]);

            /**
            * Request has player_id and team_id, create a title for that player and team
            */
            if($request->player_id && $request->team_id) {
                $title = Players_titles::create([
                    'name' => $request->name,
                    'player_id' => $request->player_id,
                    'team_id' => $request->team_id,
                    'league_id' => $request->league_id,
                    'date' => $request->date
                ]);
    
                return response()->json([
                    'success' => true,
                    'message' => 'Title created successfully',
                ], 200);
            }
            
            /**
             * Request only has player_id, create a title for that player
             */
            if ($request->player_id) {
                $player = Players::findOrFail($request->player_id);

                $title = Players_titles::create([
                    'name' => $request->name,
                    'player_id' => $request->player_id,
                    'team_id' => $player->teams_id,
                    'league_id' => $request->league_id,
                    'date' => $request->date
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Title created successfully',
                    'title' => $title
                ], 200);
            }

            /**
             * Request has team_id, create a title for all players of that team
             */
            if ($request->team_id) {
                $players = Players::where('teams_id', $request->team_id)->get();

                foreach ($players as $player) {
                    $title = Players_titles::create([
                        'name' => $request->name,
                        'player_id' => $player->id,
                        'team_id' => $request->team_id,
                        'league_id' => $request->league_id,
                        'date' => $request->date
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'The title has been added to all players of the team',
                ], 200);
            }

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
            $title = Players_titles::with(
                'player:id,name,nickname',
                'league:id,name',
                'team:id,name'
            )->findOrFail($id);

            if (!$title) {
                return response()->json([
                    'success' => false,
                    'message' => 'The title has been not found'
                ], 404);
            }

            return response()->json([
                'id' => $title->id,
                'name' => $title->name,
                'player' => $title->player,
                'team' => $title->team,
                'league' => $title->league->name,
                'date' => $title->date,
                'created_at' => $title->created_at,
                'updated_at' => $title->updated_at
            ]);
            
        } catch (\Exception $error) {
            throw new ApiException($error->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $title = Players_titles::find($id);
        
        if (!$title) {
            throw new ApiException("Title not found", 404);
        }

        try {
            $request->validate([
                'name' => 'required|string|max:150',
                'player_id' => 'integer',
                'team_id' => 'integer',
                'league_id' => 'integer',
                'date' => 'max:11'
            ]);

            $title->update([
                'name' => $request->input('name', $title->name),
                'player_id' => $request->input('player_id', $title->player_id),
                'team_id' => $request->input('team_id', $title->team_id),
                'league_id' => $request->input('league_id', $title->league_id),
                'date' => $request->input('date', $title->date)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Title updated successfully',
                'title' => $title->refresh()
            ], 200);

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
            $title = Players_titles::destroy($id);
 
            if (!$title) {
                throw new ApiException("Title not found", 404);
            }
            
            return response()->json([
                 'success' => true,
                 'message' => 'Title has been deleted'
            ]);
         } catch (\Exception $error) {
            throw new ApiException($error->getMessage(), 500);
         }
    }
}
