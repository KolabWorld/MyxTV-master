<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Auth;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Contracts\Routing\ResponseFactory;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		try {
			$user = Auth::guard('admin')->user();
			if ($user)
			{
				return $next($request);

				// $user = $this->auth->user();
				// $actions = $request->route()->getAction();
				// $roles = isset($actions['roles']) ? $actions['roles'] : null;
				// if($roles && !$user->hasRole($roles)) {
				//     return $this->response->redirectTo('/admin/unauthorized');
				// }
				// elseif($user->hasRole(['admin','superadmin','manager','user', 'employee', 'accounts', 'hr']))
				// else
				//     return redirect()->guest('/');
			}	else {
              return $this->response->redirectTo('/admin/login');
            }
		}
        catch(Exception $e){
            return redirect()->intended('/login');
        }

		return $next($request);
	}

}
