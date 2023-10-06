<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Tag;
use Illuminate\Http\Request;

use Session;
use Image;
use File;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session::put('menu', 'Offers');
        $pagetitle = 'Offers';
        $offers = Offer::get();
        $tags = Tag::get();

        return  view('offers', compact('offers', 'tags', 'pagetitle'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $this->validate(
            $request,
            [
                'Title' => 'required',
                'Days'   => 'required',
                'Image'  => 'required'
            ]
        );


        if (!empty($input['new_items'])) {
            $input['dropdown_items'] = array_merge($input['dropdown_items'], $input['new_items']);
        }
        $input['GroupTag'] = implode(",", $input['dropdown_items']);

        $imageName = null;
        $image = $request->file('Image');
        if ($image) {
            $imageName = time() . '.' . $image->extension();
            $destinationPath = public_path('/uploads/thumbnail');
            $img = Image::make($image->path());
            $img->resize(400, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $imageName);
            $destinationPath = public_path('uploads');
            $image->move($destinationPath, $imageName);
        }
        $input['Image'] = $imageName;
        Offer::create($input);
        return redirect()->route('offers.index')->with([
            'message' => 'Offer saved successfully!',
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        session::put('menu', 'Offers');
        $pagetitle = 'Offers';
        $offers = Offer::get();
        $tags = Tag::get();




        return  view('offers', compact('offers', 'offer', 'pagetitle','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        $imageName = '';

        if ($request->hasFile('Image')) {
            $image = $request->file('Image');
            $imageName = time() . '.' . $image->extension();
            $destinationPath = public_path('/uploads/thumbnail');
            $img = Image::make($image->path());
            $img->resize(400, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $imageName);
            $destinationPath = public_path('uploads');
            $image->move($destinationPath, $imageName);
            if ($offer->image) {
                \Storage::delete('public/uploads/thumbnail/' . $offer->image);
                \Storage::delete('public/uploads/' . $offer->image);
            }
        } else {
            $imageName = $offer->Image;
        }



        if (!empty($request->input('new_items'))) {
           $dropdown_items = array_merge($request->input('dropdown_items'), $request->input('new_items'));
        }else{
            $dropdown_items =$request->input('dropdown_items');
        }
        

        $offer->Title = $request->input('Title');
        $offer->Description = trim($request->input('Description'));
        $offer->Days = trim($request->input('Days'));
        $offer->discount = trim($request->input('discount'));
        $offer->image = $imageName;

        $offer->OfferType = trim($request->input('OfferType'));

        $offer->Level =  trim($request->input('Level'));
        
        $offer->GroupTag = implode(",",  $dropdown_items);

        $offer->save();
        return redirect()->route('offers.index')->with([
            'message' => 'Offer updated successfully!',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        if ($offer->Image) {
            \Storage::delete('public/uploads/' . $offer->Image);

            \Storage::delete('public/uploads/thumbnail/' . $offer->Image);
        }
        $offer->delete();
        return redirect()->route('offers.index')->with([
            'message' => 'Offer deleted successfully!',
            'status' => 'success'
        ]);
    }

    public function saveTag(Request $request)
    {
        $tag = new Tag;
        $tag->TagName = $request->tag_name;
        $tag->save();
        return response()->json([
            'tag_name' => $request->tag_name,
        ]);
    }
}
