<?php
namespace App;

use App\Models\Role;
use App\Models\Offer;
use App\Models\Admin;
use App\Models\Event;
use App\Models\Address;
use App\Models\Country;
use App\Models\MailBox;

use App\Helpers\ConstantHelper;
use App\Models\DayWiseSummary;
use App\Models\Order;
use App\Models\UserWallet;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Services\Mailers\Mailer;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, Notifiable, SoftDeletes, HasMediaTrait;

    /** By Abhishek
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'user_name',
        'email',
        'alternate_emailids',
        'password',
        'is_email_verified',
        'mobile',
        'is_mobile_verified',
        'profile_image_url',
        'has_password',
        'two_step_verification',
        'remember_token',
        'date_of_birth',
        'gender',
        'department_id',
        'marital_status',
        'organization_id',
        'status',
        'company_name',
        'tax_exempt',
        'currency_id',
        'country_id',
        'social_link_id',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['profile_pic'];

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
    
    public function offers()
    {
        return $this->belongsToMany(Offer::class)->withTimestamps();
    }

    public function events()
    {
        return $this->belongsToMany(Event::class)->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function dayWiseSummaries()
    {
        return $this->hasMany(DayWiseSummary::class);
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable')
            ->with('city', 'state', 'country');
    }

    public function billingAddresses()
    {
        return $this->morphMany(Address::class, 'addressable')
            ->where('type', '=', 'billing')
            ->with('city', 'state', 'country');
    }

    public function shippingAddresses()
    {
        return $this->morphMany(Address::class, 'addressable')
            ->where('type', '=', 'shipping')
            ->with('city', 'state', 'country');
    }


    public function address()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->with('city', 'state', 'country');
    }

    public function billingAddress()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->where('type', '=', 'billing')
            ->with('city', 'state', 'country');
    }

    public function shippingAddress()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->where('type', '=', 'shipping')
            ->with('city', 'state', 'country');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function comment()
    {
        return $this->morphOne(Comment::class, 'commentable');
    }

    public function user_profile()
    {
        return $this->hasOne(UserProfile::class);
    }
   
    public function wallet()
    {
        return $this->hasOne(UserWallet::class);
    }

    public function getProfilePicAttribute()
    {

        if ($this->getMedia('profile_pic')->isEmpty()) {
            return "false";
        } else {
            return $this->getMedia('profile_pic')->first()->getFullUrl();
        }
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('profile_pic')
            ->singleFile();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        $roles = $this->roles()->pluck('alias')->toArray();
        return in_array($role, $roles);
    }

    public function hasRoles($roles)
    {
        $userRoles = $this->roles()->pluck('alias')->toArray();
        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return true;
            }
        }
        return false;
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function socialLink()
    {
        return $this->belongsTo(SocialMedia::class);
    }

    public function services()
    {
        return $this->hasMany(UserService::class, 'user_id');
    }

    public function can($permission, $arguments = [])
    {
        // dd($permission);
        foreach ($this->roles as $role) {
            if ($role->name == 'Super Admin') {
                return true;
            }
            if ($role->can($permission)) {
                return true;
            }
        }
        return false;
    }

    public function getPermissionsAttribute()
    {
        $permissions = [];
        foreach ($this->roles as $role) {
            $rolePermissions = [];
            foreach ($role->permissions as $permission) {
                $rolePermissions[] = $permission->type . '.' . $permission->name;
            }
            $permissions = array_merge($permissions, $rolePermissions);
        }
        return $permissions;
    }

}