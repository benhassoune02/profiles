<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;




class ClientManageController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('admin.all_clients' , compact('clients'));
    }

    public function addClient()
    {
        return view('admin.add_clients');
    }

    public function storeClient(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:clients|max:255',
                'password' => 'required|string|max:255',
            ]);
    
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
    
            $client = new Client();
            $client->name = $request->input('name');
            $client->email = $request->input('email');
            $client->password = Hash::make($request->input('password'));
            $client->save();
    
            return redirect()->route('all_clients')->with('success', 'Client added successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while adding the client.');
        }
    }

    public function editClient($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.edit_client', compact('client'));
    }

    public function updateClient(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $client = Client::findOrFail($id);
        $client->name = $validatedData['name'];
        $client->email = $validatedData['email'];

        if (!empty($validatedData['password'])) {
            $client->password = bcrypt($validatedData['password']);
        }

        $client->save();

        return redirect()->route('all_clients')->with('success', 'Client updated successfully.');
    }


    public function destroyClient($id)
    {
        $client = Client::findOrFail($id); 
        $client->delete(); 

        return redirect()->route('all_clients')->with('success', 'Client deleted successfully');
    }
}
