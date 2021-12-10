<?php

namespace App\Model\Setting;

use App\Scopes\GlobalScopeUserId;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    const STATUS_SHOW_NOTE_YES 	= 10;
    const STATUS_SHOW_NOTE_NO 	= 20;

    protected $table        = 'tbl_setting_app';
    protected $guard_name   = 'web';

    public $timestamps      = true;

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new GlobalScopeUserId);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'paper_size',
        'customer_note',
        'customer_note_show',
        'ip_server_wa',
        'wa_message'
    ];


    public function user()
    {
      return $this->belongsTo('App\User\User');
    }
}
