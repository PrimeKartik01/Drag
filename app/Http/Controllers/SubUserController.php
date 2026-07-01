<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\SubUserStoreRequest;
use App\Http\Requests\SubUserUpdateRequest;

// Model
use App\Models\Role;
use App\Models\SubUser;
use Illuminate\Support\Facades\Log;

class SubUserController extends Controller
{

    /**
     * Show Subuser Index Page
     */
    public function index(Request $request)
    {
        $subusers = SubUser::with('role')
            ->when($request->search, function ($query) use ($request) {

                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('subuser.index', compact('subusers'));
    }


    /**
     * Show Subuser Create Page
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        return view('subuser.create', compact('roles'));
    }

    /**
     * Store Subuser Data 
     */
    public function store(SubUserStoreRequest $request)
    {
        try {
            $input = $request->validated();
            $input['password'] = Hash::make($input['password']);
            SubUser::create($input);
            Session::flash('success', 'Subuser Created Successfully.');
        } catch (Exception $e) {
            Log::error('Subuser Create Failed' . $e->getMessage());
            Session::flash('error', 'Something went wrong while creating the subuser');
        }

        return redirect()->route('subuser.create');
    }

    public function edit(SubUser $subuser)
    {
        $roles = Role::pluck('name', 'id');
        return view('subuser.edit', compact('subuser', 'roles'));
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

            $subuser->update($input);
            Session::flash('success', 'Subuser Updated Successfully.');

            return redirect()->route('subuser.index');
        } catch (Exception $e) {
            Log::error('Subuser Update Failed: ' . $e->getMessage());
            Session::flash('error', 'Something went wrong while updating the subuser');

            return redirect()->route('subuser.index');
        }
    }

    /**
     * Delete the Sub User
     */
    public function destroy(SubUser $subuser)
    {
        try {
            $subuser->delete();
            Session::flash('success', 'Subuser Deleted Successfully.');
        } catch (Exception $e) {
            Log::error('Subuser Delete Function Failed' . $e->getMessage());
            Session::flash('error', ' Subuser Deleted Failed');
        }

        return redirect()->route('subuser.index');
    }

    public function status()
    {
        $subusers = SubUser::select('id', 'last_activity_at')->get();

        return response()->json($subusers);
    }
}
