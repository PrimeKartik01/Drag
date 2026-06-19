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
     * Show Employee
     */
    public function index(Request $request)
    {
        $subusers = SubUser::when($request->search, function ($query) use ($request) {

            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        })->latest()->paginate(10);


        return view('subuser.index', compact('subusers'));
    }


    public function create()
    {
        return view('subuser.create');
    }

    public function store(SubUserStoreRequest $request)
    {
        try {

            $input = $request->validated();
            $input['password'] = Hash::make($input['password']);
            SubUser::create($input);
            Session::flash('success', 'Subuser created successfully.');

            return redirect()->route('subuser.create');
        } catch (\Exception $e) {

            Log::error('Problem in the subuser store function' . $e->getMessage());
            Session::flash('error', 'Something went wrong: ' . $e->getMessage());

            return redirect()->route('subuser.index');
        }
    }

    public function edit(SubUser $subuser)
    {
        return view('admin.subuser.edit', compact('subuser'));
    }

    public function update(SubUserUpdateRequest $request, SubUser $subuser)
    {
        $input = $request->validated();

        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        } else {
            unset($input['password']);
        }

        $subuser->update($input);

        return redirect()->route('subuser.index')->with('success', 'Sub User Updated Successfully');
    }

    public function destroy(SubUser $subuser)
    {
        $subuser->delete();

        return redirect()->route('subuser.index')->with('success', 'Sub User Deleted Successfully');
    }
}
