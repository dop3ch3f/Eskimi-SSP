<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdvertisementCampaignResource;
use App\Models\AdvertisementCampaign;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AdvertisementCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return AdvertisementCampaignResource::collection(AdvertisementCampaign::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Campaigns/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'total_budget' => 'required|numeric',
            'daily_budget' => 'required|numeric',
            'from' => 'required|date',
            'to' => 'required|date',
        ]);

        if ($validator->fails()) {
            return \response([
                'error' => $validator->errors()->first(),
                'status' => false,
            ], 400)->send();
        }

        $adCampaign = new AdvertisementCampaign();
        $adCampaign->name = $request->input('name');
        $adCampaign->total_budget = $request->input('total_budget');
        $adCampaign->daily_budget = $request->input('daily_budget');
        $adCampaign->from = Carbon::parse($request->input('from'));
        $adCampaign->to = Carbon::parse($request->input('to'));

        $files = $request->allFiles();

        foreach ($files["creative_upload"] as $key => $file) {
            $adCampaign->addMedia($file)->toMediaCollection();
        }

        $adCampaign->save();

        return \response([
            'data' => new AdvertisementCampaignResource($adCampaign),
            'status' => true,
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return AdvertisementCampaignResource
     */
    public function show($id)
    {
        return new AdvertisementCampaignResource(AdvertisementCampaign::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id, Request $request)
    {
        return Inertia::render('Campaigns/Edit', [
            'campaign' => new AdvertisementCampaignResource(AdvertisementCampaign::findOrFail($id)),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id )
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'total_budget' => 'numeric',
            'daily_budget' => 'numeric',
            'from' => 'date',
            'to' => 'date',
        ]);

        if ($validator->fails()) {
            return \response([
                'error' => $validator->errors()->first(),
                'status' => false,
            ], 400);
        }

        $adCampaign = AdvertisementCampaign::findOrFail($id);
        $adCampaign->name = $request->input('name') ?? $adCampaign->name;
        $adCampaign->total_budget = $request->input('total_budget') ?? $adCampaign->total_budget;
        $adCampaign->daily_budget = $request->input('daily_budget') ?? $adCampaign->daily_budget;
        $adCampaign->from = Carbon::parse($request->input('from')) ?? $adCampaign->from;
        $adCampaign->to = Carbon::parse($request->input('to')) ?? $adCampaign->to;

        $files = $request->allFiles();

        if (count($files) > 0) {
            $adCampaign->clearMediaCollection();

            foreach ($files['creative_upload'] as $key => $file) {
                $adCampaign->addMedia($file)->toMediaCollection();
            }
        }



        $adCampaign->save();

        return \response([
            'data' => new AdvertisementCampaignResource($adCampaign),
            'status' => true,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $adCampaign = AdvertisementCampaign::findOrFail($id);
        $adCampaign->delete();
        return \response([
            'data' => 'campaign deleted',
            'status' => true,
        ], 200)->send();
    }
}
