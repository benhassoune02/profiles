<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;
use App\Models\Profile;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function loginClient() 
    {

        return view('client.login');
    
    }

    public function check(Request $request) 
    {
        
        $check = $request->all();
        if (Auth::guard('client')->attempt(['email'=>$check['email'], 'password'=>$check['password']])) {
            return redirect()->route('client_profiles');

        }else{
            return redirect()->back()->with('error', 'Invalid Email Or Password !'); 
        }

    }

    public function showRegistrationForm()
    {
        return view('client.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|min:8', ], [
            'password' => 'Password must have 8 characters !',
            'email.unique' => 'You are already registered with this email. Please SIGN IN !',
        ]);
        

        $client = new Client([
            'name' => $request ->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $client->save();

        return redirect()->route('login_client')->with('success', 'Client you should log in now ');
    }

    public function editProfile()
    {
        $client = auth()->guard('client')->user();
        return view('client.edit_profile_client', compact('client'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email,' . auth()->guard('client')->id(),
            'password' => 'nullable|min:6|confirmed',
        ]);
    
        $client = auth()->guard('client')->user();
    
        $client->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->filled('password') ? Hash::make($request->input('password')) : $client->password,
        ]);
    
        return redirect()->route('edit_profile')->with('success', 'Profile updated successfully!');
    }

    public function logoutClient(Request $request)
    {
        
        Auth::guard('client')->logout();

        $request->session()->invalidate();

        return redirect()->route('login_client');
    }
    

    public function clientprofiles()
    {
        $clientId = Auth::guard('client')->id();
        
        // Retrieve all profiles that are not part of a pending bank transfer for the current client
        // and are not already purchased by the current client.
        $profiles = Profile::whereDoesntHave('bankTransferOrders', function ($query) use ($clientId) {
            $query->where('client_id', $clientId)
                  ->where('payment_status', 'pending');
        })
        ->get();
    
        return view('client.profilesClient', compact('profiles'));
    }

    public function showPurchasePage($id)
    {
        $profile = Profile::findOrFail($id);
        return view('client.purchase', compact('profile'));
    }
}
