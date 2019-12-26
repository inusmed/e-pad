<?php namespace Modules\Akun\Listeners\Auth;

use Date;
use Illuminate\Auth\Events\Login as ILogin;

class Login
{

    /**
     * Handle the event.
     *
     * @param ILogin $event
     * @return void
     */
    public function handle(ILogin $event)
    {
        // Get first company
        
        $company = $event->user->userCompany()->first();
        
        // Logout if no company assigned
        if (!$company) {
            app('\App\Http\Controllers\Auth\LoginController')->logout();
            
            flash("Akun anda mengalami kesalahan")->error();
            
            return;
        }

        // Set company id
        session(['company_id' => $company->company_id]);
        
        // Save user login time
        $event->user->last_logged_in_at = Date::now();

        $event->user->save();
    }
}