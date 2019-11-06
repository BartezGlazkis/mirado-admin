<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommerceController extends Controller
{
    protected $rate;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->rate = DB::table('rate')->pluck('rate_value')->first();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.commerce', ['rate' => $this->rate]);
    }

    public function getKpList(Request $request)
    {
        $user = $request->user();

        $kp_list = [];
        if ($user->is('admin')) {
            $kp_list = DB::table('kp_list')
                ->join('users', 'users.id', '=', 'kp_list.user_id')
                ->select('kp_list.*', 'users.name as user_name')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $kp_list = DB::table('kp_list')
                ->where('user_id', $user->id)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response()->json($kp_list);
    }

    public function getKpBlocks(Request $request)
    {
        $kp_blocks = $this->getBlocksWithPositionsByKp($request->input('kp_id'));
        return response()->json($kp_blocks);
    }

    public function addPosition(Request  $request)
    {
        $kp_id = $request->input('kp');

        $block_id = $request->input('block');

        $position_id = $request->input('position');

        $count = $request->input('count');

        $kp_block_position = [
            'kp_id' => $kp_id,
            'block_id' => $block_id,
            'position_id' => $position_id,
            'count' => $count,
        ];

        DB::table('kp_block_positions')->insert($kp_block_position);
        $this->updateKpSumm($kp_id);
    }

    public function deletePosition(Request  $request)
    {
        $block_position_id = $request->input('block_position_id');

        $kp_id = DB::table('kp_block_positions')->where('id', $block_position_id)->pluck('kp_id')->first();

        DB::table('kp_block_positions')->where('id', $block_position_id)->delete();

        $this->updateKpSumm($kp_id);
    }

    public function add(Request  $request)
    {
        $kp = [];

        $kp['name'] = $request->input('name');
        $kp['email'] = $request->input('email');
        $kp['phone'] = $request->input('phone');
        $kp['user_id'] = $request->user()->id;

        $kp_id = DB::table('kp_list')->insertGetId($kp);

        $blocks = $request->input('blocks');
        if ($blocks) {
            $blocks = explode(",", $blocks);
            $kp_blocks = [];

            foreach ($blocks as $block) {
                $kp_block = [];
                $kp_block['kp_id'] = $kp_id;
                $kp_block['block_id'] = $block;

                $kp_blocks[] = $kp_block;
            }
            DB::table('kp_blocks')->insert($kp_blocks);
        }

        return response()->json($kp_id);
    }

    public function edit(Request  $request)
    {
        $kp_id = $request->input('kp_id');

        $kp = [];

        $kp['name'] = $request->input('name');
        $kp['email'] = $request->input('email');
        $kp['phone'] = $request->input('phone');

        DB::table('kp_list')
            ->where('id', $kp_id)
            ->update($kp);

        $blocks = $request->input('blocks');

        if ($blocks) {
            $blocks = explode(",", $blocks);

            DB::table('kp_blocks')->where('kp_id', $kp_id)->delete();

            $kp_blocks = [];

            foreach ($blocks as $block) {
                $kp_block = [];
                $kp_block['kp_id'] = $kp_id;
                $kp_block['block_id'] = $block;

                $kp_blocks[] = $kp_block;
            }

            DB::table('kp_blocks')->insert($kp_blocks);
        }
    }

    public function delete(Request  $request)
    {
        $kp_id = $request->input('kp_id');

        DB::table('kp_list')->where('id', $kp_id)->delete();

        DB::table('kp_blocks')->where('kp_id', $kp_id)->delete();

        DB::table('kp_block_positions')->where('kp_id', $kp_id)->delete();
    }

    public function addSale(Request  $request)
    {
        $kp_id = $request->input('kp_id');
        $sale = $request->input('sale');

        DB::table('kp_list')->where('id', $kp_id)->update(['sale' => $sale]);
    }

    public function updateKpSumm($kp_id)
    {
        $positions = DB::table("kp_block_positions")
            ->join('price_position', 'kp_block_positions.position_id', '=', 'price_position.id')
            ->where('kp_block_positions.kp_id', $kp_id)
            ->select('price_position.priceYE AS price', 'kp_block_positions.count AS count')
            ->get();

        $summ = 0;
        foreach ($positions as $position) {
            $summ += ($position->count * $position->price * $this->rate);
        }

        DB::table('kp_list')->where('id', $kp_id)->update(['summ' => $summ]);
    }

    public function getBlocksWithPositionsByKp($kp_id)
    {
        $blocks = DB::table('kp_blocks')
            ->join('blocks', 'kp_blocks.block_id', '=', 'blocks.id')
            ->select('blocks.*')
            ->where('kp_blocks.kp_id', $kp_id)
            ->get();

        foreach ($blocks as $i => $block) {

            $block->positions = DB::table('kp_block_positions AS kbp')
                ->join('price_position AS pp', 'kbp.position_id', '=', 'pp.id')
                ->join('categories AS c', 'pp.category', '=', 'c.id')
                ->join('subCategories AS sc', 'pp.subCategory', '=', 'sc.id')
                ->select('kbp.id', 'pp.id as position_id', 'pp.link_img', 'pp.name as position_name', 'pp.priceYE as price', 'kbp.count', 'c.name as category_name', 'sc.name as subCategory_name')
                ->where([
                    'block_id' => $block->id,
                    'kp_id' => $kp_id,
                ])
                ->get();
            $blocks[$i] = $block;
        }
        return $blocks;
    }
}
