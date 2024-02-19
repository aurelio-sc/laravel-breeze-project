<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
   
    public function create(Request $request)
    {        
        $request->validate([
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);        
        $note = new Note();
        $note->description = $request->description;
        $note->priority = $note->setPriority($request->priority);
        $note->status = 'a';
        $note->user_id = auth()->id();
        $note->save();
        return redirect()->back();
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);
        $note = Note::findOrFail($id);
        $note->description = $request->description;
        $note->priority = $note->setPriority($request->priority);
        $note->save();
        return redirect()->back();
    }

    public function setStatus(Request $request)
    {
        
    }

    public function setPriority(Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        
    }
}
