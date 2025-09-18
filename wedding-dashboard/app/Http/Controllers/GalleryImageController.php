<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Models\WeddingEvent;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GalleryImageController extends CrudController
{
    public function __construct()
    {
        $this->model = GalleryImage::class;
        $this->routePrefix = 'gallery-images';
        $this->columns = ['id', 'wedding_event_id', 'image_url', 'thumbnail_url', 'description', 'sort_order', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $galleryImages = GalleryImage::with('weddingEvent.couple')->latest()->paginate(10);
        $title = 'Gallery Images';
        
        return view('gallery_images.index', [
            'galleryImages' => $galleryImages,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $title = 'Create Gallery Image';
        $weddingEvents = WeddingEvent::with('couple')->get();
        
        return view('gallery_images.create', [
            'title' => $title,
            'storeRoute' => route('gallery-images.store'),
            'weddingEvents' => $weddingEvents,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'wedding_event_id' => 'required|exists:wedding_events,id',
            'image_url' => 'required|string|max:255',
            'thumbnail_url' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        GalleryImage::create($request->all());

        return redirect()->route('gallery-images.index')
            ->with('success', 'Gallery Image created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $galleryImage = GalleryImage::with('weddingEvent.couple')->findOrFail($id);
        $title = 'View Gallery Image';
        
        return view('gallery_images.show', [
            'galleryImage' => $galleryImage,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $record = GalleryImage::findOrFail($id);
        $title = 'Edit Gallery Image';
        $weddingEvents = WeddingEvent::with('couple')->get();
        
        return view('gallery_images.edit', [
            'record' => $record,
            'title' => $title,
            'updateRoute' => route('gallery-images.update', $record->id),
            'weddingEvents' => $weddingEvents,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'wedding_event_id' => 'required|exists:wedding_events,id',
            'image_url' => 'required|string|max:255',
            'thumbnail_url' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $record = GalleryImage::findOrFail($id);
        $record->update($request->all());

        return redirect()->route('gallery-images.index')
            ->with('success', 'Gallery Image updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $record = GalleryImage::findOrFail($id);
        $record->delete();

        return redirect()->route('gallery-images.index')
            ->with('success', 'Gallery Image deleted successfully.');
    }
}
