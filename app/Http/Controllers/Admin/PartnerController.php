<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    // ─── INDEX ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Partner::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        $partners = $query->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.partners.index', compact('partners'));
    }

    // ─── CREATE ───────────────────────────────────────────────────────────────
    public function create()
    {
        $types = Partner::$types;
        return view('admin.partners.create', compact('types'));
    }

    // ─── STORE ────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:partners,slug',
            'deskripsi' => 'nullable|string|max:1000',
            'type' => ['required', Rule::in(array_keys(Partner::$types))],
            'is_active' => 'boolean',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        // Slug fallback
        $validated['slug'] = $validated['slug']
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']);

        // Ensure unique slug
        $validated['slug'] = $this->uniqueSlug($validated['slug']);

        // Upload logo
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('partners/logos', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        Partner::create($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', "Partner \"{$validated['name']}\" berhasil ditambahkan.");
    }

    // ─── EDIT ─────────────────────────────────────────────────────────────────
    public function edit(Partner $partner)
    {
        $types = Partner::$types;
        return view('admin.partners.edit', compact('partner', 'types'));
    }

    // ─── UPDATE ───────────────────────────────────────────────────────────────
    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('partners', 'slug')->ignore($partner->id)],
            'deskripsi' => 'nullable|string|max:1000',
            'type' => ['required', Rule::in(array_keys(Partner::$types))],
            'is_active' => 'boolean',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        $validated['slug'] = $validated['slug']
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']);

        // Upload logo baru (hapus yang lama)
        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $validated['logo'] = $request->file('logo')->store('partners/logos', 'public');
        }

        // Hapus logo jika diminta
        if ($request->boolean('remove_logo') && $partner->logo) {
            Storage::disk('public')->delete($partner->logo);
            $validated['logo'] = null;
        }

        $validated['is_active'] = $request->boolean('is_active');

        $partner->update($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', "Partner \"{$partner->name}\" berhasil diperbarui.");
    }

    // ─── DESTROY ──────────────────────────────────────────────────────────────
    public function destroy(Partner $partner)
    {
        $name = $partner->name;

        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', "Partner \"{$name}\" berhasil dihapus.");
    }

    // ─── HELPERS ──────────────────────────────────────────────────────────────
    private function uniqueSlug(string $slug, int $ignoreId = 0): string
    {
        $original = $slug;
        $counter = 1;

        while (Partner::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }
}