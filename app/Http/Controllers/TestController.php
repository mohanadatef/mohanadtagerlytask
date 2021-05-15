<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jsonString = file_get_contents(base_path("public/DataProviderX.json"));
        $data = json_decode($jsonString, true);
        foreach ($data as $keys => $value) {
            if (isset($request->product_name) && !empty($request->product_name)) {
                if (strtolower($value['product_name']) != strtolower($request->product_name)) {
                    unset($data[$keys]);
                }
            }
            if (isset($request->vendor_name) && !empty($request->vendor_name)) {
                if (strtolower($value['vendor_name']) != strtolower($request->vendor_name)) {
                    unset($data[$keys]);
                }
            }
            if (isset($request->pricemin) && isset($request->pricemax) && !empty($request->pricemin) && !empty($request->pricemax)) {
                if ($value['price'] >= $request->pricemin && $value['price'] <= $request->pricemax) {
                    continue;
                } else {
                    unset($data[$keys]);
                }
            }
        }
        if (isset($request->sort) && !empty($request->sort)) {
            if ($request->sort == 'price') {
                $column_sort = array_column($data, 'price');
            }
            if ($request->sort == 'most_selling') {
                $datas=array();
                $x=0;
                $column_sort=array_column($data, 'vendor_name');
                $column_sorts=array_count_values(array_column($data, 'vendor_name'));
                arsort($column_sorts);
                foreach ($column_sorts as $keys => $values)
                {
                    foreach ($column_sort as $key => $value)
                    {
                        if($keys == $value)
                        {
                            $datas[$x]= $data[$key];
                            $x++;
                        }
                    }

                }
                return response($datas);
            }
            if ($request->sort == 'customer_votes') {
                $column_sort = array_column($data, 'customer_votes');
            }
            array_multisort($column_sort, SORT_ASC, SORT_REGULAR,$data);
        }
        return response($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
