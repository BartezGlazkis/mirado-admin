<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PriceListController extends Controller
{

    protected $view = 'pages.priceList';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view($this->view);
    }

    public function getPositions(Request $request)
    {
        $category = $request->input('category');
        $subCategory = $request->input('subCategory');
        $keyword = $request->input('keyword');
        if ($category || $subCategory || $keyword) {
            $query = DB::table('price_position AS pp')
                ->join('units as u', 'pp.unit', '=', 'u.id')
                ->join('suppliers as s', 'pp.supplier', '=', 's.id')
                ->join('manufacturers as m', 'pp.manufacturer', '=', 'm.id')
                ->select('pp.*', 'u.name as unit_name', 's.name as supplier_name', 'm.name as manufacturer_name');

            $query->when($category, function ($query) use ($category) {
                return $query->where('category', $category);
            });

            $query->when($subCategory, function ($query) use ($subCategory) {
                return $query->where('subCategory', $subCategory);
            });

            $query->when($keyword, function ($query) use ($keyword) {
                return $query->where('pp.name', 'LIKE',  '%' . $keyword . '%');
            });

            $positions = $query->orderBy('pp.id', 'desc')
                ->get();

            return response()->json($positions);
        } else {
            $positions = DB::table('price_position AS pp')
                ->join('units as u', 'pp.unit', '=', 'u.id')
                ->join('suppliers as s', 'pp.supplier', '=', 's.id')
                ->join('manufacturers as m', 'pp.manufacturer', '=', 'm.id')
                ->select('pp.*', 'u.name as unit_name', 's.name as supplier_name', 'm.name as manufacturer_name')
                ->orderBy('pp.id', 'desc')
                ->limit(20)
                ->get();
            return response()->json($positions);
        }
    }

    public function add(Request $request)
    {
        $position = [];
        $position['name'] = $request->input('name');
        $position['art'] = $request->input('art');
        $position['supplier'] = $request->input('supplier');
        $position['manufacturer'] = $request->input('manufacturer');
        $position['unit'] = $request->input('unit');
        $position['priceYE'] = $request->input('priceYE');
        $position['comment'] = $request->input('comment');
        $position['dateCr'] = date("m.d.Y G:i");
        $position['category'] = $request->get('category');
        $position['subCategory'] = $request->get('subcategory');
        if ($request->has('link_img')) {
            $image = $request->file('link_img');
            $name = Str::slug($position['name'] . '_' . date("H_m_s"), '_')  . '.' . $image->getClientOriginalExtension();

            Storage::disk('public')->putFileAs('uploads/images/', $image, $name);

            $position['link_img'] = $name;
        }

        DB::table('price_position')
            ->insert($position);

    }

    public function edit(Request $request)
    {
        $position = [];
        $position['id'] = $request->input('id');
        $position['name'] = $request->input('name');
        $position['art'] = $request->input('art');
        $position['supplier'] = $request->input('supplier');
        $position['manufacturer'] = $request->input('manufacturer');
        $position['unit'] = $request->input('unit');
        $position['priceYE'] = $request->input('priceYE');
        $position['comment'] = $request->input('comment');
        $position['category'] = $request->get('category');
        $position['subCategory'] = $request->get('subcategory');

        if ($request->has('link_img')) {
            $image = $request->file('link_img');
            $name = Str::slug($position['name'] . '_' . date("H_m_s"), '_')  . '.' . $image->getClientOriginalExtension();

            Storage::disk('public')->putFileAs('uploads/images/', $image, $name);

            $position['link_img'] = $name;
        }

        DB::table('price_position')
            ->where('id', $position['id'])
            ->update($position);
        return response()->json($position);
    }

    public function delete(Request $request)
    {
        $position_id = $request->input('id');
        if ($position_id && $link_img = $request->has('link_img')) {

            DB::table('price_position')->where('id', $position_id)->delete();

            Storage::delete($link_img);
        }
    }
}
