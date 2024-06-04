<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileManageController extends Controller
{

    public function index()
    {
        $profiles = Profile::all(); 
        return view('admin.all_profiles', compact('profiles')); 
    }

    public function createProfile()
    {
        return view('admin.add_profile');
    }

    public function storeProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:300', 
            'price' => 'required|numeric',
        ]);

        $profile = new Profile;
        $profile->name = $validatedData['name'];
        $profile->email = $validatedData['email'];
        $profile->phone_number = $validatedData['phone_number'];
        $profile->address = $validatedData['address']; 
        $profile->price = $validatedData['price'];
    
        $profile->save();

        return redirect()->route('profile_create')->with('success', 'Profile created successfully');
    }

    public function edit($id)
    {

        $profile = Profile::findOrFail($id);
        return view('admin.edit_profile', compact('profile'));
    
    }

    public function updateProfile(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email,' . $id, 
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:300',
            'price' => 'required|numeric',
        ]);

        $profile = Profile::findOrFail($id);
        $profile->name = $validatedData['name'];
        $profile->email = $validatedData['email'];
        $profile->phone_number = $validatedData['phone_number'];
        $profile->address = $validatedData['address'];
        $profile->price = $validatedData['price'];

        $profile->save();

        return redirect()->route('all_profiles')->with('success', 'Profile updated successfully');
    }

    public function destroyProfile($id)
    {
        $profile = Profile::findOrFail($id); 
        $profile->delete(); 

        return redirect()->route('all_profiles')->with('success', 'Profile deleted successfully');
    }

    public function searchProfiles(Request $request)
    {
        $search = $request->input('search');

        $profiles = Profile::query()
            ->where('name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhere('address', 'like', "%$search%")
            ->orWhere('phone_number', 'like', "%$search%")
            ->get();

        if ($profiles->isEmpty()) {
            $message = 'No profiles found with the given search criteria.';
        }

        return view('admin.all_profiles', ['profiles' => $profiles, 'message' => '']);
    }
}