<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

// Models
use App\Models\Builder;
use App\Models\Township;
use App\Models\City;

// Request
use App\Http\Requests\TownshipRequest;
use App\Http\Requests\TownshipUpdateRequest;

// Service
use App\Services\HelperService;

class TownshipController extends Controller
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

            $townships = Township::with(['builder', 'city'])
                ->when($request->search, function ($query) use ($request) {

                    $query->where(function ($q) use ($request) {

                        $q->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('location', 'like', '%' . $request->search . '%');
                    });
                })
                ->latest()
                ->paginate(10);

            return view('township.index', compact('townships'));
        } catch (Exception $e) {
            Log::error('Township Index Failed: ' . $e->getMessage());
            Session::flash('error', 'Township Fetch Failed');

            return redirect()->route('admin.dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {

            $builders = Builder::pluck('name', 'id');
            $cities = City::pluck('name', 'id');

            return view('township.create', compact('builders', 'cities'));
        } catch (Exception $e) {
            Log::error('Township Create Failed: ' . $e->getMessage());
            Session::flash('error', 'Township Create Failed');

            return redirect()->route('township.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TownshipRequest $request)
    {
        try {

            $input = $request->validated();

            $input['slug'] = $this->helperService->generateUniqueSlug(
                Township::class,
                $input['slug']
            );

            Township::create($input);

            Session::flash('success', 'Township Created Successfully');
        } catch (Exception $e) {
            Log::error('Township Store Failed: ' . $e->getMessage());
            Session::flash('error', 'Something went wrong');
        }

        return redirect()->route('township.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Township $township)
    {
        try {

            $builders = Builder::pluck('name', 'id');
            $cities = City::pluck('name', 'id');

            return view('township.edit', compact('township', 'builders', 'cities'));
        } catch (Exception $e) {
            Log::error('Township Edit Failed: ' . $e->getMessage());
            Session::flash('error', 'Township Edit Failed');

            return redirect()->route('township.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TownshipUpdateRequest $request, Township $township)
    {
        try {

            $input = $request->validated();

            $input['slug'] = $this->helperService->generateUniqueSlug(
                Township::class,
                $input['slug'],
                $township->id
            );

            $township->update($input);

            Session::flash('success', 'Township Updated Successfully');
        } catch (Exception $e) {
            Log::error('Township Update Failed: ' . $e->getMessage());
            Session::flash('error', 'Something went wrong');
        }

        return redirect()->route('township.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Township $township)
    {
        try {

            $township->load(['builder', 'city']);

            return view('township.show', compact('township'));
        } catch (Exception $e) {
            Log::error('Township Show Failed: ' . $e->getMessage());
            Session::flash('error', 'Township Details Failed');

            return redirect()->route('township.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Township $township)
    {
        try {

            $township->delete();

            Session::flash('success', 'Township Deleted Successfully');
        } catch (Exception $e) {
            Log::error('Township Delete Failed: ' . $e->getMessage());
            Session::flash('error', 'Township Delete Failed');
        }

        return redirect()->route('township.index');
    }

    /**
     *  Bulk Delete
     */
    public function bulkDelete(Request $request)
    {
        try {

            $ids = explode(',', $request->ids);

            if (empty($ids)) {

                Session::flash('error', 'No townships selected');

                return back();
            }

            Township::whereIn('id', $ids)->delete();

            Session::flash('success', 'Selected Townships Deleted Successfully');
        } catch (Exception $e) {
            Log::error('Township Bulk Delete Failed: ' . $e->getMessage());
            Session::flash('error', 'Bulk Delete Failed');
        }

        return redirect()->route('township.index');
    }
}
