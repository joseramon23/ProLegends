<?php

namespace App\Http\Controllers;

use App\Models\Players_titles;
use Illuminate\Http\Request;

class TitlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $titles = Players_titles::get();

            if(!$titles) {
                return response()->json([
                    'success' => false,
                    'message' => 'Titles has been not found'
                ], 404);
            }

            return $titles;

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
            $request->validate([
                'name' => 'required|string|max:150',
                'player_id' => 'required',
                'team_id' => 'required',
                'league_id' => 'required',
                'date' => 'required|max:8'
            ]);

            $title = Players_titles::create([
                'name' => $request->name,
                'player_id' => $request->player_id,
                'team_id' => $request->team_id,
                'league_id' => $request->league_id,
                'date' => $request->date
            ]);

            return response()->json([
                'success' => true,
                'message' => 'The title has been added',
                'player' => $title
            ], 200);

        } catch (\Exception $error) {
            return response()->json([
                'succes' => false,
                'message' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $title = Players_titles::findOrFail($id);

            if (!$title) {
                return response()->json([
                    'success' => false,
                    'message' => 'The title has been not found'
                ], 404);
            }

            return $title;
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
        $title = Players_titles::find($id);
        
        if (!$title) {
            return response()->json([
                'success' => false,
                'message' => "Title not found"
            ], 404);
        }

        try {
            $request->validate([
                'name' => 'required|string|max:150',
                'player_id' => 'integer',
                'team_id' => 'integer',
                'league_id' => 'integer',
                'date' => 'max:8'
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
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
                'error' => $error
            ]);
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
                 return response()->json([
                     'success' => false,
                     'message' => 'Title not found'
                 ], 404);
            }
            
            return response()->json([
                 'success' => true,
                 'message' => 'Title has been deleted'
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
