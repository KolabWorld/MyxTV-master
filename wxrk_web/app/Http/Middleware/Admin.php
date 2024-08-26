<?php 
namespace App\Http\Middleware;
use App\Helpers\ConstantHelper;
use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Auth\Middleware\Authenticate;

class Admin {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The response factory implementation.
     *
     * @var ResponseFactory
     */
    protected $response;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @param  ResponseFactory  $response
     * @return void
     */
    public function __construct(Guard $auth,
                                ResponseFactory $response)
    {

        $this->auth = $auth;
        $this->response = $response;
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
                // return $next($request);

                 $user = $this->auth->user();
                $actions = $request->route()->getAction();
                $roles = isset($actions['roles']) ? $actions['roles'] : null;
                
                if($roles && !$user->hasRoles($roles)) {
                    return $this->response->redirectTo('/unauthorized/view');
                }
                else
                    // return redirect()->guest('/dashboard');
                    return $next($request);
            } 
            else {
              return $this->response->redirectTo('/');
            }
        }
        catch(Exception $e){
            return redirect()->intended('/');
        }
	}

}
