<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeopleList;

class IpaAuthController extends Controller
{
    public function destroy_session() {
        session_destroy();
        return redirect()->route('login');
    }
    // getting connection and auth from ipa
    public function user_login(Request $request) {
        if($request->filled('username') && $request->filled('password')) {
            $username = $request->input('username');
            $password = $request->input('password');
            $adServer = "ldap.server.address";
            $ldap = ldap_connect($adServer, $adPort ?? 389);
            if ($ldap===false) {
                abort(403, 'Unable to connect to LDAP.');
            }
            $username = (strpos($username,'@')===false) ? $username : explode('@',$username)[0];
            $ldaprdn = "uid=" . $username . ",cn=users,cn=accounts,dc=domain,dc=com";
            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
            $bind = @ldap_bind($ldap, $ldaprdn, $password);
            if ($bind) {
                $filter="(&(uid=$username)";// to find the username in ldap define the correct ldap attribute (it is not necessary an uid attribute)
//                $filter .= "(|(!(nsaccountlock=*))(nsaccountlock=FALSE)))"; any other filters if required
                $result = ldap_search($ldap,"dc=domain,dc=com",$filter);
                if ($result===false){
                    abort(403, 'User is not found in LDAP."');
                }
                $info = ldap_get_entries($ldap, $result);
                if ($info===false){
                    abort(403, 'User attributes are not defined in LDAP.');
                }
                if($info['count'] >= 1) {
                    if (!empty($_SESSION['uName'])) {
                        @ldap_close($ldap);
                        return redirect()->route('welcome');//view('welcome');
                    }
//                    $_SESSION['uName'] = $username;
                    $_SESSION['reader_uName'] = "" . \Config::get('db_session.ipa_user');
                    $_SESSION['reader_uPass'] = "" . \Config::get('db_session.ipa_password');
                    $_SESSION['db_user'] = "" . \Config::get('db_session.db_user');
                    $_SESSION['db_pass'] = "" . \Config::get('db_session.db_pass');
                    $_SESSION['postgres_host'] = "localhost";
                    $_SESSION['uName'] = $username;
                    $userArr = PeopleList::where('uiserid', 'ilike', $_SESSION['uName'])->first();
                    $_SESSION['email'] = $userArr['email'] ?? '';
                    $_SESSION['FIO_full'] = $userArr['fio_full'] ?? '';
                    list($_SESSION['sDomain'], $_SESSION['sUser']) = explode("\\",$_SESSION['sFullUser']);
                    $_SESSION['dev_flag'] = env('APP_DEBUG');
                    @ldap_close($ldap);
                    return redirect()->route('welcome');
                }
            } else {
                return view('login', ['pwd' => 'bad']);
            }
            @ldap_close($ldap);
        } else {
            return redirect()->route('login');
        }
    }
}
