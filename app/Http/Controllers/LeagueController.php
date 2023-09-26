<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;

use App\Models\Leagues;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $leagues = Leagues::get();
            if (!$leagues) {
                throw new ApiException("League not found", 404);
            }
            return $leagues;

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
                'name' => 'string|required|max:250',
                'slug' => 'string|required|max:5',
                'region' => 'string|required',
                'founded' => 'required',
                'image' => 'file'
            ]);

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::slug($request->slug)."_".($request->name).".".$image->guessExtension();
                $route = public_path("images/leagues/");
                copy($image->getRealPath(), $route.$imageName);

            } else $imageName = "default.jpg";

            $league = Leagues::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'region' => $request->region,
                'founded' => $request->founded,
                'image' => $imageName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'League has been added',
                'league' => $league
            ], 200);

        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $league = Leagues::findOrFail($id);
            $league->teams;

            if(!$league) {
                throw new ApiException("League not found", 404);
            }
            return $league;

        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $league = Leagues::find($id);

        if(!$league) {
            throw new ApiException("League not found", 404);
        }

        try {
            $request->validate([
                'name' => 'string|max:250',
                'slug' => 'string|max:5',
                'region' => 'string',
                'founded' => 'string',
                'image' => 'file'
            ]);

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::slug($request->slug)."_".($request->name).".".$image->guessExtension();
                $route = public_path("images/leagues/");

                if (Storage::exists($route . $league->image)) {
                    Storage::delete($route . $league->image);
                }
                
                Storage::putFileAs($route, $image, $imageName);

            } else $imageName = $league->image;

            $league->update([
                'name' => $request->input('name', $league->name),
                'slug' => $request->input('slug', $league->slug),
                'region' => $request->input('region', $league->region),
                'founded' => $request->input('founded', $league->founded),
                'image' => $imageName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'League updated successfully',
                'league' => $league->fresh()
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
            $league = Leagues::destroy($id);
 
            if (!$league) {
                throw new ApiException("League not found", 404);
            }
            
            return response()->json([
                 'success' => true,
                 'message' => 'League has been deleted',
                 'league' => $id
            ]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }
}
