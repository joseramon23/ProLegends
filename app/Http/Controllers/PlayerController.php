<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Resources\PlayersResource;
use App\Models\Players;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $players = Players::get();

            if (!$players) {
                throw new ApiException("Players not found", 404);
            } 
            return PlayersResource::collection($players);

        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'string|max:250',
                'nickname' => 'required|string|max:50',
                'birthdate' => 'required',
                'teams_id' => 'required',
                'country' => 'required|string|max:50',
                'image' => 'file',
                'rol' => 'required|max:10'
            ]);

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::slug($request->nickname).".".$image->guessExtension();
                $route = public_path("images/players/");
                copy($image->getRealPath(), $route.$imageName);

            } else $imageName = "default.jpg";

            $player = Players::create([
                'name' => $request->name,
                'nickname' => $request->nickname,
                'birthdate' => $request->birthdate,
                'teams_id' => $request->teams_id,
                'country' => $request->country,
                'image' => $imageName,
                'rol' => $request->rol
            ]);

            return response()->json([
                'success' => true,
                'message' => 'The player has been added',
                'player' => $player
            ], 200);
            
        } catch(\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $player = Players::findOrFail($id);

            if(!$player) {
                throw new ApiException("Player not found", 404);
            }
            return PlayersResource::make($player)->allPlayer();

        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $player = Players::find($id);

        if (!$player) {
            throw new ApiException("Player not found", 404);
        }

        try {
            $request->validate([
                'name' => 'string|max:250',
                'nickname' => 'string|max:50',
                'country' => 'string|max:50',
                'image' => 'file',
                'rol' => 'max:10'
            ]);

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::slug($request->nickname).".".$image->guessExtension();
                $route = public_path("images/players/");

                if (Storage::exists($route . $player->image)) {
                    Storage::delete($route . $player->image);
                }
                
                Storage::putFileAs($route, $image, $imageName);

            } else $imageName = $player->image;

            $player->update([
                'name' => $request->input('name', $player->name),
                'nickname' => $request->input('nickname', $player->nickname),
                'teams_id' => $request->input('teams_id', $player->teams_id),
                'birthdate' => $request->input('birthdate', $player->birthdate),
                'country' => $request->input('country', $player->country),
                'image' => $imageName,
                'rol' => $request->input('rol', $player->rol)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Player updated successfully',
                'player' => $player->fresh(),
                'request' => $request
            ], 200);

        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
           $player = Players::destroy($id);

           if (!$player) {
                throw new ApiException("Player not found", 404);
           }
           
           return response()->json([
                'success' => true,
                'message' => 'Player has been deleted'
           ]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }
}

