<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $table = 'places';
    protected $fillable = [
        'user_contributor_id',
        'place_name',
        'address',
        'description',
        'image',
        'latitude',
        'longitude',
        'condition',
        'isFixed',
    ];

    public $appends = [
        'coordinate', 'map_popup_content',
    ];

    /**
     *
     * @return string
     */
    public function getNameLinkAttribute()
    {
        $title = __('app.show_detail_title', [
            'name' => $this->name, 'type' => __('road.road'),
        ]);
        $link = '<a href="'.route('roads.show', $this).'"';
        $link .= ' title="'.$title.'">';
        $link .= $this->name;
        $link .= '</a>';

        return $link;
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     *
     * @return string|null
     */
    public function getCoordinateAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return $this->latitude.', '.$this->longitude;
        }
    }

    /**
     *
     * @return string
     */
    public function getMapPopupContentAttribute()
    {
        if($this->isFixed){
            $mapPopupContent = '';
            $mapPopupContent .= '<div class="my-2"><strong>'.'Status'.':</strong><br><span class="badge text-bg-success">Fixed</span></div>';
            $mapPopupContent .= '<div class="my-2"><strong>'.'Place name'.':</strong><br>'.$this->place_name.'</div>';
            $mapPopupContent .= '<div class="my-2"><strong>'.'Address'.':</strong><br>'.$this->address.'</div>';
            $mapPopupContent .= '<div class="my-2"><strong>'.'Old Condition'.':</strong><br>'.$this->condition.'</div>';
        } else {
            $mapPopupContent = '';
            $mapPopupContent .= '<div class="my-2"><strong>'.'Place name'.':</strong><br>'.$this->place_name.'</div>';
            $mapPopupContent .= '<div class="my-2"><strong>'.'Address'.':</strong><br>'.$this->address.'</div>';
            $mapPopupContent .= '<div class="my-2"><strong>'.'Condition'.':</strong><br>'.$this->condition.'</div>';
            $mapPopupContent .= '<div class="my-2"><strong>'.'Photo'.':</strong><br>'.'<img width="100%" src='. asset("upload/foto_jalan/$this->image").'>'.'</div>';
            $mapPopupContent .= '<div class="my-2"><strong>'.'Coordinate'.':</strong><br>'.$this->coordinate.'</div>';
            $mapPopupContent .= '<div class="my-2"><strong>'.'Status'.':</strong><br><span class="badge text-bg-danger">Belum Diperbaiki</span></div>';
        }

        return $mapPopupContent;
    }
}
