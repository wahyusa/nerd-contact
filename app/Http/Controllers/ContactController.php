<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Zodiac;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    /**
     * Display a paginated listing of contacts
     */
    public function index(Request $request): Response
    {
        $query = Contact::with('zodiac');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Filter by tag using your scope
        if ($request->has('tag') && $request->tag) {
            $query->byTag($request->tag);
        }

        // Filter by zodiac using your scope
        if ($request->has('zodiac') && $request->zodiac) {
            $query->byZodiac($request->zodiac);
        }

        // Filter favorites
        if ($request->has('favorites') && $request->favorites === 'true') {
            $query->where('is_favorite', true);
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'first_name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if (in_array($sortBy, ['first_name', 'last_name', 'email', 'created_at', 'last_meet'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination
        $contacts = $query->paginate(15)->withQueryString();

        // Get available tags and zodiacs for filters
        $availableTags = Contact::whereNotNull('tags')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        $zodiacs = Zodiac::all(['id', 'name', 'symbol']);

        return Inertia::render('contacts/Index', [
            'contacts' => $contacts,
            'filters' => $request->only(['search', 'tag', 'zodiac', 'favorites', 'sort_by', 'sort_order']),
            'availableTags' => $availableTags,
            'zodiacs' => $zodiacs,
        ]);
    }

    /**
     * Show the form for creating a new contact
     */
    public function create(): Response
    {
        $zodiacs = Zodiac::all(['id', 'name', 'symbol']);

        return Inertia::render('Contacts/Create', [
            'zodiacs' => $zodiacs,
        ]);
    }

    /**
     * Store a newly created contact
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:contacts,email',
            'phone' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'zodiac_id' => 'nullable|exists:zodiacs,id',
            'description' => 'nullable|string',
            'social_links' => 'nullable|array',
            'tags' => 'nullable|array',
            'last_meet' => 'nullable|date',
            'is_favorite' => 'boolean',
        ]);

        Contact::create($validated);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact created successfully!');
    }

    /**
     * Display the specified contact
     */
    public function show(Contact $contact): Response
    {
        $contact->load('zodiac');

        return Inertia::render('Contacts/Show', [
            'contact' => $contact,
        ]);
    }

    /**
     * Show the form for editing the specified contact
     */
    public function edit(Contact $contact): Response
    {
        $zodiacs = Zodiac::all(['id', 'name', 'symbol']);

        return Inertia::render('Contacts/Edit', [
            'contact' => $contact,
            'zodiacs' => $zodiacs,
        ]);
    }

    /**
     * Update the specified contact
     */
    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:contacts,email,' . $contact->id,
            'phone' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'zodiac_id' => 'nullable|exists:zodiacs,id',
            'description' => 'nullable|string',
            'social_links' => 'nullable|array',
            'tags' => 'nullable|array',
            'last_meet' => 'nullable|date',
            'is_favorite' => 'boolean',
        ]);

        $contact->update($validated);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully!');
    }

    /**
     * Remove the specified contact
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully!');
    }
}