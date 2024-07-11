## Laravel Template Project for apps with ldap/freeipa integration and custom IdM system

This app template can be useful for some enterprise activities that are used internally.
As we know some central apps/reports are quite expensive to implement for certain requests.

## LDAP and DB user password

Define an identity with read rights for your LDAP and DB user (with full access to DB) in .env file.

## LDAP connection & bind

In `IpaAuthController` define ldap server, port. Additionally specify a local users' table to add other user attributes to session variable if you want to use them for this or other application on same domain.

## PHP SESSION

The session data is stored in PHP Session. `session_start()` takes place in `index.php (/public)` file.
Each route can be checked with `auth.check` middleware to confirm that session was started and desired username attribute is set. Otherwise, the user gets redirected to login page.

## Local IdM system

To check the user access to this app each route can have middleware check for user roles:

- in the `CheckRolesMiddleware` you can define a local IdM relation (user - role) table and check current user for roles,
- the role array in this middleware should consist of roles by this application from your local IdM system,
- in routes you call this `role.check:<role_name>` middleware to check the role for each page or action, but the role itself must be defined there.

## Local ENV variables

In addition to default variables you must set the following:

- `IPA_USER` (for ldap user)
- `IPA_PASSWORD` (for ldap password)
- `IDM_APP_NAME` (for local idm system)

## Additional libraries

The following libraries outside the default are added to the project:

- jQuery,
- axios
- bootstrap v5

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT) as well as the following:
- [axios LICENCE](https://github.com/axios/axios/blob/v1.x/LICENSE)
- [jQuery LICENCE](https://jquery.com/license/)
- [bootstrap 5 licence](https://getbootstrap.com/docs/5.0/about/license/)
