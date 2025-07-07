<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Zodiac;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactControllerAPI extends Controller
{
    /**
     * Display a paginated listing of contacts
     */
    public function index(Request $request): JsonResponse
    {
        $query = Contact::with('zodiac');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Filter by tag
        if ($request->has('tag')) {
            $query->byTag($request->get('tag')); // Using your scope
        }

        // Filter by zodiac
        if ($request->has('tag')) {
            $query->byZodiac($request->get('zodiac')); // Using your scope
        }

        // Filter favorites
        if ($request->has('favorites') && $request->get('favorites') === 'true') {
            $query->where('is_favorite', true);
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'first_name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if (in_array($sortBy, ['first_name', 'last_name', 'email', 'created_at', 'last_meet'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination
        $perPage = min($request->get('per_page', 15), 100); // Max 100 per page
        $contacts = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $contacts->items(),
            'meta' => [
                'current_page' => $contacts->currentPage(),
                'last_page' => $contacts->lastPage(),
                'per_page' => $contacts->perPage(),
                'total' => $contacts->total(),
                'from' => $contacts->firstItem(),
                'to' => $contacts->lastItem(),
            ],
            'links' => [
                'first' => $contacts->url(1),
                'last' => $contacts->url($contacts->lastPage()),
                'prev' => $contacts->previousPageUrl(),
                'next' => $contacts->nextPageUrl(),
            ]
        ]);
    }

    /**
     * Display the specified contact
     */
    public function show(Contact $contact): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $contact->load('zodiac')
        ]);
    }

    /**
     * Store a newly created contact
     */
    public function store(Request $request): JsonResponse
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
        ]);

        $contact = Contact::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Contact created successfully',
            'data' => $contact->load('zodiac')
        ], 201);
    }

    /**
     * Update the specified contact
     */
    public function update(Request $request, Contact $contact): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email|unique:contacts,email,' . $contact->id,
            'phone' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'zodiac_id' => 'nullable|exists:zodiacs,id',
            'description' => 'nullable|string',
            'social_links' => 'nullable|array',
            'tags' => 'nullable|array',
            'last_meet' => 'nullable|date',
        ]);

        $contact->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Contact updated successfully',
            'data' => $contact->fresh(['zodiac'])
        ]);
    }

    /**
     * Remove the specified contact
     */
    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Contact deleted successfully'
        ]);
    }

    /**
     * Get all zodiac signs for dropdowns
     */
    public function zodiacs(): JsonResponse
    {
        $zodiacs = Zodiac::all(['id', 'name', 'symbol', 'element']);

        return response()->json([
            'status' => 'success',
            'data' => $zodiacs
        ]);
    }

    /**
     * Get contact statistics
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total_contacts' => Contact::count(),
            'favorites' => Contact::where('is_favorite', true)->count(),
            'with_birth_date' => Contact::whereNotNull('birth_date')->count(),
            'with_social_links' => Contact::whereNotNull('social_links')->count(),
            'recent_contacts' => Contact::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }
}
