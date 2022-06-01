<?php

namespace App\Http\Middleware;

use App\Models\Activity;
use Closure;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\MessageBag;
use ReallySimpleJWT\Decode;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Parse;
use ReallySimpleJWT\Token;

/**
 * Prevents helpers to do restricted operations on a Calendar's Activities, Helpers and Targets
 */
class CheckCalendarRole
{
    /**
     * Handle an incoming request.
     * Prevents helpers to do restricted operations on a Calendar's Activities, Helpers and Targets
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $this->authori
        return $next($request);
    }




    // public function handle(Request $request, Closure $next)
    // {
    //     error_log('checkcalendarrole');
    //     $user = $this->_getCurrentUser();
    //     $calendar = session('calendar');

    //     if (is_null($user) || is_null($calendar)){
    //         // FORBIDDEN: ERROR: NO USER LOGGED IN / NO CALENDAR
    //         return redirect('/');
    //     }

    //     // if user is the owner of current calendar
    //     if ($calendar->owner->id === $user->id){
    //         return $next($request);
    //     }

    //     // Helper
    //     $resource = explode('/', $request->route()->uri)[0];


    //     switch($resource){
    //         // As a helper whom current calendar is a helped one, it needs to be able to change it
    //         case 'calendars': return $this->_handleCalendarResource($request, $next); break;
    //         case 'activities': return $this->_handleActivityResource($request, $next); break;

    //         // If resource is not activities nor calendars, helper is forbidden
    //         default: return $this->_handleActivityResource($request, $next); break;
    //     }
    // }

    // Actions available for all models
    public $globalAllowedActions = ['index', 'show'];



    public function _handleDefaultResource(Request $request, Closure $next)
    {
        $action = $request->route()->getActionMethod();
        $resource = explode('/', $request->route()->uri)[0];

        // If request action is not restricted for helper, let it go
        if (in_array($action, $this->globalAllowedActions)) {
            error_log("action not restricted. action = {$action}");
            return $next($request);
        }
        return redirect()->back()->withErrors(new MessageBag(["Action {$action} is restricted for resource {$resource} on role helper"]));
    }


    /**
     * As a helper of current calendar, user needs to be able to create or view new calendar
     */
    public function _handleCalendarResource(Request $request, Closure $next)
    {
        $action = $request->route()->getActionMethod();

        // If request action is not restricted for helper, let it go
        $allowedMethods = ['index', 'show', 'create', 'store', 'switch'];
        if (in_array($action, $allowedMethods)) {
            error_log("action not restricted. action = {$action}");
            return $next($request);
        }

        return redirect()->back()->withErrors(new MessageBag(["Action {$action} is restricted for resource calendars on role helper"]));
    }


    /**
     * As a helper of current calendar, user needs to be able to create new activities and delete/update its created ones
     */
    public function _handleActivityResource(Request $request, Closure $next)
    {
        $action = $request->route()->getActionMethod();

        // If request action is not restricted for helper, let it go
        $allowedMethods = ['index', 'show', 'edit', 'create', 'store'];
        if (in_array($action, $allowedMethods)) {
            error_log("action not restricted. action = {$action}");
            return $next($request);
        }

        // si llegamos aqui es por UPDATE, EDIT o DESTROY -> comprobar que el recurso activity es creado por el mismo usuario
        $activity = Activity::find($request->activity);
        $user = $this->_getCurrentUser();
        if ($activity->creator->id == $user->id) {
            return $next($request);
        }
        return redirect()->back()->withErrors(new MessageBag(["Action {$action} is restricted for resource activities on role helper"]));
    }

    // Actions restricted for helper on model Activity
    public $restrictedActions = ['update', 'destroy'];









    // NOTA: FUNCIO REPETIDA!!! JA HI ES A LA CLASSE Controller.php!!!!! com es pot solucionar¿

    /**
     * Gets current user with the token data
     */
    protected function _getCurrentUser()
    {
        $parser = new Parse(new Jwt(session('token')), new Decode());

        $parsedToken = $parser->parse();
        $email = $parsedToken->getPayload()['user'];

        return User::where('email', $email)->first();
    }
}
