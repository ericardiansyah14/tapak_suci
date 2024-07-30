<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return view('welcome');
        
    }

    public function loginPost(Request $request){
        $credetials = [
            'username' => $request->email,
            'password' => $request->pass,
        ];
        if(Auth::attempt($credetials)){
            if(Auth::user()->role == 'admin'){
            Alert::success('Success','Berhasil Login');
            return redirect('/dashboard')->with('success','Berhasil Login');
        }else if(Auth::user()->role == 'pelatih'){
            Alert::success('Success','Berhasil Login');
            return redirect('/Dashpelatih')->with('success','Berhasil Login');
        }
        }else{
           
            return redirect('/')->with('error','gagal Login');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();
        Alert::success('success','Anda Berhasil Logout');
        return redirect()->route('welcome')->with('success', 'Anda Berhasil Logout');
    }
}
