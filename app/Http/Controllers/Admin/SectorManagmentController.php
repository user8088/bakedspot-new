<?php

namespace App\Http\Controllers\Admin;
use App\Models\Sector;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SectorManagmentController extends Controller
{
    public function get_sectorManagmentPage()
    {
        $sectors = Sector::all();
        // dd($sectors);
        return view('admin.modules.sector-managment',compact('sectors'));
    }

    public function get_addnewsectorpage()
    {
        return view('admin.modules.add_sector');
    }

    public function addNewSector(Request $request)
    {
        $request->validate([
            'sector_name' => 'required|string|max:255',
            'delivery_charges' => 'required|numeric|min:0',
        ]);

        try{
            $sector = Sector::create([
                'sector_name' => $request->sector_name,
                'delivery_charges' => $request->delivery_charges
            ]);

            return redirect()->route('get-addnewsectorpage')->with('success', 'Sector added successfully.');
        }
        catch (\Exception $e) {
            \Log::error('sector creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function updateSector(Request $request , $id)
    {
        $sector = Sector::all()->findOrFail($id);
        $request->validate([
            'delivery_charges' => 'required|numeric|min:0',
        ]);
        try
        {
            $sector->update([
                'delivery_charges' => $request->delivery_charges
            ]);

            return redirect()->route('get-sectormanagmentpage')->with('success', 'Delivery cost updated successfully.');
        }
        catch (\Exception $e) {
            \Log::error('sector update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function deleteSector(Request $request ,$id)
    {
        $sector = Sector::all()->findOrFail($id);
        try{
            $sector->delete();
            return redirect()->route('get-sectormanagmentpage')->with('success', 'Sector deleted successfully.');
        }
        catch (\Exception $e) {
            \Log::error('sector deletion error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
