<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;
class CompanyRegistrationController extends Controller
{

    public function create()
    {
        return view('auth.register-company');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
        ]);

        $company = Company::create(['name' => $request->name]);

        // Option 1: Redirect to registration with session data
        return redirect()->route('register')->with('company_id', $company->id);
    }
    //
}
