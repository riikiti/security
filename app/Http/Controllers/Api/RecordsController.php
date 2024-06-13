<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Records\RecordsCompactRequest;
use App\Http\Requests\Records\RecordsRequest;
use App\Http\Requests\Records\RecordsStoreRequest;
use App\Http\Requests\Search\SearchRecordsRequest;
use App\Http\Resources\RecordsResource;
use App\Models\Cluster;
use App\Models\Record;
use App\Services\Helpers\Encryption\EncryptionHelperService;
use Illuminate\Http\JsonResponse;

class RecordsController extends Controller
{
    private Record $record;
    private string $password;
    private array $data;

    private EncryptionHelperService $encryptHelper;

    public function __construct()
    {
        $this->encryptHelper = app(EncryptionHelperService::class);
    }

    public function index(RecordsCompactRequest $request): JsonResponse
    {
        $encryptedRecords = [];
        $cluster = Cluster::find($request->cluster_id);
        $records = Record::query()->where('cluster_id', $request->cluster_id)->get();
        foreach ($records as $record) {
            $decryptedRecord['id'] = $record->id;
            $decryptedRecord['email'] = isset($record->email) ? $this->encryptHelper->decrypt(
                $record->email,
                $cluster->password
            ) : null;
            $decryptedRecord['site'] = isset($record->site) ? $this->encryptHelper->decrypt(
                $record->site,
                $cluster->password
            ) : null;
            $decryptedRecord['login'] = isset($record->login) ? $this->encryptHelper->decrypt(
                $record->login,
                $cluster->password
            ) : null;
            $decryptedRecord['password'] = isset($record->password) ? $this->encryptHelper->decrypt(
                $record->password,
                $cluster->password
            ) : null;
            $decryptedRecord['color'] = $record->color ?? null;
            $decryptedRecord['title'] = $record->title ?? null;
            $encryptedRecords[] = $decryptedRecord;
        }
        return response()->json(['status' => 'success', 'data' => $encryptedRecords]);
    }

    public function show(RecordsRequest $request): JsonResponse
    {
        $this->record = Record::find($request->record_id);
        $this->password = $this->record->cluster->password;
        $this->data['email'] = isset($this->record->email) ? $this->encryptHelper->decrypt(
            $this->record->email,
            $this->password
        ) : null;
        $this->data['site'] = isset($this->record->site) ? $this->encryptHelper->decrypt(
            $this->record->site,
            $this->password
        ) : null;
        $this->data['login'] = isset($this->record->login) ? $this->encryptHelper->decrypt(
            $this->record->login,
            $this->password
        ) : null;
        $this->data['color'] = $this->data['color'] ?? null;
        $this->data['title'] = $this->data['title'] ?? null;
        $this->data['password'] = isset($this->record->password) ? $this->encryptHelper->decrypt(
            $this->record->password,
            $this->password
        ) : null;
        $this->data['id'] = $this->record->id;
        return response()->json(['status' => 'success', 'data' => $this->data]);
    }

    public function store(RecordsStoreRequest $request): JsonResponse
    {
        //вынести все данные в функцию чтоб данные сразу заносили зашифроваными
        $this->data = $request->validated();
        $cluster = Cluster::find($this->data['cluster_id']);
        $this->data['email'] = isset($this->data['email']) ? $this->encryptHelper->encrypt(
            $this->data['email'],
            $cluster->password
        ) : null;
        $this->data['site'] = isset($this->data['site']) ? $this->encryptHelper->encrypt(
            $this->data['site'],
            $cluster->password
        ) : null;
        $this->data['login'] = isset($this->data['login']) ? $this->encryptHelper->encrypt(
            $this->data['login'],
            $cluster->password
        ) : null;
        $this->data['password'] = isset($this->data['password']) ? $this->encryptHelper->encrypt(
            $this->data['password'],
            $cluster->password
        ) : null;
        $this->record = Record::create($this->data);
        return response()->json(['status' => 'success', 'data' => $this->record]);
    }

    public function update(RecordsRequest $request): JsonResponse
    {
        $this->data = $request->validated();
        $this->record = Record::find($request->record_id);
        $this->password = $this->record->cluster->password;
        $this->data['email'] = isset($this->data['email']) ? $this->encryptHelper->encrypt(
            $this->data['email'],
            $this->password
        ) : null;
        $this->data['site'] = isset($this->data['site']) ? $this->encryptHelper->encrypt(
            $this->data['site'],
            $this->password
        ) : null;
        $this->data['login'] = isset($this->data['login']) ? $this->encryptHelper->encrypt(
            $this->data['login'],
            $this->password
        ) : null;
        $this->data['color'] = $this->data['color'] ?? null;
        $this->data['title'] = $this->data['title'] ?? null;
        $this->data['password'] = isset($this->data['password']) ? $this->encryptHelper->encrypt(
            $this->data['password'],
            $this->password
        ) : null;
        $this->record->fill($this->data)->save();
        return response()->json(['status' => 'success', 'data' => $this->record]);
    }

    public function delete(Record $record): JsonResponse
    {
        $record->delete();
        return response()->json(['status' => 'success', 'data' => []]);
    }

    public function search(SearchRecordsRequest $request): JsonResponse
    {
        $encryptedRecords = [];
        $records = Record::query()
            ->where('cluster_id', $request->cluster_id)
            ->where('title', 'LIKE', '%' . $request->find . '%')
            ->get();
        foreach ($records as $record) {
            $this->password = $record->cluster->password;
            $decryptedRecord['id'] = $record->id;
            $decryptedRecord['email'] = isset($record->email) ? $this->encryptHelper->decrypt(
                $record->email,
                $this->password
            ) : null;
            $decryptedRecord['site'] = isset($record->site) ? $this->encryptHelper->decrypt(
                $record->site,
                $this->password
            ) : null;
            $decryptedRecord['login'] = isset($record->login) ? $this->encryptHelper->decrypt(
                $record->login,
                $this->password
            ) : null;
            $decryptedRecord['password'] = isset($record->password) ? $this->encryptHelper->decrypt(
                $record->password,
                $this->password
            ) : null;
            $this->data['color'] = $record->color ?? null;
            $this->data['title'] = $record->title ?? null;
            $encryptedRecords[] = $decryptedRecord;
        }
        return response()->json(['status' => 'success', 'data' => $encryptedRecords]);
    }

}
