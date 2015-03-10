<?php

class BannerResource extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /banner
     *
     * @return Response
     */
    public function index()
    {
        $banners = Banner::paginate(10);
        return View::make('banner.index')->withBanners($banners);
    }

    /**
     * Show the form for creating a new resource.
     * GET /banner/create
     *
     * @return Response
     */
    public function create()
    {
        return View::make('banner.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /banner
     *
     * @return Response
     */
    public function store()
    {
        if (Input::hasFile('file'))
        {
            $path = public_path() . '/photo/';
            $filename = $original = Input::file('file')->getClientOriginalName();
            $extension = Input::file('file')->getClientOriginalExtension();
            while (File::exists($path . $filename))
            {
                $filename = time() . '_' . $original;
            }
            $file = Input::file('file')->move($path, $filename);

            $banner = new Banner;
            $banner->name = Input::get('name');
            $banner->image_data = Input::get('url');
            $banner->picture = url('/photo/' . $filename);
            $banner->save();
            return Redirect::to('banner');
        }
    }

    /**
     * Display the specified resource.
     * GET /banner/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $banner = Banner::find($id);
        $banner->delete();
        return Redirect::to('banner');
    }

    /**
     * Show the form for editing the specified resource.
     * GET /banner/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $banner = Banner::find($id);
        $banner->is_active = $banner->is_active == 'true' ? 'false' : 'true';
        $banner->save();
        return Redirect::to('banner');
    }

    /**
     * Update the specified resource in storage.
     * PUT /banner/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /banner/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
