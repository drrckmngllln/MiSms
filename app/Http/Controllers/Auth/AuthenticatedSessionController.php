<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {


        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::User();

        $user = $request->User();
        $dt = Carbon::now('Asia/Manila');

        if ($request->user()->hasRole('Super_Administrator')) {

            $roleName = Role::find($user->roles()->first()?->id)?->name;
            $activityLog = [
                'username' => $user->name,
                'email' => $request->email,
                'role_name' => $roleName,
                'modify_user' => 'Logged in',
                'date_time' => $dt->format('D, M j, Y g:i A'),

            ];

            DB::table('activity_logs')->insert($activityLog);

            return redirect()->route('superadmin.sadmindashboard');
        } elseif ($request->user()->hasRole('Finance Cashier')) {
            $roleName = Role::find($user->roles()->first()?->id)?->name;
            $activityLog = [
                'username' => $user->name,
                'email' => $request->email,
                'role_name' => $roleName,
                'modify_user' => 'Logged in',
                'date_time' => $dt->format('D, M j, Y g:i A'),

            ];
            DB::table('activity_logs')->insert($activityLog);
            return redirect()->route('superadmin.fee_collection.index');
        } elseif ($request->user()->hasRole('Registrar')) {
            $roleName = Role::find($user->roles()->first()?->id)?->name;
            $activityLog = [
                'username' => $user->name,
                'email' => $request->email,
                'role_name' => $roleName,
                'modify_user' => 'Logged in',
                'date_time' => $dt->format('D, M j, Y g:i A'),

            ];
            DB::table('activity_logs')->insert($activityLog);
            return redirect()->route('superadmin.campuses.index');
        } elseif ($request->user()->hasRole('High School Department Super Administrator')) {
            $roleName = Role::find($user->roles()->first()?->id)?->name;
            $activityLog = [
                'username' => $user->name,
                'email' => $request->email,
                'role_name' => $roleName,
                'modify_user' => 'Logged in',
                'date_time' => $dt->format('D, M j, Y g:i A'),

            ];
            DB::table('activity_logs')->insert($activityLog);
            return redirect()->route('superadmin.sadmindashboard');
        } elseif ($request->user()->hasRole('Super Admin for Finance')) {
            $roleName = Role::find($user->roles()->first()?->id)?->name;
            $activityLog = [
                'username' => $user->name,
                'email' => $request->email,
                'role_name' => $roleName,
                'modify_user' => 'Logged in',
                'date_time' => $dt->format('D, M j, Y g:i A'),

            ];
            DB::table('activity_logs')->insert($activityLog);
            return redirect()->route('superadmin.non.assessed');
        } elseif ($request->user()->hasRole('Super Admin for Accounting')) {
            $roleName = Role::find($user->roles()->first()?->id)?->name;
            $activityLog = [
                'username' => $user->name,
                'email' => $request->email,
                'role_name' => $roleName,
                'modify_user' => 'Logged in',
                'date_time' => $dt->format('D, M j, Y g:i A'),

            ];
            DB::table('activity_logs')->insert($activityLog);
            return redirect()->route('superadmin.otherfees.index');
        } elseif ($request->user()->hasRole('Evaluator')) {
            $roleName = Role::find($user->roles()->first()?->id)?->name;
            $activityLog = [
                'username' => $user->name,
                'email' => $request->email,
                'role_name' => $roleName,
                'modify_user' => 'Logged in',
                'date_time' => $dt->format('D, M j, Y g:i A'),

            ];
            DB::table('activity_logs')->insert($activityLog);
            return redirect()->route('superadmin.create_account.index');
        }


        // Fallback redirection for users who don't have the 'Super_Administrator' role
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
