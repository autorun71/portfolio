<?php

namespace Webkul\Ecom\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Webkul\Region\Http\Requests\Region\RegionSaveRequest;
use Illuminate\Contracts\View\Factory;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

use Illuminate\View\View;
use Webkul\Region\Models\Region;
use Webkul\Region\Repositories\RegionPropsRepository;
use Webkul\Region\Repositories\RegionRepository;
//use Webkul\Region\Models\Region;

class ImportTypeController extends Controller
{
    protected $_config;

    protected $regionRepository;
    protected $regionPropsRepository;
    public function __construct()
    {
        $this->_config = request('_config');

        $this->regionRepository = app(RegionRepository::class);
        $this->regionPropsRepository = app(RegionPropsRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {


        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view($this->_config['view']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RegionSaveRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RegionSaveRequest $request)
    {
        $data = $request->input();

        if (empty($data['alias'])) {
            $data['alias'] = Str::slug($data['alias']);
        }
        $item = new Region($data);
        $item->save();

        if ($item) {
            return redirect()
                ->route('admin.region.index')
                ->with(["success" => trans('region::app.section.main.create-success')]);
        } else {
            return back()
                ->withErrors(["msg" => trans('region::app.section.main.create-error')])
                ->withInput();
        }

//        Event::dispatch('core.locale.create.before');


//        Event::dispatch('core.locale.create.after', $locale);


    }

        /**
         * Display the specified resource.
         *
         * @param int $id
         * @return void
         */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param Request $request
     * @return Factory|View
     */
    public function edit($id, Request $request)
    {
        $params = $request->all();
        $channel = 1;
        if (!empty($params) && !empty($params['channel'])){
            $channel = $params['channel'];
        }
        $region = $this->regionRepository->getEdit($id);
        $props = $this->regionPropsRepository->getPropsWithValueForRegionAndChannel($id, $channel);
        $channels = $this->regionRepository->getChannelsForRegion($id)->all();
        $selectedOptionIds = array_map(fn ($channel) => $channel['id'], $channels);

        return view($this->_config['view'], compact('region', 'props', 'channel', 'selectedOptionIds'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $props = $request->props;

        $item = $this->regionRepository->getEdit($id);
        if (empty($item)) {
            return back()
                ->withErrors(["msg" => "Регион id=[$id] не найден"])
                ->withInput();
        }
        $data = $request->all();
        $channels = [];
        if (!empty($data['channels']) && !in_array(0, $data['channels'])){
            $channels = array_map(fn ($channel) => (int) $channel, $data['channels']);
        }
        $item->channels()->sync($channels);
        $result = $item->update($data);
        foreach ($props as $prop){


            try {
                $item->regionProps()->attach($prop['id'], ['value' => $prop['value'], 'channels_id' => $data['channels_id']]);
            }catch (\Exception $e){

                $this->regionRepository->saveRegionWithPropsAndChannel($item->id, $prop['id'], $data['channels_id'], $prop['value']);
            }
        }
        if ($result) {
            return redirect()
                ->route($this->_config['redirect'], $item->id)
                ->with(["success" => "Успешно сохранено"]);
        } else {
            return back()
                ->withErrors(["msg" => "Ошибка сохранения"])
                ->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response|bool
     */
    public function destroy($id)
    {
        $item = $this->regionRepository->getEdit($id);
//        return response()->json([$item]);
        if($item->delete()){
            return \response()->json(['result' => true]);
        }


    }
}
