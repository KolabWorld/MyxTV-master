<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements HasMedia
{
    use HasApiTokens, Notifiable, SoftDeletes, HasMediaTrait;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'user_name',
        'admin_type',
        'password',
        'has_password',
        'email',
        'is_email_verified',
        'mobile',
        'is_mobile_verified',
        'two_step_verification',
        'company_name',
        'company_website',
        'contact_person_name',
        'alternate_contact_number',
        'alternate_email',
        'business_category',
        'business_category_id',
        'subscription_plan_id',
        'is_payment_done',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arraysequence
     */
    protected $appends = ['logo', 'offers_sold_value'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at', 'media'
    ];

    public function setPasswordAttribute($password)
    {
        if (!is_null($password))
            $this->attributes['password'] = bcrypt($password);
    }

    public function findForPassport($username) {
        return $this->where('user_name', $username)
        			->first();
    }
    
    public function registerMediaCollections()
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }
    
    public function getLogoAttribute()
    {

        if ($this->getMedia('logo')->isEmpty()) {
            return false;
        } else {
            return $this->getMedia('logo')->first()->getFullUrl();
        }
    }

    public function profile() {
        return $this->hasOne(AdminProfile::class);
    }

    public function businessCategory() {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    public function adminSubscriptionPlan() {
        return $this->hasOne(AdminSubscriptionPlan::class, 'admin_id')
            ->where('subscription_plan_id', $this->subscription_plan_id)
            ->latest();
    }

    public function subscriptionPlan() {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id', 'id');
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function origins() {
        return $this->belongsToMany(Origin::class);
    }

    public function notificationMapping() {
        return $this->belongsToMany(NotificationAdminMapping::class,'admin_id');
    }

    public function paymentTransactions()
    {
        return $this->morphMany(PaymentTransaction::class, 'payable');
    }

    public function hasRole($role) {
        $roles = $this->roles()->pluck('alias')->toArray();
        return in_array($role, $roles);
	}

	public function hasRoles($roles) {
		$adminRoles = $this->roles()->pluck('alias')->toArray();
        if($roles) {
            foreach($roles as $role) {
                if(in_array($role, $adminRoles)) {
                    return true;
                }
            }
        }
		return false;
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->with(['city', 'state', 'country']);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'created_by');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function getOffersSoldValueAttribute(){
        return $this->offers->sum('sold_value');
    }
    
    
    
}