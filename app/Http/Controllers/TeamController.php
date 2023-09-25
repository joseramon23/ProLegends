<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;

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
                throw new ApiException("Teams not found", 404);
            }
            return $teams;
            
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

            $validation = $request->validate([
                'name' => 'string|max:50',
                'slug' => 'required|string|max:3',
                'league_id' => 'required',
                'founded' => 'required',
                'country' => 'required|string|max:50',
                'image' => 'file',
            ]);

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::slug($request->slug)."_".($request->name).".".$image->guessExtension();
                $route = public_path("images/teams/");
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
            $team = Teams::findOrFail($id);
            $team->league;
            $team->players;

            if(!$team) {
                throw new ApiException("Team not found", 404);
            }
            return $team;

        } catch (\Exception $error) {
            throw new ApiException($error->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $team = Teams::find($id);

        if (!$team) {
            throw new ApiException("Team not found", 404);
        }

        try {

            $validation = $request->validate([
                'name' => 'string|max:50',
                'slug' => 'string|max:3',
                'founded' => 'year',
                'country' => 'string|max:50',
                'image' => 'file',
            ]);

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::slug($request->slug)."_".($request->name).".".$image->guessExtension();
                $route = public_path("images/teams/");
                copy($image->getRealPath(), $route.$imageName);

            } else $imageName = $team->image;

            $team->update([
                'name' => $request->input('name', $team->name),
                'slug' => $request->input('slug', $team->slug),
                'league_id' => $request->input('league_id', $team->league_id),
                'founded' => $request->input('founded', $team->founded),
                'country' => $request->input('country', $team->country),
                'image' => $imageName,
            ]);


            return response()->json([
                'success' => true,
                'message' => 'Team updated successfully',
                'team' => $team->fresh()
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
            $team = Teams::destroy($id);
 
            if (!$team) {
                throw new ApiException("Team not found", 404);
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
