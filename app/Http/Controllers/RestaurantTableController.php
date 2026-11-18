<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantTable\StoreRestaurantTableRequest;
use App\Http\Requests\RestaurantTable\UpdateRestaurantTableRequest;
use App\Models\RestaurantTable;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Manoar\QrCode\Facades\QrCode;

class RestaurantTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');
        $type = request('type');
        $tables = RestaurantTable::query()->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })->when($type, function ($query, $type) {
            return $query->where('type', $type);
        })->paginate(12)->withQueryString();

        // $url = route('restaurant-tables.qr.show',$tables->unique_token);
        // $qr = QrCode::size(200)->formate('svg')->generate($url);

        return view('dashboard.admin.restaurant-tables.index', compact('tables', 'status', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = ['ground floor', 'first floor', 'garden'];
        // $areas = ['Ground Floor', 'First Floor', 'Garden'];
        return view('dashboard.admin.restaurant-tables.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantTableRequest $request)
    {
        // dd($request->toArray());
        $data = $request->validated();
        $data['unique_token'] = Str::uuid()->toString();
        // dd($data);
        RestaurantTable::create($data);
        return redirect()->route('restaurant-tables.index')->with('status', "Restaurant Table Number {$data['table_number']} Created Successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(RestaurantTable $restaurantTable)
    {
        $restaurantTable->get();
        return view('dashboard.admin.restaurant-tables.show', compact('restaurantTable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RestaurantTable $restaurantTable)
    {
        $areas = ['ground floor', 'first floor', 'garden'];
        // $areas = ['Ground Floor', 'First Floor', 'Garden'];
        $restaurantTable->get();
        return view('dashboard.admin.restaurant-tables.edit', compact('restaurantTable', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantTableRequest $request, RestaurantTable $restaurantTable)
    {
        // dd($request->toArray());
        $data = $request->validated();
        $restaurantTable->update($data);
        return redirect()->route('restaurant-tables.index')->with('status', 'Restaurant Table Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestaurantTable $restaurantTable)
    {
        $table_number = $restaurantTable->table_number;
        $restaurantTable->delete();
        return redirect()->route('restaurant-tables.index')->with('status', "{$table_number} Table Deleted Successfully!");
    }
    public function qrRegenerate(RestaurantTable $restaurantTable)
    {
        // dd($restaurantTable->table_number);

        $restaurantTable->update(['unique_token' => Str::uuid()->toString(),]);

        return back()->with('status', 'New Qr Code Generated Successfully!');
    }
    public function qrBulkGenerate()
    {
        $tables = RestaurantTable::get();
        foreach ($tables as $table)
            $table->update(['unique_token' => Str::uuid()->toString(),]);
        return back()->with('status', 'All Qr Code Regenerated Successfully!');
    }
    public function qrShow(string $token)
    {
        $id = request('token');
        $restaurantTable = RestaurantTable::findOrFail($id);
        $token = $restaurantTable->unique_token;

        $menuUrl = route('customer.menu', $token);

        // dd($id);
        // dd($restaurantTable);
        // $qr = QrCode::size(300)->format('svg')->generate($menuUrl);
        $qr = QrCode::size(300)->format('png')->generate($restaurantTable->unique_token);


        return view('dashboard.admin.restaurant-tables.qr', compact('qr', 'restaurantTable', 'menuUrl'));
    }

    public function qrDownload(RestaurantTable $restaurantTable, string $flag)
    {
        // dd($restaurantTable->table_number);
        $customerUrl = route('customer.menu', $restaurantTable->unique_token);

        $qr = QrCode::size(300)
            ->format($flag ?? 'svg')
            ->margin(2)
            ->generate($customerUrl);

        if ($flag == 'png') {
            $filename = 'table-' . $restaurantTable->table_number . '-qr.png';
        } else {
            $filename = 'table-' . $restaurantTable->table_number . '-qr.svg';
        }

        return response($qr->toHtml(), 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
