<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\SubUserStoreRequest;
use App\Http\Requests\SubUserUpdateRequest;

// Model
use App\Models\Role;
use App\Models\SubUser;

class SubUserController extends Controller
{

    /**
     * Show Subuser Index Page
     */
    public function index(Request $request)
    {
        try {
            $subusers = SubUser::with('role')
                ->when($request->search, function ($query) use ($request) {

                    $query->where(function ($q) use ($request) {

                        $q->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                    });
                })
                ->latest()
                ->paginate(10);

            return view('subuser.index', compact('subusers'));
        } catch (Exception $e) {
            Log::error('Subuser Index Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Subuser Fetch Failed');

            return redirect()->route('admin.dashboard');
        }
    }


    /**
     * Show Subuser Create Page
     */
    public function create()
    {
        try {
            $roles = Role::pluck('name', 'id');

            return view('subuser.create', compact('roles'));
        } catch (Exception $e) {
            Log::error('Subuser Create Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Subuser Create Failed');

            return redirect()->route('subuser.index');
        }
    }

    /**
     * Store Subuser Data 
     */
    public function store(SubUserStoreRequest $request)
    {
        $newPhoto = null;

        try {
            $input = $request->validated();
            $input['password'] = Hash::make($input['password']);

            if ($request->hasFile('photo')) {
                $newPhoto = $request->file('photo')->store('subusers', 'public');
                $input['photo'] = $newPhoto;
            }

            SubUser::create($input);
            Session::flash('success', 'Subuser Created Successfully.');
        } catch (Exception $e) {
            // Delete uploaded image if database insert fails
            if ($newPhoto && Storage::disk('public')->exists($newPhoto)) {
                Storage::disk('public')->delete($newPhoto);
            }

            Log::error('Subuser Store Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Something went wrong while creating the subuser');
        }

        return redirect()->route('subuser.index');
    }

    public function edit(SubUser $subuser)
    {
        try {
            $roles = Role::pluck('name', 'id');

            return view('subuser.edit', compact('subuser', 'roles'));
        } catch (Exception $e) {
            Log::error('Subuser Edit Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Subuser Edit Failed');

            return redirect()->route('subuser.index');
        }
    }

    /**
     * Update Password
     */
    public function update(SubUserUpdateRequest $request, SubUser $subuser)
    {
        try {
            $input = $request->validated();

            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                unset($input['password']);
            }

            $oldPhoto = $subuser->photo;
            $newPhoto = null;

            if ($request->hasFile('photo')) {
                $newPhoto = $request->file('photo')->store('subusers', 'public');
                $input['photo'] = $newPhoto;
            } else {
                $input['photo'] = $oldPhoto;
            }

            $subuser->update($input);

            // Delete old photo only after successful DB update
            if ($newPhoto && $oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
                Storage::disk('public')->delete($oldPhoto);
            }

            Session::flash('success', 'Subuser Updated Successfully.');
        } catch (Exception $e) {
            // Rollback newly uploaded photo if DB update fails
            if (isset($newPhoto) && $newPhoto && Storage::disk('public')->exists($newPhoto)) {
                Storage::disk('public')->delete($newPhoto);
            }

            Log::error('Subuser Update Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Something went wrong while updating the subuser');
        }

        return redirect()->route('subuser.index');
    }

    /**
     * Delete the Sub User
     */
    public function delete(SubUser $subuser)
    {
        try {
            $subuser->delete();
            Session::flash('success', 'Subuser Deleted Successfully.');
        } catch (Exception $e) {
            Log::error('Subuser Delete Function Failed: ' . $e->getMessage());
            Session::flash('error', ' Subuser Deletion Failed');
        }

        return redirect()->route('subuser.index');
    }

    public function show(SubUser $subuser)
    {
        return view('subuser.show', compact('subuser'));
    }

    public function status()
    {
        try {

            $subusers = SubUser::select('id', 'last_activity_at')->get();

            return response()->json($subusers);
        } catch (Exception $e) {
            Log::error('Subuser Status Function Failed: ' . $e->getMessage());

            return response()->json([], 500);
        }
    }
}
