<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\MobileBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Get active banners for mobile app (Public API).
     * GET /api/banners
     */
    public function getActiveBanners()
    {
        $banners = MobileBanner::active()->get();

        return response()->json([
            'success' => true,
            'message' => 'Banner iklan & promo berhasil diambil',
            'data'    => $banners
        ]);
    }

    /**
     * Get all banners for Web Dashboard / Admin.
     * GET /mobile/banners atau GET /api/mobile/banners
     */
    public function index()
    {
        $banners = MobileBanner::orderBy('order', 'asc')->orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'data'    => $banners
        ]);
    }

    /**
     * Store a newly created banner.
     * POST /mobile/banners atau POST /api/mobile/banners
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'subtitle'     => 'nullable|string|max:255',
            'image'        => 'required_without:image_url|nullable|file|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'image_url'    => 'required_without:image|nullable|url|max:500',
            'badge_text'   => 'nullable|string|max:50',
            'badge_color'  => 'nullable|string|max:20',
            'action_type'  => 'nullable|in:none,url,exam,announcement',
            'action_value' => 'nullable|string|max:255',
            'order'        => 'nullable|integer|min:0',
            'is_active'    => 'nullable|boolean',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'banner_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('mobile/banners', $fileName, 'public');
            $imagePath = $path;
        } elseif (!empty($validated['image_url'])) {
            $imagePath = $validated['image_url'];
        }

        $banner = MobileBanner::create([
            'title'        => $validated['title'],
            'subtitle'     => $validated['subtitle'] ?? null,
            'image'        => $imagePath,
            'badge_text'   => $validated['badge_text'] ?? 'INFO',
            'badge_color'  => $validated['badge_color'] ?? '#0d6efd',
            'action_type'  => $validated['action_type'] ?? 'none',
            'action_value' => $validated['action_value'] ?? null,
            'order'        => $validated['order'] ?? (MobileBanner::max('order') + 1),
            'is_active'    => $request->has('is_active') ? $request->boolean('is_active') : true,
            'start_date'   => $validated['start_date'] ?? null,
            'end_date'     => $validated['end_date'] ?? null,
        ]);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Banner iklan baru berhasil ditambahkan.',
                'data'    => $banner
            ], 201);
        }

        return redirect()->back()->with('success', 'Banner iklan baru berhasil ditambahkan.');
    }

    /**
     * Update the specified banner.
     * POST /mobile/banners/{id}
     */
    public function update(Request $request, $id)
    {
        $banner = MobileBanner::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'subtitle'     => 'nullable|string|max:255',
            'image'        => 'nullable|file|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'image_url'    => 'nullable|url|max:500',
            'badge_text'   => 'nullable|string|max:50',
            'badge_color'  => 'nullable|string|max:20',
            'action_type'  => 'nullable|in:none,url,exam,announcement',
            'action_value' => 'nullable|string|max:255',
            'order'        => 'nullable|integer|min:0',
            'is_active'    => 'nullable|boolean',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($request->hasFile('image')) {
            // Hapus file lama jika ada di storage
            if ($banner->image && !filter_var($banner->image, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $file = $request->file('image');
            $fileName = 'banner_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('mobile/banners', $fileName, 'public');
            $banner->image = $path;
        } elseif (!empty($validated['image_url'])) {
            $banner->image = $validated['image_url'];
        }

        $banner->title        = $validated['title'];
        $banner->subtitle     = $validated['subtitle'] ?? null;
        $banner->badge_text   = $validated['badge_text'] ?? $banner->badge_text;
        $banner->badge_color  = $validated['badge_color'] ?? $banner->badge_color;
        $banner->action_type  = $validated['action_type'] ?? 'none';
        $banner->action_value = $validated['action_value'] ?? null;
        $banner->order        = $validated['order'] ?? $banner->order;
        $banner->is_active    = $request->has('is_active') ? $request->boolean('is_active') : $banner->is_active;
        $banner->start_date   = $validated['start_date'] ?? null;
        $banner->end_date     = $validated['end_date'] ?? null;
        $banner->save();

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Banner iklan berhasil diperbarui.',
                'data'    => $banner
            ]);
        }

        return redirect()->back()->with('success', 'Banner iklan berhasil diperbarui.');
    }

    /**
     * Toggle banner active status.
     * POST /mobile/banners/{id}/toggle
     */
    public function toggleStatus($id)
    {
        $banner = MobileBanner::findOrFail($id);
        $banner->is_active = !$banner->is_active;
        $banner->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Status banner berhasil diubah.',
            'is_active' => $banner->is_active
        ]);
    }

    /**
     * Remove the specified banner.
     * DELETE /mobile/banners/{id}
     */
    public function destroy(Request $request, $id)
    {
        $banner = MobileBanner::findOrFail($id);

        if ($banner->image && !filter_var($banner->image, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Banner iklan berhasil dihapus.'
            ]);
        }

        return redirect()->back()->with('success', 'Banner iklan berhasil dihapus.');
    }
}
