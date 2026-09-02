<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RepairShieldPermissions extends Command
{
    protected $signature = 'shield:repair
                            {--user=1 : Admin user ID to assign super_admin}
                            {--panel=admin : Panel guard name}';

    protected $description = 'Clean orphaned Spatie permissions and restore super admin access';

    public function handle(): int
    {
        $guard = (string) $this->option('panel');
        $userId = (int) $this->option('user');

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $orphanedRolePermissions = DB::table('role_has_permissions')
            ->leftJoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->whereNull('permissions.id')
            ->delete();

        $orphanedModelPermissions = DB::table('model_has_permissions')
            ->leftJoin('permissions', 'permissions.id', '=', 'model_has_permissions.permission_id')
            ->whereNull('permissions.id')
            ->delete();

        $wrongGuardRolePermissions = DB::table('role_has_permissions')
            ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where('permissions.guard_name', '!=', $guard)
            ->delete();

        $wrongGuardModelPermissions = DB::table('model_has_permissions')
            ->join('permissions', 'permissions.id', '=', 'model_has_permissions.permission_id')
            ->where('permissions.guard_name', '!=', $guard)
            ->delete();

        $this->info("Removed orphaned role permissions: {$orphanedRolePermissions}");
        $this->info("Removed orphaned model permissions: {$orphanedModelPermissions}");
        $this->info("Removed wrong-guard role permissions: {$wrongGuardRolePermissions}");
        $this->info("Removed wrong-guard model permissions: {$wrongGuardModelPermissions}");

        $role = Role::query()->firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => $guard],
        );

        $role->syncPermissions([]);

        $admin = Admin::query()->find($userId);

        if (! $admin) {
            $this->error("Admin user {$userId} not found.");

            return self::FAILURE;
        }

        $admin->forceFill(['role' => 'super_admin', 'is_active' => true])->saveQuietly();

        $admin->syncRoles([]);
        $admin->syncPermissions([]);
        $admin->assignRole($role);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Artisan::call('optimize:clear');

        $this->info("Super admin restored for {$admin->email} (ID {$admin->id}).");
        $this->comment('Log out and log in again on the admin panel.');

        return self::SUCCESS;
    }
}
