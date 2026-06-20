<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\SubUserStoreRequest;
use App\Http\Requests\SubUserUpdateRequest;

// Model
use App\Models\SubUser;
use Illuminate\Support\Facades\Log;

class SubUserController extends Controller
{

    /**
     * Show Subuser Index Page
     */
    public function index(Request $request)
    {
        $subusers = SubUser::when($request->search, function ($query) use ($request) {

            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        })->latest()->paginate(10);

        return view('subuser.index', compact('subusers'));
    }


    /**
     * Show Subuser Create Page
     */
    public function create()
    {
        return view('subuser.create');
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

            return redirect()->route('subuser.create');
        } catch (\Exception $e) {

            Log::error('Subuser Create Failed' . $e->getMessage());
            Session::flash('error', 'Something went wrong while creating the subuser');

            return redirect()->route('subuser.index');
        }
    }

    public function edit(SubUser $subuser)
    {
        return view('subuser.edit', compact('subuser'));
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
        } catch (\Exception $e) {

            Log::error('Subuser Update Failed: ' . $e->getMessage());
            Session::flash('error', 'Something went wrong while updating the subuser');

            return redirect()->route('subuser.index');
        }
    }

    public function destroy(SubUser $subuser)
    {
        $subuser->delete();

        return redirect()->route('subuser.index')->with('success', 'Sub User Deleted Successfully');
    }
}
