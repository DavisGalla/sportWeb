<?php

namespace App\Http\Controllers;

use App\Models\PersonalBest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonalBestController extends Controller
{
    public function index(): View
    {
        $bests = auth()->user()
            ->PersonalBests()
            ->orderBy('exercise')
            ->get();
 
        return view('personalBests.index', compact('bests'));
    }
 
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'exercise' => ['required', 'string', 'max:100'],
            'weight'   => ['required', 'numeric', 'min:0'],
        ]);
 
        auth()->user()->PersonalBests()->create($data);
 
        return redirect()->route('pbs.index')->with('success', 'PR added!');
    }
 
    public function destroy(PersonalBest $pb): RedirectResponse
    {
        if ($pb->user_id !== auth()->id()) {
            abort(403);
        }

        $pb->delete();

        return redirect()->route('pbs.index')->with('success', 'PR deleted.');
    }

    public function update(Request $request, PersonalBest $pb): RedirectResponse
    {
        if ($pb->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'weight' => ['required', 'numeric', 'min:0'],
        ]);

        $pb->update($data);

        return redirect()->route('pbs.index')->with('success', 'PR updated!');
    }
}
