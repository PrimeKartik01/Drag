<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Builder;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\BuilderStoreRequest;
use App\Http\Requests\BuilderUpdateRequest;

// Service
use App\Services\HelperService;

class BuilderController extends Controller
{
    protected HelperService $helperService;

    public function __construct(HelperService $helperService)
    {
        $this->helperService = $helperService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $builders = Builder::when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('rera_no', 'like', '%' . $request->search . '%');
                });
            })->latest()->paginate(10);

            return view('builder.index', compact('builders'));
        } catch (Exception $e) {
            Log::error('Builder Index Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Builder Fetch Failed');

            return redirect()->route('admin.dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('builder.create');
        } catch (Exception $e) {
            Log::error('Builder Create Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Builder Create Failed');

            return redirect()->route('builder.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BuilderStoreRequest $request)
    {
        $newPhoto = null;

        try {

            $input = $request->validated();

            $input['slug'] = $this->helperService->generateUniqueSlug(
                Builder::class,
                $input['slug']
            );

            if ($request->hasFile('photo')) {
                $newPhoto = $request->file('photo')->store('builders', 'public');
                $input['photo'] = $newPhoto;
            }

            Builder::create($input);

            Session::flash('success', 'Builder Created Successfully');
        } catch (Exception $e) {
            // Delete uploaded image if database insert fails
            if ($newPhoto && Storage::disk('public')->exists($newPhoto)) {
                Storage::disk('public')->delete($newPhoto);
            }

            Log::error('Builder Store Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Something went wrong while creating the builder');
        }

        return redirect()->route('builder.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Builder $builder)
    {
        try {
            return view('builder.edit', compact('builder'));
        } catch (Exception $e) {

            Log::error('Builder Edit Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Builder Edit Failed');

            return redirect()->route('builder.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BuilderUpdateRequest $request, Builder $builder)
    {
        try {

            $input = $request->validated();

            $input['slug'] = $this->helperService->generateUniqueSlug(
                Builder::class,
                $input['slug'],
                $builder->id
            );

            $oldPhoto = $builder->photo;
            $newPhoto = null;

            if ($request->hasFile('photo')) {
                $newPhoto = $request->file('photo')->store('builders', 'public');
                $input['photo'] = $newPhoto;
            } else {

                $input['photo'] = $oldPhoto;
            }

            $builder->update($input);

            // Delete old photo only after successful DB update
            if ($newPhoto && $oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
                Storage::disk('public')->delete($oldPhoto);
            }

            Session::flash('success', 'Builder Updated Successfully');
        } catch (Exception $e) {

            // Rollback newly uploaded photo if DB update fails
            if (isset($newPhoto) && $newPhoto && Storage::disk('public')->exists($newPhoto)) {
                Storage::disk('public')->delete($newPhoto);
            }

            Log::error('Builder Update Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Something went wrong while updating the builder');
        }

        return redirect()->route('builder.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Builder $builder)
    {
        try {
            return view('builder.show', compact('builder'));
        } catch (Exception $e) {

            Log::error('Builder Show Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Builder Details Failed');

            return redirect()->route('builder.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Builder $builder)
    {
        try {

            if ($builder->photo && Storage::disk('public')->exists($builder->photo)) {
                Storage::disk('public')->delete($builder->photo);
            }

            $builder->delete();
            Session::flash('success', 'Builder Deleted Successfully');
        } catch (Exception $e) {

            Log::error('Builder Delete Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Builder Deletion Failed');
        }

        return redirect()->route('builder.index');
    }


    /**
     *  Bulk Delete
     */
    public function bulkDelete(Request $request)
    {
        try {

            $ids = array_filter(explode(',', $request->ids));

            if (empty($ids)) {

                Session::flash('error', 'No builders selected');

                return back();
            }

            $builders = Builder::whereIn('id', $ids)->get();

            foreach ($builders as $builder) {

                if ($builder->photo && Storage::disk('public')->exists($builder->photo)) {
                    Storage::disk('public')->delete($builder->photo);
                }
            }

            Builder::whereIn('id', $ids)->delete();
            Session::flash('success', 'Selected Builders Deleted Successfully');
        } catch (Exception $e) {

            Log::error('Builder Bulk Delete Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Builder Bulk Delete Failed');
        }

        return redirect()->route('builder.index');
    }
}
