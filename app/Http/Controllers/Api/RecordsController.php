<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Records\RecordsCompactRequest;
use App\Http\Requests\Records\RecordsRequest;
use App\Http\Resources\RecordsResource;
use App\Models\Record;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    private Record $record;

    public function index(RecordsCompactRequest $request): JsonResponse
    {
        $records = Record::query()->where('cluster_id', $request->cluster_id)->get();
        return response()->json(['status' => 'success', 'data' => RecordsResource::collection($records)]);
    }

    public function show(RecordsRequest $request): JsonResponse
    {
        $this->record = Record::find($request->record_id);
        return response()->json(['status' => 'success', 'data' => RecordsResource::make($this->record)]);
    }

    public function update(RecordsRequest $request): JsonResponse
    {
        $this->record = Record::find($request->record_id);
        $this->record->fill($request->validated())->save();
        return response()->json(['status' => 'success', 'data' => RecordsResource::make($this->record)]);
    }

    public function delete(RecordsRequest $request): JsonResponse
    {
        $this->record = Record::find($request->record_id);
        $this->record->delete();
        return response()->json(['status' => 'success', 'data' => []]);
    }

}
