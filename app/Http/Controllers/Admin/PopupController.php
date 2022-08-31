<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Popup;
use App\Image;

use App\Http\Controllers\Controller;
use App\Http\Requests\PopupStoreRequest;
use App\Traits\UploadTrait;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class PopupController extends Controller
{
    use UploadTrait;

    function __construct()
    {
        $this->middleware('can:create popup', ['only' => ['create', 'store']]);
        $this->middleware('can:edit popup', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete popup', ['only' => ['destroy']]);
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.popup.index'); 
        
    }

    /**
     * Datatables Ajax Data
     *
     * @return mixed
     * @throws \Exception
     */
    public function datatables(Request $request)
    {

        if ($request->ajax() == true) {
            $data = Popup::select([
                'id',
                'title',
                'content',
                'image', 
                'bt_name', 
            ]);

            return Datatables::eloquent($data)
                ->addColumn('action', function ($data) {
                    
                    $html='';
                    if (auth()->user()->can('edit popup')){
                        $html.= '<a href="'.  route('admin.popup.edit', ['popup' => $data->id]) .'" class="btn btn-success btn-sm float-left mr-3"  id="popup-modal-button"><span tooltip="Edit" flow="left"><i class="fas fa-edit"></i></span></a>';
                    }

                    if (auth()->user()->can('edit popup')){
                        $html.= '<form method="post" class="float-left delete-form" action="'.  route('admin.popup.destroy', ['popup' => $data->id ]) .'"><input type="hidden" name="_token" value="'. Session::token() .'"><input type="hidden" name="_method" value="delete"><button type="submit" class="btn btn-danger btn-sm"><span tooltip="Delete" flow="right"><i class="fas fa-trash"></i></span></button></form>';
                    }

                    return $html; 
                })
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.popup.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PopupStoreRequest $request)
    {
        try {

            $user = auth()->user()->id;
            $popup = new Popup();
            $popup->title = $request->title;
            $popup->content = $request->content;
            $popup->image = $request->image; 
            $popup->bt_name = $request->bt_name; 
            $popup->save();

            //Session::flash('success', 'Popup was created successfully.');
            //return redirect()->route('popup.index');

            return response()->json([
                'success' => 'Popup was created successfully.' // for status 200
            ]);

        } catch (\Exception $exception) {

            DB::rollBack();

            //Session::flash('failed', $exception->getMessage() . ' ' . $exception->getLine());
            /*return redirect()->back()->withInput($request->all());*/

            return response()->json([
                'error' => $exception->getMessage() . ' ' . $exception->getLine() // for status 200
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Popup  $popup
     * @return \Illuminate\Http\Response
     */
    public function show(Popup $popup)
    {
         return view('admin.popup.show', compact('popup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Popup  $popup
     * @return \Illuminate\Http\Response
     */
    public function edit(Popup $popup)
    {
        return view('admin.popup.edit', compact('popup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Popup  $popup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Popup $popup)
    {
        try {

            if (empty($popup)) {
                //Session::flash('failed', 'Hobby Update Denied');
                //return redirect()->back();
                return response()->json([
                    'error' => 'Popup update denied.' // for status 200
                ]);   
            }

            $user = auth()->user()->id;
            $popup->title = $request->title;
            $popup->content = $request->content;
            $popup->image = $request->image;
            $popup->bt_name = $request->bt_name;
            $popup->save();

            //Session::flash('success', 'A popup updated successfully.');
            //return redirect('admin/popup');

            return response()->json([
                'success' => 'Popup update successfully.' // for status 200
            ]);

        } catch (\Exception $exception) {

            DB::rollBack();

            //Session::flash('failed', $exception->getMessage() . ' ' . $exception->getLine());
            /*return redirect()->back()->withInput($request->all());*/

            return response()->json([
                'error' => $exception->getMessage() . ' ' . $exception->getLine() // for status 200
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Popup  $popup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Popup $popup)
    {
        $popup->delete();
        //return redirect('admin/popup')->with('success', 'Popup deleted successfully.');
        return response()->json([
            'success' => 'Popup deleted successfully.' // for status 200
        ]);
    }
}
