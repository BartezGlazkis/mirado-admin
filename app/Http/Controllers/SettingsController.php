<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $title;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        
    }

    public function index($table)
    {
        $settings = DB::table($table)->orderBy('id', 'desc')->get();

        switch ($table) {
            case 'categories':
                $this->title = 'Категории';
                break;
            case 'manufacturers':
                $this->title = 'Производители';
                break;
            case 'units':
                $this->title = 'Ед.измерения';
                break;
            case 'suppliers':
                $this->title = 'Поставщики';
                break;
            case 'blocks':
                $this->title = 'Блоки';
                break;
        }

        return view('pages.settings', ['settings' =>  $settings, 'table' =>  $table, 'title' => $this->title]);
    }

    public function add($table, Request $request)
    {

        $name = $request->input('name');

        DB::table($table)->insert(['name' => $name]);

        return redirect()->action('SettingsController@index', ['table' => $table]);
    }

    public function delete($table, Request $request)
    {
        $id = $request->input('id');

        DB::table($table)->where('id', $id)->delete();

        return redirect()->action('SettingsController@index', ['table' => $table]);
    }

    public function edit($table, Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');

        DB::table($table)->where('id', $id)->update(['name' => $name]);

        return redirect()->action('SettingsController@index', ['table' => $table]);
    }

    public function subCategories()
    {
        $subCategories = DB::table('subCategories as sc')->join('categories as c', 'sc.category', '=', 'c.id')->select('sc.*', 'c.name as category_name')->orderBy('id', 'desc')->get();

        $categories = DB::table('categories')->get();

        return view('pages.subCategories', ['subCategories' =>  $subCategories, 'categories' => $categories]);
    }
    public function subCategoryAdd(Request $request)
    {

        $name = $request->input('name');
        $category = $request->input('category');

        DB::table('subCategories')->insert(['name' => $name, 'category' => $category]);

        return redirect()->action('SettingsController@subCategories');
    }
    public function subCategoryEdit(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $category = $request->input('category');

        DB::table('subCategories')->where('id', $id)->update(['name' => $name, 'category' => $category]);

        return redirect()->action('SettingsController@subCategories');
    }
    public function subCategoryDelete(Request $request)
    {
        $id = $request->input('id');

        DB::table('subCategories')->where('id', $id)->delete();

        return redirect()->action('SettingsController@subCategories');
    }
}
