<?php

namespace App\Http\Controllers;

use App\Models\Players;
use Illuminate\Http\Request;
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

            foreach($players as $player) {
                $player->actuallyTeam;
            }

            if (!$players) {
                return response()->json([
                    'success' => false,
                    'message' => 'Players not found'
                ], 404);
            } else return $players;

        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validation = $request->validate([
                'name' => 'string|max:250',
                'nickname' => 'required|string|max:50',
                'birthdate' => 'required',
                'team_id' => 'required',
                'country' => 'required|string|max:50',
                'image' => 'string',
                'rol' => 'required|max:10'
            ]);

            if($validation) {

                if($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = Str::slug($request->id)."_".($request->name).".".$image->guessExtension();
                    $route = public_path("images/players/");
                    copy($image->getRealPath(), $route.$imageName);

                } else $imageName = "default.jpg";

                $player = Players::create([
                    'name' => $request->name,
                    'nickname' => $request->nickname,
                    'birthdate' => $request->birthdate,
                    'team_id' => $request->team_id,
                    'country' => $request->country,
                    'image' => $imageName,
                    'rol' => $request->rol
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'The player has been added',
                    'player' => $player
                ], 200);
            }
        } catch(\Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
                'error' => $error
            ], 500);
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
                return response()->json([
                    'success' => false,
                    'message' => 'The player has been not found'
                ], 404);
            }

            return $player;
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $player = Players::find($id);

        if (!$player) {
            return response()->json([
                'success' => false,
                'message' => "Player not found"
            ], 404);
        }

        try {

            $validation = $request->validate([
                'name' => 'string|max:250',
                'nickname' => 'string|max:50',
                'country' => 'string|max:50',
                'image' => 'string',
                'rol' => 'max:10'
            ]);

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::slug($request->id)."_".($request->name).".".$image->guessExtension();
                $route = public_path("images/players/");
                copy($image->getRealPath(), $route.$imageName);

            } else $imageName = $player->image;

            if($validation) {
                $player->name = $request->has('name') ? $request->get('name') : $player->name;
                $player->nickname = $request->has('nickname') ? $request->get('nickname') : $player->nickname;
                $player->team_id = $request->has('team_id') ? $request->get('team_id') : $player->team_id;
                $player->birthdate = $request->has('birthdate') ? $request->get('birthdate') : $player->birthdate;
                $player->country = $request->has('country') ? $request->get('country') : $player->country;
                $player->image = $imageName;
                $player->rol = $request->has('rol') ? $request->get('rol') : $player->rol;
                $player->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Player updated successfully'
            ]);

        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
                'error' => $error
            ], 500);
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
                return response()->json([
                    'success' => false,
                    'message' => 'Player not found'
                ], 404);
           }
           
           return response()->json([
                'success' => true,
                'message' => 'Player has been deleted'
           ]);
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
                'error' => $error
            ]);
        }
    }
}
