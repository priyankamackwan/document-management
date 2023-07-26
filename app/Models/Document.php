<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class Document extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'documents';

    protected $appends = [
        'document_file',
        'document_photo',
    ];

    const IS_REMINDER_RADIO = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'maturity_date',
        'premium_payment_date',   
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const PREMIUM_PAYMENT_DURATION_SELECT = [
        'onetime' => 'One Time',
        '1_month' => 'Every 1 Month',
        '3_month' => 'Every 3 Months',
        '6_month' => 'Every 6 Months',
        'yearly'  => 'Yearly',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'policy_number',
        'policy_owner',
        'start_date',
        'end_date',
        'maturity_date',
        'maturity_amount',
        'description',
        'premium_payment_amount',
        'premium_payment_duration',
        'premium_payment_date',
        'is_reminder',
        'policy_purchased_from',
        'document_type_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function documentType() {
        return $this->hasMany(DocumentType::class,'id');
    }
    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getMaturityDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setMaturityDateAttribute($value)
    {
        $this->attributes['maturity_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getPremiumDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setPremiumDateAttribute($value)
    {
        $this->attributes['premium_payment_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDocumentFileAttribute()
    {
        return $this->getMedia('document_file');
    }

    public function getDocumentPhotoAttribute()
    {
        $files = $this->getMedia('document_photo');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }
}
