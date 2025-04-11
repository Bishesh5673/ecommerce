<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\SellerRequestNotification;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function home()
    {
        $offer_products = Product::where('stock', true)->where('discount', '>', 0)->get();
        return view('frontend.home', compact('offer_products'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function seller_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:sellers',
            'contact_number' => 'required',
            'address' => 'required',
            'pan_no' => 'required',
            'reg_no' => 'required',
        ]);

        $seller = new Seller();
        $seller->name = $request->name;
        $seller->email = $request->email;
        $seller->contact_number = $request->contact_number;
        $seller->address = $request->address;
        $seller->pan_no = $request->pan_no;
        $seller->reg_no = $request->reg_no;
        $seller->password = Hash::make(uniqid());
        $seller->save();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
        ];
        $admins = Admin::all();
        // foreach ($admins as $admin) {
        //     Mail::to($admin->email)->send(new SellerRequestNotification());
        // }
        Mail::to($admins)->send(new SellerRequestNotification($data));
        return redirect()->route('home');
    }
    public function compare(Request $request)
    {
        $q = $request->q;
        $results = Product::where('name',"like","%$q%")->orderBy('price','asc')->get();
        return view('frontend.compare', compact('results','q'));
    }
}
