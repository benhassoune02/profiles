<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankTransferOrder;
use Illuminate\Support\Facades\DB;



class TransferBankController extends Controller
{
    public function viewbanktransfers()
    {
        
        $banktransfers = BankTransferOrder::with('client')->get();
        return view('admin.bank_transfer', compact('banktransfers'));
    }

    public function confirmTransfer($id)
    {
        DB::table('bank_transfer_orders')
            ->where('id', $id)
            ->update(['payment_status' => 'confirmed']);

        return back()->with('success', 'Transfer confirmed successfully.');
    }

    public function cancelTransfer($id)
    {
        DB::table('bank_transfer_orders')
            ->where('id', $id)
            ->update(['payment_status' => 'cancelled']);

        return back()->with('error', 'Transfer cancelled.');
    }

    public function deleteBankTransfer($id)
    {
        $bankTransfer = BankTransferOrder::find($id);
    
        if ($bankTransfer) {
            $bankTransfer->delete();
            return redirect()->route('banktransfers')->with('success', 'Bank transfer deleted successfully.');
        } else {
            return redirect()->route('banktransfers')->with('error', 'Bank transfer not found.');
        }
    }

}
