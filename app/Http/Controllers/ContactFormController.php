<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;


class ContactFormController extends Controller
{
    public function processForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20', 
            'address' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'message' => $request->input('message'),
        ]);

        return redirect()->route('home')->with('success', 'Thank you for your inquiry! We will get in touch with you soon.');
    }
    
    public function viewAllContacts()
    {
        $contacts = Contact::all();

        return view('admin.contacts', compact('contacts'));
    }

    public function deleteContact($id)
    {

        $contact = Contact::find($id);

        if ($contact) {
            $contact->delete();
            return redirect()->route('all_contacts')->with('success', 'Contact deleted successfully.');
        } else {
            return redirect()->route('all_contacts')->with('error', 'Contact not found.');
        }
    }
}
