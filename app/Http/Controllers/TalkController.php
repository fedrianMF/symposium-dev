<?php

namespace App\Http\Controllers;

use App\Enums\TalkType;
use App\Models\Talk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TalkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('talks.index', [
            'talks' => $request->user()->talks()->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('talks.create', ['talk' => new Talk]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $request->user()->talks()->create($validated);

        return redirect()->route('talks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Talk $talk): View
    {
        $this->ensureUserOwnsTalk($request, $talk);

        return view('talks.show', ['talk' => $talk]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Talk $talk): View
    {
        $this->ensureUserOwnsTalk($request, $talk);

        return view('talks.edit', ['talk' => $talk]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Talk $talk): RedirectResponse
    {
        $this->ensureUserOwnsTalk($request, $talk);

        $talk->update($request->validate($this->rules()));

        return redirect()->route('talks.show', $talk);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Talk $talk): RedirectResponse
    {
        $this->ensureUserOwnsTalk($request, $talk);

        $talk->delete();

        return redirect()->route('talks.index');
    }

    /**
     * Validation rules shared by store and update.
     *
     * @return array<string, array<int, mixed>>
     */
    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'length' => ['nullable', 'string', 'max:255'],
            'type' => ['required', Rule::enum(TalkType::class)],
            'abstract' => ['nullable', 'string'],
            'organizer_notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Abort with 403 when the talk does not belong to the authenticated user.
     */
    private function ensureUserOwnsTalk(Request $request, Talk $talk): void
    {
        abort_unless($talk->author()->is($request->user()), 403);
    }
}
