<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Song;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playlists = Playlist::all();
        return view('playlist.index', compact('playlists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('playlist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'tag' => 'required'
        ]);

        Playlist::create([
            'name' => $request->input('name'),
            'tag' => $request->input('tag')
        ]);

        return redirect('/playlist')->with('success', 'Playlist created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Playlist $playlist)
    {
        // Get all songs from dropdown
        $allSongs = Song::all();

        
        return view('playlist.show', ['playlist' => $playlist, 'allSongs' => $allSongs]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the playlist by its ID
        $playlist = Playlist::findOrFail($id);

        // Pass the playlist to the view
        return view('playlist.edit', ['playlist' => $playlist]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'tag' => 'required'
        ]);

        // Find the playlist and update its attributes
        $playlist = Playlist::findOrFail($id);
        $playlist->update([
            'name' => $request->input('name'),
            'tag' => $request->input('tag'),
        ]);

        // Redirect back to the playlists index page
        return redirect()->route('playlist.index')->with('success', 'Playlist updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $playlist = Playlist::where('id', $id)->firstOrFail();
        $playlist->delete();

        return redirect('/playlist')->with('success', 'Playlist deleted successfully!');
    }

    /**
     * Add music in playlist
     */
    public function addSong(Request $request, Playlist $playlist)
    {
        $songId = $request->input('song');

        // Check if song was added in playlist
        if (!$playlist->songs->contains($songId)) {
            $playlist->songs()->attach($songId);
        }

        return redirect()->route('playlist.show', $playlist->id)->with('success', 'Song added successfully!');
    }

    /**
     * Remove song from playlist
     */
    public function removeSong($playlistId, $songId)
    {
        $playlist = Playlist::findOrFail($playlistId);

        // Disconect song grom playlist
        if ($playlist->songs->contains($songId)) {
            $playlist->songs()->detach($songId);
        }

        return redirect()->route('playlist.show', $playlistId)->with('success', 'Song removed successfully!');
    }
}
