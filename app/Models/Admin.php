<?php
namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;
use Filament\Panel;

class Admin extends Authenticatable
{
    use HasRoles, SoftDeletes, Notifiable;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
        'is_active',
        'role',
    ];
    
    protected $hidden = [
        'password',
    ];
    
    protected $casts = [
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];
    
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'auther_id');
    }
    
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
    
    public function canComment(): bool
    {
        return true;
    }
    
    public static function boot()
    {
        parent::boot();
        
        static::saving(function ($model) {
            // Check if password is empty/null and unset it to prevent updating
            if (empty($model->password)) {
                unset($model->password);
            }
            
            // Only process role assignment if role field has a value
            if (!empty($model->role)) {
                // Remove any previous roles
                $model->syncRoles([]);
                
                // Find the role
                $role = Role::where('name', $model->role)->first();
                
                // Check if role exists before accessing permissions
                if ($role) {
                    // Assign new role
                    $model->assignRole($model->role);
                    
                    // Get all permissions for the new role
                    $permissions = $role->permissions;
                    
                    // Sync permissions
                    $model->syncPermissions([]);
                    if ($permissions->isNotEmpty()) {
                        $model->syncPermissions($permissions);
                    }
                } else {
                    // Optional: Log warning or throw exception
                    \Log::warning("Role '{$model->role}' not found for admin user {$model->id}");
                }
            }
        });
    }
}