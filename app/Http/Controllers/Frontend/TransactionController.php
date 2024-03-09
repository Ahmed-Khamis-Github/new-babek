<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
        public function showTransactions()
        {
            $userTransactions = Transaction::with('formSubmission')
            ->where('user_id', auth()->id())
            ->get();
            

            return view('frontend.dashboard.pages.transactions.index', ['transactions' => $userTransactions]);
        }

    public function markAsCompleted($id)
    {
        // Fetch the form submission by ID
        $submission = FormSubmission::findOrFail($id);

        

        // Update the status to 'completed'
        $submission->update(['status' => 'completed']);

         return redirect('form-builder/forms');

    }
}
