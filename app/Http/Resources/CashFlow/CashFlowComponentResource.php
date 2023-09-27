<?php

namespace App\Http\Resources\CashFlow;

use Illuminate\Http\Resources\Json\JsonResource;

class CashFlowComponentResource extends JsonResource
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
            'user_created'  => $this->user_created,
            'category_name' => $this->category_name,
            'type'          => $this->type,
            'note'          => $this->note,
            'status_aktif'  => $this->status_aktif,
            'updated_by'    => $this->updated_by,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at
        ];
    }
}
