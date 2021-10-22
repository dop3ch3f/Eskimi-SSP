<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementCampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'total_budget' => $this->total_budget,
            'daily_budget' => $this->daily_budget,
            'from' => $this->from,
            'to' => $this->to,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'creative_uploads' => $this->getUploads(),
        ];
    }

    public function getUploads() {
        $mediaEntries = $this->getMedia()->all();
        return array_map(function($entry) {
            return $entry->getFullUrl();
        }, $mediaEntries);
    }
}
