<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $teams = Teams::get();

            if(!$teams) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teams has been not found'
                ], 404);
            } else return $teams;
        } catch (\Exception $error) {
            return response()->json([
                'succes' => false,
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
                'name' => 'string|max:50',
                'slug' => 'required|string|max:3',
                'league_id' => 'required',
                'founded' => 'required|year',
                'country' => 'required|string|max:50',
                'image' => 'string',
            ]);

            if($validation) {

                if($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = Str::slug($request->id)."_".($request->name).".".$image->guessExtension();
                    $route = public_path("images/players/");
                    copy($image->getRealPath(), $route.$imageName);

                } else $imageName = "default.jpg";

                $team = Teams::create([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'league_id' => $request->league_id,
                    'founded' => $request->founded,
                    'country' => $request->country,
                    'image' => $imageName
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'The team has been added',
                    'player' => $team
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
            $team = Teams::findOrFail($id);

            if(!$team) {
                return response()->json([
                    'success' => false,
                    'message' => 'The team has been not found'
                ], 404);
            }

            return $team;
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
        $team = Teams::find($id);

        if (!$team) {
            return response()->json([
                'success' => false,
                'message' => "Team not found"
            ], 404);
        }

        try {

            $validation = $request->validate([
                'name' => 'string|max:50',
                'slug' => 'string|max:3',
                'founded' => 'year',
                'country' => 'string|max:50',
                'image' => 'string',
            ]);

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::slug($request->id)."_".($request->name).".".$image->guessExtension();
                $route = public_path("images/teams/");
                copy($image->getRealPath(), $route.$imageName);

            } else $imageName = $team->image;

            if($validation) {
                $team->name = $request->has('name') ? $request->get('name') : $team->name;
                $team->slug = $request->has('slug') ? $request->get('slug') : $team->slug;
                $team->league_id = $request->has('league_id') ? $request->get('league_id') : $team->team_id;
                $team->founded = $request->has('founded') ? $request->get('founded') : $team->founded;
                $team->country = $request->has('country') ? $request->get('country') : $team->country;
                $team->image = $imageName;
                $team->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Team updated successfully'
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
            $team = Teams::destroy($id);
 
            if (!$team) {
                 return response()->json([
                     'success' => false,
                     'message' => 'Team not found'
                 ], 404);
            }
            
            return response()->json([
                 'success' => true,
                 'message' => 'Team has been deleted'
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
