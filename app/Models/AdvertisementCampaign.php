<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia as HasMediaAlias;
use Spatie\MediaLibrary\InteractsWithMedia;

class AdvertisementCampaign extends Model implements HasMediaAlias
{
    use HasFactory,InteractsWithMedia;

    protected $table = 'advertisement_campaign';
}
