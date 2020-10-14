<?php

namespace Webkul\Region\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Webkul\Region\Http\Requests\Props\RegionPropsSaveRequest;
use Illuminate\Contracts\View\Factory;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

use Illuminate\View\View;
use Webkul\Region\Models\Region;
use Webkul\Region\Models\RegionProps;
use Webkul\Region\Repositories\RegionPropsRepository;
use Webkul\Region\Repositories\RegionRepository;

class RegionPropsController extends Controller
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
     * @return Factory|View
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
     * @param RegionPropsSaveRequest $request
     * @return RedirectResponse
     */
    public function store(RegionPropsSaveRequest $request)
    {
        $data = $request->input();

        if (empty($data['code'])) {
            $data['code'] = strtoupper(Str::slug($data['code']));
        }
        $item = new RegionProps($data);
        $item->save();

        if ($item) {
            return redirect()
                ->route('admin.region.props.index')
                ->with(["success" => trans('region::app.main.create-success')]);
        } else {
            return back()
                ->withErrors(["msg" => trans('region::app.main.create-error')])
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
     * @return Factory|View
     */
    public function edit($id)
    {

        $props = $this->regionPropsRepository->getEdit($id);
        return view($this->_config['view'], compact('props'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $item = $this->regionPropsRepository->getEdit($id);
        if (empty($item)) {
            return back()
                ->withErrors(["msg" => "Свойство id=[$id] не найдено"])
                ->withInput();
        }
        $data = $request->all();
        $data['code'] = strtoupper($data['code']);
        $result = $item->update($data);

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
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $item = $this->regionPropsRepository->getEdit($id);
//        return response()->json([$item]);
        if ($item->delete()) {
            return \response()->json(['result' => true]);
        }


    }
}
