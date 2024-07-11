<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApplicationRoles;

class CheckRolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    private $role_array = array(
        // [role_name_for_route_check] => [role_name_from_local_IdM]
        // 'equipment_operator' => 'APP-NAME-->eq_operator_050'
        //  here the role in table is by template 'APP-NAME-->eq_operator_050' where `-->` stands as a delimeter
        'any' => '%'
    );
    public function handle(Request $request, Closure $next, $routeParameter)
    {
        if (empty($_SESSION['uName'])) return redirect()->route('login');
//        dd($routeParameter);
        $response = $next($request);
        $role_arr = array();
        $app_name = config('app.idm_app_name');//Application Name
        $app = $app_name.'-->'.$this->role_array[$routeParameter];
        $res = ApplicationRoles::where('role_name','like',"{$app}")
            ->where('pid', '=', $_SESSION['AUUSR'])
            ->get();
        foreach($res as $role_rows) {
            $role_arr[] = substr($role_rows['role_name'], strpos($role_rows['role_name'], '-->')+3, strlen($role_rows['role_name']));
        }
        if (count($res) === 0) {
            abort(403, 'Unauthorized action. Missing role: '.$this->role_array[$routeParameter].' of '.$app_name.'.');
        }
//        return [
//            $response,
//            $role_arr
//        ];
        $request->roleArr = $role_arr;
//        dd($request);
        return $next($request);
    }
}
